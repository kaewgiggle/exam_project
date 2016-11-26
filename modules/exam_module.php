<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

include 'db_module.php';

function getExamList( $page ){
	
	$limit 		= 5;
	$offset 	= 0;
	$data 		= array();
	$practiceExamTemplate = 'practice_exam.php?id=';
	$htmlExamList = '';

	if( $page > 1 ){

		$offset = ($limit * $page) + 1;
	}

	$conn 		= connectDB();
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

	disconnectDB($conn);

	return $htmlExamList;
	
}

function getExamYear( $examID ){

	if ( $examID != null){

		$conn 		= connectDB();
		$sql 		= "SELECT EXAM_YEAR FROM EXAM_YEARS WHERE EXAM_YEAR_ID = $examID LIMIT 1";
		$result 	= $conn->query($sql);
		$year  		= null;

		if ($result->num_rows == 1) {

			$row 	= $result->fetch_assoc();
			$year 	= $row['EXAM_YEAR'];
		}
	}

	disconnectDB($conn);

	return $year;
	
}

function getExamQuestions ( $examID ){

	if ( $examID != null){

		$conn 			= connectDB();
		$sql 			= "SELECT * FROM QUESTION WHERE EXAM_ID = $examID ORDER BY QUESTION_NO";
		$result 		= $conn->query($sql);
		$questionList 	= array();

		if ($result->num_rows > 0) {

			while($row = $result->fetch_assoc()) {

				$questionList[] = $row;
			}
		}

		disconnectDB($conn);
		return $questionList;

	}else{
		return null;
	}	
}


function getExamTitle( $examID ){

	$year = getExamYear( $examID );

	if ( $year != null ) {
		return '<h3>' . 'Examination Year : ' . $year . '</h3>';
	}else{
		return '';
	}
}

function getChoicesForQuestion ( $questionID, $radioGroupID ){

	if ( $questionID != null){

		$conn 			= connectDB();
		$sql 			= "SELECT * FROM CHOICE WHERE QUESTION_ID = $questionID ORDER BY CHOICE_NO";
		$result 		= $conn->query($sql);
		$choicesHTML	= '<div class="col-lg-12"><div class="input-group">';

		if ($result->num_rows > 0) {

			while($row = $result->fetch_assoc()) {
			$choicesHTML 	= $choicesHTML  .
								'<input type="radio" name="'. $radioGroupID . ' id="' . $radioGroupID.'"' . 
								' value="' . $row['CHOICE_NO'] . '"' .
								'>&nbsp;&nbsp;' .$row['CHOICE_DESC'] . '</br>';
			}
		}

		$choicesHTML = $choicesHTML . '</div></div>';

		disconnectDB($conn);
		return $choicesHTML;

	}else{

		return null;
	}

}

function getExamContent( $examID ){

	$questionList 		= getExamQuestions( $examID );
	$examContentHTML 	= '<table class="table table-striped">';

	for ( $i=0; $i < count($questionList) ; $i++ ) { 
		$question 			= $questionList[$i];
		$examContentHTML 	= $examContentHTML . '<tr><td>';
		$radioGroupID		= 'question_' . $question['QUESTION_NO'];
		$eachQuestionHTML 	= '<div class="container">' . 
							  ' <label for="'. $radioGroupID . '">' . 
							  $question['QUESTION_NO'] . '. ' . $question['QUESTION_DESC'] .
							  '</label>';

		$choiceList			= getChoicesForQuestion( $question['QUESTION_ID'], $radioGroupID );
		$eachQuestionHTML	= $eachQuestionHTML . $choiceList;
		$eachQuestionHTML	= $eachQuestionHTML . '</div>';
		$examContentHTML  	= $examContentHTML . $eachQuestionHTML . '</td></tr>';
	}

	$examContentHTML = $examContentHTML . '</table>';

	return $examContentHTML;

}

?>
