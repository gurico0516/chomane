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
     * @return object
     */
    public function getAll(int $allowanceId): object
    {
        $allowance = $this->expenseRepository->getAll($allowanceId);

        return $allowance;
    }
}
