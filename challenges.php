<?php 
	require_once dirname(__FILE__).'/inc/globals.php';
	
	// TODO: allow authenticated users only
	layoutHeader('Start');
	
	echo '<div class="hero-unit">';
		echo '<h1>Desafios</h1>';
		echo '<p>Lista de desafios que podem ser resolvidos.</p>';
	echo '</div>';
	
	$aChallenges = $gDb->query("SELECT * FROM challenges WHERE 1");
	
	if ($aChallenges->rowCount() == 0) {
		echo '<div class="row">';
			echo '<div class="span12">';
					echo '<p>Não há desafios cadastrados no momento</p>';
				echo '</div>';
		echo '</div>';
	} else {
		while($aRow = $aChallenges->fetch()) {
			echo '<div class="row">';
				echo '<div class="span12">';
						echo '<h2><a href="code.php?challenge='.$aRow['id'].'">'.$aRow['name'].'</a> <span class="label label-warning">Nível '.$aRow['level'].'</span></h2>';
						echo '<p>'.$aRow['description'].'</p>';
					echo '</div>';
			echo '</div>';
		}
	}
	
	layoutFooter();
?>