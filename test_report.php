<?php

require( '../tools/fpdf16/fpdf.php' );

class PDF extends FPDF {
	
	//Load data
	function LoadData( $file ) {
		
		//Read file lines
		$lines = file( $file );
		$data = array();
		
		foreach( $lines as $line )
			$data[] = explode( ';', chop( $line ) );
			
		return $data;
		
	}

	//Colored table
	function FancyTable( $header, $data ) {
		
		//Colors, line width and bold font
		$this -> SetFillColor( 255, 0, 0 );
		$this -> SetTextColor( 255 );
		$this -> SetDrawColor( 128, 0, 0 );
		$this -> SetLineWidth( .3 );
		$this -> SetFont( '', 'B' );
		
		//Header
		$w = array( 50, 20, 20, 20, 20, 20, 40 );
		for( $i = 0; $i < count( $header ); $i++ )
			$this -> Cell( $w[ $i ], 10, $header[ $i ], 1, 0, 'C', true );
			
		$this -> Ln();
		
		//Color and font restoration
		$this -> SetFillColor( 224, 235, 255 );
		$this -> SetTextColor( 0 );
		$this -> SetFont( '' );
		
		//Data
		$fill = false;
		foreach( $data as $row ) {
			
			$this -> Cell( $w[ 0 ], 8, $row[ 0 ], 'LR', 0, 'L', $fill );
			$this -> Cell( $w[ 1 ], 8, number_format( $row[ 1 ] ), 'LR', 0, 'R', $fill );
			$this -> Cell( $w[ 2 ], 8, number_format( $row[ 2 ] ), 'LR', 0, 'R', $fill );
			$this -> Cell( $w[ 3 ], 8, number_format( $row[ 3 ] ), 'LR', 0, 'R', $fill );
			
			$average = ( 0.15 * ( $row[ 1 ] + $row[ 2 ] ) ) + ( 0.7 * $row[ 3 ] );
			
			$this -> Cell( $w[ 4 ], 8, number_format( $average ), 'LR', 0, 'R', $fill );
			
			$grade = "E";
			$comment = "";
			
			if( $average > 35 )
				$grade = "D-";
				
			if( $average > 40 )
				$grade = "D";
				
			if( $average > 45 )
				$grade = "D+";
			
			if( $average > 50 )
				$grade = "C-";
			
			if( $average > 55 )
				$grade = "C";
			
			if( $average > 60 )
				$grade = "C+";
			
			if( $average > 65 )
				$grade = "B-";
			
			if( $average > 70 )
				$grade = "B";	
			
			if( $average > 75 )
				$grade = "B+";	
			
			if( $average > 80 )
				$grade = "A";	
		
			$this -> Cell( $w[ 5 ], 8, $grade, 'LR', 0, 'C', $fill );
			
			$this -> Cell( $w[ 6 ], 8, $comment, 'LR', 0, 'C', $fill );
			
			$this -> Ln();
			
			$fill =! $fill;
		
		}
		
		$this -> Cell( array_sum( $w ), 0, '', 'T' );
	}
	
}

$pdf = new PDF();

//Column titles
$header = array( 'subject', 'cat 1','cat 2', 'exam', 'ave', 'grade', 'comment' );

//Data loading
$data = $pdf -> LoadData( 'scores.txt' );

$pdf -> SetFont( 'Arial', '', 14 );
$pdf -> AddPage();

$pdf -> FancyTable( $header, $data );

$pdf -> Output();

?>
