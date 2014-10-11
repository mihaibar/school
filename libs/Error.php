<?php
/**
 * Class Error
 *
 * 404 and Resetti
 */
class Error {


	/**
	 * Sets the header of the module, what's being displayed in the title bar.
	 */
	function __construct () {
		$this->_applicationName= "error";

	}

	/**
	 * Give the user the 404
	 */
	public static function pageNotFound() {
		$view = new View();
		$view->_applicationNameShort = "Error";
		$view->pageTitle = "Page not found!";
		$view->_applicationName = "error";
		$view->render('error/404');
		die();

	}

	/**
	 * Mr. Resetti saves the day!
	 */
	public static function forbidden () {
		$view = new View();
		$view->_applicationNameShort = "Error";
		$view->pageTitle = "Access Forbidden!";
		$view->_applicationName = "error";
		//	Session::destroy();
		$view->render('error/forbidden');
		die();

	}

}

