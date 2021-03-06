<?php

include_once( "Person.class.php" );


Class Employee extends Person {
	
	private $IDNumber;
	private $KRAPIN;
	private $dateOfEmployment;
	
	function setIDNumber( $IDNumber ) {
		
		$this -> IDNumber = $IDNumber;
	
	}
	
	function getIDNumber() {
		
		return $this -> IDNumber;
	
	}
	
	function setKRAPIN( $KRAPIN ) {
		
		$this -> KRAPIN = $KRAPIN;
	
	}
	
	function getKRAPIN() {
		
		return $this -> KRAPIN;
	
	}
	
	function setDateOfEmployment( $dateOfEmployment ) {
		
		$this -> dateOfEmployment = $dateOfEmployment;
	
	}
	
	function getDateOfEmployment() {
		
		return $this -> dateOfEmployment;
	
	}
	
	function save() {
		
		GLOBAL $dbh;
		
		$returnValue = false;
		
		if( parent::save() ) {
			
			$query = '
INSERT INTO `employeeDetails` (
	  `uniqueID`
	, `IDNumber`
	, `KRAPIN`
	, `dateOfEmployment`
)
VALUES (
	  "' . mysql_escape_string( $this -> getUniqueID() ) . '"
	, "' . mysql_escape_string( $this -> getIDNumber() ) . '"
	, "' . mysql_escape_string( $this -> getKRAPIN() ) . '"
	, "' . mysql_escape_string( $this -> getDateOfEmployment() ) . '"
)';
		
			try {
						
				$dbh -> beginTransaction();

					$dbh -> exec( $query );
			   
				$dbh -> commit();				
				
				$returnValue = true;
			   
			} 
			catch( PDOException $e ) {
				
			   print "Error!: " . $e -> getMessage() . "<br/>";			   
			   die();
			   
			}
			
			$returnValue = true;
		
		}
		
		return $returnValue;
	
	}
	
	function load() {
		
		GLOBAL $dbh;
		
		$returnValue = false;
		
		if( parent::load() ) {
			
			$query = '
SELECT
	  `IDNumber`
	, `KRAPIN`
	, `dateOfEmployment`
FROM
	`employeeDetails`
WHERE
	`uniqueID` = "' . mysql_escape_string( $this -> getUniqueID() ) . '"
';

			try {			
				
				$statement = $dbh -> prepare( $query );
				$statement -> execute();
			
				$row = $statement -> fetch();
				
				$this -> setIDNumber( mysql_escape_string( $row[ "IDNumber" ] ) );
				$this -> setKRAPIN( mysql_escape_string( $row[ "KRAPIN" ] ) );
				$this -> setDateOfEmployment( mysql_escape_string( $row[ "dateOfEmployment" ] ) );
			
				$returnValue = true;
			   
			} 
			catch( PDOException $e ) {
				
			   print "Error!: " . $e -> getMessage() . "<br/>";			   
			   die();
			   
			}
			
			$returnValue = true;
		
		}
		
		return $returnValue;
	
	}
	
	function update() {
		
		GLOBAL $dbh;
		
		$returnValue = false;
		
		if( parent::update() ) {
			
			$query = '
UPDATE
	`employeeDetails`
SET
	  `IDNumber`
	, `KRAPIN`
	, `dateOfEmployment`
WHERE
	`uniqueID` = "' . mysql_escape_string( $this -> getUniqueID() ) . '"';
	
			try {
		
				$statement = $dbh -> prepare( $query );
				$statement -> execute();				

				$returnValue = true;
				   
			} 
			catch( PDOException $e ) {
				
			   print "Error!: " . $e -> getMessage() . "<br/>";			   
			   die();
			   
			}
			
			$returnValue = true;
		
		}
		
		return $returnValue;
	
	}
	
	function __construct( $uniqueID = DEFAULT_UNIQUE_ID,
						  $surName = "",
						  $otherNames = "",
						  $IDNumber = "",
						  $KRAPIN = "",
						  $dateOfEmployment = "" ) {
							  
		parent::__construct( $uniqueID, $surName, $otherNames );
		
		if( $uniqueID != "00000" ) {
			
			$this -> load();
		
		}
		else {
		
			if( $IDNumber != "" ) {
				
				$this -> setIDNumber( $IDNumber );
			
			}
			
			if( $KRAPIN != "" ) {
				
				$this -> setKRAPIN( $KRAPIN );
			
			}
			
			if( $dateOfEmployment != "" ) {
				
				$this -> setDateOfEmployment( $dateOfEmployment );
			
			}

		}
	
	}

}

function getEmployees( $filter = "all", $type = "all" ) {
	
	GLOBAL $dbh;
	
	$returnValue = Array();
	
	$query = '
SELECT
	`uniqueID`
FROM
	`employeeDetails`
WHERE';
	
	switch( $filter ) {
		
		case "all" :
		default : {
			
			$query .= '
1';
		
		}
		break;
	
	}
	
	switch( $type ) {
	
		case "teacher" : {
			
			$query .= '
AND
	`type` = "0"';
		
		}
		break;
		
	}
	
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
	
	return $returnValue;

}


?>
