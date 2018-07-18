<?php
namespace App\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Criteria\Criteria;
use App\Interfaces\RepositoryInterface as Repository;

/**
* Class RequestCriteria
*/
class RequestCriteria extends Criteria
{
    /**
    * @var \Illuminate\Http\Request
    */
    protected $request;
    protected $model;
    protected $columns;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
    * Get searchable columns from the Eloquent Model
    *
    * @return void
    */
    protected function getSearchableColumns()
    {
        return $this->getCriteriaModel()->getSearchable();
    }

    /**
     * Get table column names from the Eloquent Model
     *
     * @return void
     */
    protected function getTableColumns($model)
    {
        return $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
    }

    protected function validateRequest()
    {
        $columns = $this->getColumns();
        $sort = ['asc', 'desc'];
        $this->request->validate([
            'searchText' => 'string|max:50|nullable',
            'orderByMulti' => [
                'sometimes',
                'string',
                'max:150',
                'nullable',
                function ($attribute, $value, $fail) use ($columns) {
                    $fields = explode(';', $value);
                    if (is_array($fields)) {
                        $strcolumn = '';
                        foreach ($columns as $column) {
                            $strcolumn = $strcolumn.' '.$column;
                        }
                        foreach ($fields as $field) {
                            if (!in_array($field, $columns)) {
                                return $fail('The field '.$field.' in '.$attribute .'='.$value.' (columns: '.$strcolumn.') is invalid.');
                            }
                        }
                    }
                    if (!in_array($value, $columns)) {
                        return $fail($attribute . '=' . $value . ' is invalid.');
                    }
                }
            ],
            'sortedByMulti' => [
                'required_with:orderByMulti',
                'string',
                'max:150',
                'nullable',
                function ($attribute, $value, $fail) use ($sort) {
                    $fields = explode(';', $value);
                    foreach ($fields as $field) {
                        if (!in_array($field, $sort)) {
                            return $fail($attribute . '=' . $value . ' is invalid.');
                        }
                    }
                    if (!in_array($value, $sort)) {
                        return $fail($attribute . '=' . $value . ' is invalid.');
                    }
                }
            ]
        ]);
    }

    protected function getRelation()
    {
        if ($this->request->filled('with')) {
            $relations = explode(',', $this->request->with);
            $this->model = $this->model->with($relations);
        }
    }

    protected function doSearch()
    {
        if ($this->request->filled('searchText')) {
            $search = $this->request->searchText;
            $columns = $this->getSearchableColumns();
            foreach ($columns as $column) {
                if (substr_count($column, '.') > 0) {
                    $col = explode('.', $column);
                    $this->model = $this->model->orWhereHas($col[0], function ($query) use ($search, $col) {
                        $query->where($col[1], 'LIKE', '%' . $search . '%');
                    });
                } else {
                    $this->model = $this->model->orWhere($column, 'LIKE', '%' . $search . '%');
                }
            }
        }
    }

    protected function sortMultipleColumns()
    {
        if ($this->request->filled('orderByMulti')) {
            $sort = $this->request->orderByMulti;
            $dir = $this->request->sortedByMulti;
            $fields = explode(';', $sort);
            $dirs = explode(';', $dir);
            $i = 0;
            foreach ($fields as $field) {
                if (in_array($field, $this->getColumns())) {
                    $this->model = $this->model->orderBy($field, $dirs[$i]);
                }
                $i++;
            }
        }
    }

    protected function sortColumn()
    {
        if ($this->request->filled('orderBy')) {
            $order = $this->request->orderBy;
            $this->model = $this->model->orderBy($order, $this->request->sortedBy);
        }
    }

    /**
    * Apply criteria in query repository
    *
    * @param         Builder|Model     $model
    * @param RepositoryInterface $repository
    *
    * @return mixed
    * @throws \Exception
    */
    public function apply($model, Repository $repository)
    {
        $this->setCriteriaModel($model);
        $this->setColumns($this->getTableColumns($model));
        $this->validateRequest();
        $this->getRelation();
        $this->doSearch();
        $this->sortColumn();
        $this->sortMultipleColumns();
        return $model = $this->model;
    }

    /**
    * Get the value of model
    */
    protected function getCriteriaModel()
    {
        return $this->model->getModel();
    }

    /**
    * Set the value of model
    *
    * @return  self
    */
    protected function setCriteriaModel($model)
    {
        $this->model = $model;
    }

    /**
     * Get the value of columns
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Set the value of columns
     *
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;
    }
}
