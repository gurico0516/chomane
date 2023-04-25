<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Throwable;

class Expense extends Model
{
    use HasFactory;

    /**
     * Get the template fillable
     *
     * @var Array[number] $fillable
     */
    protected $fillable = [
        'allowance_id',
        'expence',
        'memo',
        'type',
    ];
}
