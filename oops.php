<?php 
	require_once dirname(__FILE__).'/inc/globals.php';

	layoutHeader('Inicial');
	
	echo '<div class="hero-unit">';
		echo '<h1>Oops!</h1>';
		echo '<p>Você acessou uma página inexistente ou que está temporariamente indisponível.</p>';
	echo '</div>';

	echo '<div class="row">';
		echo '<div class="span12">';
		echo '</div>';
	echo '</div>';
	
	layoutFooter();
?>