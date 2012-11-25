<?php

require_once( "DBConfig.php" );
	
try {
	
	$dbh = new PDO( 'mysql:host=localhost;dbname=' . $DBName, $DBUser, $DBPass, array( PDO::ATTR_PERSISTENT => true ) );
	$dbh -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
   
} 
catch( PDOException $e ) {
	
	print "Error!: " . $e -> getMessage() . "<br/>";
   
	die();
   
}	

	

Class base {
	
	private $uniqueID;
	
	function setUniqueID( $uniqueID ) {
		
		$this -> uniqueID = $uniqueID;
	
	}
	
	function getUniqueID() {
		
		return $this -> uniqueID;
	
	}

	function genUniqueID( $length = 5, $seed = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ' ) {
		
		$returnValue = '00000';

			for( $i = 0; $i < $length; $i++ ) {
		
				$returnValue[ $i ] = $seed[ rand( 0, strlen( $seed ) - 1 ) ];

			}
		
		return $returnValue;
			
	}

	function __construct( $uniqueID = "00000" ) {
		
		if( $uniqueID == "00000" ) {
			
			// No unique ID was passed, this is a new record, generate a new one
			
			$this -> setUniqueID( $this -> genUniqueID() );
		
		}
		else {
			
			// A unique ID was passed, set it
			
			$this -> setUniqueID( $uniqueID );
		
		}
	
	}

}

class Person extends Base {
	
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

class Student extends Person {
	
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
	, `KCPEScore` 
)
VALUES (
	  "' . mysql_escape_string( $this -> getUniqueID() ) . '"
	, "' . mysql_escape_string( $this -> getSchoolID() ) . '"
	, "' . mysql_escape_string( $this -> getDateOfAdmission() ) . '"
	, "' . mysql_escape_string( $this -> getYearOfStudyAtAdmission() ) . '"
	, "' . mysql_escape_string( $this -> getGender() ) . '"
	, "' . mysql_escape_string( $this -> getKCPEScore() ) . '"
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
	, `KCPEScore`
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
					$this -> setKCPEScore( $row[ "KCPEScore" ] );
				
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

class Employee extends Person {
	
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

class Teacher extends Employee {
	


}

class Subject extends Base {
	
	private $code;
	private $name;
	private $description;
	private $startYear;
	private $stopYear;
	
	function setCode( $code ) {
		
		$this -> code = $code;
	
	}
	
	function getCode() {
		
		return $this -> code;
	
	}
	
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
	
	function saveToDB( $returnType = 0 ) {
		
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
	
	function loadFromDB( $returnType = 0 ) {
		
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
	
	function updateDB( $returnType = 0 ) {
		
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
	
	function __construct( $uniqueID = "00000",
	                      $code = "000",
	                      $name = "",
	                      $description = "",
	                      $startYear = 1,
	                      $stopYear = 4 ) {
							  
		parent::__construct( $uniqueID );
		
		if( $uniqueID != "00000" ) {
			
			$this -> loadFromDB();
			
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

class Stream extends Base {
	
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
	
	function saveToDB( $returnType = 0 ) {
		
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
	
	function loadFromDB( $returnType = 0 ) {
		
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
	
	function updateDB( $returnType = 0 ) {
		
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
	
	function __construct( $uniqueID = "00000", 
	                      $name = "",
	                      $description = "",
	                      $startYear = 1,
	                      $stopYear = 4 ) {
	
		parent::__construct( $uniqueID );
		
		if( $uniqueID == "00000" ) {
			
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
			
			$this -> loadFromDB();
		
		}
	
	}

}

class Test extends Base {
	
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

function getYears() {}

function getTeachers() {}

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

function getSubjects( $filter = "all" ) {
	
	GLOBAL $dbh;
	
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
