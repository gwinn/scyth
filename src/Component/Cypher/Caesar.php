<?php

/**
 * Caesar
 *
 * PHP Version 5.3
 *
 * @category Cypher
 * @package  Scyth
 * @author   Alex Lushpai <lushpai@gmail.com>
 * @license  MIT http://opensource.org/licenses/MIT
 * @link     https://github.com/gwinn/scyth/blob/master/README.md
 *
 */

namespace Scyth\Component\Cypher;

use Exception;

/**
 * Caesar class
 *
 * @category Cypher
 * @package  Scyth
 * @author   Alex Lushpai <lushpai@gmail.com>
 * @license  MIT http://opensource.org/licenses/MIT
 * @link     https://github.com/gwinn/scyth/blob/master/README.md
 *
 */

class Caesar
{

    protected $offset;

    /**
     * Set offset
     */
    public function __construct($offset = 3)
    {
        $this->offset = $offset;
    }

    /**
     * Encryption Procedure
     *
     * @param mixed $msg message/data
     *
     * @throws \Exception
     * @return string caesar encrypted string
     */
    public function encrypt($msg)
    {
        if (empty($msg)) {
            throw new Exception('Message must be not empty.');
        }

        $symbols = str_split($msg);

        foreach($symbols as $index => $symbol) {
            $position = ord($symbol);
            $position += $this->offset;
            $symbols[$index] = chr($position);
        }

        return implode('', $symbols);
    }

    /**
     * Decryption Procedure
     *
     * @param mixed $msg message/data
     *
     * @throws \Exception
     * @return string original string
     */
    public function decrypt($msg)
    {
        if (empty($msg)) {
            throw new Exception('Message must be not empty.');
        }

        $symbols = str_split($msg);

        foreach($symbols as $index => $symbol) {
            $position = ord($symbol);
            $position -= $this->offset;
            $symbols[$index] = chr($position);
        }

        return implode('', $symbols);
    }
}
