<?php

require_once( "Person.class.php" );

Class Student extends Person {
	
	private $schoolID;
//	private $dateOfBirth;
	private $KCPEScore;
	private $dateOfAdmission;
	private $yearOfStudyAtAdmission;
	private $gender;
	
	private $stream;
	
	private $subjects = Array();
	private $holdBacks = Array();
	
	function setSchoolID( $schoolID ) {
		
		$this -> schoolID = $schoolID;
	
	}
	
	function getSchoolID() {
		
		return $this -> schoolID;
	
	}

	function addSubject( $subjectCode ) {
		
		array_push( $this -> subjects, $subjectCode );
	
	}
	
	function getSubjects() {
		
		return $this -> subjects;
	
	}

/*	
	function setDateOfBirth( $dateOfBirth ) {
		
		$this -> dateOfBirth = $dateOfBirth;
	
	}
	
	function getDateOfBirth() {
		
		return $this -> dateOfBirth;
	
	}
*/	

	function setKCPEScore( $KCPEScore ) {
		
		$this -> KCPEScore = $KCPEScore;
	
	}
	
	function getKCPEScore() {
		
		return $this -> KCPEScore;
	
	}

	function setDateOfAdmission( $dateOfAdmission ) {
		
		$this -> dateOfAdmission = $dateOfAdmission;
	
	}
	
	function getDateOfAdmission() {
		
		return $this -> dateOfAdmission;
	
	}
	
	function setYearOfStudyAtAdmission( $yearOfStudyAtAdmission ) {
		
		$this -> yearOfStudyAtAdmission = $yearOfStudyAtAdmission;
	
	}
	
	function getYearOfStudyAtAdmission() {
		
		return $this -> yearOfStudyAtAdmission;
	
	}
	
	function addHoldBack( $holdBackID ) {
		
		array_push( $this -> holdBacks, $holdBackID );
	
	}
	
	function getHoldBacks() {
		
		return $this -> holdBacks;
		
	}
	
	function getYearOfStudy() {
		
		$returnValue = $this -> getYearOfStudyAtAdmission();
		
		$returnValue = ( date( "Y" ) - date( "Y", strtotime( $this -> getDateOfAdmission() ) ) + 1 );
		
		return $returnValue;
	
	}
	
	function setGender( $gender ) {
		
		$this -> gender = $gender;
	
	}
	
	function getGender() {
		
		return $this -> gender;
	
	}
	
	function setStream( $stream ) {
		
		$this -> stream = $stream;
	
	}
	
	function getStream() {
		
		return $this -> stream;
	
	}
	
	function saveToDB( $returnType = 0 ) {
		
		GLOBAL $dbh;
		
		$query = '
INSERT INTO `studentDetails` (
	  `uniqueID`
	, `schoolID`
	, `dateOfAdmission`
	, `yearOfStudyAtAdmission`
	, `gender` 
)
VALUES (
	  "' . mysql_escape_string( $this -> getUniqueID() ) . '"
	, "' . mysql_escape_string( $this -> getSchoolID() ) . '"
	, "' . mysql_escape_string( $this -> getDateOfAdmission() ) . '"
	, "' . mysql_escape_string( $this -> getYearOfStudyAtAdmission() ) . '"
	, "' . mysql_escape_string( $this -> getGender() ) . '"
)';

		$query2 = '
INSERT INTO `studentSubjects` (
	  `studentID`
	, `subjectCode`
)
VALUES (
	  "' . $this -> getUniqueID() . '"
	  ?
)
';
		
		if( $returnType == 0 ) {
			
			$returnValue = false;
		
			if( parent::saveToDB() ) {
			
				try {
							
					$dbh -> beginTransaction();

						$dbh -> exec( $query );
						
						$subjects = $this -> getSubjects();
						
						if( count( $subjects ) > 0 ) {
						
							foreach( $subjects as $subject ) {
								
								$sth = $dbh -> prepare( $query2 );
								
								$sth -> bindParam( 1, $subject, PDO::PARAM_STR );

								$sth -> execute();
							
							}

						}
				   
					$dbh -> commit();				
					
					$returnValue = true;
				   
				} 
				catch( PDOException $e ) {
					
				   print "Error!: " . $e -> getMessage() . "<br/>";			   
				   die();
				   
				}
				
				$returnValue = true;
				
			}

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
	  `schoolID`
	, `dateOfAdmission`
	, `yearOfStudyAtAdmission`
	, `gender` 
FROM
	`studentDetails`
WHERE
	`uniqueID` = "' . mysql_escape_string( $this -> getUniqueID() ) . '"
';
	
		if( $returnType == 0 ) {
		
			$returnValue = false;
			
			if( parent::loadFromDB() ){
				
				try {			
					
					$statement = $dbh -> prepare( $query );
					$statement -> execute();
				
					$row = $statement -> fetch();
					
					$this -> setSchoolID( $row[ "schoolID" ] );
					$this -> setDateOfAdmission( $row[ "dateOfAdmission" ] );
					$this -> setYearOfStudyAtAdmission( $row[ "yearOfStudyAtAdmission" ] );
					$this -> setGender( $row[ "gender" ] );
				//	$this -> setKCPEScore( $row[ "KCPEScore" ] );
				
					$returnValue = true;
				   
				} 
				catch( PDOException $e ) {
					
				   print "Error!: " . $e -> getMessage() . "<br/>";			   
				   die();
				   
				}
				
				$returnValue = true;
			
			}
		
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
	`studentDetails`
SET
	, `schoolID` = "' . mysql_escape_string( $this -> getSchoolID() ) . '"
	, `dateOfAdmission` = "' . mysql_escape_string( $this -> getDateOfAdmission() ) . '"
	, `yearOfStudyAtAdmission` = "' . mysql_escape_string( $this -> getYearOfStudyAtAdmission() ) . '"
	, `gender` = "' . mysql_escape_string( $this -> getGender() ) . '"
	, `KCPEScore` = "' . mysql_escape_string( $this -> getKCPEScore() ) . '"
WHERE
	`uniqueID` = "' . $this -> getUniqueID() . '"';
		
		if( $returnType == 0 ) {
		
			$returnValue = false;
			
			if( parent::updateDB() ) {

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
			
		}
		else {
			
			$returnValue = $query;
		
		}
			
		return $returnValue;
	
	}
	
	function __construct( $uniqueID = "00000",
						  $surName = "",
						  $otherNames = "",
						  $schoolID = "",
						  $KCPEScore = 0,
						  $dateOfAdmission = "",
						  $yearOfStudyAtAdmission = 0,
						  $gender = 0,
						  $stream = "" ) {
							  
		parent::__construct( $uniqueID, $surName, $otherNames );
		
		if( $uniqueID != "00000" ) {
			
			$this -> loadFromDB();
		
		}
		else {
			
			if( $schoolID != "" ) {
				
				$this -> setSchoolID( $schoolID );
			
			}
			
			if( $stream != "" ) {
				
				$this -> setStream( $stream );
			
			}
			
			if( $dateOfAdmission != "" ) {
				
				$this -> setDateOfAdmission( $dateOfAdmission );
			
			}
				
			$this -> setKCPEScore( $KCPEScore );
			
			if( $yearOfStudyAtAdmission != 0 ) {
				
				$this -> setYearOfStudyAtAdmission( $yearOfStudyAtAdmission );
			
			}
			
			$this -> setGender( $gender );
		
		}
	
	}

}

function getStudents( $filter = "all" ) {
	
	GLOBAL $dbh;
	
	$returnValue = Array();
	
	$query = '
SELECT
	`uniqueID`
FROM
	`studentDetails`
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
