<?php
	require_once dirname(__FILE__).'/layout.php';

	$aData			= View::data();
	$aUser 			= $aData['user'];
	$aCategoryId 	= $aData['categoryId'];

	layoutHeader('Editor de categorias', View::baseUrl());

	echo '<div class="jumbotron">';
		echo '<div class="container">';
			echo '<h1>Editor de categorias</h1>';
			echo '<p>Adicionar e editar categorias.</p>';
		echo '</div>';
	echo '</div>';

	echo '<div class="container">';

	if (isset($aData['createdOrUpdated'])) {
		if ($aData['createdOrUpdated'] == true) {
			echo '<div class="alert alert-success"><strong>Tudo certo!</strong> Categoria alterada com sucesso!</div>';

		} else {
			echo '<div class="alert alert-danger"><strong>Oops!</strong> Alguma coisa saiu errada.</div>';
		}
	}

	$aCategoryInfo = $aData['categoryInfo'];

	echo '<form action="categories-manager.php" method="post" name="formCategories" id="formCategories">';
		echo '<div class="row">';
			echo '<div class="col-md-12">';
				echo '<input type="hidden" name="hasValue" value="1" />';
				echo '<input type="hidden" name="id" value="'.$aCategoryId.'" />';

				echo '<div class="form-group">';
					echo '<label class="control-label">Título</label>';
					echo '<input type="text" name="name" value="'.@$aCategoryInfo['name'].'" class="col-lg-6 form-control" /><br/>';
				echo '</div>';
			echo '</div>';
		echo '</div>';

		echo '<div class="row" style="margin-top: 15px;">';
			echo '<div class="col-md-12">';
				echo '<label class="control-label">Descrição</label>';
				layoutPrintMarkdownTextarea('description', @$aCategoryInfo['description'], array('Texto'));
				echo '<input type="submit" name="submit" value="Salvar" class="btn btn-success" />';
			echo '</div>';
		echo '</div>';
	echo '</form>';

	echo '</div>';

	layoutFooter(View::baseUrl());
?>
