<?php
	require_once dirname(__FILE__).'/layout.php';

	$aData		= View::data();
	$aUser 		= $aData['user'];
	$aGroup 	= $aData['group'];
	$aGroups 	= $aData['groups'];
	$aUsers		= $aData['users'];

	layoutHeader('Editor de grupos', View::baseUrl());

	echo '<div class="jumbotron">';
		echo '<div class="container">';
			echo '<h1>Grupos</h1>';
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

	if($aGroup != null) {
		echo '<div class="row">';
			echo '<div class="col-md-2">';
				echo '<a href="groups-manager.php"><i class="fa fa-arrow-circle-left"></i> Voltar</a><br/><br/>';
			echo '</div>';
		echo '</div>';

		echo '<form action="groups-manager.php" method="post" name="formGroups" id="formGroups">';
			echo '<div class="row">';
				echo '<div class="col-md-12">';
					echo '<input type="hidden" name="hasValue" value="1" />';
					echo '<input type="hidden" name="id" value="'.$aGroup['id'].'" />';

					echo '<div class="form-group">';
						echo '<label class="control-label">Nome</label>';
						echo '<input type="text" name="name" value="'.@$aGroup['name'].'" class="col-lg-6 form-control" /><br/>';
					echo '</div>';
				echo '</div>';
			echo '</div>';

			echo '<div class="row" style="margin-top: 15px;">';
				echo '<div class="col-md-8">';
					echo '<input type="submit" name="submit" value="Salvar" class="btn btn-success" />';
				echo '</div>';
			echo '</div>';
		echo '</form>';

		echo '<div class="row" style="margin-top: 25px;">';
			echo '<div class="col-md-12">';
				echo '<div class="panel panel-default">';
					echo '<div class="panel-heading">Integrantes do grupo';
						echo '<a class="pull-right" id="link-add-member" onclick="$(\'#panel-add-member\').show();$(this).hide();"><i class="fa fa-plus-circle"></i> Adicionar integrante</a>';

						echo '<datalist id="users">';
							if(count($aUsers) > 0) {
								foreach($aUsers as $aId => $aInfo) {
									echo '<option data-id="'.$aId.'" value="'.View::escape($aInfo['name']).'" />';
								}
							}
						echo '</datalist>';

						echo '<span id="panel-add-member" class="pull-right form-inline" style="margin-top: -6px; display: none;">';
							echo '<input type="text" list="users" id="user-name" class="form-control" placeholder="Digite o nome"/>';
							echo '<button class="btn btn-default btn-sm" onclick="CODEBOT.addGroupMember(\'group-members\', '.$aGroup['id'].', \'user-name\');"><i class="fa fa-plus-circle"></i> Adicionar</button>';
						echo '</span>';
					echo '</div>';
					echo '<div id="group-members"><script>CODEBOT.loadGroupMembers(\'group-members\', '.$aGroup['id'].');</script></div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	} else {
		if(count($aGroups) > 0) {
			echo '<table class="table table-hover">';
				echo '<thead>';
					echo '<th style="width: 5%;"></th>';
					echo '<th>Id</th>';
					echo '<th style="width: 60%;">Nome</th>';
					echo '<th>Integrantes</th>';
					echo '<th>Opções</th>';
				echo '</thead>';
				echo '<tbody>';
					foreach($aGroups as $aIdGroup => $aInfo) {
						echo '<tr>';
							echo '<td><i class="fa fa-group"></i></td>';
							echo '<td>'.$aInfo['id'].'</td>';
							echo '<td><a href="groups-manager.php?id='.$aIdGroup.'">'.View::escape($aInfo['name']).'</a></td>';
							echo '<td>N/A</td>';
							echo '<td>';
								echo '<a href="groups-manager.php?id='.$aIdGroup.'" title="Editar grupo"><i class="fa fa-edit"></i></a> ';
								echo '<a href="groups-manager.php?id='.$aIdGroup.'" title="Apagar grupo"><i class="fa fa-trash"></i></a>';
							echo '</td>';
						echo '</tr>';
					}
				echo '</tbody>';
			echo '</table>';

		} else {
			echo '<div class="row" style="margin-top: 15px;">';
				echo '<div class="col-md-12">';
					echo 'Não há grupos cadastrados ainda.';
				echo '</div>';
			echo '</div>';
		}
	}

	echo '</div>';

	layoutFooter(View::baseUrl());
?>
