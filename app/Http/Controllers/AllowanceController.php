<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Services\AllowanceService;
use App\Http\Requests\AllowanceRequest;
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
     * Show Allowance list
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Allowance/Index', [
            'status' => session('status'),
        ]);
    }
}
