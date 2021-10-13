<?php
declare(strict_types=1);

namespace DigitalFarm\Repository;

use \DigitalFarm\Cart\IProduct;
use \DigitalFarm\IFactory;

final class Product
{
    private IFactory $factory;

    private array $cache = [];

    public function __construct(IFactory $factory) {
        $this->factory = $factory;
        $this->loadData();
    }

    public function getByCode(string $code): IProduct {
        if (!isset($this->cache[$code])) {
            throw new \DomainException("There is no product with code: " . $code);
        }

        return clone $this->cache[$code];
    }

    private function loadData(){
        $data = \json_decode(\file_get_contents(\realpath("./data/products.json")), true);
        foreach ($data as $productData) {
               $product = $this->factory->createCardProduct(
                   $productData['code'],
                   $productData['name'],
                   $this->factory->createPrice(
                        $productData['price'],
                        $productData['price'],
                        $productData['price'],
                        $productData['price'],
                        $productData['currency'],
                    )
               );

               $this->cache[$product->getCode()] = $product;
        }
    }
}