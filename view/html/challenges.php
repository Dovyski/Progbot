<?php 
	require_once dirname(__FILE__).'/layout.php';

	layoutHeader('Desafios', View::baseUrl());
	
	$aData 			= View::data();
	$aIsProfessor 	= $aData['isProfessor'];
	
	echo '<div class="jumbotron">';
		echo '<div class="container">';
			echo '<h1>Desafios</h1>';
			echo '<p>Lista de desafios que podem ser resolvidos.</p>';
		echo '</div>';
	echo '</div>';
	
	if($aIsProfessor) {
		echo '<div class="row">';
			echo '<div class="col-md-2 col-md-offset-10">';
				echo '<a href="challenges-manager.php" class="pull-right"><span class="glyphicon glyphicon-plus-sign"></span> Criar desafio</a>';
			echo '</div>';
		echo '</div>';
	}
		
	// Challenges
	echo '<div class="panel panel-primary">';
		echo '<div class="panel-heading"><span class="glyphicon glyphicon-book"></span> Desafios não resolvidos</div>';
		echo '<div id="active-challenges"><script>CODEBOT.loadChallenges(\'active-challenges\', \'actives\', 0);</script></div>';
		echo '<div class="panel-footer"></div>';
	echo '</div>';
	
	echo '<div class="panel panel-primary">';
		echo '<div class="panel-heading"><span class="glyphicon glyphicon-thumbs-up"></span> Desafios já resolvidos</div>';
		echo '<div id="answered-challenges"><script>CODEBOT.loadChallenges(\'answered-challenges\', \'answered\', 0);</script></div>';
		echo '<div class="panel-footer"></div>';
	echo '</div>';
	
	layoutFooter(View::baseUrl());
?>