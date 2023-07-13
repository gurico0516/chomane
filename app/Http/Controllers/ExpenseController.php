<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Services\AllowanceService;
use App\Services\ExpenseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ExpenseController extends Controller
{
    /**
     * Expense service instance
     *
     * @var ExpenseService
     */
    protected $expenseService;

    /**
     * Allowance service instance
     *
     * @var AllowanceService
     */
    protected $allowanceService;

    /**
     * ExpenseController constructor
     *
     * @return void
     */
    public function __construct(ExpenseService $expenseService, AllowanceService $allowanceService)
    {
        $this->expenseService = $expenseService;
        $this->allowanceService = $allowanceService;
    }

    /**
     * Show Expense create page
     */
    public function createView(): Response
    {
        return Inertia::render('Expense/Create', [
            'status' => session('status'),
        ]);
    }

    /**
     * Create Expense
     */
    public function create(ExpenseRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $this->expenseService->create($validated);

        $userId = Auth::id();
        $this->allowanceService->decrease($userId);

        return Redirect::route('allowance.index');
    }
}
