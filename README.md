# Cart library

A simple example of implementing a shopping cart in an ecommerce portal.

## 1. Installation

```php
git clone git@github.com:MichalStrzelczyk/ecommerce-cart.git
cd ecommerce-cart && composer install
```

## 2. Usage
This library can be used for ecommerce projects that require storage of products selected by the customer. Basic functionalities are described in details below.

You can see more examples of the library's use in integration tests [here](./tests/integration):

### 2.1 Creating

Creating a new instance of the shopping cart requires the injection of a class that will implement the `IPriceCalculator` interface.  
This class is responsible for performing mathematical operations on transport objects implementing the IPrice interface.
This library already contains the default PriceCalculator implementation.

An example how to create new instance of cart:
```php
    $factory = new Factory();
    $cart = new Cart($factory->createPriceCalculator(), [
            new Cart\OfferRule\RedWidgetDiscount($factory),
            new Cart\OfferRule\Shipping($factory)
    ]);    
```

As a second parameter, the special offers can be injected. You can read more about this in the section 2.4

### 2.2 Adding product

To add product to the cart you must run the `addProduct` method. The product parameter must implement the `IProduct` 
interface. As a second parameter you can set product quantity. Each time a product is added to the shopping cart a unique
hash is generated. This is then used to remove the selected product from the cart.

```php
    $card->addProduct($product, 10);
```

**CAUTION: default quantity is set to 1**

**CAUTION: product objects are ALWAYS cloned**

To see all product you can run

```php
$products = $card->getProducts();
```
As a result you will get:
```php
.array(2) {
  ["616832b7da1c6"]=>
  object(DigitalFarm\Cart\Product)#259 (3) {
    ["code"]=>
    string(3) "R01"
    ["name"]=>
    string(10) "Red Widget"
    ["price"]=>
    object(DigitalFarm\Cart\Product\Price)#258 (5) {
      ["originalNetAmount"]=>
      int(3295)
      ["originalGrossAmount"]=>
      int(3295)
      ["netAmount"]=>
      int(1647)
      ["grossAmount"]=>
      int(1647)
      ["currency"]=>
      string(3) "USD"
    }
  }
  ["616832b7da1c9"]=>
  object(DigitalFarm\Cart\Product)#257 (3) {
    ["code"]=>
    string(3) "R01"
    ["name"]=>
    string(10) "Red Widget"
    ["price"]=>
    object(DigitalFarm\Cart\Product\Price)#256 (5) {
      ["originalNetAmount"]=>
      int(3295)
      ["originalGrossAmount"]=>
      int(3295)
      ["netAmount"]=>
      int(1647)
      ["grossAmount"]=>
      int(1647)
      ["currency"]=>
      string(3) "USD"
    }
  }
}
......
```

If you want to see how many products are in your cart you can use the following method:

```php 
    $card->getProductsCount();
```

To see a cart summary with the amount to be paid including all special offers and shipping cost you can call the method:

```php 
    $totalPrice = $card->getTotalPrice();
```

### 2.3 Removing product

To remove any product from the cart, you must use the `removeProduct` method.
It is not possible to remove many products on the same time.

```php
    $card->removeProduct($productHash);
```
**CAUTION: if you want to remove not existing product, the InvalidArgumentException will be thrown**

### 2.4 Special offers

Special offer is a class which must implement the `ISpecialOffer` interface.
These objects are run every time when product is added to the card or is deleted.
By special offer you are able to define custom business basket behavior like: creating discounts for product, group or products, rules of shipping costs etc...  

**CAUTION: the order of definition special offers objects matters** 

All special orders must be injected during the card object is created.
It is not possible to edit them on the fly.

## 3. Tests

After all extended libraries are installed by the composer you can run test using this method: 

```php
    ./vendor/bin/phpunit .
```

If you want to run only specific type of tests you can define the main test folder like:

```php
    ./vendor/bin/phpunit ./tests/integrations
```

## 4. To_do
- creating unit tests
- creating pre & post hooks