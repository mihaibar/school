<?php

/**
 * Class Session
 *
 * Manages the session
 */
class Session {

    private static $_sessionStarted = false;

	/**
	 * Initialize the session
	 */
	public static function start() {
        if (self::$_sessionStarted == false) {
            session_start();
            self::$_sessionStarted = true;
        }
    }

	/**
	 * Set a value for a session key
	 * @param $key
	 * @param $value
	 */
	public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

	/**
	 * Gets the values for specific session keys
	 * @param $key
	 * @param bool $secondKey
	 * @return bool
	 */
	public static function get($key, $secondKey = false) {
        if ($secondKey == true) {
            if (isset($_SESSION[$key][$secondKey]))
                return $_SESSION[$key][$secondKey];
        } else {
            if (isset($_SESSION[$key]))
                return $_SESSION[$key];
        }
        return false;
    }

	/**
	 * Show me the session.
	 * @TODO shall we move this to Debug?
	 */
	public static function display() {
        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";
    }

	/**
	 * Destroy the session
	 */
	public static function destroy() {
        if (self::$_sessionStarted == true) {
            session_unset();
            session_destroy();
            self::$_sessionStarted = false;
        }
    }   
    

}