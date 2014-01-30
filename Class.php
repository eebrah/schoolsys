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
