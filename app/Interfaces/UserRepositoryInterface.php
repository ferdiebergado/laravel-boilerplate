<?php

namespace App\Interfaces;

use App\Interfaces\RepositoryInterface;

/**
 * User Repository Interface
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * Get all active users
     *
     * @return Collection
     */
    public function active();
}
