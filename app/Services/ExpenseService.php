<?php

namespace App\Services;

use App\Repositories\ExpenseRepository;

class ExpenseService
{
    /**
     * Expense repository instance
     *
     * @var ExpenseRepository
     */
    protected $expenseRepository;

    /**
     * ExpenseService constructor
     *
     * @return void
     */
    public function __construct(ExpenseRepository $expenseRepository)
    {
        $this->expenseRepository = $expenseRepository;
    }

    /**
     * Create expense
     *
     * @param array $request
     * @return void
     */
    public function create(array $request): void
    {
        $this->expenseRepository->create($request);
    }

    /**
     * Get allowance
     *
     * @param int $allowanceId
     * @return object
     */
    public function getAll(int $allowanceId): object
    {
        $allowance = $this->expenseRepository->getAll($allowanceId);

        return $allowance;
    }

    /**
     * Get expense by id
     * 
     * @param int $id
     * @return object
     */
    public function getById(int $id): object
    {
        $expense = $this->expenseRepository->getById($id);

        return $expense;
    }

    /**
     * Edit allowance
     *
     * @param array $request
     * @param int $expenseId
     * @return array
     */
    public function edit(array $request, int $expenseId): array
    {
        $originalExpense = $this->expenseRepository->getById($expenseId)->expense;
        $this->expenseRepository->edit($request, $expenseId);

        $newExpense = $request['expense'];
        $expenseResponse = [
            'originalExpense' => $originalExpense,
            'newExpense' => $newExpense,
        ];

        return $expenseResponse;
    }

    /**
     * Delete expense
     *
     * @return void
     */
    public function delete(): void
    {
        $this->expenseRepository->deleteExpense();
    }
}
