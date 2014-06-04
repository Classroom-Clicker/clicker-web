<!DOCTYPE html>
<html>
	<head>
		<?php include "includes/head.php"; ?>
		<title>Classroom cicker - Result</title>
	</head>
	<body>
		<div id='all'>
			<?php include "includes/header.php"; ?>
			<div id='content' class='container-fluid'>
				<!-- Main jumbotron for a primary marketing message or call to action -->
				<div class="row row-offcanvas row-offcanvas-left">
					<div class="col-sm-3 col-md-2 sidebar-offcanvas">
						<ul class="nav nav-list bs-docs-sidenav affix">
							<li><a href="<?php echo base_url()."users"?>"> MyAccount</a></li>
							<li><a href="<?php echo base_url()."quizzes"?>"> Quizzes</a></li>
						</ul>
					</div>
					<div class="col-sm-9 col-md-10 main">
						
						<?php  echo "<a href='".base_url()."quizzes'>".$wCourse->getName()."</a> > 
						".$wQuiz->getName(); ?>
						<ul class="nav nav-tabs">
							<li ><a>Sessions</a></li>
							<?php
							$wActive = 'active';
							foreach ($wResults as $wResult) {
								echo '<li class="'.$wActive.'"><a href="#'.$wResult['id'].'" data-toggle="tab">'.$wResult['id'].'</a></li>';
								$wActive = "";
							}
							?>
						</ul>

						<div class="tab-content">
							<?php
							$wActive = 'active';
							foreach ($wResults as $wResult) {
								echo '<div class="tab-pane '.$wActive.'" id="'.$wResult['id'].'">';
								echo '<p>This quizz has been done the done the '.$wResult['date'].'</p>';
								echo '	<table class="table table-striped">';
								echo '		<thead>';
								echo '			<tr>';
								echo '				<th style="width:10%"># Question</th>';
								echo '				<th style="width:10%">Correct</th>';
								echo '				<th style="width:10%">Incorrect</th>';
								echo '				<th>Result</th>';
								echo '			</tr>';
								echo '		</thead>';
								echo '		<tbody>';
								for($wI = 1; $wI <= $wResult['max']; $wI++){
									echo '		<tr>';
									echo '			<td style="vertical-align:top">'.$wI.'</td>';
									$wTotal = $wResult[$wI]['correct'] + $wResult[$wI]['incorrect'];
									$wCorrectPercentage = $wResult[$wI]['correct'] / $wTotal * 100;
									$wIncorrectPercentage = 100-$wCorrectPercentage;
									echo '			<td>'.$wResult[$wI]['correct'].'/'.$wTotal.'('.$wCorrectPercentage.'%)</td>';
									echo '			<td>'.$wResult[$wI]['incorrect'].'/'.$wTotal.'('.$wIncorrectPercentage.'%)</td>';
									echo '			<td>';
									echo '				<div class="progress">';
									echo '					<div class="progress-bar progress-bar-success" style="width: '.$wCorrectPercentage.'%"></div>';
									echo '					<div class="progress-bar progress-bar-danger" style="width: '.$wIncorrectPercentage.'%"></div>';
									echo '				</div>';
									echo '			</td>';
									
									echo '		</tr>';
								}
								echo '		</tbody>';
								echo '	</table>';
								echo '</div>';
								$wActive = "";
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<div class="container" style='margin-top:60px'></div>
			<?php include "includes/footer.php"; ?>
		</div>
	</body>
</html>
