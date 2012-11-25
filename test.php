<?php

require_once( "Class.php" );

$person = new Employee( "00000", "Ngeno", "Walter Kibet", "28900345", "T823MHR78T", "2010-01-28" );

$output = '<p>NAME : ' . $person -> getSurName() . ', ' . $person -> getOtherNames() . '</p>
		   <p>IDNumber : ' . $person -> getIDNumber() . '</p>
		   <p>DOE : ' . $person -> getDateOfEmployment() . '</p>';

$person -> saveToDB();

$person -> loadFromDB();

$output .= '<p>NAME : ' . $person -> getSurName() . ', ' . $person -> getOtherNames() . '</p>';

echo $output;

?>
