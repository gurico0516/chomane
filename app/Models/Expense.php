<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
