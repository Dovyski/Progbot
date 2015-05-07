<?php
	require_once dirname(__FILE__).'/layout.php';

	$aData		= View::data();
	$aUser 		= $aData['user'];
	$aGroupId 	= $aData['groupId'];

	layoutHeader('Editor de grupos', View::baseUrl());

	echo '<div class="jumbotron">';
		echo '<div class="container">';
			echo '<h1>Editor de grupos</h1>';
			echo '<p>Adicionar e editar grupos.</p>';
		echo '</div>';
	echo '</div>';

	echo '<div class="container">';

	if (isset($aData['createdOrUpdated'])) {
		if ($aData['createdOrUpdated'] == true) {
			echo '<div class="alert alert-success"><strong>Tudo certo!</strong> Grupo alterado com sucesso!</div>';

		} else {
			echo '<div class="alert alert-danger"><strong>Oops!</strong> Alguma coisa saiu errada.</div>';
		}
	}

	$aGroupInfo = $aData['groupInfo'];

	echo '<form action="groups-manager.php" method="post" name="formGroups" id="formGroups">';
		echo '<div class="row">';
			echo '<div class="col-md-12">';
				echo '<input type="hidden" name="hasValue" value="1" />';
				echo '<input type="hidden" name="id" value="'.$aGroupId.'" />';

				echo '<div class="form-group">';
					echo '<label class="control-label">Nome</label>';
					echo '<input type="text" name="name" value="'.@$aGroupInfo['name'].'" class="col-lg-6 form-control" /><br/>';
				echo '</div>';
			echo '</div>';
		echo '</div>';

		echo '<div class="row" style="margin-top: 15px;">';
			echo '<div class="col-md-12">';
				echo '<input type="submit" name="submit" value="Salvar" class="btn btn-success" />';
			echo '</div>';
		echo '</div>';
	echo '</form>';

	echo '</div>';

	layoutFooter(View::baseUrl());
?>
