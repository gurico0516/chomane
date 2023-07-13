<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class Allowance extends Model
{
    use HasFactory;

    /**
     * Get the template fillable
     *
     * @var Array[number]
     */
    protected $fillable = [
        'allowance',
        'user_id',
    ];

    /**
     * Create allowance
     *
     * @param array $request
     * @return string
     */
    public function create(array $request): string
    {
        DB::beginTransaction();
        try {
            $allowance = new Allowance();
            $allowance->user_id = Auth::id();
            $allowance->allowance = $request['allowance'];
            $allowance->save();
            DB::commit();

            return 'success status: 200';
        } catch (Throwable $e) {
            DB::rollback();
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
        DB::beginTransaction();
        try {
            self::find($allowanceId)->fill($request)->save();
            DB::commit();

            return 'success status: 200';
        } catch (Throwable $e) {
            DB::rollback();
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
        DB::beginTransaction();
        try {
            self::where('user_id', Auth::id())->delete();
            DB::commit();

            return 'success status: 200';
        } catch (Throwable $e) {
            DB::rollback();
            Log::error('Failed to create an expense: ', ['error' => $e->getMessage()]);

            return 'Failed to create an expense: status ' . $e->getCode();
        }
    }

    /**
     * Get allowance
     *
     * @param int $userId
     */
    public function get(int $userId): object
    {
        $getAllowance = self::where('user_id', $userId)
            ->latest('created_at')
            ->first();

        return $getAllowance;
    }
}
