# Riddlestone Brokkr-Console

A [Laminas](https://github.com/laminas) module for [Symfony Console](https://github.com/symfony/console)

## Installation

Installation of this module uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

```sh
composer require riddlestone/brokkr-console
```

## Usage

To include your `Symfony\Component\Console\Command\Command` commands in the console, add them to your module's config file:

```php
<?php
return [
    'console' => [
        'commands' => [
            'My\\Command',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'My\\Command' => 'My\\CommandFactory',
        ],
    ],
];
```

Your command will now be available in your project:
```sh
vendor/bin/brokkr my-command
```

## Get Involved

File issues at https://github.com/riddlestone/brokkr-console/issues
