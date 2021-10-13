<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use \DigitalFarm\Cart;
use \DigitalFarm\IFactory;
use \DigitalFarm\Repository\Product as Repository;
use PHPUnit\Framework\TestCase;

class OfferRuleScenarioTest extends TestCase
{
    private ?Cart $cart = null;
    private IFactory $factory;
    private Repository $repository;

    protected function setUp(): void {
        $this->factory = new \DigitalFarm\Factory();
        $this->cart = new \DigitalFarm\Cart($this->factory->createPriceCalculator(), [
            new \DigitalFarm\Cart\OfferRule\RedWidgetDiscount($this->factory),
            new \DigitalFarm\Cart\OfferRule\Shipping($this->factory)
        ]);
        $this->repository = new Repository($this->factory);
    }

    public function testScenario1(): void
    {
        $this->cart->addProduct($this->repository->getByCode("B01"));
        $this->cart->addProduct($this->repository->getByCode("G01"));
        $totalPrice = $this->cart->getTotalPrice();

        $this->assertEquals(3785, $totalPrice->getGrossAmount());
        $this->assertEquals("USD", $totalPrice->getCurrency());
    }

    public function testScenario2(): void
    {
        $this->cart->addProduct($this->repository->getByCode("R01"));
        $this->cart->addProduct($this->repository->getByCode("R01"));
        $totalPrice = $this->cart->getTotalPrice();

        $this->assertEquals(5437, $totalPrice->getGrossAmount());
        $this->assertEquals("USD", $totalPrice->getCurrency());
    }

    public function testScenario3(): void
    {
        $this->cart->addProduct($this->repository->getByCode("R01"));
        $this->cart->addProduct($this->repository->getByCode("G01"));
        $totalPrice = $this->cart->getTotalPrice();

        $this->assertEquals(6085, $totalPrice->getGrossAmount());
        $this->assertEquals("USD", $totalPrice->getCurrency());
    }

    public function testScenario4(): void
    {
        $this->cart->addProduct($this->repository->getByCode("B01"),2);
        $this->cart->addProduct($this->repository->getByCode("R01"),3);
        $totalPrice = $this->cart->getTotalPrice();

        $this->assertEquals(9827, $totalPrice->getGrossAmount());
        $this->assertEquals("USD", $totalPrice->getCurrency());
    }

}
