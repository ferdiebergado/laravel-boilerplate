<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Interfaces\UserRepositoryInterface;

/**
 * Class UserRepository
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @return string
     */
    public function model()
    {
        return 'App\User';
    }

    /**
     * Get all active users
     *
     * @return Collection
     */
    public function active()
    {
        return $this->findBy('active', 1)->all();
    }
}
