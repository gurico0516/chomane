<?php

namespace App\Services;

use App\Models\Allowance;

class AllowanceService
{
    /**
     * Allowance model
     *
     * @var Allowance
     */
    protected $allowanceModel;

    /**
     * AllowanceService constructor
     *
     * @param Allowance $allowanceModel
     * @return void
     */
    public function __construct(Allowance $allowanceModel)
    {
        $this->allowanceModel = $allowanceModel;
    }
}
