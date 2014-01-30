<?php

require_once( "Base.class.php" );

Class Person extends Base {
	
	private $surName;
	private $otherNames;
	
	function setSurName( $surName ) {
		
		$this -> surName = $surName;
	
	}
	
	function getSurName() {
		
		return $this -> surName;
	
	}
	
	function setOtherNames( $otherNames ) {
		
		$this -> otherNames = $otherNames;
	
	}
	
	function getOtherNames() {
		
		return $this -> otherNames;
	
	}
	
	function saveToDB() {
		
		GLOBAL $dbh;
		
		$returnValue = false;
		
		$query = '
INSERT INTO `personDetails` (
	  `uniqueID`
	, `surName`
	, `otherNames`
)
VALUES (
	  "' . mysql_escape_string( $this -> getUniqueID() ) . '"
	, "' . mysql_escape_string( $this -> getSurName() ) . '"
	, "' . mysql_escape_string( $this -> getOtherNames() ) . '"
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
		
		return $returnValue;
	
	}
	
	function loadFromDB() {
	
		GLOBAL $dbh;
		
		$returnValue = false;
		
		$query = '
SELECT
	  `surName`
	, `otherNames`
FROM
	`personDetails`
WHERE
	`uniqueID` = "' . mysql_escape_string( $this -> getUniqueID() ) . '"
';

		try {			
			
			$statement = $dbh -> prepare( $query );
			$statement -> execute();
		
			$row = $statement -> fetch();
			
			$this -> setSurName( mysql_escape_string( $row[ "surName" ] ) );
			$this -> setOtherNames( mysql_escape_string( $row[ "otherNames" ] ) );
		
			$returnValue = true;
		   
		} 
		catch( PDOException $e ) {
			
		   print "Error!: " . $e -> getMessage() . "<br/>";			   
		   die();
		   
		}
		
		return $returnValue;
			
	}
	
	function updateDB() {
	
		GLOBAL $dbh;
		
		$returnValue = false;
		
		$query = '
UPDATE
	`personDetails`
SET
	  `surName` = "' . mysql_escape_string( $this -> getSurName() ) . '"
	, `otherNames` = "' . mysql_escape_string( $this -> getOtherNames() ) . '"
WHERE
	`uniqueID` = "' . $this -> getUniqueID() . '"';

		try {
	
			$statement = $dbh -> prepare( $query );
			$statement -> execute();				

			$returnValue = true;
			   
		} 
		catch( PDOException $e ) {
			
		   print "Error!: " . $e -> getMessage() . "<br/>";			   
		   die();
		   
		}
				
		return $returnValue;
	
	}
	
	function __construct( $uniqueID = "00000", 
						  $surName = "",
						  $otherNames = "" ) {
		
		parent::__construct( $uniqueID );
		
		if( $uniqueID != "00000" ) {
			
			$this -> loadFromDB();
		
		}
		else {
			
			if( $surName != "" ) {
				
				$this -> setSurName( $surName );
			
			}
			
			if( $otherNames != "" ) {
				
				$this -> setOtherNames( $otherNames );
			
			}
		
		}
	
	}

}

?>
