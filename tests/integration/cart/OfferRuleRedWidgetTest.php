<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use \DigitalFarm\Cart;
use \DigitalFarm\IFactory;
use \DigitalFarm\Repository\Product as Repository;
use PHPUnit\Framework\TestCase;

class OfferRuleRedWidgetTest extends TestCase
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

    /**
     * @dataProvider dataSet
     *
     * @param int $quantity
     * @param int $expectedPrice
     * @param int $expectedOriginalPrice
     */
    public function testWithOneProduct(int $quantity, int $expectedPrice, int $expectedOriginalPrice): void
    {
        $this->cart->addProduct($this->repository->getByCode("R01"), $quantity);
        $totalPrice = $this->cart->getTotalPrice();

        $this->assertEquals($expectedPrice, $totalPrice->getGrossAmount());
        $this->assertEquals($expectedPrice, $totalPrice->getNetAmount());
        $this->assertEquals($expectedOriginalPrice, $totalPrice->getOriginalGrossAmount());
        $this->assertEquals($expectedOriginalPrice, $totalPrice->getOriginalNetAmount());
        $this->assertEquals("USD", $totalPrice->getCurrency());
    }

    public function dataSet(): array {
        return [
            [
                1, 3295 + 495, 3295 + 495
            ],
            [
                2, 3295 + 1647 + 495, 3295 + 3295 + 495
            ],
            [
                3, 3295 + 1647 + 3295 + 295, 3295 + 3295 + 3295 + 295
            ],
            [
                4, 3295 + 1647 + 3295 + 1647, 3295 + 3295 + 3295 + 3295
            ]
        ];
    }
}
