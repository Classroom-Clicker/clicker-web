<!DOCTYPE html>
<html>
	<head>
		<?php include "includes/head.php"; ?>
		<title>Classroom clicker</title>
	</head>
	<body>
		<div id='all'>
			<?php include "includes/header.php"; ?>
			<div id='content' class='container'>

				<div class="row">
					<!-- Take a quiz with the given Quiz ID -->
					<input type="text" id="quizid" name="quizid" placeholder="Quiz ID"></input>
					<button onclick="takeButton()" type="submit" class="btn btn-default">Take Quiz</button>
				</div>
				<?php if($sessionsNames){ ?>
					<div class="row">
						<h1>Sessions</h1>
						<ul class="list-group" id="listSession">
							<?php foreach($sessionsNames as $sessionName){ ?>
								<a href="#" class="list-group-item"> <?php echo $sessionName; ?></a>
							<?php } ?>
						</ul>
						<div class="btn-group btn-group-justified">
							<div class="btn-group">
								<button onclick="editSession()" type="submit" class="btn btn-default">Open session</button>
							</div>
						</div>
						<script>
							var activePos = null; // Index of current active list-item, null if none
							var listSession = <?php echo json_encode($sessionsId); ?>;
							console.log(activePos);

							/* On click listener for each list view element */
							$('#listSession .list-group-item').on('click',function(e){
								var previous = $(this).closest(".list-group").children(".active");
								previous.removeClass('active'); // previous list-item
								$(e.target).addClass('active'); // activated list-item

								var nums = document.getElementById("listSession");
								var listItem = nums.getElementsByTagName("a");

								for (var i=0; i < listItem.length; i++) {
									if (listItem[i].className=="list-group-item active") {
										/* Keep track of which item is currently active */
										activePos = i;
									}
								}
								console.log(listSession[activePos].id);
							});
						</script>
					</div>
				<?php } ?>

				<div class="row">
					<h1>My Quizzes</h1>
					<div>
						<button onclick="newButton()" type="submit" class="btn btn-default">New Quiz</button><br><br>

						<!-- List view displaying each quiz. Click to select -->
						<ul class="list-group" id="ul">
							<?php
								$numQuizzes = count($quizIds);
								for ($i = 0; $i < $numQuizzes; $i++) {
									print '<a href="#" class="list-group-item">'.$quizNames[$i].'</a>';
								}
							?>

							<!-- Change class of list item to active when clicked -->
							<script>
								var activePos = null; // Index of current active list-item, null if none
								var quizIds = <?php echo json_encode($quizIds); ?>;
								console.log(activePos);

								/* On click listener for each list view element */
								$('#ul .list-group-item').on('click',function(e){
									var previous = $(this).closest(".list-group").children(".active");
									previous.removeClass('active'); // previous list-item
									$(e.target).addClass('active'); // activated list-item

									var nums = document.getElementById("ul");
									var listItem = nums.getElementsByTagName("a");

									for (var i=0; i < listItem.length; i++) {
										if (listItem[i].className=="list-group-item active") {
											/* Keep track of which item is currently active */
											activePos = i;
										}
									}
									console.log(quizIds[activePos]);
								});
							</script>
						</ul>					

						<!-- Start, Edit, and View Results buttons -->
						<div class="btn-group btn-group-justified">
							<div class="btn-group">
								<button onclick="startButton()" type="submit" class="btn btn-default">Start Quiz</button>
							</div>
							<div class="btn-group">
								<button onclick="editButton()" type="submit" class="btn btn-default">Edit Quiz</button>
							</div>
							<div class="btn-group">
								<button onclick="resultsButton()" type="submit" class="btn btn-default">View Results</button>
							</div>
						</div>

						<!-- Redirects to start, edit, or view results for the selected quiz -->
						<script>
							// On click listener for take quiz button
							function takeButton() {
								var base = 'quizzes/question/'
								var id = document.getElementById('quizid').value;
								var redirect = base.concat(id);
								redirect = redirect.concat('/1');
								buttonHandler(redirect);
							}

							function editSession() {
								var redirect = 'quizzes/session/'
								redirect = redirect + listSession[activePos].toString();
								buttonHandler(redirect);
							}
							// On click listener for new button
							function newButton() {
								var redirect = 'quizzes/edit/null'
								buttonHandler(redirect);
							}

							// On click listener for start button
							function startButton() {
								var base = 'quizzes/Sessionstart/'
								var redirect = base.concat(quizIds[activePos].toString());
								buttonHandler(redirect);
							}

							// On click listener for edit button
							function editButton() {
								var base = 'quizzes/edit/'
								var redirect = base.concat(quizIds[activePos].toString());
								buttonHandler(redirect);
							}

							// On click listener for view results button
							function resultsButton() {
								var base = 'results/quiz/'
								var redirect = base.concat(quizIds[activePos].toString());
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
		</div>
	</body>
</html>