<?php
declare(strict_types=1);

namespace DigitalFarm\Cart\OfferRule;

use DigitalFarm\ICart;
use \DigitalFarm\Cart\IOfferRule;

class RedWidgetDiscount implements IOfferRule {

    public function modify(Icart $cart) {
        $redWidgets = \array_filter($cart->getProducts(), function($product){
            return $product->getCode() === "R01";
        });

        // Do nothing if there are less than 2 red widgets into basket
        if (\count($redWidgets) <= 1) {
            return;
        }

        // How many products must be discounted?
        $discountedProductsCount = (int) \floor(\count($redWidgets) / 2);

        // Remove any already discounted products
        foreach($redWidgets as $product) {
            $product->getPrice()->setNetAmount($product->getPrice()->getOriginalNetAmount());
            $product->getPrice()->setGrossAmount($product->getPrice()->getOriginalGrossAmount());
        }

        // Add discount
        $i = 0;
        foreach($redWidgets as $key => $product) {
            $product->getPrice()->setNetAmount($this->dev($product->getPrice()->getOriginalNetAmount(),2));
            $product->getPrice()->setGrossAmount($this->dev($product->getPrice()->getOriginalNetAmount(),2));
            $i++;
            if ($i === $discountedProductsCount) {
                break;
            }
        }
    }

    private function dev(int $amount, float $dev): int {
        return (int) \bcdiv((string) $amount, (string) $dev, 0);
    }
}