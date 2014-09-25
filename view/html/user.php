<?php 
	require_once dirname(__FILE__).'/layout.php';

	layoutHeader('Usuário', View::baseUrl());
	
	$aData 			= View::data();
	$aIsProfessor 	= $aData['isProfessor'];
	$aUser			= $aData['user'];
	
	echo '<div class="jumbotron jumbotron-user-profile">';
		echo '<div class="container">';
			echo '<img src="http://avatars.io/facebook/nonexistentthing?size=large" class="thumbnail" />';
			echo '<h1>'.$aUser['name'].'</h1>';
			echo '<p><i class="fa fa-envelope"></i> email@uffs.edu.br</p>';
		echo '</div>';
	echo '</div>';
	
	echo '<div class="container">';
		if($aIsProfessor) {
			echo '<div class="row">';
				echo '<div class="col-md-2 col-md-offset-10">';
					echo '<a href="#" class="pull-right"><span class="fa fa-group"></span> Vincular a um grupo</a>';
				echo '</div>';
			echo '</div>';
		}
			
		// Groups
		echo '<div class="panel panel-default">';
			echo '<div class="panel-heading">Grupos</div>';
			echo '<div><p style="padding: 10px;">Não há grupos para serem mostrados no momento.</p></div>';
			//echo '<div class="panel-footer"></div>';
		echo '</div>';
		
		// Achievements
		echo '<div class="panel panel-default">';
			echo '<div class="panel-heading">Conquistas</div>';
			echo '<div><p style="padding: 10px;">Não há conquistas para serem mostradas no momento.</p></div>';
			//echo '<div class="panel-footer"></div>';
		echo '</div>';
	echo '</div>';
	
	layoutFooter(View::baseUrl());
?>