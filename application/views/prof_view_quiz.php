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
						<?php if($wQuizSession->getStatus() == 1 ){
							echo '<a href="'.base_url('/quizzes/sessionChangeStatus').'/'.$wQuizSession->getId().'/2"><button class="btn btn-info" type="button">Pause</button></a>';
						} else {
							echo '<a href="'.base_url('/quizzes/sessionChangeStatus').'/'.$wQuizSession->getId().'/1"><button class="btn btn-info" type="button">Resume</button></a>';
						} 
						echo '<a href="'.base_url('/quizzes/sessionChangeStatus').'/'.$wQuizSession->getId().'/0"><button class="btn btn-danger" type="button">Stop</button></a>';
						?>
					</div>
				</div>
			</div>
			<?php include "includes/footer.php"; ?>
		</div>
	</body>
</html>
