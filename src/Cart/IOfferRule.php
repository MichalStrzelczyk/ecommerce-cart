<?php
declare(strict_types=1);

namespace DigitalFarm\Cart;

use DigitalFarm\ICart;

interface IOfferRule {
    public function modify(Icart $cart);
}