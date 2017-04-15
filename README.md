# DiffieHellman-PHP
A Diffie Helmann implementation in PHP.

## Usage
Simple example on how to generate a shared secret
```php
require_once 'path/to/Autoloader.php';
Autoload::register();

// alice and bob generate their data and exchange public ones
$dh_bob   = new DiffieHellman();
$dh_alice = new DiffieHellman($dh_bob->getModulus(), $dh_bob->getBase(), DiffieHellman::PREDEFINED_8192);

// Alice and Bob generate the same secret with their own
$dh_alice->compute_secret($dh_bob->getPublic());
$dh_bob->compute_secret($dh_alice->getPublic());

if (gmp_strval($dh_alice->getSecret()) === gmp_strval($dh_bob->getSecret())) {
    echo "Alice and Bob share the same secret" . PHP_EOL;
} else {
    echo "Alice and Bob don't share the same secret" . PHP_EOL;
}
```
