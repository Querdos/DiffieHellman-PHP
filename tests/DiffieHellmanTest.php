<?php
use PHPUnit\Framework\TestCase;

require_once '../lib/DiffieHellman.php';
require_once '../lib/PredefinedValues.php';

/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 4/15/17
 * Time: 4:22 PM
 */
class DiffieHellmanTest extends TestCase
{
    public function testSecret()
    {
        $this->expectException(\Exception::class);
        new DiffieHellman(0);

        $this->expectException(InvalidArgumentException::class);
        new DiffieHellman(gmp_init(1), 0);

        $this->expectException(InvalidArgumentException::class);
        new DiffieHellman(null, null, null);

        $this->expectException(Exception::class);
        new DiffieHellman(gmp_init("1"), null);

        $this->expectException(Exception::class);
        new DiffieHellman(-1, null);

        $dh_alice = new DiffieHellman();
        $dh_bob   = new DiffieHellman($dh_alice->getModulus(), $dh_alice->getBase());

        $this->assertNotNull($dh_alice->getModulus(), "Modulus null for Alice");
        $this->assertNotNull($dh_alice->getBase(), "Base null for Alice");

        $this->assertNotNull($dh_bob->getModulus(), "Modulus null for Bob");
        $this->assertNotNull($dh_bob->getBase(), "Base null for Bob");

        $dh_alice->init();
        $this->assertNotNull($dh_alice->getPrivate(), "Private key null for Alice");
        $this->assertNotNull($dh_alice->getPublic(), "Public key null for Alice");

        $dh_bob->init();
        $this->assertNotNull($dh_bob->getPrivate(), "Private key null for Bob");
        $this->assertNotNull($dh_bob->getPublic(), "Public key null for Bob");

        $dh_alice->compute_secret($dh_bob->getPublic());
        $dh_bob->compute_secret($dh_alice->getPublic());

        $this->assertEquals(0, gmp_cmp($dh_alice->getSecret(), $dh_bob->getSecret()), "Secret differents for bob and alice");
    }
}
