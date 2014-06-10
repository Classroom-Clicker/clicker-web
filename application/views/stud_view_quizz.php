<!DOCTYPE html>

<html>
	<head>
		<?php include "includes/head.php"; ?>
		<title>Classroom Clicker -Quiz</title>
	</head>
	<body>
		<div id='all'>
			<?php include "includes/header.php"; ?>
			<div id='content' class='container'>
				<script>
					redirect = "<?php echo base_url();?>" + "/quizzes/save/null/" + "<?php echo ($numAnswers+1).'/'.$quiz_id.'/' ?>";

					var form = document.createElement("form");
					form.setAttribute("method", "POST");
					form.setAttribute("action", redirect);
					document.body.appendChild(form);
					form.submit();

				</script>
				<div class="form-group">
					<h2><?php echo $wQuestion->getQuestion(); ?></h2>
						<div class="btn-group-vertical">                             
							<?php for ($i = 0; $i < $numAnswers; $i++) { ?>
								<?php if($wAnswers[$i] == NULL){	break; } ?>	
								<?php if($wAnswers[$i]->getValue() != '' and $wAnswers[$i]->getValue() != ' '){ ?> 	
									<button onclick = <?php echo '"getAnswer('.$wAnswers[$i]->getNumber().')" ';?> type="button" class="btn btn-default"><?php echo $wAnswers[$i]->getValue();?> </button>
								<?php } ?>
							<?php } ?>
						</div>
					<script>

						// On click listener for answer
						function getAnswer(i) {
							i = i;
							var redirect  = "<?php echo 'quizzes/answer/'.$wSessionId.'/'.$wQuestionNumber.'/';?>" + i;
							buttonHandler(redirect);
						}

						// Creates form based on which button was clicked.
						function buttonHandler(redirect) {
							redirect = "<?php echo base_url();?>" + redirect;
							var form = document.createElement("form");
							form.setAttribute("method", "POST");
							form.setAttribute("action", redirect);
							document.body.appendChild(form);
							form.submit();
						}
					</script>
			</div>
			</div>
		</div>
		<?php include "includes/footer.php"; ?>
	</body>
</html>

