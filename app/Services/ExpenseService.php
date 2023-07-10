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
     *
     * @param array $request
     * @return string
     */
    public function create(array $request): string
    {
        try {
            $this->expenseModel->create($request);

            return 'success status: 200';
        } catch (Throwable $e) {
            Log::error($e);

            return 'error status: ' . (string) $e->getCode() . 'error message: ' . $e->getMessage();
        }
    }
}
