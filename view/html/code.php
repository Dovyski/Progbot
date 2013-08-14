<?php 
	require_once dirname(__FILE__).'/layout.php';

	layoutHeader('Resolução de desafio', View::baseUrl());
	
	$aData		  = View::data();
	$aIsReviewing = $aData['isReviewing'];
	$aChallengeId = $aData['challengeId'];	
	$aChallenge   = $aData['challenge'];
	$aUserInfo	  = $aData['user'];
	$aProgram	  = $aData['program'];
	
	if ($aChallenge == null) {
		echo '<div class="row">';
			echo '<div class="span12">';
				echo '<p>O desafio informado não existe ou você não possui acesso a ele.</p>';
			echo '</div>';
		echo '</div>';
	} else {
	
		echo '<div class="row">';
			echo '<div class="span12">';
				echo '<h2>'.$aChallenge['name'].'</h2><br/>';
			echo '</div>';
		echo '</div>';
		
		echo '<div class="tabbable">';
			echo '<ul class="nav nav-tabs">';
				echo '<li class="active"><a href="#tab-code-desc" data-toggle="tab" class="codeTab">Descrição</a></li>';
				echo '<li><a href="#tab-code-code" data-toggle="tab" class="codeTab">Código</a></li>';
				echo '<li><a href="#tab-code-review" data-toggle="tab" class="codeTab">Revisão</a></li>';

				echo '<li style="width: 100px; text-align: right; float: right;"><p><a href="javascript:void(0);" onclick="CODEBOT.openEditor();">[E]</a> <a href="javascript:void(0);" onclick="CODEBOT.openTerminal();">[T]</a></p></li>';
			echo '</ul>';
			echo '<div class="tab-content code-tab">';
				// Description tab
				echo '<div class="tab-pane active" id="tab-code-desc">';
					echo '<p>'.MarkdownExtended($aChallenge['description']).'</p>';
				echo '</div>';
				
				// Code tab
				echo '<div class="tab-pane" id="tab-code-code">';
					if($aProgram['grade'] >= 0) {
						echo '<div class="alert alert-warning"><strong>Atenção!</strong> Você não pode mais alterar esse código porque ele já recebeu nota e revisão.</div>';
					}
					echo '<div class="row">';
						echo '<div class="span4" style="text-align: center;">';
							echo '<img style="width: 100%; height: auto;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAAErUlEQVR4Xu3YwStscRjG8d8QQnZEFkqyY6NE/n0rlOxkS1ZqrCiFe/udOtPcue6YJ889Gc93Vtz7eo/3eT/9zjl6/X7/V+FDAhMm0APMhElR1iQAGCBICQBGiotiwGBASgAwUlwUAwYDUgKAkeKiGDAYkBIAjBQXxYDBgJQAYKS4KAYMBqQEACPFRTFgMCAlABgpLooBgwEpAcBIcVEMGAxICQBGiotiwGBASgAwUlwUAwYDUgKAkeKiGDAYkBIAjBQXxYDBgJQAYKS4KAYMBqQEACPFRTFgMCAlABgpLooBgwEpAcBIcVEMGAxICQBGiotiwGBASgAwUlwUAwYDUgKAkeKiGDAYkBIAjBQXxYDBgJQAYKS4KAYMBqQEACPFRTFgMCAlABgpLooBgwEpAcBIcVEMGAxICQBGiotiwGBASgAwUlwUAwYDUgKAkeKiGDAYkBIAjBQXxYDBgJQAYKS4KAYMBqQEACPFRTFgMCAlABgpLooBgwEpgakH8/7+Xs7Ozsrz83M5OTkpi4uLfwRwd3dXbm5uyvr6etnf32/+r9/vl6urq1J/tn729vbKxsbGRMF1fb2JfqkOi6YazOvrazk9PS1vb2+l1+v9BaZd7tPT0wBM+zNLS0vl6OioXF5eNtjq13Nzc2Oj7/p6HTqY+FJTC2Z4eXXaj8BcX1+Xh4eHUmvX1taaE6Y9cba3t8vOzs7g+3rKzM/PNyfP8vJyA6j+/P39fXMCra6uDnC6rjfpqTbxNjsonGowFxcX5eDgYHBKDN+S2tvO1tZWub29/RRMC6ieOI+Pj+X4+Licn5+X9iSq6P7H9TrYsfUSUwumTeGjZ4r232ZmZsru7m5zarQnTHtqjJ4w7feT3naGn5m+cj3rNjto9iPBDN9K2tvMZ7ekFkzNvJ4y9YQaflAeB/Sr1+tgz7ZL/DgwCwsLzVtTfdAd/aysrJTNzc3mremjZ5j6TNHeyuoD8MvLy19vUKMn2levZ9tkR41+HJjR1+oWQHvCjHtLmp2dbbDVt67Dw8PmpKlfD79BffZarVzvs7eyjgxIl4kDM+7vMP96vhm+Nalgxl1P2tQ3KZ56MN8kx5hfAzAxq/YMChhPjjFdABOzas+ggPHkGNMFMDGr9gwKGE+OMV0AE7Nqz6CA8eQY0wUwMav2DAoYT44xXQATs2rPoIDx5BjTBTAxq/YMChhPjjFdABOzas+ggPHkGNMFMDGr9gwKGE+OMV0AE7Nqz6CA8eQY0wUwMav2DAoYT44xXQATs2rPoIDx5BjTBTAxq/YMChhPjjFdABOzas+ggPHkGNMFMDGr9gwKGE+OMV0AE7Nqz6CA8eQY0wUwMav2DAoYT44xXQATs2rPoIDx5BjTBTAxq/YMChhPjjFdABOzas+ggPHkGNMFMDGr9gwKGE+OMV0AE7Nqz6CA8eQY0wUwMav2DAoYT44xXQATs2rPoIDx5BjTBTAxq/YMChhPjjFdABOzas+ggPHkGNMFMDGr9gwKGE+OMV0AE7Nqz6CA8eQY0wUwMav2DAoYT44xXQATs2rPoIDx5BjTBTAxq/YMChhPjjFdABOzas+ggPHkGNMFMDGr9gz6G1HzSbXtC7t7AAAAAElFTkSuQmCC"/><br/>';
							echo '<strong>Abrir código usando editor online</strong>';
						echo '</div>';
						echo '<div class="span4" style="text-align: center;">';
							echo '<img style="width: 100%; height: auto;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAAErUlEQVR4Xu3YwStscRjG8d8QQnZEFkqyY6NE/n0rlOxkS1ZqrCiFe/udOtPcue6YJ889Gc93Vtz7eo/3eT/9zjl6/X7/V+FDAhMm0APMhElR1iQAGCBICQBGiotiwGBASgAwUlwUAwYDUgKAkeKiGDAYkBIAjBQXxYDBgJQAYKS4KAYMBqQEACPFRTFgMCAlABgpLooBgwEpAcBIcVEMGAxICQBGiotiwGBASgAwUlwUAwYDUgKAkeKiGDAYkBIAjBQXxYDBgJQAYKS4KAYMBqQEACPFRTFgMCAlABgpLooBgwEpAcBIcVEMGAxICQBGiotiwGBASgAwUlwUAwYDUgKAkeKiGDAYkBIAjBQXxYDBgJQAYKS4KAYMBqQEACPFRTFgMCAlABgpLooBgwEpAcBIcVEMGAxICQBGiotiwGBASgAwUlwUAwYDUgKAkeKiGDAYkBIAjBQXxYDBgJQAYKS4KAYMBqQEACPFRTFgMCAlABgpLooBgwEpgakH8/7+Xs7Ozsrz83M5OTkpi4uLfwRwd3dXbm5uyvr6etnf32/+r9/vl6urq1J/tn729vbKxsbGRMF1fb2JfqkOi6YazOvrazk9PS1vb2+l1+v9BaZd7tPT0wBM+zNLS0vl6OioXF5eNtjq13Nzc2Oj7/p6HTqY+FJTC2Z4eXXaj8BcX1+Xh4eHUmvX1taaE6Y9cba3t8vOzs7g+3rKzM/PNyfP8vJyA6j+/P39fXMCra6uDnC6rjfpqTbxNjsonGowFxcX5eDgYHBKDN+S2tvO1tZWub29/RRMC6ieOI+Pj+X4+Licn5+X9iSq6P7H9TrYsfUSUwumTeGjZ4r232ZmZsru7m5zarQnTHtqjJ4w7feT3naGn5m+cj3rNjto9iPBDN9K2tvMZ7ekFkzNvJ4y9YQaflAeB/Sr1+tgz7ZL/DgwCwsLzVtTfdAd/aysrJTNzc3mremjZ5j6TNHeyuoD8MvLy19vUKMn2levZ9tkR41+HJjR1+oWQHvCjHtLmp2dbbDVt67Dw8PmpKlfD79BffZarVzvs7eyjgxIl4kDM+7vMP96vhm+Nalgxl1P2tQ3KZ56MN8kx5hfAzAxq/YMChhPjjFdABOzas+ggPHkGNMFMDGr9gwKGE+OMV0AE7Nqz6CA8eQY0wUwMav2DAoYT44xXQATs2rPoIDx5BjTBTAxq/YMChhPjjFdABOzas+ggPHkGNMFMDGr9gwKGE+OMV0AE7Nqz6CA8eQY0wUwMav2DAoYT44xXQATs2rPoIDx5BjTBTAxq/YMChhPjjFdABOzas+ggPHkGNMFMDGr9gwKGE+OMV0AE7Nqz6CA8eQY0wUwMav2DAoYT44xXQATs2rPoIDx5BjTBTAxq/YMChhPjjFdABOzas+ggPHkGNMFMDGr9gwKGE+OMV0AE7Nqz6CA8eQY0wUwMav2DAoYT44xXQATs2rPoIDx5BjTBTAxq/YMChhPjjFdABOzas+ggPHkGNMFMDGr9gwKGE+OMV0AE7Nqz6CA8eQY0wUwMav2DAoYT44xXQATs2rPoIDx5BjTBTAxq/YMChhPjjFdABOzas+ggPHkGNMFMDGr9gz6G1HzSbXtC7t7AAAAAElFTkSuQmCC"/><br/>';
							echo '<strong>Baixar código</strong>';
						echo '</div>';
						echo '<div class="span4" style="text-align: center;">';
							echo '<img style="width: 100%; height: auto;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAAErUlEQVR4Xu3YwStscRjG8d8QQnZEFkqyY6NE/n0rlOxkS1ZqrCiFe/udOtPcue6YJ889Gc93Vtz7eo/3eT/9zjl6/X7/V+FDAhMm0APMhElR1iQAGCBICQBGiotiwGBASgAwUlwUAwYDUgKAkeKiGDAYkBIAjBQXxYDBgJQAYKS4KAYMBqQEACPFRTFgMCAlABgpLooBgwEpAcBIcVEMGAxICQBGiotiwGBASgAwUlwUAwYDUgKAkeKiGDAYkBIAjBQXxYDBgJQAYKS4KAYMBqQEACPFRTFgMCAlABgpLooBgwEpAcBIcVEMGAxICQBGiotiwGBASgAwUlwUAwYDUgKAkeKiGDAYkBIAjBQXxYDBgJQAYKS4KAYMBqQEACPFRTFgMCAlABgpLooBgwEpAcBIcVEMGAxICQBGiotiwGBASgAwUlwUAwYDUgKAkeKiGDAYkBIAjBQXxYDBgJQAYKS4KAYMBqQEACPFRTFgMCAlABgpLooBgwEpgakH8/7+Xs7Ozsrz83M5OTkpi4uLfwRwd3dXbm5uyvr6etnf32/+r9/vl6urq1J/tn729vbKxsbGRMF1fb2JfqkOi6YazOvrazk9PS1vb2+l1+v9BaZd7tPT0wBM+zNLS0vl6OioXF5eNtjq13Nzc2Oj7/p6HTqY+FJTC2Z4eXXaj8BcX1+Xh4eHUmvX1taaE6Y9cba3t8vOzs7g+3rKzM/PNyfP8vJyA6j+/P39fXMCra6uDnC6rjfpqTbxNjsonGowFxcX5eDgYHBKDN+S2tvO1tZWub29/RRMC6ieOI+Pj+X4+Licn5+X9iSq6P7H9TrYsfUSUwumTeGjZ4r232ZmZsru7m5zarQnTHtqjJ4w7feT3naGn5m+cj3rNjto9iPBDN9K2tvMZ7ekFkzNvJ4y9YQaflAeB/Sr1+tgz7ZL/DgwCwsLzVtTfdAd/aysrJTNzc3mremjZ5j6TNHeyuoD8MvLy19vUKMn2levZ9tkR41+HJjR1+oWQHvCjHtLmp2dbbDVt67Dw8PmpKlfD79BffZarVzvs7eyjgxIl4kDM+7vMP96vhm+Nalgxl1P2tQ3KZ56MN8kx5hfAzAxq/YMChhPjjFdABOzas+ggPHkGNMFMDGr9gwKGE+OMV0AE7Nqz6CA8eQY0wUwMav2DAoYT44xXQATs2rPoIDx5BjTBTAxq/YMChhPjjFdABOzas+ggPHkGNMFMDGr9gwKGE+OMV0AE7Nqz6CA8eQY0wUwMav2DAoYT44xXQATs2rPoIDx5BjTBTAxq/YMChhPjjFdABOzas+ggPHkGNMFMDGr9gwKGE+OMV0AE7Nqz6CA8eQY0wUwMav2DAoYT44xXQATs2rPoIDx5BjTBTAxq/YMChhPjjFdABOzas+ggPHkGNMFMDGr9gwKGE+OMV0AE7Nqz6CA8eQY0wUwMav2DAoYT44xXQATs2rPoIDx5BjTBTAxq/YMChhPjjFdABOzas+ggPHkGNMFMDGr9gwKGE+OMV0AE7Nqz6CA8eQY0wUwMav2DAoYT44xXQATs2rPoIDx5BjTBTAxq/YMChhPjjFdABOzas+ggPHkGNMFMDGr9gz6G1HzSbXtC7t7AAAAAElFTkSuQmCC"/><br/>';
							echo '<strong>Abrir terminal online</strong>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
				
				// Review tab
				echo '<div class="tab-pane" id="tab-code-review">';
					// Student's info
					echo '<div class="row" style="background: #efefef; padding: 5px;">';
						echo '<div class="span2">';
							if ($aProgram != null) {
								echo '<div class="grade-info">';
									echo ($aIsReviewing ? '<a href="#" id="changeGradeLink" title="Clique para editar a nota">' : '').'<strong>'.($aProgram['grade'] < 0 ? '?' : $aProgram['grade']).'</strong>' . ($aIsReviewing ? '<i class="icon-edit"></i></a>' : '');
									echo '<div id="changeGradePanel" style="display:none;">';
										echo '<form action="" method="post" name="formChangeGrade" id="formChangeGrade">';
											echo '<input type="hidden" name="action" value="changegrade" />';
											echo '<input type="hidden" name="programId" value="'.$aProgram['id'].'" />';
											echo '<input type="text" name="grade" value="'.($aProgram['grade'] < 0 ? '' : $aProgram['grade']).'" class="span1" placeholder="" />';
											echo '<input type="submit" name="submit" value="Ok" class="btn btn-primary" />';
										echo '</form>';
									echo '</div>';
									echo '<div class="grade-info-title">Nota</div>';
								echo '</div>';
							}
						echo '</div>';
						echo '<div class="span6" style="padding-top: 15px;">';
							layoutPrintUser($aUserInfo['id'], $aUserInfo);
						echo '</div>';
					echo '</div>';
					
					echo '<hr/>';
					
					// Student's code 
					echo '<h4><i class="icon-zoom-in"></i> Revisão do código<a href="#" id="code-review"></a></h4>';
					
					if ($aProgram != null) {
						echo '<div>';
							echo '<textarea name="code" id="code" style="width: 100%; height: 600px;">'.$aProgram['code'].'</textarea>';
						echo '</div>';
					} else {
						echo '<div class="span12">';
							echo 'Você ainda não criou um programa para resolver esse desafio.';
						echo '</div>';
					}
					
					// Revision
					echo '<h4><i class="icon-zoom-in"></i> Comentários do professor<a href="#" id="revisions"></a></h4>';
					$aReviews = $aData['reviews'];
					
					if (count($aReviews) > 0) {
						foreach($aReviews as $aReview) {
							echo '<div class="bloco-desafios">';
								echo '<div class="row">';
									echo '<div class="span11">';
										echo MarkdownExtended($aReview['comment']);
									echo '</div>';
								echo '</div>';
								echo '<div class="row" style="margin-top: 20px;">';
									echo '<div class="span3 offset8">';
										layoutPrintUser($aReview['fk_user']);
									echo '</div>';
								echo '</div>';
							echo '</div>';
						}
					} else if(!$aIsReviewing) {
						echo '<div class="row">';
							echo '<div class="span12">';	
								echo 'Nenhum comentário foi feito ainda.';
							echo '</div>';
						echo '</div>';
					}

					// Code review
					if ($aIsReviewing && $aProgram != null) {
						echo '<div class="row">';
							echo '<div class="span12">';
								echo '<form action="ajax-code.php" method="post" name="formReview" id="formReview">';
									echo '<input type="hidden" name="action" value="writereview" />';
									echo '<input type="hidden" name="id" value="" />';
									echo '<input type="hidden" name="programId" value="'.$aProgram['id'].'" />';
									layoutPrintMarkdownTextarea('comment', '');
									echo ' <input type="submit" name="submit" value="Salvar" class="btn btn-primary" />';
								echo '</form>';
							echo '</div>';
						echo '</div>';
					}
				echo '</div>';
			echo '</div>';
		echo '</div>';
		
		$aBaseUrl = View::baseUrl();
		
		echo '<script type="text/javascript">CODEBOT.initCodePage();</script>';
		
		// Codemirror stuff
		// TODO: replace with syntax highlighter?
		echo '<style>@import url("'.$aBaseUrl.'/js/codemirror/lib/codemirror.css");</style>';
		echo '<script src="'.$aBaseUrl.'/js/codemirror/lib/codemirror.js"></script>';
		echo '<script src="'.$aBaseUrl.'/js/codemirror/addon/edit/matchbrackets.js"></script>';
		echo '<script src="'.$aBaseUrl.'/js/codemirror/mode/clike/clike.js"></script>';
			
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
	
	layoutFooter(View::baseUrl());
?>