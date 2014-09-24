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
	
	echo '<div class="container">';
	
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
			echo '<div class="col-md-4">';
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
			
			echo '<div class="col-md-3">';
				echo '<label class="control-label">Categoria</label>';
				echo '<select name="fk_category" class="col-lg-4 form-control">';
					echo '<option value="0">Algoritmos e Programação</option>'; // TODO: fix this!
					echo '<option value="1">Programação Avançada</option>';
					echo '<option value="2">Estrutura de Dados</option>';
				echo '</select>';
				echo '<input type="hidden" name="fk_group" value="'.$aUser['fk_group'].'" />'; // TODO: add dropdown
				echo '<input type="hidden" name="fk_category" value="0" />'; // TODO: add dropdown
			echo '</div>';
			
			echo '<div class="col-md-2">';
				echo '<label class="control-label">Trabalho?</label>';
				echo '<select name="assignment" id="assignment" class="form-control col-lg-2">';
					echo '<option value="0" '.(@$aChallengeInfo['assignment'] == 0 ? 'selected="selected"' : '').'>Não</option>';
					echo '<option value="1" '.(@$aChallengeInfo['assignment'] == 1 ? 'selected="selected"' : '').'>Sim</option>';
				echo '</select>';
			echo '</div>';
		echo '</div>';
		
		// Assignment panel
		echo '<div class="row" id="assignment-panel" style="margin-top: 15px; display: '.(@$aChallengeInfo['assignment'] ? 'block' : 'none').';">';
			echo '<div class="col-md-2">';
				echo '<label class="control-label">Data de início</label>';
				echo '<input type="text" name="start_date" value="'.date('d/m/Y', @$aChallengeInfo['start_date']).'" class="col-lg-6 form-control" /><br/>';
			echo '</div>';
			echo '<div class="col-md-2">';
				echo '<label class="control-label">Data de entrega</label>';
				echo '<input type="text" name="deadline_date" value="'.date('d/m/Y', @$aChallengeInfo['deadline_date']).'" class="col-lg-6 form-control" /><br/>';
			echo '</div>';
			echo '<div class="col-md-2">';
				echo '<label class="control-label">Autorizar atraso</label>';
				echo '<select name="post_deadline_date" class="form-control col-lg-2">';
					for ($aDias = 0; $aDias <= 5; $aDias++) {
						echo '<option value="'.$aDias.'" '.(@$aData['postDeadlineDays'] == $aDias ? 'selected="selected"' : '').'>'.($aDias == 0 ? 'Não' : ($aDias == 1 ? '1 dia' : $aDias . ' dias')).'</option>';
					}
				echo '</select>';
			echo '</div>';
		echo '</div>';
		
		echo '<div class="row" style="margin-top: 15px;">';
			echo '<div class="col-md-12">';
				echo '<label class="control-label">Descrição</label>';
				layoutPrintMarkdownTextarea('description', @$aChallengeInfo['description'], array('Texto'));
				echo '<input type="submit" name="submit" value="Salvar" class="btn btn-success" />';
			echo '</div>';
		echo '</div>';
	echo '</form>';
	
	echo '</div>';
	
	echo "<script>
		$('#assignment').on('change', function() {
			$('#assignment-panel').slideToggle();
		});
	</script>";
	
	layoutFooter(View::baseUrl());
?>