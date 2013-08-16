<?php 
	require_once dirname(__FILE__).'/layout.php';

	layoutHeader('Desafios', View::baseUrl());
	
	$aData 			= View::data();
	$aIsProfessor 	= $aData['isProfessor'];
	
	echo '<div class="hero-unit">';
		echo '<h1>Desafios</h1>';
		echo '<p>Lista de desafios que podem ser resolvidos.</p>';
	echo '</div>';
	
	if($aIsProfessor) {
		echo '<div class="row">';
			echo '<div class="span2 offset10">';
				echo '<a href="challenges-manager.php"><i class="icon-plus-sign"></i> Criar desafio</a><br/><br/>';				
			echo '</div>';
		echo '</div>';
	}
		
	// Active challenges	
	echo '<h4><i class="icon-book"></i> Desafios não resolvidos</h4>';
	echo '<div id="active-challenges" class="bloco-desafios"><script>CODEBOT.loadChallenges(\'active-challenges\', \'actives\', 0);</script></div>';
	
	echo '<h4 style="margin-top: 30px;"><i class="icon-thumbs-up"></i> Desafios já resolvidos</h4>';
	echo '<div id="answered-challenges" class="bloco-desafios"><script>CODEBOT.loadChallenges(\'answered-challenges\', \'answered\', 0);</script></div>';	
	
	layoutFooter(View::baseUrl());
?>