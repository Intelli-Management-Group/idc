<?php
/**
 * Password helper.
 *
 * Originally a PHP 5.3/5.4 polyfill of password_hash()/password_verify().
 * Since PHP 7.4 the PASSWORD_BCRYPT constant is the string '2y' (not an int),
 * which made the old polyfill reject every call and store NULL passwords.
 * These methods now simply wrap PHP's native functions. Existing $2y$ bcrypt
 * hashes in the database keep working unchanged.
 */
class Password
{
    public function __construct()
    {
    }

    /**
     * @return string|false The hashed password, or false on error.
     */
    public function password_hash($password, $algo = PASSWORD_DEFAULT, array $options = [])
    {
        if (!is_string($password) || $password === '') {
            return false;
        }

        return \password_hash($password, $algo ?? PASSWORD_DEFAULT, $options);
    }

    public function password_get_info($hash)
    {
        return \password_get_info((string) $hash);
    }

    public function password_needs_rehash($hash, $algo = PASSWORD_DEFAULT, array $options = [])
    {
        return \password_needs_rehash((string) $hash, $algo ?? PASSWORD_DEFAULT, $options);
    }

    /**
     * @return bool True if the password matches the hash.
     */
    public function password_verify($password, $hash)
    {
        if (!is_string($password) || !is_string($hash) || $hash === '') {
            return false;
        }

        return \password_verify($password, $hash);
    }
}
