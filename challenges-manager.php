<?php 
	require_once dirname(__FILE__).'/inc/globals.php';
	
	authAllowAuthenticated();
	
	$aUser 			= userGetById($_SESSION['user']['id']);
	$aIsProfessor 	= userIsLevel($aUser, USER_LEVEL_PROFESSOR);
	$aChallengeId 	= isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
	
	if (!$aIsProfessor || ($aChallengeId != 0 && !challengeCanBeReviewedBy($aChallengeId, $aUser))) {
		header("Location: restricted.php");
		exit();
	}
	
	layoutHeader('Editor de desafios');
	
	echo '<div class="hero-unit">';
		echo '<h1>Editor de desafios</h1>';
		echo '<p>Adicionar e editar desafios.</p>';
	echo '</div>';
	
	if (isset($_POST['hasValue'])) {
		$aOk = challengeCreateOrUpdate($aChallengeId, $_POST);
		if ($aOk) {
			echo '<div class="alert alert-success"><strong>Tudo certo!</strong> Desafio alterado com sucesso!</div>';
			
		} else {
			echo '<div class="alert alert-error"><strong>Oops!</strong> Alguma coisa saiu errada.</div>';
		}
	}
	
	$aChallengeInfo = challengeGetById($aChallengeId);
	
	echo '<form action="challenges-manager.php" method="post" name="formChallenges" id="formChallenges" class="form-horizontal">';
		echo '<div class="row">';
			echo '<div class="span6">';
				echo '<input type="hidden" name="hasValue" value="1" />';
				echo '<input type="hidden" name="id" value="'.$aChallengeId.'" />';
				
				echo '<div class="control-group">';
					echo '<label>Título</label>';
					echo '<input type="text" name="name" value="'.@$aChallengeInfo['name'].'" class="span6" /><br/>';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="span2">';
				echo '<div class="control-group">';
					echo '<label>Dificuldade</label>';
					echo '<select name="level" class="span2">';
						foreach($gChallengeLevels as $aValue => $aName) {
							echo '<option value="'.$aValue.'" '.(@$aChallengeInfo['level'] == $aValue ? 'selected="selected"' : '').'>'.$aName.'</option>'; // TODO: fix this!
						}
					echo '</select>';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="span4">';
				echo '<div class="control-group">';
					echo '<label>Categoria</label>';
					echo '<select name="fk_category" class="span4">';
						echo '<option value="0">Algoritmos e Programação</option>'; // TODO: fix this!
						echo '<option value="1">Programação Avançada</option>';
						echo '<option value="2">Estrutura de Dados</option>';
					echo '</select>';
					echo '<input type="hidden" name="fk_group" value="'.$aUser['fk_group'].'" />'; // TODO: add dropdown
					echo '<input type="hidden" name="fk_category" value="0" />'; // TODO: add dropdown
				echo '</div>';
			echo '</div>';
		echo '</div>';
		
		echo '<div class="row">';
			echo '<div class="span12">';
				echo '<label>Descrição</label>';
				layoutPrintMarkdownTextarea('description', @$aChallengeInfo['description'], array('Texto'));
				echo '<input type="submit" name="submit" value="Salvar" class="btn btn-primary" />';
			echo '</div>';
		echo '</div>';
	echo '</form>';
	
	layoutFooter();
?>