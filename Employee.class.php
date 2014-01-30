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
	
	function saveToDB() {
		
		GLOBAL $dbh;
		
		$returnValue = false;
		
		if( parent::saveToDB() ) {
			
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
	
	function loadFromDB() {
		
		GLOBAL $dbh;
		
		$returnValue = false;
		
		if( parent::loadFromDB() ) {
			
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
	
	function updateDB() {
		
		GLOBAL $dbh;
		
		$returnValue = false;
		
		if( parent::updateDB() ) {
			
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
	
	function __construct( $uniqueID = "00000",
						  $surName = "",
						  $otherNames = "",
						  $IDNumber = "",
						  $KRAPIN = "",
						  $dateOfEmployment = "" ) {
							  
		parent::__construct( $uniqueID, $surName, $otherNames );
		
		if( $uniqueID != "00000" ) {
			
			$this -> loadFromDB();
		
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

?>
