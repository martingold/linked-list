# linked-list

Library providing standard sorted linked list implementation. The strict variant is available to ensure types in list (can be used in non-typechecked codebases). Refer to 

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

in case you need runtime checking (non-typesafe codebase), please use
`StrictSortedLinkedList` implementation which checks for types at runtime as well.

## Requirements
```
php >= 8.2
```

No other dependecy required.

## Contributing

Modify the project as needed and then run
```sh
composer qa
```

The script must pass before merging pull request. The script checks for correct coding standard and runs static analysis.

You may run

```sh
composer csf
```
to fix code-style errors automatically.

## License
This library is open-source and available under the MIT License.