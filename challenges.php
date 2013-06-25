<?php 
	require_once dirname(__FILE__).'/inc/globals.php';
	
	authAllowAuthenticated();
	layoutHeader('Start');
	
	echo '<div class="hero-unit">';
		echo '<h1>Desafios</h1>';
		echo '<p>Lista de desafios que podem ser resolvidos.</p>';
	echo '</div>';
	
	$aUser = userGetById($_SESSION['user']['id']);
	$aIsProfessor = $aUser['type'] == USER_LEVEL_PROFESSOR;
	
	if($aIsProfessor) {
		echo '<div class="row">';
			echo '<div class="span2 offset10">';
				echo '<a href="challenges-manager.php"><i class="icon-plus-sign"></i> Criar desafio</a><br/><br/>';				
			echo '</div>';
		echo '</div>';
	}
		
	// Active challenges
	$aChallenges = challengeFindActivesByUser($_SESSION['user']['id']);
	
	echo '<h4><i class="icon-book"></i> Desafios não resolvidos</h4>';
	
	echo '<div class="bloco-desafios">';
		if (count($aChallenges) == 0) {
			echo '<p>Você resolveu todos os desafios existentes :)</p>';
			
		} else {
			echo '<table class="table table-hover">';
				echo '<tbody>';
					foreach($aChallenges as $aIdChallenge => $aRow) {
						echo '<tr>';
							echo '<td><i class="icon-list-alt"></i></td>';
							echo '<td>';
								echo '<a href="code.php?challenge='.$aIdChallenge.'" target="_blank">'.$aRow['name'].'</a> ';
								echo '<span class = "label label-warning" > '.challengeLevelToString($aRow['level']).' </span> '; // TODO: create some standart way to print challenges.
								if($aIsProfessor) {
									echo '<a href="challenges-manager.php?id='.$aIdChallenge.'" title="Editar desafio"><i class="icon-edit"></i></a>';
								}
								echo '<p>'.$aRow['description'].'</p>';
							echo '</td>';
						echo '</tr>';
					}
				echo '</tbody>';
			echo '</table>';
			
			// Pagination
			echo '<div class="pagination">';
				echo '<ul>';
				echo '<li><a href="#">Anterior</a></li>';
				echo '<li><a href="#">1</a></li>';
				echo '<li><a href="#">2</a></li>';
				echo '<li><a href="#">3</a></li>';
				echo '<li><a href="#">4</a></li>';
				echo '<li><a href="#">5</a></li>';
				echo '<li><a href="#">Próximo</a></li>';
				echo '</ul>';
			echo '</div>';
		}
		//echo '<div class="bloco-desafios-legenda">Desafios não resolvidos</div>';
	echo '</div>';
	
	echo '<h4 style="margin-top: 30px;"><i class="icon-thumbs-up"></i> Desafios já resolvidos</h4>';
	
	// Answered challenges
	$aChallenges = challengeFindAnsweredByUser($_SESSION['user']['id']);
	
	echo '<div class="bloco-desafios">';
		if (count($aChallenges) == 0) {
			echo '<p>Você ainda não resolveu um desafio.</p>';
			
		} else {
			echo '<table class="table table-hover">';
				echo '<tbody>';
					foreach($aChallenges as $aIdChallenge => $aRow) {
						echo '<tr>';
							echo '<td><i class="icon-ok-circle"></i></td>';
							echo '<td>';
								echo '<a href="code.php?challenge='.$aIdChallenge.'" target="_blank">'.$aRow['name'].'</a> ';
								echo '<span class = "label label-warning" > '.challengeLevelToString($aRow['level']).' </span> '; // TODO: create some standart way to print challenges.
								if($aIsProfessor) {
									echo '<a href="challenges-manager.php?id='.$aIdChallenge.'" title="Editar desafio"><i class="icon-edit"></i></a>';
								}
								echo '<p>'.$aRow['description'].'</p>';
							echo '</td>';
						echo '</tr>';
					}
				echo '</tbody>';
			echo '</table>';
			
			// Pagination
			echo '<div class="pagination">';
				echo '<ul>';
				echo '<li><a href="#">Anterior</a></li>';
				echo '<li><a href="#">1</a></li>';
				echo '<li><a href="#">2</a></li>';
				echo '<li><a href="#">3</a></li>';
				echo '<li><a href="#">4</a></li>';
				echo '<li><a href="#">5</a></li>';
				echo '<li><a href="#">Próximo</a></li>';
				echo '</ul>';
			echo '</div>';
		}
		//echo '<div class="bloco-desafios-legenda">Desafios já resolvidos</div>';
	echo '</div>';
	
	layoutFooter();
?>