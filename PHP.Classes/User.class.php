<?php

require_once( "Account.class.php" );

Class User extends Account {

	private $name;
	private $dateJoined;

	function setName( $name ) { $this -> name = $name; }
	function getName() { return $this -> name; }

	function setDateJoined( $dateJoined ) { $this -> dateJoined = $dateJoined; }
	function getDateJoined() { return $this -> dateJoined; }

	function save( $returnType = RETURN_BOOLEAN ) {

		GLOBAL $dbh;

		$query = '
INSERT INTO `userDetails` (
	  `uniqueID`
	, `name`
)
VALUES (
	  "' .  $this -> getUniqueID() . '"
	, "' . $this -> getName() . '"
)';

		switch( $returnType ) {

			case RETURN_BOOLEAN :
			default : {		// return a boolean result

				$returnValue = false;

				try {

					$dbh -> beginTransaction();

						$dbh -> exec( parent::save( 1 ) );

						$dbh -> exec( $query );

					$dbh -> commit();

					$returnValue = true;

				}
				catch( PDOException $e ) {

				   print "Error[ 101 ]: " . $e -> getMessage() . "<br/>";
				   die();

				}

			}
			break;

			case "1" : {	// return the query

				$returnValue = $query;

			}
			break;

		}

		return $returnValue;

	}

	function load( $returnType = RETURN_BOOLEAN ) {

		GLOBAL $dbh;

		$query = '
SELECT
	  `name`
	, `dateJoined`
FROM
	`userDetails`
WHERE
	`uniqueID` = "' . $this -> getUniqueID() . '"';

		switch( $returnType ) {

			case RETURN_BOOLEAN :
			default : {		// return a boolean result

				$returnValue = false;

				parent::load();

				try {

					$statement = $dbh -> prepare( $query );
					$statement -> execute();

					$row = $statement -> fetch();

					$this -> setName( $row[ "name" ] );
					$this -> setDateJoined( $row[ "dateJoined" ] );
					
					$returnValue = true;

				}
				catch( PDOException $e ) {

				   print "Error[ 102 ]: " . $e -> getMessage() . "<br/>";
				   die();

				}

			}
			break;

			case "1" : {	// return the query

				$returnValue = $query;

			}
			break;

		}

		return $returnValue;

	}

	function update( $returnType = RETURN_BOOLEAN ) {

		GLOBAL $dbh;

		$query = '
UPDATE
	`userDetails`
SET
	`name` = "' . $this -> getName() . '"
WHERE
	`uniqueID` = "' . $this -> getUniqueID() . '"';

		switch( $returnType ) {

			case RETURN_BOOLEAN :
			default : {		// return a boolean result

				$returnValue = false;

				try {

					$statement = $dbh -> prepare( parent::update( 1 ) );
					$statement -> execute();

					$statement = $dbh -> prepare( $query );
					$statement -> execute();

					$returnValue = true;

				}
				catch( PDOException $e ) {

				   print "Error[ 103 ]: " . $e -> getMessage() . "<br/>";
				   die();

				}

			}
			break;

			case "1" : {	// return the query

				$returnValue = $query;

			}
			break;

		}

		return $returnValue;

	}

	function __construct( $uniqueID = DEFAULT_UNIQUE_ID,
	                      $screenName = "",
	                      $password = "",
	                      $email = "",
	                      $accessLevel = 2,
	                      $name = "" ) {

		parent::__construct( $uniqueID, $screenName, $password, $email, $accessLevel );

		if( $uniqueID == DEFAULT_UNIQUE_ID ) {

			if( $name != "" ) {
				$this -> setName( $name );

			}

		}
		else {
			$this -> load();

		}

	}

}

function getUsers( $returnType = RETURN_BOOLEAN, $filter = "all" ) {

	GLOBAL $dbh;

	$query = '
SELECT
	  `userDetails`.`uniqueID`
FROM
	`userDetails`
INNER JOIN
	`accountDetails`
ON
	`userDetails`.`uniqueID` = `accountDetails`.`uniqueID`
WHERE';

	if( $filter == "all" ) {

		$query .= '
	1';

	}
	else {

		switch( $filter ) {

			case "pending" : {

				$query .= '
	`accountDetails`.`status` = 0';

			}
			break;

			case "active" : {

				$query .= '
	`accountDetails`.`status` = 1';

			}
			break;

			case "suspended" : {

				$query .= '
	`accountDetails`.`status` = 2';

			}
			break;

		}

	}

	switch( $returnType ) {

		case "0" : {

			$returnValue = Array();

			try {
				$statement = $dbh -> prepare( $query );
				$statement -> execute();

				$results = $statement -> fetchAll();

				foreach( $results as $result ) {
					array_push( $returnValue, $result[ "uniqueID" ] );

				}

			}
			catch( PDOException $e ) {
			   print "Error!: " . $e -> getMessage() . "<br/>";
			   die();

			}


		}
		break;

		case "1" : {

			$returnValue = $query;

		}
		break;

	}

	return $returnValue;

}

function userExists( $returnType = RETURN_BOOLEAN, $userID ) {

	GLOBAL $dbh;

	$query = '
SELECT
	`uniqueID`
FROM
	`userDetails`
WHERE
	`uniqueID` = "' . $userID . '"';

	switch( $returnType ) {

		case "0" :
		default : {

			$returnValue = true;

			try {
				$statement = $dbh -> prepare( $query );
				$statement -> execute();

				$results = $statement -> fetchAll();

				if( count( $results ) > 0 ) {
					$returnValue = true;

				}

			}
			catch( PDOException $e ) {
			   print "Error!: " . $e -> getMessage() . "<br/>";
			   die();

			}


		}
		break;

		case "1" : {

			$returnValue = $query;

		}
		break;

	}

	return $returnValue;

}

?>
