#!/usr/bin/php
<?php

@include_once dirname(__FILE__).'/config.local.php';
@require_once dirname(__FILE__).'/config.php';

echo 'chown '.TEST_USER.':'.TEST_USER_GROUP.' -R ' . dirname(__FILE__) . '/tmp/*';
//system('chown '.TEST_USER.':'.TEST_USER_GROUP.' ' . dirname(__FILE__) . '/tmp/*';
//system('cp ' . dirname(__FILE__) . '/tmp/* ' . DEPLOY_DIR);
echo 'cp -r ' . dirname(__FILE__) . '/tmp/* ' . DEPLOY_DIR;

?>