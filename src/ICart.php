<?php
declare(strict_types=1);

namespace DigitalFarm;

use \DigitalFarm\Cart\IProduct;
use \DigitalFarm\Cart\Product\IPrice;

interface ICart {
    public function addProduct(IProduct $product, int $quantity = 1): ICart;
    public function removeProduct(string $productCartId): ICart;
    public function getTotalPrice(): Iprice;
    public function getProductsCount(): int;
    public function getShippingCost(): Iprice;
}