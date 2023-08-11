<?php

namespace App\Infrastructure\Repositories;

use App\Domains\Allowance\Entities\Allowance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class AllowanceRepository
{
    /**
     * Create allowance
     *
     * @param array $request
     * @return void
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
     *
     * @param array $request
     * @param int $allowanceId
     * @return void
     */
    public function edit(array $request, int $allowanceId): void
    {
        DB::beginTransaction();
        try {
            Allowance::find($allowanceId)->fill($request)->save();

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
     * @return void
     */
    public function deleteAllowance(): void
    {
        DB::beginTransaction();
        try {
            Allowance::where('user_id', Auth::id())->delete();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollback();
            Log::error('Failed to create an expense: ', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Get allowance
     *
     * @param int $userId
     * @return object
     */
    public function get(int $userId): ?object
    {
        $getAllowance = Allowance::where('user_id', $userId)
            ->latest('created_at')
            ->first();

        return $getAllowance;
    }

    /**
     * Get one allowance
     *
     * @param int $userId
     * @return int|null
     */
    public function getOneById(int $userId): ?int
    {
        $allowance = Allowance::where('user_id', $userId)
            ->latest('created_at')
            ->first();

        return $allowance->id;
    }
}
