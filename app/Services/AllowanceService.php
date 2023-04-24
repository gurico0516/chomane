<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\Allowance;
use Throwable;

class AllowanceService
{
    /**
     * Allowance model
     *
     * @var Allowance
     */
    protected $allowanceModel;

    /**
     * AllowanceService constructor
     *
     * @param Allowance $allowanceModel
     * @return void
     */
    public function __construct(Allowance $allowanceModel)
    {
        $this->allowanceModel = $allowanceModel;
    }

    /**
     * Create allowance
     *
     * @param array $request
     * @return string
     */
    public function create(array $request): string
    {
        try {
            $this->allowanceModel->create($request);

            return 'success status: 200';
        } catch(Throwable $e) {
            Log::error($e);

            return 'error status: ' . (string) $e->getCode() . 'error message: ' . $e->getMessage();
        }
    }

    /**
     * Edit allowance
     *
     * @param array $request
     * @param integer $allowanceId
     * @return string
     */
    public function edit(array $request, int $allowanceId): string {
        try {
            $this->allowanceModel->edit($request, $allowanceId);

            return 'success status: 200';
        } catch (Throwable $e) {
            Log::error($e);

            return 'error status: ' . (string) $e->getCode() . 'error message: ' . $e->getMessage();
        }
    }

    /**
     * Delete allowance
     *
     * @return string
     */
    public function delete(): string {
        try {
            $this->allowanceModel->delete();

            return 'success status: 200';
        } catch (Throwable $e) {
            Log::error($e);

            return 'error status: ' . (string) $e->getCode() . 'error message: ' . $e->getMessage();
        }
    }

    /**
     * Get allowance
     *
     * @param integer $userId
     * @return object|string
     */
    public function get(int $userId): object|string
    {
        try {
            $allowance = $this->allowanceModel->get($userId);

            return $allowance;
        } catch(Throwable $e) {
            Log::error($e);

            return 'error status: ' . (string) $e->getCode() . 'error message: ' . $e->getMessage();
        }
    }
}
