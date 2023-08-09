<?php

namespace App\Domains\Expense\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    /**
     * Get the template fillable
     *
     * @var array<string>
     */
    protected $fillable = [
        'allowance_id',
        'expense',
        'memo',
        'type',
    ];

    /**
     * @return BelongsTo<Allowance,Expense>
     */
    public function allowance(): BelongsTo
    {
        return $this->belongsTo(Allowance::class);
    }

    /**
     * @return BelongsTo<User,Expense>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
