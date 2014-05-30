<!DOCTYPE html>
<html>
	<head>
		<?php include "includes/head.php"; ?>
		<title>Classroom cicker</title>
	</head>
	<body>
		<div id='all'>
			<?php include "includes/header.php"; ?>
			<div id='content'>
				<!-- Main jumbotron for a primary marketing message or call to action -->
				<div class="jumbotron">
					<div class="container">
						<h1>Classroom clicker</h1>
						<p>Welcome on the classroom clicker website !</p>
					</div>
				</div>
				<div class="container">

					<div id="body">

		<div class="tab-pane fade active in" id="new">
			<h2>Enter the Question:</h2>
			<form role="form" action="admin.php" method="post">
				<div class="form-group">
					<textarea class="form-control" id="content" name="content" placeholder="Enter your question" rows="2" cols="50"></textarea>
				
				<!--h3>Answers</h3-->
				<h4>Enter up to six answers and select the correct one:</h4>

					<?php
						$answers = 6;
						for ($i = 0; $i < $answers; $i++) {

						print '
						<div class="col-lg-6">
							<div class="input-group">
								<span class="input-group-addon">
								<input name="answer" id="'.$i.'" type="radio">
								</span>
								<input type="text" placeholder="Enter an answer" value="" class="form-control">
							</div>
						</div>';
						} ?>

				<button type="submit" name="addPost" class="btn btn-default">Save</button>
				</div>
			</form>
		</div>
					
				</div>
			</div>
			<?php include "includes/footer.php"; ?>
		</div>
	</body>
</html>
