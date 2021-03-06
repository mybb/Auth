<?php
/**
 * Test vBulletin Hasher
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

class Vb1Test extends \PHPUnit\Framework\TestCase
{
    /**
     * @var string
     */
    private $hash = 'd1e8f49cb269e36c92bc4cb2cd3ce070';
    /**
     * @var string
     */
    private $salt = 'OTZ>cx8\'%r}`oowCxk\p_66Au)=W{r';
    /**
     * @var string
     */
    private $utf8_hash = '6c5be35efd598c714b5eab1803a75db1';
    /**
     * @var string
     */
    private $utf8_salt = '#DLKXrlNC-*A3.wgHCDwsj&Vxq&wFT';
    /**
     * @var string
     */
    private $password = 'thisismypassword';

    /**
     * @var \MyBB\Auth\Hashing\HashVb
     */
    private $hasher;

    public function setUp()
    {
        $this->hasher = new \MyBB\Auth\Hashing\HashVb();
    }

    public function testHash()
    {
        $this->assertTrue($this->hasher->check('password', $this->hash, ['salt' => $this->salt]));
    }

    public function testUtf8Hash()
    {
        $this->assertTrue($this->hasher->check('pässwörd', $this->utf8_hash, ['salt' => $this->utf8_salt]));
    }

    public function testGenerateAndValidate()
    {
        $hash = $this->hasher->make($this->password, ['salt' => $this->salt]);

        $this->assertTrue($this->hasher->check($this->password, $hash, ['salt' => $this->salt]));
    }
}
