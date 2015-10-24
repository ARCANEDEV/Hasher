<?php namespace Arcanedev\Hasher\Tests\Stubs;

use Arcanedev\Hasher\Contracts\HashClient;

/**
 * Class     CustomHasherClient
 *
 * @package  Arcanedev\Hasher\Tests\Stubs
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CustomHasherClient implements HashClient
{
    protected $salt;

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the client.
     *
     * @return mixed
     */
    public function getClient()
    {
        return 'Custom hash client';
    }

    /**
     * Make a new Hash client.
     *
     * @param  array $configs
     *
     * @return self
     */
    public function make(array $configs)
    {
        $this->salt = array_get($configs, 'salt', '');

        return $this;
    }

    /**
     * Encode the value.
     *
     * @param  mixed $value
     *
     * @return string
     */
    public function encode($value)
    {
        $iv = mcrypt_create_iv($this->getIvSize(), MCRYPT_DEV_URANDOM);

        return base64_encode(
            $iv .
            mcrypt_encrypt(
                MCRYPT_RIJNDAEL_128,
                hash('sha256', $this->salt, true),
                $value,
                MCRYPT_MODE_CBC,
                $iv
            )
        );
    }

    /**
     * Decode the hashed value.
     *
     * @param  string $hash
     *
     * @return mixed
     */
    public function decode($hash)
    {
        $data = base64_decode($hash);
        $iv   = substr($data, 0, $this->getIvSize());

        return rtrim(
            mcrypt_decrypt(
                MCRYPT_RIJNDAEL_128,
                hash('sha256', $this->salt, true),
                substr($data, $this->getIvSize()),
                MCRYPT_MODE_CBC,
                $iv
            ),
            "\0"
        );
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the IV size.
     *
     * @return int
     */
    private function getIvSize()
    {
        return mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    }
}
