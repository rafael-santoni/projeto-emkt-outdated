<?php
include_once '/home/rafasan/public_html/EMkt/includes/config.php';

include_once DIR.INCLUDES.'topo.php';
include_once DIR.INCLUDES.'menu.html';

include_once DIR.CLASSES.'db.class.php';
include_once DIR.INCLUDES.'func_jQuery.php';

$Banco = new DB(HOST,USER,PASS,DB_NAME);
$Banco->DBError();
ajaxjQuery('index.php','nivel');

?>
<div id="content">
	<h1>Cadastro de N&iacute;veis
    <a href="<?php echo URL.MODULES?>lst_nivel_list.php">Voltar</a></h1>
	
	<div id="return"></div>
	<div id="load"><img src="<?php echo URL.IMG ?>loading.gif" alt ="" /><br />Aguarde, processando...</div>
	
	<form id="form">
		<input type="hidden" name="action" id="action" value="saveNivel" />
		
		<p>
			<label for="id">C&oacute;digo do N&iacute;vel:</label>
			<input type="text" value="1" name ="id" id = "id" />
		</p>
  
        <p>
			<label for="nivel">Nome do N&iacute;vel:</label>
			<input type="text" value="" name ="nivel" id = "nivel" />
		</p>

		<p>
			<label for="status">Ativo:</label>
			<select name="status" id="status">
				<option value="1">Sim</option>
				<option value="0">N&atilde;o</option>
			</select>
		</p>
        
		<p>
			<input type="submit" value="Salvar" />
			<input type="reset" style="display: none;" id="clean" />
		</p>
	
	</form>

</div><!--### DIV id="content" ###-->

<?php include_once DIR.INCLUDES.'fundo.php'; ?>