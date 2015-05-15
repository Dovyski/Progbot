/**
 * Bootstrap file for Codebot to bootstrap using
 * Progbot plugins and configurations.
 */

$('body').append('<script type="text/javascript" src="../progbot.web.filesystem.js"></script>');

CODEBOT.init(new ProgbotWebFilesystem());
