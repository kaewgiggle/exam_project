<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

	include 'header.php';
	include 'modules/exam_module.php';
	$examID 		= $_GET['id'];
	$examTitle		= getExamTitle($examID);
	$examContent 	= getExamContent($examID);
?>
<div class="container">
	<?php echo $examTitle; ?>
	<?php echo $examContent; ?>
</div>
<?php
	include 'footer.php';
?>