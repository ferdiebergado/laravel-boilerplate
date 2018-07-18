<?php 
namespace App\Criteria\Users;

use App\Criteria\Criteria;
use App\Interfaces\RepositoryInterface as Repository;

/**
 * Class InactiveUserCriteria
 *
 * @package App\Criteria\Users
 */
class InactiveUserCriteria extends Criteria
{

    /**
     * @param            $model
     * @param Repository $repository
     *
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        return $model->where('active', 0);
    }
}
