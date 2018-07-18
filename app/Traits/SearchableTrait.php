<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

trait SearchableTrait
{
    /**
    * Get table column names from the Eloquent Model
    *
    * @return void
    */
    // protected function getTableColumns()
    // {
    //     return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    // }
        
    /**
    * Get searchable columns from the Eloquent Model
    *
    * @return void
    */
    protected function getColumns()
    {
        return $this->searchable;
    }
        
    /**
    * Search the model's attributes for matching records, order, and paginate the result
    *
    * @param [String] $value
    * @param [Integer] $length
    * @return Collection
    */
    public function searchOrderColumns(Request $request)
    {
        try {
            $request->validate([
                    'searchText' => 'string|max:50|nullable',
                    'orderByMulti' => [
                        'string',
                        'max:150',
                        'nullable',
                        function ($attribute, $value, $fail) {
                            $fields = explode(';', $value);
                            $columns = $this->getColumns();
                            foreach ($fields as $field) {
                                if (!in_array($fields, $columns)) {
                                    return $fail($attribute . ' is invalid.');
                                }
                            }
                        }
                        ]
                        ]);
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
        $query = $this->query();
        if ($request->filled('with')) {
            $relations = explode(',', $request->with);
            $query->with($relations);
        }
        if ($request->filled('searchText')) {
            $search = (string) $request->searchText;
            $columns = $this->getColumns();
            foreach ($columns as $column) {
                $query->orWhere($column, 'LIKE', '%'.$search.'%');
            }
        }
        if ($request->filled('orderByMulti')) {
            $orders = (string) $request->orderByMulti;
            $sort = (string) $orders;
            $dir = (string) $request->sortedByMulti;
            $fields = explode(';', $sort);
            $dirs = explode(';', $dir);
            $i = 0;
            foreach ($fields as $field) {
                if (in_array($field, $this->getColumns())) {
                    $query->orderBy($field, $dirs[$i]);
                }
                $i++;
            }
        }
        if ($request->filled('orderBy')) {
            $order = (string) $request->orderBy;
            $query->orderBy($order, $request->sortedBy);
        }
        $length = (integer) $request->length;
        return $query->withTrashed()->paginate($length);
    }
}
