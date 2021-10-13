<?php
declare(strict_types=1);

namespace DigitalFarm\Cart;

use \DigitalFarm\Cart\Product\IPrice;

class Product implements IProduct {

    public string $code;
    public string $name;
    public Iprice $price;

    public function __clone(){
        $this->price = clone $this->price;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Iprice
     */
    public function getPrice(): Iprice
    {
        return $this->price;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param IPrice $price
     */
    public function setPrice(IPrice $price): self
    {
        $this->price = $price;

        return $this;
    }
}
