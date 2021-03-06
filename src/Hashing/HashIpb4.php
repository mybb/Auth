<?php
/**
 * Hasher for legacy IPB 4 passwords, using the following algorithm:
 *
 * <pre>
 * $password = crypt($password, '$2a$13$'.$salt);
 * </pre>
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use MyBB\Auth\Exceptions\HasherNoSaltException;

class HashIpb4 implements HasherContract
{
    /**
     * {@inheritdoc}
     */
    public function make($value, array $options = [])
    {
        // We need a salt to use ipb's hashing algorithm - as we don't generate one here we're throwing an error
        if (empty($options['salt'])) {
            throw new HasherNoSaltException;
        }

        return crypt($value, '$2a$13$' . $options['salt']);
    }

    /**
     * {@inheritdoc}
     */
    public function check($value, $hashedValue, array $options = [])
    {
        return ($hashedValue == $this->make($value, $options));
    }

    /**
     * {@inheritdoc}
     */
    public function needsRehash($hashedValue, array $options = [])
    {
        return false;
    }
}
