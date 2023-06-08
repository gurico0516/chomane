<?php

namespace App\Http\Controllers;

use App\Services\ExpenseService;

class ExpenseController extends Controller
{
    /**
     * Expense service instance
     *
     * @var ExpenseService
     */
    protected $expenseService;

    /**
     * ExpenseController constructor
     *
     * @return void
     */
    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }
}
