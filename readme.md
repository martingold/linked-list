# linked-list

Library providing a standard sorted linked list implementation. The strict variant is offered for ensuring types in the list, making it suitable for non-typechecked codebases.
## Installation

You can install this library using [Composer](https://getcomposer.org/):

```sh
composer require martingold/linked-list
```

## Usage

```php
require 'vendor/autoload.php';

use MartinGold\LinkedList\SortedLinkedList;

$list = new SortedLinkedList();

$list->insert(1);
$list->insert(3);
$list->insert(7);

var_dump($list->pop());
```

Following list operations are supported: `insert`, `get`, `contains`, `shift`, `pop`

In case runtime checking is required in a non-typesafe codebase, consider using the StrictSortedLinkedList implementation, which performs type checking at runtime.

### Implementing custom sorting

The default implementation of sorting is done using spaceship operator.
You may use your own implementation of `Comparator` in case you need to
sort values depending on your needs.

```php

use MartinGold\LinkedList\Comparator\Comparator;
use MartinGold\LinkedList\SortedLinkedList;

class Product
{
    public function __construct(
        public readonly float $quantity, 
    ){
        //
    }
}

/**
 * @implements Comparator<Product>
 */
class ProductComparator implements Comparator
{
    public function compare(Product $a, Product $b): int
    {
        return $a->quantity <=> $b->quantity;
    }
}

$productList = new SortedLinkedList(new ProductComparator());
$productList->insert(new Product(20));
$productList->insert(new Product(31));
$productList->insert(new Product(12));

foreach ($productList as $product) {
    echo $product->quantity;
}

// 12
// 20
// 31

```

## Requirements
```
php >= 8.2
```

No other dependency required.

## Contributing

Modify the library as needed and then run
```sh
composer qa
```

Please ensure that this script passes successfully before submitting a pull request. The script performs checks for adherence to coding standards and performs static analysis checks.

If you encounter code-style errors, you can automatically fix them by running:

```sh
composer csf
```

## License
This library is open-source and available under the MIT License.