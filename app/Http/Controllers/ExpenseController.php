<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Application\Services\ExpenseApplicationService;
use App\Application\Services\AllowanceApplicationService;
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
     * @var ExpenseApplicationService
     */
    protected $expenseApplicationService;

    /**
     * Allowance service instance
     *
     * @var AllowanceApplicationService
     */
    protected $allowanceApplicationService;

    /**
     * ExpenseController constructor
     *
     */
    public function __construct(ExpenseApplicationService $expenseApplicationService, AllowanceApplicationService $allowanceApplicationService)
    {
        $this->expenseApplicationService = $expenseApplicationService;
        $this->allowanceApplicationService = $allowanceApplicationService;
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
        $this->expenseApplicationService->create($validated);

        $userId = Auth::id();
        $this->allowanceApplicationService->decrease($userId);

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
        $expense = $this->expenseApplicationService->getById($expenseId);

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
        $response = $this->expenseApplicationService->edit($validated, $expenseId);

        $userId = Auth::id();
        $this->allowanceApplicationService->recalculateAfterExpenseEdit($userId, $response['originalExpense'], $response['newExpense']);

        return Redirect::route('allowance.index');
    }

    /**
     * Delete expense
     *
     * @return RedirectResponse
     */
    public function delete(): RedirectResponse
    {
        $this->expenseApplicationService->delete();

        return Redirect::route('allowance.index');
    }
}