<?php
declare(strict_types=1);

namespace DigitalFarm\Cart\Product\Price;

use \DigitalFarm\Cart\Product\IPrice;
use \DigitalFarm\IFactory;
use \DigitalFarm\Cart\Product\Price\Currency;

class PriceCalculator implements IPriceCalculator {

    protected IFactory $factory;

    public function __construct(IFactory $factory) {
        $this->factory = $factory;
    }
    public function sum(...$prices): IPrice {
        $originalNetAmount = 0;
        $originalGrossAmount = 0;
        $grossAmount = 0;
        $netAmount = 0;
        $currency = Currency::CURRENCY_US_DOLLARS;

        foreach ($prices as $price){
            if (!($price instanceof IPrice)) {
                throw new \InvalidArgumentException("Every argument must implement the `IPrice` interface");
            }

            // First iteration
            if ($currency === "") {
                $currency = $price->getCurrency();
            }

            if ($currency !== $price->getCurrency()) {
                throw new \DomainException("Only prices with the same currencies can be add");
            }

            $originalNetAmount += $price->getOriginalNetAmount();
            $originalGrossAmount += $price->getOriginalGrossAmount();
            $grossAmount += $price->getGrossAmount();
            $netAmount += $price->getNetAmount();
        }

        return $this->factory->createPrice($originalNetAmount,$originalGrossAmount,$netAmount,$grossAmount, $currency);
    }
}