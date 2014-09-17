<?php 
	require_once dirname(__FILE__).'/layout.php';

	layoutHeader('Trabalhos', View::baseUrl());
	
	$aData 			= View::data();
	$aIsProfessor 	= $aData['isProfessor'];
	$aAssignments	= $aData['assignments'];
	$aChallenges	= $aData['challenges'];
	
	echo '<div class="jumbotron">';
		echo '<div class="container">';
			echo '<h1>Trabalhos</h1>';
			echo '<p>Lista dos trabalhos que precisam ser resolvidos e entregues.</p>';
		echo '</div>';
	echo '</div>';
	
	echo '<div class="container challenges-container">';
		if($aIsProfessor) {
			echo '<div class="row">';
				echo '<div class="col-md-2 col-md-offset-10">';
					echo '<a href="challenges-manager.php" class="pull-right"><span class="fa fa-plus-circle"></span> Criar trabalho</a>';
				echo '</div>';
			echo '</div>';
		}
			
		// Challenges
		echo '<div class="panel panel-default">';
			echo '<div id="active-challenges">';
				if (count($aAssignments) == 0) {
					echo '<p style="padding: 15px;">Não há trabalhos para serem mostrados.</p>';
					
				} else {
					echo '<table class="table table-hover">';
						echo '<thead>';
							echo '<th style="width: 5%;"></th>';
							echo '<th>Descrição</th>';
							echo '<th>Entregar até</th>';
							echo '<th>Status</th>';
						echo '</thead>';
						echo '<tbody>';
							foreach($aAssignments as $aAssignmentId => $aAssignmentInfo) {
								$aChallenge = $aChallenges[$aAssignmentInfo['fk_challenge']];
								$aIdChallenge = $aChallenge['id'];
								
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
										echo date('d/m/Y (h:i)', $aAssignmentInfo['deadline_date']);
									echo '</td>';
									echo '<td>';
										echo '<span class="label label-danger">Não entregue</span>';
									echo '</td>';
								echo '</tr>';
							}
						echo '</tbody>';
					echo '</table>';
				}
			echo '</div>';
		echo '</div>';
	echo '</div>';
	
	layoutFooter(View::baseUrl());
?>