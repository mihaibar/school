<?php


class Model {

	/**
	 * Boot up the model, hey hey! Start the database.
	 * @param $db
	 */
	function __construct ($db) {
		$this->_db = $db;
	}
}
