# DiffieHellman-PHP
[![Build Status](https://travis-ci.org/Querdos/DiffieHellman-PHP.svg?branch=master)](https://travis-ci.org/Querdos/DiffieHellman-PHP)  

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
<?php
require_once 'vendor/autoload.php';

use Querdos\DiffieHellman;

// alice and bob generate their data and exchange public ones
$dh_bob   = new DiffieHellman();
$dh_alice = new DiffieHellman(null, $dh_bob->getModulus(), $dh_bob->getBase());

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

## Predefined values for the modulus and the base
In order to compute the secret and according to the corresponding RFC, there is a set of predefined values for g and p. You can specify which one you want in the constructor:
```php
<?php
$dh = new DiffieHellman();                      // no value, 1536bits by default
$dh = new DiffieHellman(self::PREDEFINED_1536); // 1536bits length
$dh = new DiffieHellman(self::PREDEFINED_3072); // 3072bits length 
$dh = new DiffieHellman(self::PREDEFINED_4096); // 4096bits length
$dh = new DiffieHellman(self::PREDEFINED_6144); // 6144bits length
$dh = new DiffieHellman(self::PREDEFINED_8192); // 8192bits length
```

