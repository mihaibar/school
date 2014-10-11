<?php

/**
 * Class Controller
 *
 * Manages the controllers for each module.
 */
class Controller {

	/**
	 * Constructs the main controller
	 * Initializes the view
	 */
	function __construct () {
		$this->_db = Database::getInstance();
		$this->view = new View();
	}

	/**
	 * Loads the requested model
	 * @param string $name
	 */
	public function loadModel ($name) {
		
		$modelFileName = 'models/'.$name."_model.php"; 
		if (file_exists($modelFileName)) {
			require_once $modelFileName;
			
			$modelName = $name . "_Model";
			$this->model = new $modelName(Database::getInstance());
		}
		
	}

	/**
	 * checks if there is a session for the current visitor. If not, redirects to the login page.
	 */
	public function checkUserLogin() {
		Session::start();
		if (Session::get('userID') === false) {
			header("Location: " . BASEURL . "?c=login&continue=" . urlencode($_SERVER['QUERY_STRING']));
		}
	}

	/**
	 * Checks the javascipt token sent by the application with the one set in the session. (OWASP) This is mainly used for forms, Bryntum, ExtJS and other Javascript stuff.
	 * @param $token
	 * @return bool
	 */
	public static function jsTKCheck($token) {
		/* Does the token passed from the application matches the user's token? */
		if ($token !== Session::get("jsTkn")) {
			/* test not passed, destroy the session and redirect! */
			Session::destroy();
			$view = new View();
			/* Hello Mr. Resetti! */
			$view->render("error/forbidden");
			die();
		}
		return true;
	}


}
