<?php 
require_once dirname(__FILE__).'/inc/globals.php';

authAllowAuthenticated();
header('Content-Type: text/html; charset=utf8');

$aText = isset($_REQUEST['text']) ? $_REQUEST['text'] : '';
$aHtml = layoutTextToMarkdown($aText);

echo $aHtml;
?>