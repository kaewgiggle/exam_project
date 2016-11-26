<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

function getExamList( $page ){
	
	include 'db/db_connect.php';

	$limit 		= 5;
	$offset 	= 0;
	$data 		= array();
	$practiceExamTemplate = 'practice_exam.php?id=';
	$htmlExamList = '';

	if( $page > 1 ){

		$offset = ($limit * $page) + 1;
	}


	$sql 		= "SELECT EXAM_YEAR_ID, EXAM_YEAR 
					FROM EXAM_YEARS 
					LIMIT $limit OFFSET $offset";

	$result 	= $conn->query($sql);

	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        $htmlExamList = $htmlExamList .
	        					'<tr>'. 
	        					'<td>Examination Year:' . $row['EXAM_YEAR'] .  '</td>' .
	        					'<td><a href="' . $practiceExamTemplate . $row['EXAM_YEAR_ID'] . '">Practice Exam</a</td>' .
	        					'</tr>';
	    }

	}

	include 'db/db_disconnect.php';

	return $htmlExamList;
	
}


?>