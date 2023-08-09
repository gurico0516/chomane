<?php

namespace App\Services;

use App\Repositories\AllowanceRepository;
use App\Repositories\ExpenseRepository;

class AllowanceService
{
    /**
     * Allowance repository instance
     *
     * @var AllowanceRepository
     */
    protected $allowanceRepository;

    /**
     * Expense repository instance
     *
     * @var ExpenseRepository
     */
    protected $expenseRepository;

    /**
     * @param AllowanceRepository $allowanceRepository
     * @param ExpenseRepository $expenseRepository
     */
    public function __construct(AllowanceRepository $allowanceRepository, ExpenseRepository $expenseRepository)
    {
        $this->allowanceRepository = $allowanceRepository;
        $this->expenseRepository = $expenseRepository;
    }

    /**
     * Create allowance
     *
     * @param array $request
     * @return void
     */
    public function create(array $request): void
    {
        $this->allowanceRepository->create($request);
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
        $this->allowanceRepository->edit($request, $allowanceId);
    }

    /**
     * Delete allowance
     *
     * @return void
     */
    public function delete(): void
    {
        $this->allowanceRepository->deleteAllowance();
    }

    /**
     * Get allowance
     *
     * @param int $userId
     * @return object|null
     */
    public function get(int $userId): ?object
    {
        $allowance = $this->allowanceRepository->get($userId);

        return $allowance;
    }

    /**
     * Get allowance
     *
     * @param int $userId
     * @return int|null
     */
    public function getOneById(int $userId): ?int
    {
        $allowance = $this->allowanceRepository->get($userId);

        return $allowance->id;
    }

    /**
     * Get amount of allowance
     *
     * @param int $userId
     * @return void
     */
    public function decrease(int $userId): void
    {
        $allowance = $this->allowanceRepository->get($userId);
        $expense = $this->expenseRepository->get($allowance->id);
        $amount = $allowance->allowance - $expense->expense;

        if ($allowance) {
            $allowance->allowance = $amount;
            $allowance->save();
        }
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
        $allowance = $this->allowanceRepository->get($userId);
        if (!$allowance) {
            return;
        }

        // 元々のExpenseデータを元に戻す
        $allowance->allowance += $originalExpense;

        // 新しいExpenseの値で再計算
        $allowance->allowance -= $newExpense;

        $allowance->save();
    }
}
