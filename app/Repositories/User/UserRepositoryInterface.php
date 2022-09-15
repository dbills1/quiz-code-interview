<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * Create new User Data
     *
     * @param array $data
     * @return User
     */
    public function save(array $data): User;

    /**
     * Update User data
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete User data
     *
     * @param int $id
     * @param boolean $softDelete
     * @return boolean
     */
    public function delete(int $id, bool $softDelete = true): bool;

    /**
     * Get all User data
     *
     * @param boolean $softDelete
     * @return Collection
     */
    public function getAllUser(bool $softDelete = true): Collection;

    /**
     * Get User data by given id
     *
     * @param integer $id
     * @param boolean $softDelete
     * @return User
     */
    public function getUserById(int $id, $softDelete = true): User;

    /**
     * Get User data by given parameters
     *
     * @param array $parameters
     * @param boolean $softDelete
     * @return Collection
     */
    public function getUser(array $parameters, $softDelete = true): Collection;
}
