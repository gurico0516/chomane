<?php

namespace App\Http\Controllers;

use App\Http\Requests\AllowanceRequest;
use App\Services\AllowanceService;
use App\Services\ExpenseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class AllowanceController extends Controller
{
    /**
     * Allowance service instance
     *
     * @var AllowanceService
     */
    protected $allowanceService;

    /**
     * Expense service instance
     *
     * @var ExpenseService
     */
    protected $expenseService;

    /**
     * AllowanceController constructor
     *
     * @return void
     */
    public function __construct(AllowanceService $allowanceService, ExpenseService $expenseService)
    {
        $this->allowanceService = $allowanceService;
        $this->expenseService = $expenseService;
    }

    /**
     * Show allowance list
     */
    public function index(): Response
    {
        $userId = Auth::id();
        $allowance = $this->allowanceService->get($userId);
        $expenses = $this->expenseService->getAll($userId);

        return Inertia::render('Allowance/Index', [
            'allowance' => $allowance,
            'expenses' => $expenses,
            'status' => session('status'),
        ]);
    }

    /**
     * Show allowance create page
     */
    public function createView(): Response
    {
        return Inertia::render('Allowance/Create', [
            'status' => session('status'),
        ]);
    }

    /**
     * Create allowance
     */
    public function create(AllowanceRequest $request): RedirectResponse
    {
        $this->allowanceService->create($request->validated());

        return Redirect::route('allowance.index');
    }

    /**
     * Edit allowance edit page
     */
    public function editView(): Response
    {
        $userId = Auth::id();
        $allowance = $this->allowanceService->get($userId);

        return Inertia::render('Allowance/Edit', [
            'allowance' => $allowance,
            'status' => session('status'),
        ]);
    }

    /**
     * Edit allowance
     */
    public function edit(AllowanceRequest $request): RedirectResponse
    {
        $userId = Auth::id();
        $allowanceId = $this->allowanceService->get($userId)->id;
        $this->allowanceService->edit($request->validated(), $allowanceId);

        return Redirect::route('allowance.edit');
    }

    /**
     * Delete allowance
     */
    public function delete(): RedirectResponse
    {
        $this->allowanceService->delete();

        return Redirect::route('allowance.index');
    }
}
