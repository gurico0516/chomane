<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use Carbon\Carbon;

class Expense extends Model
{
    use HasFactory;

    /**
     * Get the template fillable
     *
     * @var Array[number]
     */
    protected $fillable = [
        'allowance_id',
        'expense',
        'memo',
        'type',
    ];

    /**
     * Create expense
     *
     * @param array $request
     * @return string
     */
    public function create(array $request): string
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

            return 'Expense created successfully: status 200';
        } catch (Throwable $e) {
            DB::rollback();
            Log::error('Failed to create an expense: ', ['error' => $e->getMessage()]);

            return 'Failed to create an expense: status ' . $e->getCode();
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
        $getExpense = self::where('allowance_id', $allowanceId)
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

        $getExpense = self::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->get();

        return $getExpense;
    }
}
