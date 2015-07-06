<?php

namespace Deck\Application;

use Deck\Types\Hash;

/**
 * The short description
 *
 * As many lines of extendend description as you want {@link element}
 * links to an element
 * {@link http://www.example.com Example hyperlink inline link} links to
 * a website. The inline
 *
 * @package package name
 * @author  Pedro Koblitz
 */
class Encryption implements EncryptionInterface
{

    /**
     * @var
     */
    protected $hash;

    protected $iv;

    protected $cipher;
    
    /**
     * The short description
     *
     * @access public
     * @param  type [ $varname] description
     * @return type description
     */
    public function __construct($cipher = 'mcrypt')
    {

        if ($cipher === 'aes' && !extension_loaded('openssl')) {
            throw new \Exception("Error Processing Request");
        }

        if ($cipher === 'mcrypt' && !extension_loaded('mcrypt')) {
            throw new \Exception("Error Processing Request");
        }

        $this->cipher = $cipher;
        
        $this->hash = new Hash();
        $this->hash->setSalt(self::ENCRYPTION_SALT);
    }

    /**
     * The short description
     *
     * @access public
     * @param  type [ $varname] description
     * @return type description
     */
    public function hashString($password)
    {

        return $this->hash->hash($password);
    }

    /**
     * The short description
     *
     * @access public
     * @param  type [ $varname] description
     * @return type description
     */
    public function generateToken()
    {

        $randomString = microtime() . self::ENCRYPTION_SALT;
        
        return $this->hash->hash($randomString);
    }


    public function generateIv()
    {

        $methodName = $this->cipher . 'generateIv';
        $this->$iv = $this->methodName();
    }

    /**/

    public function encrypt($data)
    {

        if (!is_scalar($data)) {
            $string = serialize($data);

        } else {
            $string = (string) $string;
        }

        $methodName = $this->cipher . 'Encrypt';

        return $this->methodName($string);
    }

    public function decrypt($data)
    {
        
        $methodName = $this->cipher . 'Decrypt';
        $rawData = $this->methodName($data);
        $data = @unserialize($rawData);

        return $data ? $data : $rawData;
    }

    /* mcrypt encryption mode */

    protected function mcryptGenerateIv()
    {

        $ivSize = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);

        return $iv;
    }

    protected function mcryptEncrypt($string)
    {

        $encryptedString = mcrypt_encrypt(MCRYPT_BLOWFISH, self::ENCRYPTION_KEY, utf8_encode($string), MCRYPT_MODE_ECB, $this->iv);
        
        return $encryptedString;
    }

    protected function mcryptDecrypt($string)
    {

        $decryptedString = mcrypt_decrypt(MCRYPT_BLOWFISH, self::ENCRYPTION_KEY, $string, MCRYPT_MODE_ECB, $this->iv);
        
        return $decryptedString;
    }

    /* AES-256-CBC encryption mode */

    protected function aesGenerateIv()
    {

        $iv = '!1@2#3$4%5^6&7*';

        return substr(hash('sha256', $iv), 0, 16);
    }

    protected function aesEncrypt($string)
    {

        $output = openssl_encrypt($string, 'AES-256-CBC', hash('sha256', self::ENCRYPTION_KEY), 0, $this->iv);
        
        return base64_encode($output);
    }

    protected function aesDecrypt($string)
    {

        return openssl_decrypt(base64_decode($string), 'AES-256-CBC', hash('sha256', self::ENCRYPTION_KEY), 0, $this->iv);
    }
}
