<?php

namespace Homeful\Common\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Whitecube\Price\Price;
use Brick\Money\Money;

class PriceCast implements CastsAttributes
{
    /**
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return Price
     * @throws \Brick\Math\Exception\NumberFormatException
     * @throws \Brick\Math\Exception\RoundingNecessaryException
     * @throws \Brick\Money\Exception\UnknownCurrencyException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): Price
    {
        return (new Price(Money::ofMinor($value, 'PHP')))
            ->setVat(0);
    }

    /**
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return int
     * @throws \Brick\Math\Exception\MathException
     * @throws \Brick\Math\Exception\NumberFormatException
     * @throws \Brick\Math\Exception\RoundingNecessaryException
     * @throws \Brick\Money\Exception\UnknownCurrencyException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): int
    {
        return $value instanceof Price
            ? $value->inclusive()->getMinorAmount()->toInt()
            : Money::of($value, 'PHP')->getMinorAmount()->toInt()
            ;
    }
}
