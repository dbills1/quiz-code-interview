<?php

namespace App\Repositories\Quiz;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Collection;

interface QuizRepositoryInterface
{
    /**
     * Create new Quiz Data
     *
     * @param array $data
     * @return Quiz
     */
    public function save(array $data): Quiz;

    /**
     * Update Quiz data
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete Quiz data
     *
     * @param int $id
     * @param boolean $softDelete
     * @return boolean
     */
    public function delete(int $id, bool $softDelete = true): bool;

    /**
     * Get all Quiz data
     *
     * @param boolean $softDelete
     * @return Collection
     */
    public function getAllQuiz(bool $softDelete = true): Collection;

    /**
     * Get Quiz data by given id
     *
     * @param integer $id
     * @param boolean $softDelete
     * @return Quiz
     */
    public function getQuizById(int $id, $softDelete = true): Quiz;

    /**
     * Get Quiz data by given parameters
     *
     * @param array $parameters
     * @param boolean $softDelete
     * @return Collection
     */
    public function getQuiz(array $parameters, $softDelete = true): Collection;
}
