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
     */
    public function __construct(ExpenseService $expenseService, AllowanceService $allowanceService)
    {
        $this->expenseService = $expenseService;
        $this->allowanceService = $allowanceService;
    }

    /**
     * Show expense create page
     *
     * @return Response
     */
    public function createView(): Response
    {
        return Inertia::render('Expense/Create', [
            'status' => session('status'),
        ]);
    }

    /**
     * Create expense
     *
     * @param ExpenseRequest $request
     * @return RedirectResponse
     */
    public function create(ExpenseRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $this->expenseService->create($validated);

        $userId = Auth::id();
        $this->allowanceService->decrease($userId);

        return Redirect::route('allowance.index');
    }

    /**
     * Edit expense edit page
     *
     * @param int $expenseId
     * @return Response
     */
    public function editView(int $expenseId): Response
    {
        $expense = $this->expenseService->getById($expenseId);

        return Inertia::render('Expense/Edit', [
            'expense' => $expense,
            'status' => session('status'),
        ]);
    }

    /**
     * Edit expense
     *
     * @param ExpenseRequest $request
     * @param int $expenseId
     * @return RedirectResponse
     */
    public function edit(ExpenseRequest $request, int $expenseId): RedirectResponse
    {
        $validated = $request->validated();
        $this->expenseService->edit($validated, $expenseId);

        return Redirect::route('allowance.index');
    }

    /**
     * Delete expense
     *
     * @param int $expenseId
     * @return RedirectResponse
     */
    public function delete(int $expenseId): RedirectResponse
    {
        $this->expenseService->delete($expenseId);

        return Redirect::route('allowance.index');
    }
}
