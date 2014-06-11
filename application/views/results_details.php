<!DOCTYPE html>
<html>
	<head>
		<?php include "includes/head.php"; ?>
		<title>Classroom clicker - Result details</title>
	</head>
	<body>
		<div id='all'>
			<?php include "includes/header.php"; ?>
			<div id='content' class='container'>
				<h2><?php echo $wQuestion->getQuestion();?></h2>
				<?php 
				$wI = 0;
				$wCorrect = -1;
				echo "<ul>";
				foreach($wAnswers as $wAnswer){
					$wI++;
					$wCorrect = ($wAnswer->getcorrect() == 1)? $wI : $wCorrect;
					echo '	<li>'. $wI.' : '.$wAnswer->getValue().'</li>';
				}
				echo "</ul>";
				?>
				<table class="table table-striped">
					<thead>
						<tr>
							<?php 
							for($wJ = 0 ; $wJ < $wI; $wJ++){
								$wClass = (($wJ+1) == $wCorrect)? 'success' : 'danger';
								echo '<th class="'.$wClass.'">'.($wJ+1).'</th>';
							}
							?>
						</tr>
					</thead>
					<tbody>
						<?php 
							echo '<tr>';
							for($wJ = 0 ; $wJ < $wI; $wJ++){
								$wCount = $wUserAnswers[($wJ+1)]['count'];
								echo '	<td>';
								echo '		<p>'.$wCount.' users ('.(100*$wCount/$wUserAnswers['count']).'%)</p>';
								if($wCount > 0){
									$wUsers = $wUserAnswers[($wJ+1)]['users'];
									echo '		<ul>';
									foreach($wUsers as $wUser){
										echo '			<li>'.$wUser.'</li>';
									}
									echo '		</ul>';
								}
								echo '	</td>';
							}
							echo '</tr>';
							?>
					</tbody>
				</table>
			</div>
			<div class="container" style='margin-top:60px'></div>
			<?php include "includes/footer.php"; ?>
		</div>
	</body>
</html>
