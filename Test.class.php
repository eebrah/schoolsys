<?php

require_once( "Base.class.php" );

Class Test extends Base {
	
	/*
	 *	Describes the "tests" that the studnts do that count towards their grade, 
	 * initially includes just CATs and exams but could be expanded to unclude assignments and labs etc 
	 * 
	 * startYear : The earliest group that is sitting this test
	 * stopYear : the most senior year sitting this test
	 */
	
	private $startDate;
	private $type;
	private $startYear;
	private $stopYear;
	
	function setStartDate( $startDate ) {
		
		$this -> startDate = $startDate;
	
	}
	
	function getStartDate() {
		
		return $this -> startDate;
	
	}
	
	function setType( $type ) {
		
		$this -> type = $type;
	
	}
	
	function getType() {
		
		return $this -> type;
	
	}
		
	function setStartYear( $startYear ) {
		
		$this -> startYear = $startYear;
	
	}
	
	function getStartYear() {
		
		return $this -> startYear;
	
	}	
	
	function setStopYear( $stopYear ) {
		
		$this -> stopYear = $stopYear;
	
	}
	
	function getStopYear() {
		
		return $this -> stopYear;
	
	}	
	
	function validate() {
		
		$returnValue = false;
		
		$returnValue = true;
		
		return $returnValue;
	
	}
	
	function saveToDB( $returnType = 0 ) {
		
		GLOBAL $dbh;
		
		$query = '
INSERT INTO `testDetails` (
	  `uniqueID`
	, `startDate`
	, `type`
	, `startYear`
	, `stopYear`
)
VALUES (
	  "' . mysql_escape_string( $this -> getUniqueID() ) . '"
	, "' . mysql_escape_string( $this -> getStartDate() ) . '"
	, "' . mysql_escape_string( $this -> getType() ) . '"
	, "' . mysql_escape_string( $this -> getStartYear() ) . '"
	, "' . mysql_escape_string( $this -> getStopYear() ) . '"
)';
		
		if( $returnType == 0 ) {
			
			$returnValue = false;
		
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
		else {
			
			$returnValue = $query;
		
		}
		
		return $returnValue;
	
	}
	
	function loadFromDB( $returnType = 0 ) {
		
		GLOBAL $dbh;
		
		$query = '
SELECT
	  `startDate`
	, `type`
	, `startYear`
	, `stopYear`
FROM
	`testDetails`
WHERE
	`uniqueID` = "' . mysql_escape_string( $this -> getUniqueID() ) . '"
';
	
		if( $returnType == 0 ) {
		
			$returnValue = false;
				
			try {			
				
				$statement = $dbh -> prepare( $query );
				$statement -> execute();
			
				$row = $statement -> fetch();
				
				$this -> setStartDate( $row[ "startDate" ] );
				$this -> setType( $row[ "type" ] );
				$this -> setStartYear( $row[ "startYear" ] );
				$this -> setStopYear( $row[ "stopYear" ] );
			
				$returnValue = true;
			   
			} 
			catch( PDOException $e ) {
				
			   print "Error!: " . $e -> getMessage() . "<br/>";			   
			   die();
			   
			}
			
			$returnValue = true;
	
		}
		else {
			
			$returnType = $query;
		
		}
		
		return $returnValue;
	
	}
	
	function updateDB( $returnType = 0 ) {
		
		GLOBAL $dbh;
		
		$query = '
UPDATE
	`testDetails`
SET
	, `startDate` = "' . mysql_escape_string( $this -> getStartDate() ) . '"
	, `type` = "' . mysql_escape_string( $this -> getType() ) . '"
	, `startYear` = "' . mysql_escape_string( $this -> getStartYear() ) . '"
	, `stopYear` = "' . mysql_escape_string( $this -> getStopYear() ) . '"
WHERE
	`uniqueID` = "' . $this -> getUniqueID() . '"';
		
		if( $returnType == 0 ) {
		
			$returnValue = false;
			
			try {
		
				$statement = $dbh -> prepare( $query );
				$statement -> execute();				

				$returnValue = true;
				   
			} 
			catch( PDOException $e ) {
				
			   print "Error!: " . $e -> getMessage() . "<br/>";			   
			   die();
			   
			}
			
		}
		else {
			
			$returnValue = $query;
		
		}
			
		return $returnValue;
	
	}
	
	function __construct( $uniqueID = "00000",
	                      $startDate = "",
	                      $type = 1,
	                      $startYear = 1,
	                      $stopYear = 4 ) {
							  
		parent::__construct( $uniqueID );
		
		if( $uniqueID == "00000" ) {
			
			if( $startDate != "" ) {
				
				$this -> setStartDate( $startDate );
			
			}
			
			$this -> setType( $type );
			
			$this -> setStartYear( $startYear );
			$this -> setStopYear( $stopYear );
		
		}
		else {
			
			$this -> loadFromDB();
		
		}
	
	}

}

?>
