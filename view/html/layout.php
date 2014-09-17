<?php

function layoutNavBar($theBaseUrl) {
	$aPage = basename($_SERVER['PHP_SELF']);
	
	echo '<nav class="navbar navbar-default" role="navigation">';
		echo '<div class="container">';
			echo '<div class="navbar-header">';
				echo '<a class="navbar-brand" href="index.php" title="Ir para página inicial"><i class="fa fa-home"/></i></a>';
			echo '</div>';
			
			echo '<div class="collapse navbar-collapse">';
				$aUserInfo = null;
				
				if (authIsAuthenticated()) {
					$aUserInfo = userGetById($_SESSION['user']['id']);
					$aAssignmentCount = $aUserInfo['type'] == USER_LEVEL_STUDENT ? assigmentCountActivesByUser($aUserInfo) : 0;
				
					echo '<ul class="nav navbar-nav">';
						echo '<li '.($aPage == 'challenges.php' 	? 'class="active"' : '').'><a href="challenges.php">Desafios</a></li>';
						echo '<li '.($aPage == 'assignments.php' 	? 'class="active"' : '').'><a href="assignments.php">Trabalhos '.($aAssignmentCount != 0 ? '<span class="badge alert-danger">'.$aAssignmentCount.'</span>' : '').'</a></li>';
					echo '</ul>';
				}
				
				layoutUserBar($aUserInfo);
					
				if(authIsAuthenticated()) {
					layoutAdminNavBar($aUserInfo);
				}
			echo '</div>';
		echo '</div>';
	echo '</nav>';
}

function layoutAdminNavBar($theUserInfo) {
	$aPage = basename($_SERVER['PHP_SELF']);
	
	if (!userIsLevel($theUserInfo, USER_LEVEL_PROFESSOR)) {
		return;
	}
	
	echo '<ul class="nav navbar-nav navbar-right">';
		echo '<li class="dropdown">';
			echo '<a class="dropdown-toggle" data-toggle="dropdown" href="#">Professor <b class="caret"></b></a>';
			echo '<ul class="dropdown-menu" role="menu">';
				echo '<li role="presentation" class="dropdown-header">Desafio</li>';
				echo '<li><a href="challenges-manager.php">Criar desafio</a></li>';
				echo '<li><a href="reviews.php">Revisar respostas</a></li>';
				
				echo '<li class="divider"></li>';
				echo '<li role="presentation" class="dropdown-header">Trabalhos</li>';
				echo '<li><a href="reviews.php">Criar trabalho</a></li>';
				echo '<li><a href="reviews.php">Revisar respostas</a></li>';
			echo '</ul>';
		echo '</li>';
	echo '</ul>';
}

function layoutUserBar($theUserInfo) {
	$aClassLink	= authIsAdmin() ? 'btn-danger' : 'btn-primary';
	echo '<ul class="nav navbar-nav navbar-right">';
		if (authIsAuthenticated()) {
			echo '<li style="margin-top: -5px;">';
				layoutPrintUser($theUserInfo['id'], $theUserInfo, true);
			echo '</li>';
			echo '<li class="dropdown">';
				echo '<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i><b class="caret"></b></a>';
				echo '<ul class="dropdown-menu" role="menu">';
					echo '<li><a href="logout.php"><i class="fa fa-sign-out"></i> Sair</a></li>';
				echo '</ul>';				
			echo '</li>';
		} else {
			echo '<li class="dropdown">';
			echo '<a href="login.php"><span class="glyphicon glyphicon-user"></span> Login</a>';
			echo '</li>';
		}
	echo '</ul>';
}

function layoutHeader($theTitle, $theBaseUrl = '.') {
	echo '<!DOCTYPE html>';
	echo '<html lang="en">';
	echo '<head>';
		echo '<meta charset="utf-8">';
		echo '<title>'.(empty($theTitle) ? '' : $theTitle).' | Codebot</title>';
		echo '<meta name="description" content="">';
		echo '<meta name="author" content="">';
		
		echo '<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->';
		echo '<!--[if lt IE 9]>';
		echo '<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>';
		echo '<![endif]-->';
		
		$aRandURLs = DEBUG_MODE ? '?'.rand(20, 9999) : '';
		
		echo '<!-- Le styles -->';
		echo '<link href="'.$theBaseUrl.'/css/bootstrap.css" rel="stylesheet">';
		echo '<link href="'.$theBaseUrl.'/css/style.css'.$aRandURLs.'" rel="stylesheet">';
		
		echo '<!-- Le fav and touch icons -->';
		echo '<link rel="shortcut icon" href="img/favicon.ico">';
		echo '<link rel="apple-touch-icon" href="/img/apple-touch-icon.png">';
		echo '<link rel="apple-touch-icon" sizes="72x72" href="/img/apple-touch-icon-72x72.png">';
		echo '<link rel="apple-touch-icon" sizes="114x114" href="/img/apple-touch-icon-114x114.png">';
		
		echo '<!-- FontAwesome -->';
		echo '<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">';
		
		echo '<script src="'.$theBaseUrl.'/js/jquery.js'.$aRandURLs.'"></script>';
		echo '<script src="'.$theBaseUrl.'/js/bootstrap.js'.$aRandURLs.'"></script>';
		echo '<script src="'.$theBaseUrl.'/js/codebot.js'.$aRandURLs.'"></script>';
	echo '</head>';
	
	echo '<body>';
	
	layoutNavBar($theBaseUrl);
}

