<?php

@define('LAYOUT_RESPONSIVE',		false);

// Database info
@define('DB_DSN',					'mysql:host=localhost;dbname=codebot');
@define('DB_USER',					'root');
@define('DB_PASSWORD',				'');

// Testing stuff
@define('TESTING_TTY_URL', 			'http://172.20.6.170:8080/');
@define('TESTING_TTY_DEPLOY_URL', 	'http://172.20.6.170/codebot/cb/testing/builder/');
@define('TESTING_TTY_PASSWORD', 	'test');

// Password
@define('PASSWORD_SALT', 			'dlaejhdwieugr34712-13fkj3-122045*&@#$)*&Gkdf*%$@I&$fdfd');

// System params
@define('DEBUG_MODE', 				false);
@define('SESSION_NAME', 			'codebotsid');
?>