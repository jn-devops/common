<?php

namespace Homeful\Common\Classes;

use Whitecube\Price\Price;

class DeductibleFeeFromPayment extends AmountCollectionItem {
    public function __construct(string $name, Price|float $amount)
    {
        parent::__construct($name, $amount, true);
    }
}
