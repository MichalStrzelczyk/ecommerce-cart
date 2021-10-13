<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use \DigitalFarm\Cart;
use \DigitalFarm\IFactory;
use \DigitalFarm\Repository\Product as Repository;
use PHPUnit\Framework\TestCase;

class ShippingCostsLess5000Test extends TestCase
{
    private ?Cart $cart = null;
    private IFactory $factory;

    protected function setUp(): void {
        $this->factory = new \DigitalFarm\Factory();
        $this->cart = new \DigitalFarm\Cart($this->factory->createPriceCalculator(), [
            new \DigitalFarm\Cart\OfferRule\Shipping($this->factory)
        ]);
    }

    public function testGetShippingCostForLess5000(): void
    {
        $product = $this->factory->createCardProduct(
            "Test01",
            "Test 01",
            $this->factory->createPrice(
                4999,
                4999,
                4999,
                4999,
                "USD"
            )
        );
        $this->cart->addProduct($product);
        $totalPrice = $this->cart->getTotalPrice();

        $this->assertEquals(4999 + 495, $totalPrice->getGrossAmount());
        $this->assertEquals(4999 + 495, $totalPrice->getNetAmount());
        $this->assertEquals(4999 + 495, $totalPrice->getOriginalGrossAmount());
        $this->assertEquals(4999 + 495, $totalPrice->getOriginalNetAmount());
        $this->assertEquals("USD", $totalPrice->getCurrency());
    }

    public function testGetShippingCostFor5000(): void
    {
        $product = $this->factory->createCardProduct(
            "Test02",
            "Test 02",
            $this->factory->createPrice(
                5000,
                5000,
                5000,
                5000,
                "USD"
            )
        );
        $this->cart->addProduct($product);
        $totalPrice = $this->cart->getTotalPrice();

        $this->assertEquals(5000 + 295, $totalPrice->getGrossAmount());
        $this->assertEquals(5000 + 295, $totalPrice->getNetAmount());
        $this->assertEquals(5000 + 295, $totalPrice->getOriginalGrossAmount());
        $this->assertEquals(5000 + 295, $totalPrice->getOriginalNetAmount());
        $this->assertEquals("USD", $totalPrice->getCurrency());
    }

}
