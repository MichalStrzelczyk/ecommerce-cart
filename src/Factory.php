<?php
declare(strict_types=1);

namespace DigitalFarm;

use \DigitalFarm\Cart\IProduct;
use \DigitalFarm\Cart\Product;
use \DigitalFarm\Cart\Product\IPrice;
use \DigitalFarm\Cart\Product\Price;
use \DigitalFarm\Cart\Product\Price\IPriceCalculator;
use \DigitalFarm\Cart\Product\Price\PriceCalculator;

class Factory implements IFactory {

    /**
     * Create new price object
     *
     * @param int $originalNetAmount
     * @param int $originalGrossAmount
     * @param int $netAmount
     * @param int $grossAmount
     * @param string $currency
     * @return IPrice
     */
    public function createPrice(
        int $originalNetAmount,
        int $originalGrossAmount,
        int $netAmount,
        int $grossAmount,
        string $currency
    ): IPrice {
        if (\strlen($currency) !== 3) {
            throw new \InvalidArgumentException("Incorrect currency");
        }

        if ($originalNetAmount < 0) {
            throw new \InvalidArgumentException("Original net price must be greater than 0");
        }

        if ($originalGrossAmount < 0) {
            throw new \InvalidArgumentException("Original gross price must be greater than 0");
        }

        if ($grossAmount < 0) {
            throw new \InvalidArgumentException("Gross price must be greater than 0");
        }

        if ($netAmount < 0) {
            throw new \InvalidArgumentException("Net price must be greater than 0");
        }

        if ($originalNetAmount > $originalGrossAmount ) {
            throw new \InvalidArgumentException("Incorrect original prices");
        }

        if ($netAmount > $grossAmount ) {
            throw new \InvalidArgumentException("Incorrect prices");
        }

        if ($netAmount > $originalNetAmount) {
            throw new \InvalidArgumentException("Net amount must be less than or equal to original net amount");
        }

        if ($grossAmount > $originalGrossAmount) {
            throw new \InvalidArgumentException("Gross amount must be less than or equal to original gross amount");
        }

        $price = new Price();
        $price
            ->setOriginalGrossAmount($originalGrossAmount)
            ->setOriginalNetAmount($originalNetAmount)
            ->setGrossAmount($grossAmount)
            ->setNetAmount($netAmount)
            ->setCurrency($currency);

        return $price;
    }

    public function createCardProduct(string $code, string $name, IPrice $price): IProduct {
        if (\strlen($code) === 0) {
            throw new \InvalidArgumentException("Product code must be defined");
        }

        if (\strlen($name) === 0) {
            throw new \InvalidArgumentException("Product name must be defined");
        }

        return (new Product())
            ->setCode($code)
            ->setName($name)
            ->setPrice($price);
    }

    public function createPriceCalculator(): IPriceCalculator {
        return new PriceCalculator(new Factory());
    }
}