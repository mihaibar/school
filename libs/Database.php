<?php

/**
 * Class Database
 *
 * Handles the connection with the database.
 */
class Database {

    public $dbh;
    private $_sth;
    private static $_instance;

	/**
	 * Constructor: connects to the database. Constants are taken from the configuration files.
	 */
	private function __construct() {
		try {
			$this->dbh = new PDO('mysql:host=' . DATABASE_HOST . ';dbname=' . DATABASE_NAME, DATABASE_USERNAME, DATABASE_PASSWORD);
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$this->dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

	/**
	 * Singleton for the database connection
	 * @return mixed
	 */
	public static function getInstance() {
	if (!isset(self::$_instance)) {
	    $object = __CLASS__;
	    self::$_instance = new $object;
	}
	return self::$_instance;
    }

    /**
     * Builds an SQL select statement
     * @param string $sql SQL query
     * @param array $data associative array
     * @return aray
     */
    public function select($sql, $data = array()) {
		try {
			$this->_sth = $this->dbh->prepare($sql);
			if (!empty($data)) {
				foreach ($data as $key => $value) {
					$this->_sth->bindValue("$key", $value);
				}
			}
			$this->_sth->execute();
			return $this->_sth->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			print_r ($e->getMessage());
		}
    }

	/**
	 * Builds a delete SQL statement
	 * @param string $table table name
	 * @param string $where conditional constraint
	 * @param int $limit how many rows should be deleted, default 1
	 */
	public function delete($table, $where, $limit=1) {
		switch ($limit) {
			case 0:
			$limit = '';
			break;
			case 1:
			$limit = " LIMIT 1";
			break;
			default:
			$limit = " LIMIT $limit";
		}

		try {
			$this->_sth = $this->dbh->prepare("DELETE FROM " . $table . " WHERE $where  $limit");
			$this->_sth->execute();
			// cosnider returning the IDs of the rows that were deleted,or the count.
		} catch (PDOException $e) {
			print_r ($e->getMessage());
		}
    }

    /**
     * Builds an insert SQL statement
     * @param string $table table name
     * @param array $data associative array
	 * @return array
     */
    public function insert($table, $data) {
	try {
	    ksort($data);
	    $fieldNames = implode("`, `", array_keys($data));
	    $fieldValues = ":" . implode(", :", array_keys($data));


	    $this->_sth = $this->dbh->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");
	    foreach ($data as $key => $value) {
		$this->_sth->bindValue(":$key", $value);
	    }
	    $this->_sth->execute();
	    return $this->dbh->lastInsertId();
	} catch (PDOException $e) {
		print_r ($e->getMessage());
	}
    }

    /**
     * Builds an update SQL statement
     * @param string $table table name
     * @param array $data associative array with the data that needs to be updated
     * @param string $where condition
     *
     */
	public function update($table, $data, $where) {
		try {

			//prepare the arrays
			$setArray = array();
			$paramArray = array();

			// for each item in the array, create the SET and the parameters for binding
			foreach ($data as $key => $value) {
				$setArray[] = "$key = :$key";
				$paramArray["$key"] = $value;
			}

			// implode the SET array to make it a string
			$set = implode(", ", $setArray);

			// pass table, set and where to the query
			$this->_sth = $this->dbh->prepare("UPDATE $table SET $set WHERE ".$where);

			// bind all parameters
			foreach ($paramArray as $key => $value) {
				$this->_sth->bindValue(":$key", $value);
			}

			// and execute!
			$this->_sth->execute();

		} catch (PDOException $e) {
			print_r ($e->getMessage());
		}
	}

}
