<?php 
	require_once dirname(__FILE__).'/layout.php';
	
	$aData			= View::data();
	$aUser 			= $aData['user'];
	$aChallengeId 	= $aData['challengeId'];
		
	layoutHeader('Editor de desafios', View::baseUrl());
	
	echo '<div class="jumbotron">';
		echo '<div class="container">';
			echo '<h1>Editor de desafios</h1>';
			echo '<p>Adicionar e editar desafios.</p>';
		echo '</div>';
	echo '</div>';
	
	if (isset($aData['createdOrUpdated'])) {
		if ($aData['createdOrUpdated'] == true) {
			echo '<div class="alert alert-success"><strong>Tudo certo!</strong> Desafio alterado com sucesso!</div>';
			
		} else {
			echo '<div class="alert alert-danger"><strong>Oops!</strong> Alguma coisa saiu errada.</div>';
		}
	}
	
	$aChallengeInfo = $aData['challengeInfo'];
	
	echo '<form action="challenges-manager.php" method="post" name="formChallenges" id="formChallenges">';
		echo '<div class="row">';
			echo '<div class="col-md-6">';
				echo '<input type="hidden" name="hasValue" value="1" />';
				echo '<input type="hidden" name="id" value="'.$aChallengeId.'" />';
				
				echo '<div class="form-group">';
					echo '<label class="control-label">Título</label>';
					echo '<input type="text" name="name" value="'.@$aChallengeInfo['name'].'" class="col-lg-6 form-control" /><br/>';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="col-md-2">';
				echo '<label class="control-label">Dificuldade</label>';
				echo '<select name="level" class="form-control col-lg-2">';
					foreach($aData['challengeLevels'] as $aValue => $aName) {
						echo '<option value="'.$aValue.'" '.(@$aChallengeInfo['level'] == $aValue ? 'selected="selected"' : '').'>'.$aName.'</option>'; // TODO: fix this!
					}
				echo '</select>';
			echo '</div>';
			
			echo '<div class="col-md-4">';
				echo '<label class="control-label">Categoria</label>';
				echo '<select name="fk_category" class="col-lg-4 form-control">';
					echo '<option value="0">Algoritmos e Programação</option>'; // TODO: fix this!
					echo '<option value="1">Programação Avançada</option>';
					echo '<option value="2">Estrutura de Dados</option>';
				echo '</select>';
				echo '<input type="hidden" name="fk_group" value="'.$aUser['fk_group'].'" />'; // TODO: add dropdown
				echo '<input type="hidden" name="fk_category" value="0" />'; // TODO: add dropdown
			echo '</div>';
		echo '</div>';
		
		echo '<div class="row" style="margin-top: 15px;">';
			echo '<div class="col-md-12">';
				echo '<label class="control-label">Descrição</label>';
				layoutPrintMarkdownTextarea('description', @$aChallengeInfo['description'], array('Texto'));
				echo '<input type="submit" name="submit" value="Salvar" class="btn btn-primary" />';
			echo '</div>';
		echo '</div>';
	echo '</form>';
	
	layoutFooter(View::baseUrl());
?>