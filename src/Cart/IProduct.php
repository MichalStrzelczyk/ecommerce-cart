<?php
declare(strict_types=1);

namespace DigitalFarm\Cart;

use \DigitalFarm\Cart\Product\IPrice;

interface IProduct {
    public function getCode(): string;
    public function getName(): string;
    public function getPrice(): IPrice;
}
