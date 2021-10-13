<?php
declare(strict_types=1);

namespace DigitalFarm\Cart\Product;

class Price implements IPrice {
    public int $originalNetAmount;
    public int $originalGrossAmount;
    public int $netAmount;
    public int $grossAmount;
    public string $currency = Price\Currency::CURRENCY_US_DOLLARS;

    /**
     * @return int
     */
    public function getOriginalNetAmount(): int
    {
        return $this->originalNetAmount;
    }

    /**
     * @param int $originalNetAmount
     */
    public function setOriginalNetAmount(int $originalNetAmount): self
    {
        $this->originalNetAmount = $originalNetAmount;

        return $this;
    }

    /**
     * @return int
     */
    public function getOriginalGrossAmount(): int
    {
        return $this->originalGrossAmount;
    }

    /**
     * @param int $originalGrossAmount
     */
    public function setOriginalGrossAmount(int $originalGrossAmount): self
    {
        $this->originalGrossAmount = $originalGrossAmount;

        return $this;
    }

    /**
     * @return int
     */
    public function getNetAmount(): int
    {
        return $this->netAmount;
    }

    /**
     * @param int $netAmount
     */
    public function setNetAmount(int $netAmount): self
    {
        $this->netAmount = $netAmount;

        return $this;
    }

    /**
     * @return int
     */
    public function getGrossAmount(): int
    {
        return $this->grossAmount;
    }

    /**
     * @param int $grossAmount
     */
    public function setGrossAmount(int $grossAmount): self
    {
        $this->grossAmount = $grossAmount;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }



}