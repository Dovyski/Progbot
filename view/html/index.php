<?php 
	require_once dirname(__FILE__).'/layout.php';
	
	layoutHeader('Start', View::baseUrl());
	
	echo '<div class="hero-unit">';
		echo '<h1>Codebot</h1>';
		echo '<p>Texto bem bonito falando brevemente sobre o sistema</p>';
		echo '<p><a href="oops.php" class="btn btn-primary btn-large">Saber mais &raquo;</a></p>';
	echo '</div>';
	
	echo '<div class="row">';
		echo '<div class="span4">';
			echo '<h2>Guia rápido <span class="label label-warning">Novo</span></h2>';
			echo '<p>O NCC possui diversas vantagens e algumas obrigações para seus usuários. Aprenda todas elas rapidamente através dos 8 mandamentos do NCC, um guia simples e rápido de ler.</p>';
		echo '</div>';
		
		echo '<div class="span4">';
			echo '<h2>Armazenamento</h2>';
			echo '<p>Cada usuário do NCC possui um espaço reservado no servidor para guardar arquivos (documentos, trabalhos, etc). Saiba como usar esse espaço para guardar e proteger seus dados.</p>';
		echo '</div>';
		
		echo '<div class="span4">';
			echo '<h2>Contato</h2>';
			echo '<p>Não encontrou aquilo que procurava, está com dúvidas sobre o funcionamento do NCC, tem críticas ou sugestões? Fale conosco: <a href="mailto:ncc@uffs.edu.br">ncc@uffs.edu.br</a></p>';
		echo '</div>';
	echo '</div>';
	
	layoutFooter();
?>