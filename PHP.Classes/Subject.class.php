<?php

include_once( "Base.class.php" );

Class Subject extends Base {
	
	private $code;
	private $name;
	private $description;
	private $startYear;
	private $stopYear;
	
	function setCode( $code ) { $this -> code = $code; }
	function getCode() { return $this -> code; }
	
	function setName( $name ) { $this -> name = $name; }
	function getName() { return $this -> name; }
	
	function setDescription( $description ) { $this -> description = $description; }
	function getDescription() {	return $this -> description; }
		
	function setStartYear( $startYear ) { $this -> startYear = $startYear; }
	function getStartYear() { return $this -> startYear; }	
	
	function setStopYear( $stopYear ) { $this -> stopYear = $stopYear; }
	function getStopYear() { return $this -> stopYear; }		
	
	function validate() {
		
		$returnValue = false;	// Default value
		
		$returnValue = true; 	
		
		return $returnValue;
	
	}
	
	function save( $returnType = RETURN_BOOLEAN ) {
		
		GLOBAL $dbh;
		
		$query = '
INSERT INTO `subjectDetails` (
	  `uniqueID`
	, `code`
	, `name`
	, `description`
	, `startYear`
	, `stopYear`
)
VALUES (
      "' . mysql_escape_string( $this -> getUniqueID() ) . '"
	, "' . mysql_escape_string( $this -> getCode() ) . '"
	, "' . mysql_escape_string( $this -> getName() ) . '"
	, "' . mysql_escape_string( $this -> getDescription() ) . '"
	, "' . mysql_escape_string( $this -> getStartYear() ) . '"
	, "' . mysql_escape_string( $this -> getStopYear() ) . '"
)';
		
		try {
					
			$dbh -> beginTransacstion();

				$dbh -> exec( $query );
		   
			$dbh -> commit();				
			
			$returnValue = true;
		   
		} 
		catch( PDOException $e ) {
			
		   print "Error!: " . $e -> getMessage() . "<br/>";			   
		   die();
		   
		}
				

		return $returnValue;
	
	}
	
	function load( $returnType = RETURN_BOOLEAN ) {
		
		GLOBAL $dbh;
		
		$query = '
SELECT
	  `name`
	, `code`
	, `description`
	, `startYear`
	, `stopYear`
FROM
	`subjectDetails`
WHERE 
	`uniqueID` = "' . mysql_escape_string( $this -> getUniqueID() ) . '"';
		
		try {			
			
			$statement = $dbh -> prepare( $query );
			$statement -> execute();
		
			$row = $statement -> fetch();
			
			$this -> setName( $row[ "name" ] );
			$this -> setCode( $row[ "code" ] );
			$this -> setDescription( $row[ "description" ] );
			$this -> setStartYear( $row[ "startYear" ] );
			$this -> setStopYear( $row[ "stopYear" ] );
		
			$returnValue = true;
		   
		} 
		catch( PDOException $e ) {
			
		   print "Error!: " . $e -> getMessage() . "<br/>";			   
		   die();
		   
		}
				
		return $returnValue;
	
	}
	
	function update( $returnType = RETURN_BOOLEAN ) {
		
		GLOBAL $dbh;
		
		$query = '
UPDATE 
	`subjectDetails`
SET
	  `name` = "' . mysql_escape_string( $this -> getName() ) . '"
	, `code` = "' . mysql_escape_string( $this -> getCode() ) . '"
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
	                      $code = "000",
	                      $name = "",
	                      $description = "",
	                      $startYear = 1,
	                      $stopYear = 4 ) {
							  
		parent::__construct( $uniqueID );
		
		if( $uniqueID != "00000" ) {
			
			$this -> load();
			
		}
		else {
			
			// New Subject
			
			if( $code != "000" ) {
				
				$this -> setCode( $code );
			
			}
			
			if( $name != "" ) {
				
				$this -> setName( $name );
			
			}
			
			if( $description != "" ) {
				
				$this -> setDescription( $description );
			
			}
			
			$this -> setStartYear( $startYear );
			
			$this -> setStopYear( $stopYear );
		
		}
		
	}

}

function getSubjects( $filter = "all" ) {	GLOBAL $dbh;
	
	$returnValue = Array();
	
	$query = '
SELECT
	`uniqueID`
FROM
	`subjectDetails`
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
