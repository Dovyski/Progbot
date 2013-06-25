<?php 
	require_once dirname(__FILE__).'/inc/globals.php';

	layoutHeader('Inicial');
	
	echo '<div class="hero-unit">';
		echo '<h1>Restrito!</h1>';
		echo '<p>Você não tem permissão para acessar a página solicitada.</p>';
	echo '</div>';

	echo '<div class="row">';
		echo '<div class="span12">';
		echo '</div>';
	echo '</div>';
	
	layoutFooter();
?>