<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Throwable;

class Allowance extends Model
{
    use HasFactory;

    /**
     * Get the template file
     *
     * @var string $primaryKey
     */
    protected $primaryKey = 'allowance_id';

    /**
     * Get the template fillable
     *
     * @var Array[number] $fillable
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
            $allowance            = new Allowance();
            $allowance->user_id   = Auth::id();
            $allowance->allowance = $request['allowance'];
            $allowance->save();
            DB::commit();

            return 'success status: 200';
        } catch (Throwable $e) {
            DB::rollback();
            Log::error($e);

            return 'error status: ' . (string) $e->getCode() . 'error message: ' . $e->getMessage();
        }
    }

    /**
     * Get allowance
     *
     * @param integer $userId
     * @return object
     */
    public function get(int $userId): object {
        $getAllowance = self::where('user_id', $userId)
                            ->latest('created_at')
                            ->first();

        return $getAllowance;
    }
}
