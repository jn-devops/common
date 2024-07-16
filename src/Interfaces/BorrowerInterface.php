<?php

namespace Homeful\Common\Interfaces;

use Brick\Money\Money;
use Illuminate\Support\Carbon;
use Propaganistas\LaravelPhone\PhoneNumber;
use Whitecube\Price\Price;

interface BorrowerInterface
{
    public function getBirthdate(): Carbon;

    public function getWages(): Money|float;

    public function getRegional(): bool;

    public function getMobile(): PhoneNumber;

    public function getSellerCommissionCode(): string;

    function getGrossMonthlyIncome(): Price;
}
