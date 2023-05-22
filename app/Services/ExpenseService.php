<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\Expense;
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
     * @param Expense $expenseModel
     * @return void
     */
    public function __construct(Expense $expenseModel) {
        $this->expenseModel = $expenseModel;
    }
}
