<?php

namespace App\Http\Controllers;

use App\Services\ExpenseService;
use App\Http\Requests\ExpenseRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ExpenceController extends Controller
{
    /**
     * Expense service instance
     *
     * @var ExpenseService $expenseService
     */
    protected $expenseService;

    /**
     * ExpenseController constructor
     *
     * @param ExpenseService $expenseService
     * @return void
     */
    public function __construct(ExpenseService $expenseService) {
        $this->expenseService = $expenseService;
    }
}
