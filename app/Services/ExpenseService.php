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
}
