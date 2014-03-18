<?php

/**
 *  Cypher
 *
 *  PHP Version 5.5
 *
 *  @category Security
 *  @package  Scyth
 *  @author   Alex Lushpai <alex@lushpai.org>
 *  @license  MIT http://opensource.org/licenses/MIT
 *  @link     https://github.com/gwinn/ScythBundle/blob/master/README.md
 *
 */

namespace Scyth\Component\Security;

/**
 *  Cypher class
 *
 *  @category Security
 *  @package  Scyth
 *  @author   Alex Lushpai <alex@lushpai.org>
 *  @license  MIT http://opensource.org/licenses/MIT
 *  @link     https://github.com/gwinn/ScythBundle/blob/master/README.md
 *
 */

class Cypher
{

    /** Encryption Procedure
     *
     *  @param mixed   $msg    message/data
     *  @param string  $key    encryption key
     *  @param boolean $base64 base64 encode result
     *
     *  @return string iv+ciphertext+mac or boolean false on error
     */
    public function encrypt($msg, $key, $base64 = false)
    {
        if (!$td = mcrypt_module_open('rijndael-256', '', 'ctr', '')) {
            return false;
        }

        $msg = serialize($msg);
        $iv = mcrypt_create_iv(
            mcrypt_enc_get_iv_size($td),
            MCRYPT_DEV_RANDOM
        );

        if (mcrypt_generic_init($td, $key, $iv) !== 0) {
            return false;
        }

        $msg = mcrypt_generic($td, $msg);
        $msg = $iv . $msg;
        $mac = $this->pbkdf2($msg, $key, 1000, 32);
        $msg .= $mac;

        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);

        if ($base64) {
            $msg = base64_encode($msg);
        }

        return $msg;
    }

    /** Decryption Procedure
     *
     *  @param string  $msg    output from encrypt()
     *  @param string  $key    encryption key
     *  @param boolean $base64 base64 decode msg
     *
     *  @return string original message/data
     */
    public function decrypt($msg, $key, $base64 = false)
    {
        if ($base64) {
            $msg = base64_decode($msg);
        }

        if (! $td = mcrypt_module_open('rijndael-256', '', 'ctr', '')) {
            return false;
        }

        $iv = substr($msg, 0, mcrypt_enc_get_iv_size($td));
        $mo = strlen($msg) - mcrypt_enc_get_iv_size($td);
        $em = substr($msg, $mo);
        $msg = substr(
            $msg,
            mcrypt_enc_get_iv_size($td),
            strlen($msg)-(mcrypt_enc_get_iv_size($td)*2)
        );
        $mac = $this->pbkdf2(
            $iv . $msg,
            $key,
            1000,
            mcrypt_enc_get_iv_size($td)
        );

        if ($em !== $mac) {
            return false;
        }

        if (mcrypt_generic_init($td, $key, $iv) !== 0) {
            return false;
        }

        $msg = mdecrypt_generic($td, $msg);
        $msg = unserialize($msg);

        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);

        return trim($msg);
    }

    /** PBKDF2 Implementation (as described in RFC 2898);
     *
     *  @param string $password       password
     *  @param string $salt           salt
     *  @param int    $iterationCount iteration count (1000 or higher)
     *  @param int    $keyLength      derived key length
     *  @param string $hashAlgorithm  hash algorithm
     *
     *  @return string derived key
     */
    protected function pbkdf2($password, $salt,
        $iterationCount, $keyLength, $hashAlgorithm = 'sha256'
    ) {
        $hashLength   = strlen(hash($hashAlgorithm, null, true));
        $keyBlocks    = ceil($keyLength/$hashLength);
        $deliveredKey = '';

        for ($block = 1; $block <= $keyBlocks; $block ++) {

            $ib = $b = hash_hmac(
                $hashAlgorithm,
                $salt . pack('N', $block),
                $password,
                true
            );

            for ($i = 1; $i < $iterationCount; $i ++) {
                $ib ^= ($b = hash_hmac($hashAlgorithm, $b, $password, true));
            }

            $deliveredKey .= $ib;

        }

        return substr($deliveredKey, 0, $keyLength);
    }
}
