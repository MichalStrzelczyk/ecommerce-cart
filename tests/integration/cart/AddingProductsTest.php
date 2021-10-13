<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use \DigitalFarm\Cart;
use \DigitalFarm\Repository\Product as Repository;
use PHPUnit\Framework\TestCase;

class AddingProductsTest extends TestCase
{
    private ?Cart $cart = null;
    private Repository $repository;

    protected function setUp(): void {
        $factory = new \DigitalFarm\Factory();
        $this->repository = new Repository($factory);
        $this->cart = new \DigitalFarm\Cart($factory->createPriceCalculator(), []);
    }

    public function testGetTotalPriceForOneProduct(): void
    {
        $blue = $this->repository->getByCode("B01");
        $this->cart->addProduct($blue);

        $totalPrice = $this->cart->getTotalPrice();
        $this->assertEquals(795, $totalPrice->getGrossAmount());
        $this->assertEquals(795, $totalPrice->getNetAmount());
        $this->assertEquals(795, $totalPrice->getOriginalGrossAmount());
        $this->assertEquals(795, $totalPrice->getOriginalNetAmount());
        $this->assertEquals("USD", $totalPrice->getCurrency());
    }

    public function testGetTotalPriceForManyProduct(): void
    {
        $this->cart->addProduct($this->repository->getByCode("B01"),2);
        $this->cart->addProduct($this->repository->getByCode("R01"), 3);

        $totalPrice = $this->cart->getTotalPrice();
        $this->assertEquals(795 + 795 + 3295 + 3295 + 3295, $totalPrice->getGrossAmount());
        $this->assertEquals(795 + 795 + 3295 + 3295 + 3295, $totalPrice->getNetAmount());
        $this->assertEquals(795 + 795 + 3295 + 3295 + 3295, $totalPrice->getOriginalGrossAmount());
        $this->assertEquals(795 + 795 + 3295 + 3295 + 3295, $totalPrice->getOriginalNetAmount());
        $this->assertEquals("USD", $totalPrice->getCurrency());
    }
}
