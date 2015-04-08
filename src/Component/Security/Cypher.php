<?php

/**
 * Cypher
 *
 * PHP Version 5.3
 *
 * @category Security
 * @package  Scyth
 * @author   Alex Lushpai <lushpai@gmail.com>
 * @license  MIT http://opensource.org/licenses/MIT
 * @link     https://github.com/gwinn/scyth/blob/master/README.md
 *
 */

namespace Scyth\Component\Security;

use Exception;

/**
 * Cypher class
 *
 * @category Security
 * @package  Scyth
 * @author   Alex Lushpai <lushpai@gmail.com>
 * @license  MIT http://opensource.org/licenses/MIT
 * @link     https://github.com/gwinn/scyth/blob/master/README.md
 *
 */

class Cypher
{

    /**
     * Encryption Procedure
     *
     * @param mixed $msg message/data
     * @param string $key encryption key
     * @param boolean $base64 base64 encode result
     * @param string $algorythm mcrypt algorithm
     * @param string $mode mcrypt mode
     *
     * @throws \Exception
     * @return string iv+ciphertext+mac
     */
    public function encrypt($msg, $key, $base64 = false, $algorythm, $mode)
    {
        if (!in_array($algorythm, mcrypt_list_algorithms()))
        {
            throw new Exception('Wrong mcrypt algorithm. Use mcrypt_list_algorithms() for list available algorythm.');
        }

        if (!in_array($mode, mcrypt_list_modes()))
        {
            throw new Exception('Wrong mcrypt mode. Use mcrypt_list_modes() for list available mode.');
        }

        if (!$td = mcrypt_module_open($algorythm, '', $mode, '')) {
            throw new Exception('Can not open mcrypt module');
        }

        $msg = serialize($msg);
        $initializationVector = mcrypt_create_iv(
            mcrypt_enc_get_iv_size($td),
            MCRYPT_DEV_RANDOM
        );

        if (mcrypt_generic_init($td, $key, $initializationVector) !== 0) {
            throw new Exception('Can not init mcrypt');
        }

        try {

            $msg = mcrypt_generic($td, $msg);
            $msg = $initializationVector . $msg;
            $mac = $this->pbkdf2($msg, $key, 1000, 32);
            $msg .= $mac;

            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);

            if ($base64) {
                $msg = base64_encode($msg);
            }

            return $msg;

        } catch (Exception $e) {
            return 'Caught exception: ' . $e->getMessage();
        }
    }

    /**
     * Decryption Procedure
     *
     * @param string $msg output from encrypt()
     * @param string $key encryption key
     * @param boolean $base64 base64 decode msg
     * @param string $algorythm mcrypt algorithm
     * @param string $mode mcrypt mode
     *
     * @throws \Exception
     * @return string original message/data
     */
    public function decrypt($msg, $key, $base64 = false, $algorythm, $mode)
    {
        if ($base64) {
            $msg = base64_decode($msg);
        }

        if (!in_array($algorythm, mcrypt_list_algorithms()))
        {
            throw new Exception('Wrong mcrypt algorithm. Use mcrypt_list_algorithms() for list available algorythm.');
        }

        if (!in_array($mode, mcrypt_list_modes()))
        {
            throw new Exception('Wrong mcrypt mode. Use mcrypt_list_modes() for list available mode.');
        }

        if (!$td = mcrypt_module_open($algorythm, '', $mode, '')) {
            throw new Exception('Can not open mcrypt module');
        }

        try {
            $initializationVector = substr($msg, 0, mcrypt_enc_get_iv_size($td));
            $mo = strlen($msg) - mcrypt_enc_get_iv_size($td);
            $em = substr($msg, $mo);
            $msg = substr(
                $msg,
                mcrypt_enc_get_iv_size($td),
                strlen($msg)-(mcrypt_enc_get_iv_size($td)*2)
            );

            $mac = $this->pbkdf2(
                $initializationVector . $msg,
                $key,
                1000,
                mcrypt_enc_get_iv_size($td)
            );
        } catch (Exception $e) {
            return 'Caught exception: ' . $e->getMessage();
        }

        if ($em !== $mac) {
            throw new Exception('Can not init mcrypt');
        }

        if (mcrypt_generic_init($td, $key, $initializationVector) !== 0) {
            throw new Exception('Can not init mcrypt');
        }

        try {
            $msg = mdecrypt_generic($td, $msg);
            $msg = unserialize($msg);

            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);

            return trim($msg);
        } catch (Exception $e) {
            return 'Caught exception: ' . $e->getMessage();
        }
    }

    /**
     * PBKDF2 Implementation (as described in RFC 2898);
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
