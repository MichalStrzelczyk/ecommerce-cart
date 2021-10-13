<?php
declare(strict_types=1);

namespace DigitalFarm;

use \DigitalFarm\Cart\IProduct;
use \DigitalFarm\Cart\Product\IPrice;
use \DigitalFarm\Cart\Product\Price\IPriceCalculator;

interface IFactory {

    public function createPrice(int $originalNetAmount,int $originalGrossAmount,int $netAmount,int $grossAmount,string $currency): IPrice;

    public function createCardProduct(string $code, string $name, IPrice $price): IProduct;

    public function createPriceCalculator(): IPriceCalculator;
}