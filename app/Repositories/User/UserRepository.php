<?php

namespace App\Repositories\User;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Create new User Data
     *
     * @param array $data
     * @return User
     */
    public function save(array $data): User
    {
        DB::beginTransaction();
        try {
            $user = User::create($data);
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();

            reportError($e->getMessage());
            throw $e;
        }
    }

    /**
     * Update User data
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        DB::beginTransaction();
        try {
            $user = User::where('id', $id)->first();
            $userEmail = User::where('email', $data['email'])
                ->first();

            if (!is_null($userEmail)) {
                return false;
            }

            $user->update($data);

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();

            reportError($e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete User data
     *
     * @param int $id
     * @param boolean $softDelete
     * @return boolean
     */
    public function delete(int $id, bool $softDelete = true): bool
    {
        DB::beginTransaction();
        try {
            $user = User::where('id', $id)
                ->when($softDelete, function ($query) {
                    return $query->delete();
                }, function ($query) {
                    return $query->forceDelete();
                });

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();

            reportError($e->getMessage());
            throw $e;
        }
    }

    /**
     * Get all User data
     *
     * @param boolean $softDelete
     * @return Collection
     */
    public function getAllUser(bool $softDelete = true): Collection
    {
        return User::when($softDelete, function ($query) {
            return $query->withTrashed();
        })
            ->get();
    }

    /**
     * Get User data by given id
     *
     * @param integer $id
     * @param boolean $softDelete
     * @return User
     */
    public function getUserById(int $id, $softDelete = true): User
    {
        return User::when($softDelete, function ($query) {
            return $query->withTrashed();
        })->find($id);
    }

    /**
     * Get User data by given parameters
     *
     * @param array $parameters
     * @param boolean $softDelete
     * @return Collection
     */
    public function getUser(array $parameters, $softDelete = true): Collection
    {
        return User::when($softDelete, function ($query) {
            return $query->withTrashed();
        })
            ->when(!empty($parameters), function ($query) use ($parameters) {
                foreach ($parameters as $key => $value) {
                    $query = $query->where($key, $value);
                }
                return $query;
            })
            ->get();
    }
}
