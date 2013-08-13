<?php 
	require_once dirname(__FILE__).'/layout.php';
	
	layoutHeader('Start', View::baseUrl());
	
	echo '<div class="hero-unit">';
		echo '<h1>Codebot</h1>';
		echo '<p>Ensine e aprenda programação. Ponto.</p>';
		//echo '<p><a href="oops.php" class="btn btn-primary btn-large">Saber mais &raquo;</a></p>';
	echo '</div>';
	
	echo '<div class="row">';
		echo '<div class="span4 index-hero1">';
			echo '<h2>Programe no Browser</h2>';
			echo '<p>Um ambiente de desenvolvimento completo, disponível através do browser: editor, terminal, compilação, o que for necessário.</p>';
		echo '</div>';
		
		echo '<div class="span4 index-hero2">';
			echo '<h2>Desafios e Tarefas</h2>';
			echo '<p>Resolva desafios categorizados por assunto e nível de dificuldade. Professores podem criar desafios novos a qualquer momento.</p>';
		echo '</div>';
		
		echo '<div class="span4 index-hero3">';
			echo '<h2>Feedback</h2>';
			echo '<p>Código e feedback dado pelo professor são tratados de forma integrada: feedback junto ao código, porém sem modificá-lo.</p>';
		echo '</div>';
	echo '</div>';

	layoutFooter(View::baseUrl());
?>