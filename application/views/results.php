<!DOCTYPE html>
<html>
	<head>
		<?php include "includes/head.php"; ?>
		<title>Classroom clicker - Result</title>
	</head>
	<body>
		<div id='all'>
			<?php include "includes/header.php"; ?>
			<div id='content' class='container-fluid'>
				<!-- Main jumbotron for a primary marketing message or call to action -->
				<div class=" container">
					<ul class="nav nav-tabs">
						<li ><a>Sessions</a></li>
						<?php
						$wActive = 'active';
						foreach ($wResults as $wResult) {
							echo '<li class="'.$wActive.'"><a href="#'.$wResult['id'].'" data-toggle="tab">'.$wResult['date'].'</a></li>';
							$wActive = "";
						}
						?>
					</ul>

					<div class="tab-content">
						<?php
						$wActive = 'active';
						foreach ($wResults as $wResult) {
							echo '<div class="tab-pane '.$wActive.'" id="'.$wResult['id'].'">';
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
								if($wTotal > 0){
									$wCorrectPercentage = $wResult[$wI]['correct'] / $wTotal * 100;
									$wIncorrectPercentage = 100-$wCorrectPercentage;
								}
								else{
									$wCorrectPercentage = 0;
									$wIncorrectPercentage = 0;
								}
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
							echo '	<form>';
							echo '		<a href="'.base_url().'results/deleteSession/'.$wResult['id'].'"><button type="button" class="btn btn-danger"> Delete </button></a>';
							echo '	</form>';
							echo '</div>';
							$wActive = "";
						}
						?>
					</div>
				</div>
			</div>
			<div class="container" style='margin-top:60px'></div>
			<?php include "includes/footer.php"; ?>
		</div>
	</body>
</html>
