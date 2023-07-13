<?php

namespace App\Services;

use App\Models\Allowance;
use App\Models\Expense;

class AllowanceService
{
    /**
     * Allowance model
     *
     * @var Allowance
     */
    protected $allowanceModel;

    /**
     * Expense model
     *
     * @var Expense
     */
    protected $expenseModel;

    /**
     * AllowanceService constructor
     */
    public function __construct(Allowance $allowanceModel, Expense $expenseModel)
    {
        $this->allowanceModel = $allowanceModel;
        $this->expenseModel = $expenseModel;
    }

    /**
     * Create allowance
     */
    public function create(array $request): void
    {
        $this->allowanceModel->create($request);
    }

    /**
     * Edit allowance
     */
    public function edit(array $request, int $allowanceId): void
    {
        $this->allowanceModel->edit($request, $allowanceId);
    }

    /**
     * Delete allowance
     */
    public function delete(): void
    {
        $this->allowanceModel->deleteAllowance();
    }

    /**
     * Get allowance
     */
    public function get(int $userId): ?object
    {
        $allowance = $this->allowanceModel->get($userId);

        return $allowance;
    }

    /**
     * Get allowance
     */
    public function getOneById(int $userId): ?int
    {
        $allowance = $this->allowanceModel->get($userId);

        return $allowance->id;
    }

    /**
     * Get amount of allowance
     */
    public function decrease(int $userId): void
    {
        $allowance = $this->allowanceModel->get($userId);
        $expense = $this->expenseModel->get($allowance->id);
        $amount = $allowance->allowance - $expense->expense;

        if ($allowance) {
            $allowance->allowance = $amount;
            $allowance->save();
        }
    }
}
