<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use \DigitalFarm\Cart;
use \DigitalFarm\IFactory;
use \DigitalFarm\Repository\Product as Repository;
use PHPUnit\Framework\TestCase;

class ShippingCostsLess9000Test extends TestCase
{
    private ?Cart $cart = null;
    private IFactory $factory;

    protected function setUp(): void {
        $this->factory = new \DigitalFarm\Factory();
        $this->cart = new \DigitalFarm\Cart($this->factory->createPriceCalculator(), [
            new \DigitalFarm\Cart\OfferRule\Shipping($this->factory)
        ]);
    }

    public function testGetShippingCostForLess9000(): void
    {
        $product = $this->factory->createCardProduct(
            "Test01",
            "Test 01",
            $this->factory->createPrice(
                8999,
                8999,
                8999,
                8999,
                "USD"
            )
        );
        $this->cart->addProduct($product);
        $totalPrice = $this->cart->getTotalPrice();

        $this->assertEquals(8999 + 295, $totalPrice->getGrossAmount());
        $this->assertEquals(8999 + 295, $totalPrice->getNetAmount());
        $this->assertEquals(8999 + 295, $totalPrice->getOriginalGrossAmount());
        $this->assertEquals(8999 + 295, $totalPrice->getOriginalNetAmount());
        $this->assertEquals("USD", $totalPrice->getCurrency());
    }
}
