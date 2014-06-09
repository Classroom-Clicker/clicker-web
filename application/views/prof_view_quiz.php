<!DOCTYPE html>
<html>
	<head>
		<?php include "includes/head.php"; ?>
		<title>Classroom cicker - Quizz</title>
	</head>
	<body>
		<div id='all'>
			<?php include "includes/header.php"; ?>
			<div id='content'>
				<div class="container">
					<p>To access that quizz, use the id : <?php echo $wQuizSession->getId();?></p>
					<p>From here, you can start, pause/resume or stop a quizz.</p>
					<div>
						
					</div>
				</div>
			</div>
			<?php include "includes/footer.php"; ?>
		</div>
	</body>
</html>
