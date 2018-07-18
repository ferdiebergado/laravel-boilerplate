<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Interfaces\RoleRepositoryInterface;

/**
 * Class RoleRepository
 * @package App\Repositories
 */
class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{

    /**
     * @return string
     */
    public function model()
    {
        return 'App\Role';
    }
}
