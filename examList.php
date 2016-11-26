<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);


	include 'header.php';
	include 'modules/exam_module.php';
	$defaultPage 	= 1;
	$examList 		= getExamList($defaultPage);
	
?>
<div class="container">
		<table class="table table-striped">
	 	<?php  echo $examList; ?>
	</table>

</div>
<?php
	include 'footer.php';
?>