<?php

require_once dirname(__FILE__).'/config.php';

session_start();
session_name(SESSION_NAME);

require_once dirname(__FILE__).'/utils.php';
require_once dirname(__FILE__).'/auth.php';
require_once dirname(__FILE__).'/layout.php';

?>