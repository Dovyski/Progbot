#!/usr/bin/php
<?php

// Run this file as root under sudo: http://superuser.com/questions/440363/can-i-make-a-script-always-execute-as-root

@include_once dirname(__FILE__).'/config.local.php';
@require_once dirname(__FILE__).'/config.php';

system('cp -r ' . dirname(__FILE__) . '/tmp/* ' . DEPLOY_DIR);
system('chown '.TEST_USER.':'.TEST_USER_GROUP.' -R '. DEPLOY_DIR);
system('chmod -R 755 '. DEPLOY_DIR);

// TODO: delete folder/file after copying it?
?>