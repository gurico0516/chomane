<?php

namespace App\Application\Services;

use App\Domains\Allowance\Services\AllowanceService;

class AllowanceApplicationService
{
    /**
     * Allowance service instance
     *
     * @var AllowanceService
     */
    protected $allowanceService;

    public function __construct(AllowanceService $allowanceService)
    {
        $this->allowanceService = $allowanceService;
    }

    /**
     * Create allowance
     *
     * @param array $request
     * @return void
     */
    public function create(array $request): void
    {
        $this->allowanceService->create($request);
    }

    /**
     * Edit allowance
     *
     * @param array $request
     * @param int $allowanceId
     * @return void
     */
    public function edit(array $request, int $allowanceId): void
    {
        $this->allowanceService->edit($request, $allowanceId);
    }

    /**
     * Delete allowance
     *
     * @return void
     */
    public function delete(): void
    {
        $this->allowanceService->delete();
    }

    /**
     * Get allowance
     *
     * @param int $userId
     * @return object|null
     */
    public function get(int $userId): ?object
    {
        return $this->allowanceService->get($userId);
    }

    /**
     * Get allowance
     *
     * @param int $userId
     * @return int|null
     */
    public function getOneById(int $userId): ?int
    {
        return $this->allowanceService->getOneById($userId);
    }

    /**
     * Get amount of allowance
     *
     * @param int $userId
     * @return void
     */
    public function decrease(int $userId): void
    {
        $this->allowanceService->decrease($userId);
    }


    /**
     * Recalculate allowance after expense edit
     * 
     * @param int $userId
     * @param float $originalExpense
     * @param float $newExpense
     * @return void
     */
    public function recalculateAfterExpenseEdit(int $userId, float $originalExpense, float $newExpense): void
    {
        $this->allowanceService->recalculateAfterExpenseEdit($userId, $originalExpense, $newExpense);
    }
}