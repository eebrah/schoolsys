<?php

include_once( "Employee.class.php" );

Class Teacher extends Employee {
	
	private $subjects = Array();
	private $TSCNumber = "";


	function addSubject( $subjectCode ) { array_push( $this -> subjects, $subjectCode ); }
	
	function getSubjects() { return $this -> subjects; }
	
	function setTSCNumber( $TSCNumber ) { $this -> TSCNumber = $TSCNumber; }
	
	function getTSCNumber() { return $this -> TSCNumber; }
	
	function load( $returnType = RETURN_QUERY ) {
		
		
	
	}
	
	function __construct( $uniqueID = DEFAULT_UNIQUE_ID,
						  $surName = "",
						  $otherNames = "",
						  $IDNumber = "",
						  $KRAPIN = "",
						  $dateOfEmployment = "",
						  $TSCNumber = "" ) {
							  
		parent::__construct( $uniqueID, $surName, $otherNames, $IDNumber, $KRAPIN, $dateOfEmployment );
		
		if( $uniqueID != "00000" ) {
			
			$this -> load();
		
		}
		else {
			
			$this -> setTSCNumber( $TSCNumber );
		
		}
	
	}

}

?>
