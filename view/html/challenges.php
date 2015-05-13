<?php
	require_once dirname(__FILE__).'/layout.php';

	layoutHeader('Desafios', View::baseUrl());

	$aData 			= View::data();
	$aIsProfessor 	= $aData['isProfessor'];
	$aCategories	= $aData['categories'];

	echo '<div class="jumbotron">';
		echo '<div class="container">';
			echo '<h1>Desafios</h1>';
			echo '<p>Lista de desafios que podem ser resolvidos.</p>';
		echo '</div>';
	echo '</div>';

	echo '<div class="container challenges-container">';
		if($aIsProfessor) {
			echo '<div class="row">';
				echo '<div class="col-md-2 col-md-offset-10">';
					echo '<a href="challenges-manager.php" class="pull-right"><span class="fa fa-plus-circle"></span> Criar desafio</a>';
				echo '</div>';
			echo '</div>';
		}

		// Challenges
		echo '<div class="panel panel-default">';
			echo '<div class="panel-heading">';
				echo 'Desafios não resolvidos';

				if(count($aCategories) > 0) {
					echo '<div class="pull-right" id="panel-challenge-filter">';
						echo '<a href="javascript:void(0);" data-onclick-show="challenge-filter-category" class="pull-right"><i class="fa fa-filter"> Filtrar por categoria</i></a>';
						echo '<div class="pull-right" id="challenge-filter-category" style="display:none;">';
							echo '<select id="category-filter">';
								echo '<option value="0">Qualquer categoria</option>';
								foreach($aCategories as $aId => $aCategory) {
									echo '<option value="'.$aId.'">'.$aCategory['name'].'</option>';
								}
							echo '</select>';
						echo '</div>';
					echo '</div>';
				}
			echo '</div>';
			echo '<div id="active-challenges"></div>';
			//echo '<div class="panel-footer"></div>';
		echo '</div>';

		echo '<div class="panel panel-default">';
			echo '<div class="panel-heading">Desafios já resolvidos</div>';
			echo '<div id="answered-challenges"></div>';
			//echo '<div class="panel-footer"></div>';
		echo '</div>';
	echo '</div>';

	echo "
	<script>
		$(function() {
			CODEBOT.page.enhance();
			CODEBOT.page.challenges.init();
		})
	</script>";

	layoutFooter(View::baseUrl());
?>
