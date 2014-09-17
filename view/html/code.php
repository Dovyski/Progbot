<?php 
	require_once dirname(__FILE__).'/layout.php';

	layoutHeader('Resolução de desafio', View::baseUrl());
	
	$aData		  = View::data();
	$aIsReviewing = $aData['isReviewing'];
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
				echo '<h2>'.$aChallenge['name'].'</h2><br/>';
			echo '</div>';
		echo '</div>';
		
		if ($aData['hasAssignment']) {
			echo '<div class="row">';
				echo '<div class="col-md-12">';
					echo '<div class="alert alert-info" role="alert">Esse desafio está vinculado a um trabalho que você precisa entregar. O prazo de entrega é até <strong>'.date('d/m/Y - h:i', $aData['assignment']['deadline_date']).'</strong>.</div>';
				echo '</div>';
			echo '</div>';		
		}
		
		echo '<div class="row">';
			echo '<div class="col-md-12">';
				echo '<div class="tabbable">';
					echo '<ul class="nav nav-tabs">';
						echo '<li '.($aTab == 0 ? 'class="active"' : '').'><a href="#tab-code-desc" data-toggle="tab" class="codeTab">Descrição</a></li>';
						echo '<li '.($aTab == 1 ? 'class="active"' : '').'><a href="#tab-code-review" data-toggle="tab" class="codeTab">Entrega e Revisão</a></li>';

						echo '<li style="width: 200px; text-align: right; float: right;">';
							echo '<button type="button" class="btn btn-success" onclick="CODEBOT.openEditor('.$aChallengeId.');">';
								echo '<i class="fa fa-paper-plane"></i> Enviar código';
							echo '</button>';
						echo '</li>';
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
									echo '<p>18:23 - 20/11/14</p>';
								echo '</li>';
								echo '<li>';
									echo '<span>Tempo de desenvolvimento:</span>';
									echo '<p>2h 31min</p>';
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
							echo '<h4>Solução enviada<a href="#" id="code-review"></a></h4>';
							
							if ($aProgram != null && $aProgram['code'] != '') {
								echo '<div>';
									echo '<textarea name="code" id="code">'.$aProgram['code'].'</textarea>';
								echo '</div>';
							} else {
								echo '<div>';
									echo '<div class="alert alert-warning" role="alert">Não há um programa para resolver esse desafio.</div>';
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
							if ($aIsReviewing && $aProgram != null) {
								echo '<div style="width: 100%">';
									echo '<form action="ajax-code.php" method="post" name="formReview" id="formReview">';
										echo '<input type="hidden" name="action" value="writereview" />';
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
		
		// Codemirror stuff
		// TODO: replace with syntax highlighter?
		echo '<style>@import url("'.$aBaseUrl.'/ide/js/codemirror/lib/codemirror.css");</style>';
		echo '<script src="'.$aBaseUrl.'/ide/js/codemirror/lib/codemirror.js"></script>';
		echo '<script src="'.$aBaseUrl.'/ide/js/codemirror/addon/edit/matchbrackets.js"></script>';
		echo '<script src="'.$aBaseUrl.'/ide/js/codemirror/mode/clike/clike.js"></script>';
			
		echo '
		<script>
		  var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
			lineNumbers: true,
			matchBrackets: true,
			mode: "text/x-csrc",
			electricChars : false,
			readOnly: true
		  });
		</script>';
	}
	
	echo '</div>';
	
	layoutFooter(View::baseUrl());
?>