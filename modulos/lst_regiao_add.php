<?php
include_once '/home/rafasan/public_html/EMkt/includes/config.php';

include_once DIR.INCLUDES.'topo.php';
include_once DIR.INCLUDES.'menu.html';

include_once DIR.CLASSES.'db.class.php';
include_once DIR.INCLUDES.'func_jQuery.php';

$Banco = new DB(HOST,USER,PASS,DB_NAME);
$Banco->DBError();
ajaxjQuery('index.php','regiao');

?>
<div id="content">
	<h1>Cadastro de Regi&otilde;es
    <a href="<?php echo URL.MODULES?>lst_regiao_list.php">Voltar</a></h1>
	
	<div id="return"></div>
	<div id="load"><img src="<?php echo URL.IMG ?>loading.gif" alt ="" /><br />Aguarde, processando...</div>
	
	<form id="form">
		<input type="hidden" name="action" id="action" value="saveRegiao" />
		
		<p>
			<label for="regiao">Nome da Regi&atilde;o:</label>
			<input type="text" value="" name ="regiao" id = "regiao" />
		</p>

		<p>
			<label for="nivel">N&iacute;vel da Regi&atilde;o</label>
			<select name="nivel" id="nivel">
				<option value="0"></option>
				<?php 
					$Banco->selecionaTabela('nivel','`lvl_id` as ID, `lvl_nome` AS Nome, `lvl_status` as Status','WHERE lvl_status=1');
                    $rsNivel = $Banco->resultado;
                    echo "valor do rsNivel ".$rsNivel;
                    //$rsMudules = mysql_query("SELECT mod_id, mod_name FROM `modules` WHERE mod_status=1");
					if(mysql_num_rows($rsNivel)>0):
						while($row = mysql_fetch_object($rsNivel)):
						
							echo '<option value="'.$row->ID.'">'.$row->Nome.'</option>';
						
						endwhile;
					else:
						echo '<option value="0">Nenhum n&iacute;vel encontrado</option>';
					endif;
				?>
				
			</select>
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