<?php

namespace App\Http\Controllers;

use App\Http\Requests\AllowanceRequest;
use App\Application\Services\ExpenseApplicationService;
use App\Application\Services\AllowanceApplicationService;
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
     * @var AllowanceApplicationService
     */
    protected $allowanceApplicationService;

    /**
     * Expense service instance
     *
     * @var ExpenseApplicationService
     */
    protected $expenseApplicationService;

    /**
     * AllowanceController constructor
     *
     */
    public function __construct(AllowanceApplicationService $allowanceApplicationService, ExpenseApplicationService $expenseApplicationService)
    {
        $this->allowanceApplicationService = $allowanceApplicationService;
        $this->expenseApplicationService = $expenseApplicationService;
    }

    /**
     * Show allowance list
     *
     * @return Response
     */
    public function index(): Response
    {
        $userId = Auth::id();
        $allowance = $this->allowanceApplicationService->get($userId);
        $expenses = $this->expenseApplicationService->getAll($userId);

        $weeklyExpenses = $this->getWeeklySummaryData();

        return Inertia::render('Allowance/Index', [
            'allowance' => $allowance,
            'expenses' => $expenses,
            'weeklyExpenses' => $weeklyExpenses,
            'status' => session('status'),
        ]);
    }

    /**
     * Get weekly summary data
     *
     * @return array
     */
    protected function getWeeklySummaryData(): array
    {
        $expenses = $this->expenseApplicationService->getWeeklySummary();
        return $expenses->map(function ($expense) {
            return [
                'type' => $expense->type,
                'total' => $expense->total
            ];
        })->toArray();
    }

    /**
     * Show allowance create page
     *
     * @return Response
     */
    public function createView(): Response
    {
        return Inertia::render('Allowance/Create', [
            'status' => session('status'),
        ]);
    }

    /**
     * Create allowance
     *
     * @param AllowanceRequest $request
     * @return RedirectResponse
     */
    public function create(AllowanceRequest $request): RedirectResponse
    {
        $this->allowanceApplicationService->create($request->validated());

        return Redirect::route('allowance.index');
    }

    /**
     * Edit allowance edit page
     *
     * @return Response
     */
    public function editView(): Response
    {
        $userId = Auth::id();
        $allowance = $this->allowanceApplicationService->get($userId);

        return Inertia::render('Allowance/Edit', [
            'allowance' => $allowance,
            'status' => session('status'),
        ]);
    }

    /**
     * Edit allowance
     *
     * @param AllowanceRequest $request
     * @return RedirectResponse
     */
    public function edit(AllowanceRequest $request): RedirectResponse
    {
        $userId = Auth::id();
        $allowanceId = $this->allowanceApplicationService->getOneById($userId);
        $this->allowanceApplicationService->edit($request->validated(), $allowanceId);

        return Redirect::route('allowance.index');
    }

    /**
     * Delete allowance
     *
     * @return RedirectResponse
     */
    public function delete(): RedirectResponse
    {
        $this->allowanceApplicationService->delete();

        return Redirect::route('allowance.index');
    }
}
