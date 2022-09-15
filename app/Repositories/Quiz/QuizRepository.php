<?php

namespace App\Repositories\Quiz;

use App\Models\Quiz;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class QuizRepository implements QuizRepositoryInterface
{
    /**
     * Create new Quiz Data
     *
     * @param array $data
     * @return Quiz
     */
    public function save(array $data): Quiz
    {
        DB::beginTransaction();
        try {
            $quiz = Quiz::create($data);
            DB::commit();
            return $quiz;
        } catch (Exception $e) {
            DB::rollback();

            reportError($e->getMessage());
            throw $e;
        }
    }

    /**
     * Update Quiz data
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        DB::beginTransaction();
        try {
            $quiz = Quiz::where('id', $id)
                ->update($data);
            DB::commit();
            return $quiz;
        } catch (Exception $e) {
            DB::rollback();

            reportError($e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete Quiz data
     *
     * @param int $id
     * @param boolean $softDelete
     * @return boolean
     */
    public function delete(int $id, bool $softDelete = true): bool
    {
        DB::beginTransaction();
        try {
            $quiz = Quiz::where('id', $id)
                ->when($softDelete, function ($query) {
                    return $query->delete();
                }, function ($query) {
                    return $query->forceDelete();
                });

            DB::commit();
            return $quiz;
        } catch (Exception $e) {
            DB::rollback();

            reportError($e->getMessage());
            throw $e;
        }
    }

    /**
     * Get all Quiz data
     *
     * @param boolean $softDelete
     * @return Collection
     */
    public function getAllQuiz(bool $softDelete = true): Collection
    {
        return Quiz::when($softDelete, function ($query) {
            return $query->withTrashed();
        })->get();
    }

    /**
     * Get Quiz data by given id
     *
     * @param integer $id
     * @param boolean $softDelete
     * @return Quiz
     */
    public function getQuizById(int $id, $softDelete = true): Quiz
    {
        return Quiz::when($softDelete, function ($query) {
            return $query->withTrashed();
        })->find($id);
    }

    /**
     * Get Quiz data by given parameters
     *
     * @param array $parameters
     * @param boolean $softDelete
     * @return Collection
     */
    public function getQuiz(array $parameters, $softDelete = true): Collection
    {
        return Quiz::when($softDelete, function ($query) {
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

    public function getScores(): int
    {
        return Quiz::sum('score');
    }
}
