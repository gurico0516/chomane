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
     * @var array<string>
     */
    protected $fillable = [
        'allowance',
        'user_id',
    ];

    /**
     * Create allowance
     */
    public function create(array $request): void
    {
        DB::beginTransaction();
        try {
            $allowance = new Allowance();
            $allowance->user_id = Auth::id();
            $allowance->allowance = $request['allowance'];
            $allowance->save();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollback();
            Log::error($e);
        }
    }

    /**
     * Edit allowance
     */
    public function edit(array $request, int $allowanceId): void
    {
        DB::beginTransaction();
        try {
            self::find($allowanceId)->fill($request)->save();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollback();
            Log::error($e);
        }
    }

    /**
     * Delete allowance
     *
     * @throws \Exception
     */
    public function deleteAllowance(): void
    {
        DB::beginTransaction();
        try {
            self::where('user_id', Auth::id())->delete();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollback();
            Log::error('Failed to create an expense: ', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Get allowance
     */
    public function get(int $userId): ?object
    {
        $getAllowance = self::where('user_id', $userId)
            ->latest('created_at')
            ->first();

        return $getAllowance;
    }

    /**
     * Get one allowance
     */
    public function getOneById(int $userId): ?int
    {
        $allowance = self::where('user_id', $userId)
            ->latest('created_at')
            ->first();

        return $allowance->id;
    }
}
