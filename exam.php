<?php
	include 'header.php';
	// include 'modules/ExamModule.php';

	function getExamList( $page ){
		$servername = "localhost";
		$username = "root";
		$password = "1234567890";
		$dbname = "exam_project";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 


		$itemPerPage 	= 5;
		if ( $page > 1 ){
			$offset = $page * $itemPerPage + 1;
		}else{
			$offset	= 0;
		}

		$sql 			= "	SELECT EXAM_YEAR_ID, EXAM_YEAR 
							FROM EXAM_YEARS
							LIMIT $itemPerPage OFFSET $offset";
		$result 		= $conn->query($sql);

		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		       $data["EXAM_YEAR_ID"] 	= $row["EXAM_YEAR_ID"];
		       $date["EXAM_YEAR"] 		= $row["EXAM_YEAR"]. "<br>";
		    }
		    var_dump($data);
		}
	// 	return $result;
		$conn->close();
	}

	$page 	= 1;
	getExamList($page);
	
?>
<div class="container">
	<table class="table table-striped">
	 	<tr>
	 		<td>Examination 1</td>
	 		<td><a href="ex_1.php">Link</a></td>
	 	</tr>
	 	<tr>
	 		<td>Examination 2</td>
	 		<td><a href="ex_2_array.php">Link</a</td>
	 	</tr>
	 	<tr>
	 		<td>Examination 3</td>
	 		<td><a href="ex_3_class.php">Link</a</td>
	 	</tr>
	</table>

</div>
<?php
	include 'db_disconnect.php';
	include 'footer.php';
?>