<?php

namespace App\Http\Controllers;

use App\Services\AllowanceService;
use App\Http\Requests\AllowanceRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AllowanceController extends Controller
{
    /**
     * Allowance service instance
     *
     * @var AllowanceService $allowanceService
     */
    protected $allowanceService;

    /**
     * AllowanceController constructor
     *
     * @param AllowanceService $service
     * @return void
     */
    public function __construct(AllowanceService $allowanceService)
    {
        $this->allowanceService = $allowanceService;
    }

    /**
     * Show allowance list
     *
     * @return Response
     */
    public function index(): Response
    {
        $userId    = Auth::id();
        $allowance = $this->allowanceService->get($userId);

        return Inertia::render('Allowance/Index', [
            'allowance' => $allowance,
            'status'    => session('status'),
        ]);
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
     * @return RedirectResponse
     */
    public function create(AllowanceRequest $request): RedirectResponse
    {
        $allowance = $request->validated();
        $this->allowanceService->create($allowance);

        return Redirect::route('allowance.create');
    }

    /**
     * Edit allowance edit page
     *
     * @return Response
     */
    public function editView(): Response
    {
        return Inertia::render('Allowance/Edit', [
            'status' => session('status'),
        ]);
    }

    /**
     * Edit allowance
     *
     * @param integer $allowanceId
     * @return RedirectResponse
     */
    public function edit(AllowanceRequest $request): RedirectResponse
    {
        $allowance = $request->validate();
        $this->allowanceService->create($allowance);

        return Redirect::route('allowance.edit');
    }
}
