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
     * @param AllowanceService $allowanceService
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
        $this->allowanceService->create($request->validated());

        return Redirect::route('allowance.create');
    }

    /**
     * Edit allowance edit page
     *
     * @return Response
     */
    public function editView(): Response
    {
        $userId    = Auth::id();
        $allowance = $this->allowanceService->get($userId);

        return Inertia::render('Allowance/Edit', [
            'allowance' => $allowance,
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
        $userId      = Auth::id();
        $allowanceId = $this->allowanceService->get($userId)->id;
        $this->allowanceService->edit($request->validated(), $allowanceId);

        return Redirect::route('allowance.edit');
    }

    /**
     * Delete allowance
     *
     * @return RedirectResponse
     */
    public function delete(): RedirectResponse
    {
        $this->allowanceService->delete();

        return Redirect::route('allowance.index');
    }
}
