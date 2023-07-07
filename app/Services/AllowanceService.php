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

    public function decrease(int $userId)
    {
        $allowance = $this->allowanceModel->get($userId);
        $expense = $this->expenseModel->get($allowance->id);
        $amount = $this->getAmount($allowance->allowance, $expense->expense);

        if ($allowance) {
            $allowance->allowance = $amount;
            $allowance->save();
        }
    }

    private function getAmount(string $allowance, string $expense): int
    {
        $amount = $allowance - $expense;

        return $amount;
    }
}
