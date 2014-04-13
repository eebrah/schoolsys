<?php

require_once( "Base.class.php" );

Class Stream extends Base {
	
	private $name;
	private $description;
	private $startYear;
	private $stopYear;
	
	function setName( $name ) {
		
		$this -> name = $name;
	
	}
	
	function getName() {
		
		return $this -> name;
	
	}
	
	function setDescription( $description ) {
		
		$this -> description = $description;
	
	}
	
	function getDescription() {
		
		return $this -> description;
	
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
	
	function save( $returnType = RETURN_BOOLEAN ) {
		
		GLOBAL $dbh;
		
		$query = '
INSERT INTO `streamDetails` (
	  `uniqueID`
	, `name`
	, `description`
	, `startYear`
	, `stopYear`
)
VALUES (
      "' . mysql_escape_string( $this -> getUniqueID() ) . '"
	, "' . mysql_escape_string( $this -> getName() ) . '"
	, "' . mysql_escape_string( $this -> getDescription() ) . '"
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
			
		}
		else {
			
			$returnValue = $query;
		
		}

		return $returnValue;
	
	}
	
	function load( $returnType = RETURN_BOOLEAN ) {
		
		GLOBAL $dbh;
		
		$query = '
SELECT
	  `name`
	, `description`
	, `startYear`
	, `stopYear`
FROM
	`streamDetails`
WHERE 
	`uniqueID` = "' . mysql_escape_string( $this -> getUniqueID() ) . '"';
		
		if( $returnType == 0 ) {
			
			$returnValue = false;
		
			try {			
			
				$statement = $dbh -> prepare( $query );
				$statement -> execute();
			
				$row = $statement -> fetch();
				
				$this -> setName( $row[ "name" ] );
				$this -> setDescription( $row[ "description" ] );
				$this -> setStartYear( $row[ "startYear" ] );
				$this -> setStopYear( $row[ "stopYear" ] );
			
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
	
	function update( $returnType = RETURN_BOOLEAN ) {
		
		GLOBAL $dbh;
		
		$query = '
UPDATE 
	`streamDetails`
SET
	  `name` = "' . mysql_escape_string( $this -> getName() ) . '"
	, `description` = "' . mysql_escape_string( $this -> getDescription() ) . '"
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
	
	function __construct( $uniqueID = DEFAULT_UNIQUE_ID, 
	                      $name = "",
	                      $description = "",
	                      $startYear = 1,
	                      $stopYear = 4 ) {
	
		parent::__construct( $uniqueID );
		
		if( $uniqueID == DEFAULT_UNIQUE_ID ) {
			
			if( $name != "" ) {
				
				$this -> setName( $name );
			
			}
			
			if( $description != "" ) {
				
				$this -> setDescription( $description );
			
			}
			
			$this -> setStartYear( $startYear );
			
			$this -> setStopYear( $stopYear );
		
		}
		else {
			
			$this -> load();
		
		}
	
	}

}

function getStreams( $filter = "all" ) {
	
	GLOBAL $dbh;
	
	$returnValue = Array();
	
	$query = '
SELECT
	`uniqueID`
FROM
	`streamDetails`
WHERE';
	
	switch( $filter ) {
		
		case "all" :
		default : {
			
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
