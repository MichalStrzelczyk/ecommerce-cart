<?php
declare(strict_types=1);

namespace DigitalFarm;

use \DigitalFarm\Cart\IProduct;
use \DigitalFarm\Cart\Product\IPrice;
use \DigitalFarm\Cart\IOfferRule;
use \DigitalFarm\Cart\Product\Price\IPriceCalculator;

class Cart implements ICart {

    /** @var []IProduct $products */
    private $products = [];

    /** @var IPrice|null  */
    private ?IPrice $shipping = null;

    /** @var IPriceCalculator|null  */
    private ?IPriceCalculator $priceCalculator = null;

    /** @var []IOfferRule $offerRules  */
    private array $offerRules = [];

    public function __construct(IPriceCalculator $priceCalculator, array $offerRules = []){
        if (\count($offerRules) > 0 ) {
            foreach($offerRules as $offerRule){
                if (!($offerRule instanceof IOfferRule)) {
                    throw new \InvalidArgumentException("Invalid offer rule");
                }
            }
        }

        $this->priceCalculator = $priceCalculator;
        $this->offerRules = $offerRules;
    }

    public function addProduct(IProduct $product, int $quantity = 1): ICart {
        for ($i=0;$i<$quantity;$i++){
            $productCartId = \uniqid();
            $this->products[$productCartId] = clone $product;
        }

        $this->refreshState();

        return $this;
    }

    public function removeProduct(string $productCartId):ICart{
        if (!isset($this->products[$productCartId])){
            throw new \InvalidArgumentException("Product cart with id: ".$productCartId." doesn't exist");
        }

        unset($this->products[$productCartId]);
        $this->refreshState();

        return $this;
    }

    public function getProducts(): array {
        return $this->products;
    }

    public function getProductsCount(): int {
        return \count($this->products);
    }

    public function getTotalPrice(): Iprice {
        $prices = [];

        foreach ($this->products as $product) {
            $prices[] = $product->getPrice();
        }

        if ($this->shipping !== null) {
            $prices[] = $this->shipping;
        }

        return $this->priceCalculator->sum(...$prices);
    }

    protected function refreshState(){
        foreach($this->offerRules as $offerRule){
            $offerRule->modify($this);
        }
    }

    public function getShippingCost(): IPrice {
        return $this->shipping;
    }

    public function setShippingCost(IPrice $shippingCost): self {
        $this->shipping = $shippingCost;

        return $this;
    }
}