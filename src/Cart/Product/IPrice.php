<?php
declare(strict_types=1);

namespace DigitalFarm\Cart\Product;

interface IPrice {
    public function getOriginalNetAmount(): int;
    public function getOriginalGrossAmount(): int;
    public function getNetAmount(): int;
    public function getGrossAmount(): int;
    public function getCurrency(): string;
}