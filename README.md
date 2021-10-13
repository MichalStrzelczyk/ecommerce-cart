# Cart library

A simple example of implementing a shopping cart in an ecommerce portal.

## 1. Installation

```php
git clone git@github.com:MichalStrzelczyk/ecommerce-cart.git
cd ecommerce-cart && composer install
```

## 2. Usage

In order to create a new shopping cart, the object

You can see more examples of the library's use in integration tests here:
[./tests]

## 2.1 Creating

## 2.2 Adding product



```php
    $card->addProduct($product,10);
```

**CAUTION: default quantity is set to 1**

**CAUTION: product objects are ALWAYS cloned**


## 2.3 Removing product

To remove any product from the cart, you must use the `removeProduct` method.
It is not possible to remove many products on the same time.

```php
    $card->removeProduct($productHash);
```
**CAUTION: if you want to remove not existing product, the InvalidArgumentException will be thrown**

## 2.4 Special offers

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