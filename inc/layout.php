<?php

require_once dirname(__FILE__).'/config.php';

function layoutNavBar() {
	$aPage = basename($_SERVER['PHP_SELF']);
	
	echo '<div class="navbar navbar-fixed-top navbar-inverse">';
		echo '<div class="navbar-inner">';
			echo '<div class="container">';
				echo '<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">';
					echo '<span class="icon-bar"></span>';
					echo '<span class="icon-bar"></span>';
					echo '<span class="icon-bar"></span>';
				echo '</a>';
				echo '<a class="brand" href="index.php">Codebot</a>';
			
				echo '<div class="nav-collapse">';
					echo '<ul class="nav">';
						echo '<li '.($aPage == 'challenges.php' 	? 'class="active"' : '').'><a href="challenges.php">Desafios</a></li>';
					echo '</ul>';
					
					layoutUserBar();
					
					if(authIsAuthenticated()) {
						layoutAdminNavBar();
					}
				echo '</div><!--/.nav-collapse -->';
			echo '</div>';
		echo '</div>';
	echo '</div>';
}

function layoutAdminNavBar() {
	$aPage = basename($_SERVER['PHP_SELF']);
	
	echo '<ul class="nav pull-right">';
		echo '<li class="dropdown pull-right">';
			echo '<a class="dropdown-toggle" data-toggle="dropdown" href="#">Professor <b class="caret"></b></a>';
			echo '<ul class="dropdown-menu">';
				echo '<li><a href="challenges-manager.php">Criar desafio</a></li>';
				echo '<li><a href="reviews.php">Revisar respostas</a></li>';
				//echo '<li class="divider"></li>';
				//echo '<li><a href="reviews.php">Revisar respostas</a></li>';
			echo '</ul>';
		echo '</li>';
	echo '</ul>';
}

function layoutUserBar() {
	$aClassLink	  = authIsAdmin() ? 'btn-danger' : 'btn-primary';
	
	echo '<ul class="nav pull-right">';
		echo '<div class="btn-group">';
			if(authIsAuthenticated()) {
				echo '<a class="btn '.$aClassLink.'" href="oops.php"><i class="icon-user icon-white"></i> '.$_SESSION['user']['name'].'</a>';
				echo '<a class="btn '.$aClassLink.' dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>';
					
				echo '<ul class="dropdown-menu">';
				echo '<li><a href="logout.php"><i class="icon-remove"></i> Sair</a></li>';
				echo '</ul>';				
			} else {
				echo '<a class="btn '.$aClassLink.'" href="login.php"><i class="icon-user icon-white"></i> Login</a>';
			}
		echo '</div>';
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
		
		if(LAYOUT_RESPONSIVE) {
			echo '<link href="'.$theBaseUrl.'/css/bootstrap-responsive.css" rel="stylesheet">';
		}
		
		echo '<!-- Le fav and touch icons -->';
		echo '<link rel="shortcut icon" href="img/favicon.ico">';
		echo '<link rel="apple-touch-icon" href="/img/apple-touch-icon.png">';
		echo '<link rel="apple-touch-icon" sizes="72x72" href="/img/apple-touch-icon-72x72.png">';
		echo '<link rel="apple-touch-icon" sizes="114x114" href="/img/apple-touch-icon-114x114.png">';
		
		echo '<script src="'.$theBaseUrl.'/js/jquery.js'.$aRandURLs.'"></script>';
		echo '<script src="'.$theBaseUrl.'/js/bootstrap.js'.$aRandURLs.'"></script>';
		echo '<script src="'.$theBaseUrl.'/js/codebot.js'.$aRandURLs.'"></script>';
	echo '</head>';
	
	echo '<body>';
	
	layoutNavBar();
	
	echo '<div class="container">';
}

function layoutFooter($theBaseUrl = '.') {
		echo '<hr>';
		
		echo '<footer>';
			echo '<p style="float:left;">&copy; 2013 - Codebot. Desenvolvido pelo curso de <a href="http://cc.uffs.edu.br" target="_blank">Ciência da Computação</a> - <a href="http://uffs.edu.br" target="_blank">UFFS</a>.</p>';
		echo '</footer>';
		
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
	
	echo '</div> <!-- /container -->';
	
	echo '</body>';
	echo '</html>';
}

function layoutPrintUser($theUserId, $theUserInfo = null, $theBadge = true) {
	$theUserInfo = !isset($theUserInfo) ? userGetById($theUserId) : $theUserInfo;
	
	if ($theUserInfo != null) {
		echo '<div class="user-info">';
			// TODO: use user data to show profile image
			echo '<img src="'.(DEBUG_MODE ? '' : 'http://avatars.io/twitter/as3gamegears').'" class="img-circle" title="'.$theUserInfo['name'].'"/>';
			echo '<strong>'.$theUserInfo['name'] . '</strong><br/>';
			
			if($theUserInfo['type'] == USER_LEVEL_PROFESSOR) {
				echo '<span class="label label-info">Prof</span> ';
			}
			
			echo '<small><i class="icon-ok-circle"></i> 10 <i class="icon-briefcase"></i> 3 <i class="icon-fire"></i> 4</small>';
		echo '</div>';
	}
}

function layoutTextToMarkdown($theText) {
	return MarkdownExtended($theText);
}

function layoutPrintMarkdownTextarea($theFieldName, $theInitialText = '') {
	echo '<div class="tabbable">';
		echo '<ul class="nav nav-tabs">';
			echo '<li class="active"><a href="#'.$theFieldName.'-tab-markdown" data-toggle="tab">Comentário</a></li>';
			echo '<li><a href="#'.$theFieldName.'-tab-view-markdown" data-toggle="tab">Visualização</a></li>';
		echo '</ul>';
		echo '<div class="tab-content" style="height: 320px;">';
			echo '<div class="tab-pane active" id="'.$theFieldName.'-tab-markdown">';
				echo '<textarea name="comment" id="'.$theFieldName.'" style="width: 95%; height: 300px;">'.$theInitialText.'</textarea>';
			echo '</div>';
			echo '<div class="tab-pane" id="'.$theFieldName.'-tab-view-markdown">';
				echo 'A visualização não está disponível ainda. Desculpe!';
			echo '</div>';
		echo '</div>';
	echo '</div>';
	
	echo '<script type="text/javascript">CODEBOT.createMarkdownTextarea(\''.$theFieldName.'\');</script>';
}

?>