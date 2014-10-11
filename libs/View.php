<?php

class View {

	/**
	 * Actually, we have nothing to construct.
	 */
	function __construct() {
    }

	/**
	 * Renders the page, finally! If noHeader is set to TRUE, then we don't need the header :D
	 * @param string $name
	 * @param bool $noHeader
	 */
	public function render($name, $noHeader = FALSE) {
		if ($noHeader == TRUE) {
			require VIEWS . $name . ".php";
		} else {
			require VIEWS . 'header.php';
			require VIEWS . $name . ".php";
			require VIEWS . 'footer.php';
		}
	}

	/**
	 * Set the page title.
	 * @param $name
	 */
	public function pageTitle($name) {
		$this->pageTitle = $name;
	}

	/**
	 * Redirect with controller, method and whatever arguments have to be passed
	 * @param string $c
	 * @param string $m
	 * @param string $args
	 */
	public function redirect($c, $m, $args) {
		header("Location: " . URL_BASE . "?c=" . $c . "&m=" . $m . "&" . $args);
	}

	/**
	 * Displayes the text on screen. That's all. Almost extremely certain this is not used.
	 * @param string $text
	 * @param bool $noHeader
	 */
	public function message($text, $noHeader = FALSE) {
		if ($noHeader == TRUE) {
			echo $text;
		} else {
			require VIEWS . 'header.php';
			echo $text;
			require VIEWS . 'footer.php';
		}
	}
}
