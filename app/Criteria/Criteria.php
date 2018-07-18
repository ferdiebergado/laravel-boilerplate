<?php 
namespace App\Criteria;

use App\Interfaces\RepositoryInterface as Repository;

abstract class Criteria
{

    /**
     * @param $model
     * @param Repository $repository
     * @return mixed
     */
    abstract public function apply($model, Repository $repository);
}
