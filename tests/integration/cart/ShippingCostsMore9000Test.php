<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use \DigitalFarm\Cart;
use \DigitalFarm\IFactory;
use PHPUnit\Framework\TestCase;

class ShippingCostsMore9000Test extends TestCase
{
    private ?Cart $cart = null;
    private IFactory $factory;

    protected function setUp(): void {
        $this->factory = new \DigitalFarm\Factory();
        $this->cart = new \DigitalFarm\Cart($this->factory->createPriceCalculator(), [
            new \DigitalFarm\Cart\OfferRule\Shipping($this->factory)
        ]);
    }

    public function testGetShippingCostFor9000(): void
    {
        $product = $this->factory->createCardProduct(
            "Test01",
            "Test 01",
            $this->factory->createPrice(
                9000,
                9000,
                9000,
                9000,
                "USD"
            )
        );
        $this->cart->addProduct($product);
        $totalPrice = $this->cart->getTotalPrice();

        $this->assertEquals(9000, $totalPrice->getGrossAmount());
        $this->assertEquals(9000, $totalPrice->getNetAmount());
        $this->assertEquals(9000, $totalPrice->getOriginalGrossAmount());
        $this->assertEquals(9000, $totalPrice->getOriginalNetAmount());
        $this->assertEquals("USD", $totalPrice->getCurrency());
    }

    public function testGetShippingCostForMore9000(): void
    {
        $product = $this->factory->createCardProduct(
            "Test01",
            "Test 01",
            $this->factory->createPrice(
                9001,
                9001,
                9001,
                9001,
                "USD"
            )
        );
        $this->cart->addProduct($product);
        $totalPrice = $this->cart->getTotalPrice();

        $this->assertEquals(9001, $totalPrice->getGrossAmount());
        $this->assertEquals(9001, $totalPrice->getNetAmount());
        $this->assertEquals(9001, $totalPrice->getOriginalGrossAmount());
        $this->assertEquals(9001, $totalPrice->getOriginalNetAmount());
        $this->assertEquals("USD", $totalPrice->getCurrency());
    }
}
