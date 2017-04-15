<?php

require_once 'PredefinedValues.php';

/**
 * Class DiffieHellman
 * @author Hamza ESSAYEGH <hamza.essayegh@protonmail.com>
 */
class DiffieHellman
{
    const PREDEFINED_1536 = 0;
    const PREDEFINED_3072 = 1;
    const PREDEFINED_4096 = 2;
    const PREDEFINED_6144 = 3;
    const PREDEFINED_8192 = 4;

    const PRIVATE_KEY_LENGTH = 1024;

    /**
     * @var \GMP
     */
    private $modulus;

    /**
     * @var \GMP
     */
    private $base;

    /**
     * @var \GMP
     */
    private $public;

    /**
     * @var
     */
    private $private;

    /**
     * @var \GMP
     */
    private $secret;

    /**
     * DiffieHellman constructor.
     *
     * @param \GMP $modulus
     * @param \GMP $base
     * @param int  $predefined
     *
     * @throws \Exception
     */
    public function __construct($modulus = null, $base = null, $predefined = -1)
    {
        if (null === $modulus && null === $base) {
            switch ($predefined) {
                case self::PREDEFINED_1536:
                    list(
                        $this->modulus,
                        $this->base
                    ) = dh_predefined_1536();
                    break;
                case self::PREDEFINED_3072:
                    list(
                        $this->modulus,
                        $this->base
                    ) = dh_predefined_3072();
                    break;
                case self::PREDEFINED_4096:
                    list(
                        $this->modulus,
                        $this->base
                    ) = dh_predefined_4096();
                    break;
                case self::PREDEFINED_6144:
                    list(
                        $this->modulus,
                        $this->base
                    ) = dh_predefined_6144();
                    break;
                case self::PREDEFINED_8192:
                    list(
                        $this->modulus,
                        $this->base
                    ) = dh_predefined_8192();
                    break;
                case -1:
                    list(
                        $this->modulus,
                        $this->base
                    ) = dh_predefined_1536();
                    break;
                default:
                    throw new \InvalidArgumentException("Invalid value for predefined (value=`$predefined`)");
            }
        } else if (null !== $modulus && null !== $base) {
            if (!($modulus instanceof \GMP)) {
                throw new \InvalidArgumentException("Modulus must be an instance of GMP");
            } else if (!($base instanceof \GMP)) {
                throw new \InvalidArgumentException("Base must be an instance of GMP");
            }

            $this->modulus = $modulus;
            $this->base    = $base;
        } else {
            throw new \Exception("Invalid values for the modulus and the base");
        }
    }

    /**
     * Initialize the DH process by generating the public and private key
     */
    public function init()
    {
        // generate private key
        $this->generate_private_key();

        // compute public key
        $this->compute_public();
    }

    /**
     * Generate the private key for the built object
     */
    public function generate_private_key()
    {
        // generating private key
        $this->private = gmp_random_bits(self::PRIVATE_KEY_LENGTH);
    }

    /**
     * Compute the public for the built object
     */
    public function compute_public()
    {
        $this->public = gmp_powm($this->base, $this->private, $this->modulus);
    }

    /**
     * Compute the secret with the given public key
     *
     * @param \GMP $public
     */
    public function compute_secret(\GMP $public = null)
    {
        if (null !== $public) {
            $this->secret = gmp_powm($public, $this->private, $this->modulus);
        } else {
            $this->secret = gmp_powm($this->public, $this->private, $this->modulus);
        }
    }
    
    /**
     * @return \GMP
     */
    public function getModulus()
    {
        return $this->modulus;
    }

    /**
     * @param \GMP $modulus
     *
     * @return DiffieHellman
     */
    public function setModulus(\GMP $modulus)
    {
        $this->modulus = $modulus;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * @param \GMP $base
     *
     * @return DiffieHellman
     */
    public function setBase($base)
    {
        $this->base = $base;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * @param mixed $public
     *
     * @return DiffieHellman
     */
    public function setPublic($public)
    {
        $this->public = $public;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * @param mixed $private
     *
     * @return DiffieHellman
     */
    public function setPrivate($private)
    {
        $this->private = $private;
        return $this;
    }

    /**
     * @return \GMP
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param \GMP $secret
     *
     * @return DiffieHellman
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
        return $this;
    }
}
