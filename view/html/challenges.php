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
		// Challenges
		echo '<div class="row">';
			echo '<div class="col-md-12">';
				echo '<div class="panel panel-default">';
					echo '<div class="panel-heading">';
						echo 'Desafios não resolvidos';

						if($aIsProfessor) {
							echo '<a href="challenges-manager.php" class="pull-right"><span class="fa fa-plus-circle"></span> Criar desafio</a> ';
						}

						if(count($aCategories) > 0) {
							echo '<div class="pull-right" id="panel-challenge-filter">';
								echo '<a href="javascript:void(0);" data-onclick-show="challenge-filter-category" class="pull-right"><i class="fa fa-filter"></i> Filtrar</a>';
								echo '<div class="pull-right" id="challenge-filter-category" style="display:none;">';
									echo '<i class="fa fa-filter"></i> ';
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
		echo '</div>';
	echo '</div>';

	layoutFooter(View::baseUrl());
?>
