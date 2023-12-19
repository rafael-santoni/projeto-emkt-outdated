<?php
include_once '/home/rafasan/public_html/EMkt/includes/config.php';

include_once DIR.INCLUDES.'topo.php';
include_once DIR.INCLUDES.'menu.html';

include_once DIR.CLASSES.'db.class.php';
$Banco = new DB(HOST,USER,PASS,DB_NAME);
$Banco->DBError();

include_once DIR.INCLUDES.'func_jQuery.php';
//    ajaxjQuery('index.php','nome');
    jQueryMultiUpload('index.php','nome');
    botaoAddCampo("imagens[]","file");

?>
<div id="content">
	<h1>Cadastro de Templates para E-Marketing
    <a href="<?php echo URL.MODULES?>emk_template_list.php">Voltar</a></h1>
	
	<div id="return"></div>
	<div id="load"><a href="javascript:void(0);" style="outline: none;" id="topFocus"><img src="<?php echo URL.IMG ?>loading.gif" alt ="" /></a><br />Aguarde, processando...</div>
	
    <form enctype="multipart/form-data" method="post" name="multiform">
		<input type="hidden" name="action" id="action" value="saveTemplate_temp" />
		
        <p>
			<label for="nome">Nome do Template:</label>
			<input type="text" value="" name="nome" id="nome" />
		</p>
        
        <p>
			<label for="arquivo">Arquivo Template:</label>
			<input type="file" value="" name="arquivo" id="arquivo" />
		</p>

		<p>
			<label for="imgURL">URL das Imagens:</label>
            <input type="text" value="" name="imgURL" id="imgURL" />
		</p>
       
        <p>
			<label for="msg_padrao">Mensagem Padr&atilde;o:</label>
			<textarea name="msg_padrao" id="msg_padrao" cols="50" rows="4"></textarea>
		</p>
        
		<p>
            <label for="imagem1">Imagems:</label> <br /><br />
            <input type="file"   name="imagens[]"  /><br />
        
            <span id="result">
                <!-- Se for precionado o + aqui é adicionado os campos -->
            </span>
        </p>
        
        <span>
            <a href="javascript:void(0);" onClick="adicionaCampo();">+ Adicionar Imagem</a>
        </span>
        
		<p>
			<!--  <input type="submit" id="upload" value="Salvar" />   -->
            <input type="button" id="upload" value="Salvar" />
			<input type="reset" style="display: none;" id="clean" />
		</p>
	
	</form>

</div><!--### DIV id="content" ###-->

<?php include_once DIR.INCLUDES.'fundo.php'; ?>