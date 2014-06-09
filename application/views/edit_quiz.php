<!DOCTYPE html>

<html>
<head>
	<?php include "includes/head.php"; ?>
	<title>Classroom Clicker</title>
</head>
<body>
	<div id='all'>
		<?php include "includes/header.php"; ?>
		<div id='content' class='container'>

	<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
	<?php if($count > 0) { ?>
	<li class="active"><a href="#tab0" data-toggle="tab">Question 1 </a></li>
	
	<?php
	for($i = 1; $i < $count; $i++){
		print '

	<li><a href="#tab'.($i).'" data-toggle="tab">Question '.($i+1).'</a></li>';	}?>
	<li><a href="#new" data-toggle="tab">New</a></li>
	<?php } else { ?>
	<li class="active"><a href="#new" data-toggle="tab">New</a></li>
	<?php } ?>
	</ul>
	<div id="my-tab-content" class="tab-content">

	<?php
	$last = 0;
	for($k = 0; $k < $count; $k++){
		if($k == 0){ ?>
			<div class="tab-pane active" id="tab0">
		<?php }
		else{
			print '<div class="tab-pane" id="tab'.$k.'">';
		} ?>
		<?php print '
		<form role="form" action='.base_url('/quizzes/save/'.($questions[$k]->getId()).'/'.($k+1).'/'.$quiz_id).' method="post">';?>		<div class="form-group"> 

		<h2>Quiz Name:</h2>

		<input type="text" value=<?php echo '"'.$quiz_name.'" ';?> name="quizName" id="quizName" class="form-control" placeholder="Enter Quiz Name">

		<h2>Question:</h2>
		
			<?php print '
			<textarea class="form-control" placeholder="Enter a Question" id="question" name="question" rows="2" cols="50">'.$questions[$k]->getQuestion().'</textarea>

			<h4>Enter up to six answers and select the correct one:</h4>';
			$answers = $questions[$k]->getAnswers($this->db,$questions[$k]);
			for ($i = 0; $i < 6; $i++) { ?>
			<div class="col-lg-6">
				<div class="input-group">
				<?php
				if(array_key_exists($i, $answers) and $answers[$i]->getCorrect() == 1){
					print '<span class="input-group-addon active">
						<input name="answer" value="'.$i.'" id="radio'.$i.'" type="radio" checked="">';
				}
				else{
					print '<span class="input-group-addon">
							<input name="answer" value="'.$i.'" id="radio'.$i.'" type="radio">';
				}
				print '</span>';
				
				if(array_key_exists($i, $answers)){
					print '<input type="text" name="text'.$i.'" id="text'.$i.'" textplaceholder="Enter an answer" value="'.$answers[$i]->getValue().'" class="form-control">';
				}
				else{
					print '<input type="text" name="text'.$i.'" id="text'.$i.'" textplaceholder="Enter an answer" value=" " class="form-control">';
				} ?>	

				</div>
			</div>	
	 	<?php } ?>
	 	</div>
	 	<div class="btn-group">
		<button type="submit" name="addQuestion<?php echo $k?>" class="btn btn-success">Save Question</button>
	</form>
	<?php print '
	<form role="form" action='.base_url().' method="post">';?>
		<button type="submit" name="addNew" class="btn btn-success">done</button>
	</form>
	<form role="form" action=<?php print base_url('/quizzes/deleteQuestion/'.($questions[$k]->getId()).'/'.$quiz_id);?> method="POST">
		<button type="submit" name="deleteQuestion" class="btn btn-danger">Delete Question</button>
	</form>
	</div>
	</div>
	<!-- Add New Question Tab -->
	<?php $last = $k+1; } ?>
		<?php if($last == 0){ ?>
			<div class="tab-pane active" id="new">
		<?php }
		else{
			print '<div class="tab-pane" id="new">';
		} ?>
		
		<?php print '<form role="form" action="'.base_url('/quizzes/save/null/'.($count+1).'/'.$quiz_id).'/" method="post">';?>
		<div class="form-group">

		<h2>Quiz Name:</h2>

		<input type="text" value=<?php echo '"'.$quiz_name.'" ';?> name="quizName" id="quizName" class="form-control" placeholder="Enter Quiz Name">
		<h2>Enter the Question:</h2>
	
			<textarea class="form-control" placeholder="Enter a Question" id="question" name="question" rows="2" cols="50"></textarea>

			<h4>Enter up to six answers and select the correct one:</h4>
			
			<?php 
			for ($i = 0; $i < 6; $i++) { ?>
			<div class="col-lg-6">
				<div class="input-group">
					<span class="input-group-addon active">
						<?php print'
						<input name="answer" value="'.$i.'" id="radio'.$i.'" type="radio">
					</span>
					<input type="text" name="text'.$i.'" id="text'.$i.'" textplaceholder="Enter an answer" class="form-control">'; ?>
				</div>
			</div>	
	 	<?php } ?>
	 	</div>
	 	<div class="btn-group">
		<button type="submit" name="addNew" class="btn btn-success">Save Question</button>
	</form>	
</div>
</div>
</div>
	<?php include "includes/footer.php"; ?>
</div>
</body>
</html>