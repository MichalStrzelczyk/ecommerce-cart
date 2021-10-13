<?php
declare(strict_types=1);

namespace DigitalFarm\Cart\OfferRule;

use \DigitalFarm\ICart;
use \DigitalFarm\IFactory;
use \DigitalFarm\Cart\IOfferRule;
use \DigitalFarm\Cart\Product\Price\Currency;

class Shipping implements IOfferRule {

    private IFactory $factory;

    public function __construct(IFactory $factory) {
        $this->factory = $factory;
    }

    public function modify(Icart $cart) {
        $prices = [];
        \array_filter($cart->getProducts(), function($product) use (&$prices){
            $prices[] = $product->getPrice();
        });

        $productsSum = $this->factory->createPriceCalculator()->sum(...$prices);
        if ($productsSum->getGrossAmount() < 5000) {
            $shippingCostAmount = 495;
        } elseif ($productsSum->getGrossAmount() < 9000) {
            $shippingCostAmount = 295;
        } else {
            $shippingCostAmount = 0;
        }

        $shippingCost = $this->factory->createPrice(
            $shippingCostAmount,
            $shippingCostAmount,
            $shippingCostAmount,
            $shippingCostAmount,
            Currency::CURRENCY_US_DOLLARS
        );

        $cart->setShippingCost($shippingCost);
    }
}