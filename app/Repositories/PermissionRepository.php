<?php

namespace App\Repositories;

use App\Interfaces\PermissionRepositoryInterface;
use App\Repositories\BaseRepository;

/**
 * Class PermissionRepository
 * @package App\Repositories
 */
class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    /**
     * @return string
     */
    public function model()
    {
        return 'App\Permission';
    }
}
