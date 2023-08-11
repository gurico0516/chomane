<?php

namespace App\Infrastructure\Repositories;

use App\Domains\Allowance\Entities\Allowance;
use App\Domains\Expense\Entities\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Throwable;

class ExpenseRepository
{
    /**
     * Create expense
     *
     * @param array $request
     * @return void
     */
    public function create(array $request): void
    {
        DB::beginTransaction();
        try {
            $expense = new Expense();
            $expense->allowance_id = Allowance::where('user_id', Auth::id())->latest('id')->first()->id;
            $expense->user_id = Auth::id();
            $expense->expense = $request['expense'];
            $expense->memo = $request['memo'];
            $expense->type = $request['type'];
            $expense->save();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollback();
            Log::error('Failed to create an expense: ', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Get expense
     *
     * @param int $allowanceId
     * @return object
     */
    public function get(int $allowanceId): object
    {
        $getExpense = Expense::where('allowance_id', $allowanceId)
            ->latest('created_at')
            ->first();

        return $getExpense;
    }

    /**
     * Get expense
     *
     * @param int $userId
     * @return object
     */
    public function getAll(int $userId): object
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $getExpense = Expense::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->orderBy('created_at', 'desc')
            ->get();

        return $getExpense;
    }

    /**
     * Get expense by id
     * 
     * @param int $id
     * @return object
     */
    public function getById(int $id): object
    {
        $expense = Expense::where('id', $id)
            ->first();

        return $expense;
    }

    /**
     * Edit expense
     *
     * @param array $request
     * @param int $expenseId
     * @return void
     */
    public function edit(array $request, int $expenseId): void
    {
        DB::beginTransaction();
        try {
            Expense::find($expenseId)->fill($request)->save();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollback();
            Log::error($e);
        }
    }

    /**
     * Delete expense
     *
     * @throws \Exception
     * @return void
     */
    public function deleteExpense(): void
    {
        DB::beginTransaction();
        try {
            Expense::where('user_id', Auth::id())->delete();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollback();
            Log::error('Failed to create an expense: ', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Get weekly summary
     * 
     * @return object
     */
    public function getWeeklySummary(): object
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
    
        $expenses = Expense::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('type')
            ->select('type', DB::raw('sum(expense) as total'))
            ->get();
    
        return $expenses;
    }
}
