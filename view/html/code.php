<?php
	require_once dirname(__FILE__).'/layout.php';

	layoutHeader('Resolução de desafio', View::baseUrl());

	$aData		  = View::data();
	$aIsReviewing = $aData['isReviewing'];
	$aIsOwner	  = $aData['isOwner'];
	$aChallengeId = $aData['challengeId'];
	$aChallenge   = $aData['challenge'];
	$aUserInfo	  = $aData['user'];
	$aProgram	  = $aData['program'];
	$aTtyUrl 	  = $aData['tty'];
	$aTab 	 	  = $aData['tab'];

	echo '<div class="container">';

	if ($aChallenge == null) {
		echo '<div class="row">';
			echo '<div class="col-md-12">';
				echo '<p>O desafio informado não existe ou você não possui acesso a ele.</p>';
			echo '</div>';
		echo '</div>';
	} else {

		echo '<div class="row">';
			echo '<div class="col-md-12">';
				echo '<h2>'.$aChallenge['name'].($aData['hasAssignment'] ? ' <span class="label label-danger">Trabalho <i class="fa fa-send" title="Essa desafio é um trabalho que você precisa entregar até '.date('d/m/Y - h:i', $aChallenge['deadline_date']).'"></i></span>' : '').'</h2><br/>';
			echo '</div>';
		echo '</div>';

		echo '<div class="row">';
			echo '<div class="col-md-12">';
				echo '<div class="tabbable">';
					echo '<ul class="nav nav-tabs">';
						echo '<li '.($aTab == 0 ? 'class="active"' : '').'><a href="#tab-code-desc" data-toggle="tab" class="codeTab">Descrição</a></li>';
						echo '<li '.($aTab == 1 ? 'class="active"' : '').'><a href="#tab-code-review" data-toggle="tab" class="codeTab">Entrega e Revisão</a></li>';

						if(!$aIsReviewing) {
							echo '<li style="width: 200px; text-align: right; float: right;">';
								echo '<button type="button" class="btn btn-success" onclick="CODEBOT.openEditor('.$aChallengeId.');">';
									echo '<i class="fa fa-paper-plane"></i> Abrir editor';
								echo '</button>';
							echo '</li>';
						}
					echo '</ul>';

					echo '<div class="tab-content code-tab">';
						// Description tab
						echo '<div class="tab-pane '.($aTab == 0 ? 'active' : '').'" id="tab-code-desc">';
							echo '<p>'.MarkdownExtended($aChallenge['description']).'</p>';
						echo '</div>';

						// Review tab
						echo '<div class="tab-pane '.($aTab == 1 ? 'active' : '').'" id="tab-code-review">';
							// Student's info
							echo '<div class="review-work-info">';
								echo '<li>';
									layoutPrintUser($aUserInfo['id'], $aUserInfo);
								echo '</li>';
								echo '<li>';
									echo '<span>Última atualização:</span>';
									echo '<p>'.($aProgram != null ? date('d/m/y - H:i', $aProgram['last_update']) : 'Nenhuma').'</p>';
								echo '</li>';
								echo '<li>';
									if ($aProgram != null) {
										echo '<div class="grade-info">';
											echo ($aIsReviewing ? '<a href="#" id="changeGradeLink" title="Clique para editar a nota">' : '').'<strong>'.($aProgram['grade'] < 0 ? '?' : $aProgram['grade']).'</strong>' . ($aIsReviewing ? ' <i class="fa fa-edit"></i></a>' : '');
											echo '<div id="changeGradePanel" style="display:none;">';
												echo '<form action="" method="post" name="formChangeGrade" id="formChangeGrade">';
													echo '<input type="hidden" name="action" value="changegrade" />';
													echo '<input type="hidden" name="programId" value="'.$aProgram['id'].'" />';
													echo '<input type="text" name="grade" id="gradeInput" value="'.($aProgram['grade'] < 0 ? '' : $aProgram['grade']).'" class="span1" placeholder="" />';
													//echo '<input type="submit" name="submit" value="Ok" class="btn btn-primary" />';
												echo '</form>';
											echo '</div>';
											echo '<div class="grade-info-title">Nota</div>';
										echo '</div>';
									}
								echo '</li>';
							echo '</div>';

							// Student's code
							echo '<h4>Solução<a href="#" id="code-review"></a></h4>';

							if ($aProgram != null && $aProgram['code'] != '') {
								echo '<div class="code-container">';
									echo '<div id="code" class="code-editor-container">'.htmlspecialchars($aProgram['code']).'</div>';
								echo '</div>';
							} else {
								echo '<div>';
									echo '<div class="alert alert-warning" role="alert">';
									echo 'Não há um programa para resolver esse desafio. ';

									if($aData['canBeEdited']) {
										echo '<button type="button" class="btn btn-default" onclick="CODEBOT.openEditor('.$aChallengeId.');">';
											echo '<i class="fa fa-paper-plane"></i> Enviar código';
										echo '</button>';
									}
									echo '</div>';
								echo '</div>';
							}

							// Revision
							echo '<h4>Comentários<a href="#" id="revisions"></a></h4>';
							$aReviews = $aData['reviews'];

							if (count($aReviews) > 0) {
								foreach($aReviews as $aReview) {
									echo '<div class="panel panel-default bloco-desafios">';
										echo '<div class="panel-heading">';
											layoutPrintUser($aReview['fk_user'], null, true);
											echo ' comentou em 20/12/13 às 14:23';
										echo '</div>';
										echo '<div class="panel-body">';
											echo MarkdownExtended($aReview['comment']);
										echo '</div>';
									echo '</div>';
								}
							} else if(!$aIsReviewing) {
								echo '<div class="">';
									echo '<p>Nenhum comentário foi feito ainda.</p>';
								echo '</div>';
							}

							// Code review
							if (($aIsReviewing || $aIsOwner) && $aProgram != null) {
								echo '<div style="width: 100%">';
									echo '<form action="#" method="post" name="formComment" id="formComment">';
										echo '<input type="hidden" name="action" value="writecomment" />';
										echo '<input type="hidden" name="id" value="" />';
										echo '<input type="hidden" name="programId" value="'.$aProgram['id'].'" />';
										layoutPrintMarkdownTextarea('comment', '', array(), '200px');
										echo ' <input type="submit" name="submit" value="Escrever comentário" class="btn btn-success" />';
									echo '</form>';
								echo '</div>';
							}
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';

		$aBaseUrl = View::baseUrl();

		echo '<script type="text/javascript">CODEBOT.initCodePage();</script>';

		// TODO: replace with syntax highlighter?
		echo '<script src="'.$aBaseUrl.'/js/third-party/ace/src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>';

		echo '
		<script>
			var editor = ace.edit("code");
			editor.setTheme("ace/theme/github");
			editor.getSession().setMode("ace/mode/c_cpp");
			editor.setReadOnly(true);
		</script>';
	}

	echo '</div>';

	layoutFooter(View::baseUrl());
?>
