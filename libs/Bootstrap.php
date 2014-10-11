<?php


class Bootstrap {

	function __construct () {
				
		$queryController = isset($_GET['c']) ? $_GET['c'] : "index";

		$controllerFile = "controllers/" . $queryController . ".php";
			
			if (file_exists($controllerFile)) {
				
				/* load the required controller */
				require $controllerFile;

				if (isset ($_GET['m'])) {
					if (method_exists($queryController, $_GET['m'])) {
						$queryMethod =$_GET['m'];
					} else {
						Error::pageNotFound();
					}

				} else {
					$queryMethod ="index";
				}

					$controller = new $queryController();

				/* Initialize the session as well */
				Session::start();

				/* load the model associated with this controller */
				$controller->loadModel($queryController);

				$controller->{$queryMethod}();
			} else {

				/* if the controller file doesn't exist, give the user the 404! */
				Error::pageNotFound();
				return false;
			}

	}

}
