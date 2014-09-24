<?php 
	require_once dirname(__FILE__).'/layout.php';

	layoutHeader('Trabalhos', View::baseUrl());
	
	$aData 			= View::data();
	$aIsProfessor 	= $aData['isProfessor'];
	
	echo '<div class="jumbotron">';
		echo '<div class="container">';
			echo '<h1>Trabalhos</h1>';
			echo '<p>Lista dos trabalhos que precisam ser resolvidos e entregues.</p>';
		echo '</div>';
	echo '</div>';
	
	echo '<div class="container assignment-container">';
	
		for ($i = 0; $i < 2; $i++) {
			$aIsShowingActiveChallenges = $i == 0;
			$aAssignments = $aIsShowingActiveChallenges ? $aData['activeAssignments'] : $aData['finishedAssignments'];
			
			echo '<h4>'.($aIsShowingActiveChallenges ? 'Trabalhos com entrega próxima' : 'Trabalhos finalizados').'</h4>';	
		
			// Active assignments
			echo '<div class="panel panel-default">';
				echo '<div id="active-challenges">';
					if (count($aAssignments) == 0) {
						echo '<p style="padding: 15px;">'.($aIsShowingActiveChallenges ? 'Não há trabalhos para serem entregues.' : 'Nenhum trabalho foi finalizado até agora.').'</p>';
						
					} else {
						echo '<table class="table table-hover">';
							echo '<thead>';
								echo '<th style="width: 5%;"></th>';
								echo '<th>Descrição</th>';
								echo '<th>Prazo de entrega</th>';
								echo '<th>Foi entregue?</th>';
							echo '</thead>';
							echo '<tbody>';
								foreach($aAssignments as $aIdChallenge => $aChallenge) {
									echo '<tr>';
										echo '<td style="width: 4%; text-align: center;">';
											echo '<i class = "fa fa-book"> </i>';
											echo '<span class="label label-warning"> '.challengeLevelToString($aChallenge['level']).' </span> '; // TODO: create some standart way to print challenges.
										echo '</td>';
										echo '<td>';
											echo '<strong><a href="code.php?challenge='.$aIdChallenge.'">'.$aChallenge['name'].'</a></strong>';
											
											if($aIsProfessor) {
												echo ' <a href="challenges-manager.php?id='.$aIdChallenge.'" title="Editar desafio"><span class="fa fa-edit"></span></a>';
											}
											echo '<p>'.MarkdownExtended($aChallenge['description']).'</p>';
										echo '</td>';
										echo '<td>';
											echo date('d/m/Y (h:i)', $aChallenge['deadline_date']);
										echo '</td>';
										echo '<td>';
											if($aChallenge['program_id'] != null) {
												echo '<span class="label label-success">Sim</span>';
											} else {
												echo '<span class="label label-danger">Não</span>';
											}
										echo '</td>';
									echo '</tr>';
								}
							echo '</tbody>';
						echo '</table>';
					}
				echo '</div>';
			echo '</div>';
		}
		
	echo '</div>';
	
	layoutFooter(View::baseUrl());
?>