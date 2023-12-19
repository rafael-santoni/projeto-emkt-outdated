<?php
include_once '/home/rafasan/public_html/EMkt/includes/config.php';

include_once DIR.INCLUDES.'topo.php';
include_once DIR.INCLUDES.'menu.html';

include_once DIR.CLASSES.'db.class.php';
include_once DIR.INCLUDES.'func_jQuery.php';

ajaxjQuery('index.php', 'action', 'history.go();');
$Banco = new DB(HOST,USER,PASS,DB_NAME);
$Banco->DBError();
?>

<div id="content">
	<h1>P&aacute;gina Em Constru&ccedil;&atilde;o</h1>
    
</div><!--### DIV id="content" ###-->

<?php include_once DIR.INCLUDES.'fundo.php'; ?>