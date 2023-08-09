<?php

namespace App\Application\Services;

use App\Domains\Expense\Services\ExpenseService;

class ExpenseApplicationService
{
    protected $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    /**
     * Create expense
     *
     * @param array $request
     * @return void
     */
    public function create(array $request): void
    {
        // トランザクションの開始やエラーハンドリングなどをここで行う
        $this->expenseService->create($request);
    }

    /**
     * Get allowance
     *
     * @param int $allowanceId
     * @return object
     */
    public function getAll(int $allowanceId): object
    {
        return $this->expenseService->getAll($allowanceId);
    }

    /**
     * Get expense by id
     * 
     * @param int $id
     * @return object
     */
    public function getById(int $id): object
    {
        return $this->expenseService->getById($id);
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
        return $this->expenseService->edit($request, $expenseId);
    }

    /**
     * Delete expense
     *
     * @return void
     */
    public function delete(): void
    {
        $this->expenseService->delete();
    }

    /**
     * Get weekly summary
     * 
     * @return object
     */
    public function getWeeklySummary(): object
    {
        return $this->expenseService->getWeeklySummary();
    }
}
