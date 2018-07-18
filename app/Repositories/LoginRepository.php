<?php

namespace App\Repositories;

use App\Interfaces\LoginRepositoryInterface;
use App\Repositories\BaseRepository;

/**
 * Class PermissionRepository
 * @package App\Repositories
 */
class LoginRepository extends BaseRepository implements LoginRepositoryInterface
{
    /**
     * @return string
     */
    public function model()
    {
        return 'App\Login';
    }
}
