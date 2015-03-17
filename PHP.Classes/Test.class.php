<?php

require_once( "Base.class.php" );

/**
  * 
  * Describes the tests that the students have to do that count towards their grade, initially includes just CATs and exams but could be expanded to unclude assignments and labs etc 
  * 
  * startYear : The most junior group that is sitting this test
  * stopYear : the most senior year sitting this test
  * 
  * startDate : When it begins
  * type : Is it a CAT, Exam, Assignment? etc
  * 
  */

Class Test extends Base {
	
	private $startDate;
	private $type;
	private $startYear;
	private $stopYear;
	
	function setStartDate( $startDate ) { $this -> startDate = $startDate; }	
	function getStartDate() { return $this -> startDate; }
	
	function setType( $type ) { $this -> type = $type; }
	function getType() { return $this -> type; }
		
	function setStartYear( $startYear ) { $this -> startYear = $startYear; }
	function getStartYear() { return $this -> startYear; }	
	
	function setStopYear( $stopYear ) { $this -> stopYear = $stopYear; }
	function getStopYear() { return $this -> stopYear; }	
	
	function validate() {
		
		$returnStatus = true;
		$returnData = Array(
			"startYear" => Array(),
			"endYear" => Array(),
			"startDate" => Array(),
			"type" => Array()
		);
		
		if( $this -> getStartYear() < MOST_JUNIOR_CLASS ) {
			
			$returnStatus = false;
			
			array_push( $returnData[ "startYear" ], "the starting class year cannot be lower than " . MOST_JUNIOR_CLASS );
			
		}
		
		if( $this -> getStopYear() > MOST_SENIOR_CLASS ) {
			
			$returnStatus = false;
			
			array_push( $returnData[ "stopYear" ], "the senior class year cannot be larger than " . MOST_SENIOR_CLASS );
			
		}
		
		if( $this -> getStartYear() > $this -> getStopYear() ) {
		
			$returnStatus = false;
			
			array_push( $returnData[ "startYear" ], "the starting class year cannot be larger than the end class" );
			
		}
		
		switch( $returnType ) {
			
			case RETURN_BOOLEAN :
			default : {
				
				$returnValue = $returnStatus;
			
			}
			break;
			
			case RETURN_DATA : {
				
				$returnValue = $returnData;
			
			}
			break;
			
		}
		
		return $returnValue;
	
	}
	
	function save( $returnType = RETURN_BOOLEAN ) {
		
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
		
		switch( $returnType ) {
			
			case RETURN_BOOLEAN :
			default : {
						
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
			break;
			
			case RETURN_QUERY : {
			
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
	  `startDate`
	, `type`
	, `startYear`
	, `stopYear`
FROM
	`testDetails`
WHERE
	`uniqueID` = "' . mysql_escape_string( $this -> getUniqueID() ) . '"
';
		
		switch( $returnType ) {
			
			case RETURN_BOOLEAN :
			default : {
		
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
			break;
			
			case RETURN_QUERY : {
				
				$returnType = $query;
			
			}
			break;
			
		}
			
		return $returnValue;
	
	}
	
	function update( $returnType = RETURN_BOOLEAN ) {
		
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
		
		switch( $returnType ) {
			
			case RETURN_BOOLEAN :
			default : {
		
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
			break;
			
			case RETURN_QUERY : {
			
				$returnValue = $query;
		
			}
			break;
		
		}
			
		return $returnValue;
	
	}
	
	function __construct( $uniqueID = DEFAULT_UNIQUE_ID,
	                      $startDate = "",
	                      $type = 1,
	                      $startYear = 1,
	                      $stopYear = 4 ) {
							  
		parent::__construct( $uniqueID );
		
		if( $uniqueID == DEFAULT_UNIQUE_ID ) {
			
			if( $startDate != "" ) {
				
				$this -> setStartDate( $startDate );
			
			}
			
			$this -> setType( $type );
			
			$this -> setStartYear( $startYear );
			$this -> setStopYear( $stopYear );
		
		}
		else {
			
			$this -> load();
		
		}
	
	}

}

function getTests( $type = "all" ) {
	
	GLOBAL $dbh;
	
	$returnValue = Array();
	
	$query = '
SELECT
	`uniqueID`
FROM
	`testDetails`
WHERE';
	
	switch( $type ) {
	
		case "exam" : {
			
			$query .= '
	`type` = "2"';
		
		}
		break;
	
		case "cat" : {
			
			$query .= '
	`type` = "1"';
		
		}
		break;
		
		case "all" : {
			
			$query .= '
	1';
		
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
