<?php

namespace App\Repositories;

use App\Models\Expense;
use App\Models\Allowance;
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
}