function layoutFooter($theBaseUrl = '.') {
		echo '<div class="container">';
			echo '<hr>';
			echo '<footer class="footer">';
				echo '<a href="http://fronteiratec.com" target="_blank"><img src="'.$theBaseUrl.'/img/logo_fronteiratec_small.png"/></a>';
				echo '<a href="http://cc.uffs.edu.br" target="_blank"><img src="'.$theBaseUrl.'/img/logo_cc_bw.png"/></a>';
				echo '<p>&copy; '.date('Y').' - FronteiraTec - Todos os direitos reservados.</p>';
			echo '</footer>';
			
			echo '<div id="info-overlay">Salvando...</div>';
			
		if(DEBUG_MODE) {
			echo '<div class="row" style="margin-top: 80px;">';
				echo '<div class="span12">';
					echo '<h2>Debug</h2>';
					echo 'IP <pre>'.$_SERVER['REMOTE_ADDR'].'</pre>';
					echo 'Sessão ';
					var_dump($_SESSION);
				echo '</div>';
			echo '</div>';
		}
		echo '</div>';
		
	echo '</body>';
	echo '</html>';
}

function layoutPrintUser($theUserId, $theUserInfo = null, $theSimplified = false) {
	$theUserId = (int)$theUserId;
	$theUserInfo = !isset($theUserInfo) ? userGetById($theUserId) : $theUserInfo;
	
	if ($theUserInfo != null) {
		$aRole = $theUserInfo['type'] == USER_LEVEL_PROFESSOR ? '<span class="label label-info">Prof</span> ' : '';
		$aAvatar = '<img src="'.(DEBUG_MODE ? '' : 'http://avatars.io/twitter/as3gamegears').'" class="img-circle" title="'.$theUserInfo['name'].'" style="'.($theSimplified ? 'width: 25px;' : '').'" />';
	
		if ($theSimplified) {
			echo '<a href="user.php?id='.$theUserId.'">'. $aAvatar . ' ' . $aRole . '<strong>'.$theUserInfo['name'].'</strong></a>';
			
		} else {
			echo '<div class="user-info">';
				// TODO: use user data to show profile image
				echo $aAvatar;
				echo '<a href="user.php?id='.$theUserId.'"><strong>'.$theUserInfo['name'] . '</strong></a><br/>';
				echo $aRole;
				
				echo '<small><i class="icon-ok-circle"></i> 10 <i class="icon-briefcase"></i> 3 <i class="icon-fire"></i> 4</small>';
			echo '</div>';
		}
	}
}

function layoutPrintMarkdownTextarea($theFieldName, $theInitialText = '', $theTabsText = array(), $theTextAreaHeight = '300px') {
	echo '<div class="tabbable markdown-panel">';
		echo '<ul class="nav nav-tabs">';
			echo '<li class="active"><a href="#'.$theFieldName.'-tab-markdown" data-toggle="tab">'.(isset($theTabsText[0]) ? $theTabsText[0] : 'Comentário').'</a></li>';
			echo '<li><a href="#'.$theFieldName.'-tab-view-markdown" data-toggle="tab">'.(isset($theTabsText[1]) ? $theTabsText[1] : 'Visualização').'</a></li>';
		echo '</ul>';
		echo '<div class="tab-content" style="height: '.$theTextAreaHeight.'; width: 100%;">';
			echo '<div class="tab-pane active" id="'.$theFieldName.'-tab-markdown">';
				echo '<textarea name="'.$theFieldName.'" id="'.$theFieldName.'" style="width: 100%; height: '.$theTextAreaHeight.'; border-top: none; padding-top: 5px">'.$theInitialText.'</textarea>';
			echo '</div>';
			echo '<div class="tab-pane" id="'.$theFieldName.'-tab-view-markdown" style="padding: 7px 5px 5px 3px;">';
				echo 'A visualização não está disponível ainda. Desculpe!';
			echo '</div>';
		echo '</div>';
	echo '</div>';
	
	echo '<script type="text/javascript">CODEBOT.createMarkdownTextarea(\''.$theFieldName.'\');</script>';
}

?>