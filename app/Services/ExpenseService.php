<?php

namespace App\Services;

use App\Models\Expense;
use Illuminate\Support\Facades\Log;
use Throwable;

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
    public function create(array $request): string
    {
        try {
            $this->expenseModel->create($request);

            return 'success status: 200';
        } catch (Throwable $e) {
            Log::error($e);

            return 'error status: '.(string) $e->getCode().'error message: '.$e->getMessage();
        }
    }

    /**
     * Get allowance
     */
    public function getAll(int $allowance_id): object|string
    {
        try {
            $allowance = $this->expenseModel->getAll($allowance_id);

            return $allowance;
        } catch (Throwable $e) {
            Log::error($e);

            return 'error status: '.(string) $e->getCode().'error message: '.$e->getMessage();
        }
    }
}
