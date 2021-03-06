<?php

@include_once dirname(__FILE__).'/config.local.php';
require_once dirname(__FILE__).'/config.php';

session_start();
session_name(SESSION_NAME);

require_once dirname(__FILE__).'/db.php';
require_once dirname(__FILE__).'/auth.php';
require_once dirname(__FILE__).'/view.php';
require_once dirname(__FILE__).'/challenge.php';
require_once dirname(__FILE__).'/code.php';
require_once dirname(__FILE__).'/user.php';
require_once dirname(__FILE__).'/build.php';
require_once dirname(__FILE__).'/review.php';
require_once dirname(__FILE__).'/category.php';
require_once dirname(__FILE__).'/group.php';

require_once(dirname(__FILE__).'/libs/markdown/markdown_extended.php');

?>
