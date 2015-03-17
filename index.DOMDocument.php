<?php
// If the client can accept gzipped content, do it
if( substr_count( $_SERVER[ 'HTTP_ACCEPT_ENCODING' ], 'gzip' ) ) { ob_start( "ob_gzhandler" ); } else { ob_start(); }

session_start();

require_once( "PHP.Classes/User.class.php" );
require_once( "PHP.Classes/Employee.class.php" );
require_once( "PHP.Classes/Student.class.php" );
require_once( "PHP.Classes/Subject.class.php" );
require_once( "PHP.Classes/Stream.class.php" );
require_once( "PHP.Classes/Test.class.php" );

{	// Data
	
	$genders = Array( "male", "female" );
	$testTypes = Array( "CAT", "exam" );
	
}

$doc = new DOMDocument();

$doc -> validateOnParse = true;
$doc -> loadHTML( file_get_contents( 'template.xhtml' ) );
/*
$mainColumn = $doc -> getElementById( "mainColumn" );
*/
header( 'Content-type: text/html' );

echo $doc -> saveHTML();	


?>
