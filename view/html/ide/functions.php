<?php

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
		
		echo '<!-- Le fav and touch icons -->';
		echo '<link rel="shortcut icon" href="img/favicon.ico">';
		echo '<link rel="apple-touch-icon" href="/img/apple-touch-icon.png">';
		echo '<link rel="apple-touch-icon" sizes="72x72" href="/img/apple-touch-icon-72x72.png">';
		echo '<link rel="apple-touch-icon" sizes="114x114" href="/img/apple-touch-icon-114x114.png">';
		
		echo '<!-- Le styles -->';
		echo '<style>@import url("'.$theBaseUrl.'/js/codemirror/lib/codemirror.css");</style>';
		echo '<link href="'.$theBaseUrl.'/style.css'.$aRandURLs.'" rel="stylesheet">';
		
		echo '<!-- Le scripts -->';
		echo '<script src="'.$theBaseUrl.'/../js/jquery.js'.$aRandURLs.'"></script>';
		echo '<script src="'.$theBaseUrl.'/js/codemirror/lib/codemirror.js"></script>';
		echo '<script src="'.$theBaseUrl.'/js/codemirror/addon/edit/matchbrackets.js"></script>';
		echo '<script src="'.$theBaseUrl.'/js/codemirror/mode/clike/clike.js"></script>';
		echo '<script src="'.$theBaseUrl.'/js/ide.js'.$aRandURLs.'"></script>';
	echo '</head>';
	
	echo '<body>';
	echo '<div class="container">';
}

function layoutFooter($theBaseUrl = '.') {		
		echo '<div id="info-overlay"></div>';
		
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

function layoutToolBar() {
	echo '<div id="toolbar">';
		// TODO: add buttons using a generic approach
		echo '<a href="#" id="btn-save" class="ide-button" onclick="IDE.build();">[S]</a>';
		echo '<div id="build-info">AAAA</div>';
	echo '</div>';
}
?>