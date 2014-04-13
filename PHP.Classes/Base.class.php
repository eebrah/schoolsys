<?php

date_default_timezone_set( "Africa/Nairobi" );

const DEFAULT_UNIQUE_ID = "00000";

const RETURN_BOOLEAN = 0;
const RETURN_QUERY = 1;
const RETURN_DATA = 2;

const MOST_JUNIOR_CLASS = 1;
const MOST_SENIOR_CLASS = 4;	// 8 for primary school, 4 for secondary

require_once( "DBConfig.php" );
	
try {
	
	$dbh = new PDO( 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, array( PDO::ATTR_PERSISTENT => true ) );
	$dbh -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
   
} 
catch( PDOException $e ) {
	
	print "Error!: " . $e -> getMessage() . "<br/>";
   
	die();
   
}	

Class Base {
	
	private $uniqueID;
	
	function setUniqueID( $uniqueID ) { $this -> uniqueID = $uniqueID; }
	
	function getUniqueID() { return $this -> uniqueID; }

	function genUniqueID( $length = 5, $seed = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ' ) {
		
		$returnValue = DEFAULT_UNIQUE_ID;

			for( $i = 0; $i < $length; $i++ ) {
		
				$returnValue[ $i ] = $seed[ rand( 0, strlen( $seed ) - 1 ) ];

			}
		
		return $returnValue;
			
	}
	
	function __construct( $uniqueID = DEFAULT_UNIQUE_ID ) {
		
		if( $uniqueID == DEFAULT_UNIQUE_ID ) { 	// No uniqueID passed, this is a new record
			
			$this -> setUniqueID( $this -> genUniqueID() );
		
		}
		else { 	// A unique ID was passed, set it as the value
			
			$this -> setUniqueID( $uniqueID );
		
		}
	
	}

}

?>
