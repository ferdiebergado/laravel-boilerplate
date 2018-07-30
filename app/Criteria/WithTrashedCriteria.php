<?php
namespace App\Criteria;

use App\Criteria\Criteria;
use App\Interfaces\RepositoryInterface as Repository;

/**
 * Class WithTrashedCriteria
 *
 * @package App\Criteria
 */
class WithTrashedCriteria extends Criteria
{
    /**
     * @param            $model
     * @param Repository $repository
     *
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        if (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($model))) {
            return $model->withTrashed();
        }
        return $model;
    }
}
