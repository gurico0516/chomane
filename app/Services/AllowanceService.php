<?php

namespace App\Services;

use App\Models\Allowance;
use App\Models\Expense;
use Illuminate\Support\Facades\Log;
use Throwable;

use function PHPSTORM_META\type;

class AllowanceService
{
    /**
     * Allowance model
     *
     * @var Allowance
     */
    protected $allowanceModel;

    /**
     * Expense model
     *
     * @var Expense
     */
    protected $expenseModel;

    /**
     * AllowanceService constructor
     *
     * @return void
     */
    public function __construct(Allowance $allowanceModel, Expense $expenseModel)
    {
        $this->allowanceModel = $allowanceModel;
        $this->expenseModel = $expenseModel;
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
        } catch (Throwable $e) {
            Log::error($e);

            return 'error status: '.(string) $e->getCode().'error message: '.$e->getMessage();
        }
    }

    /**
     * Edit allowance
     *
     * @param array $request
     * @param int $allowanceId
     * @return string
     */
    public function edit(array $request, int $allowanceId): string
    {
        try {
            $this->allowanceModel->edit($request, $allowanceId);

            return 'success status: 200';
        } catch (Throwable $e) {
            Log::error($e);

            return 'error status: '.(string) $e->getCode().'error message: '.$e->getMessage();
        }
    }

    /**
     * Delete allowance
     *
     * @return string
     */
    public function delete(): string
    {
        try {
            $this->allowanceModel->delete();

            return 'success status: 200';
        } catch (Throwable $e) {
            Log::error($e);

            return 'error status: '.(string) $e->getCode().'error message: '.$e->getMessage();
        }
    }

    /**
     * Get allowance
     *
     * @param int $userId
     * @return object|string
     */
    public function get(int $userId): object|string
    {
        try {
            $allowance = $this->allowanceModel->get($userId);

            return $allowance;
        } catch (Throwable $e) {
            Log::error($e);

            return 'error status: '.(string) $e->getCode().'error message: '.$e->getMessage();
        }
    }

    /**
     * Get amount of allowance
     *
     * @param int $userId
     * @return void
     */
    public function decrease(int $userId): void
    {
        $allowance = $this->allowanceModel->get($userId);
        $expense = $this->expenseModel->get($allowance->id);
        $amount = $allowance->allowance - $expense->expense;

        if ($allowance) {
            $allowance->allowance = $amount;
            $allowance->save();
        }
    }
}
