# DiffieHellman-PHP
A Diffie Helmann implementation in PHP written by Hamza ESSAYEGH

## Installation
First of all, download and install Composer by following the [official instructions](https://getcomposer.org/download/) and the `php-gmp` library for your distribution
```bash
# Debian like installation
$ sudo apt-get install php-gmp
```

Then, you can install this implementation by running the following command:
```bash
$ composer require querdos/php-dh
```

## Usage
Simple example on how to generate a shared secret
```php
require_once 'vendor/autoload.php';

use Querdos\DiffieHellman;

// alice and bob generate their data and exchange public ones
$dh_bob   = new DiffieHellman();
$dh_alice = new DiffieHellman($dh_bob->getModulus(), $dh_bob->getBase());

// first initialization for both alice and bob (private and public keys generation)
$dh_bob->init();
$dh_alice->init();

// generating a shared secret with corresponding public keys
$dh_alice->compute_secret($dh_bob->getPublic());
$dh_bob->compute_secret($dh_alice->getPublic());

if (0 == gmp_cmp($dh_alice->getSecret(), $dh_bob->getSecret())) {
    echo "Alice and Bob share the same secret" . PHP_EOL;
} else {
    echo "Alice and Bob don't share the same secret" . PHP_EOL;
}
```
