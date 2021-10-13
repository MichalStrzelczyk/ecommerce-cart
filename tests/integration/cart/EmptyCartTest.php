<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use \DigitalFarm\Cart;
use PHPUnit\Framework\TestCase;

class EmptyCartTest extends TestCase
{
    private ?Cart $cart = null;

    protected function setUp(): void {
        $factory = new \DigitalFarm\Factory();
        $this->cart = new \DigitalFarm\Cart($factory->createPriceCalculator(), []);
    }

    public function testCountProducts(): void
    {
        $this->assertEquals(0, $this->cart->getProductsCount());
    }

    public function testGetTotalPrice(): void
    {
        $totalPrice = $this->cart->getTotalPrice();

        $this->assertEquals(0, $totalPrice->getGrossAmount());
        $this->assertEquals(0, $totalPrice->getNetAmount());
        $this->assertEquals(0, $totalPrice->getOriginalGrossAmount());
        $this->assertEquals(0, $totalPrice->getOriginalNetAmount());
        $this->assertEquals("USD", $totalPrice->getCurrency());
    }
}
