<?php

namespace App\Services;

use App\Models\Expense;

class ExpenseService
{
    /**
     * Expense model
     *
     * @var Expense
     */
    protected $expenseModel;

    /**
     * ExpenseService constructor
     *
     * @return void
     */
    public function __construct(Expense $expenseModel)
    {
        $this->expenseModel = $expenseModel;
    }

    /**
     * Create expense
     */
    public function create(array $request): void
    {
        $this->expenseModel->create($request);
    }

    /**
     * Get allowance
     */
    public function getAll(int $allowanceId): object
    {
        $allowance = $this->expenseModel->getAll($allowanceId);

        return $allowance;
    }
}
