<?php
declare(strict_types=1);

namespace DigitalFarm\Cart\Product\Price;

use DigitalFarm\Cart\Product\IPrice;

interface IPriceCalculator {
    public function sum(...$prices): IPrice;
}