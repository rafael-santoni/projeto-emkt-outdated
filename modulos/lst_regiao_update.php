<?php
include_once '/home/rafasan/public_html/EMkt/includes/config.php';

include_once DIR.INCLUDES.'topo.php';
include_once DIR.INCLUDES.'menu.html';

include_once DIR.CLASSES.'db.class.php';
include_once DIR.INCLUDES.'func_jQuery.php';

$Banco = new DB(HOST,USER,PASS,DB_NAME);
$Banco->DBError();
ajaxjQuery('index.php', 'action', 'location.href="'.URL.MODULES.'lst_regiao_list.php";');


###############################
#####  VERIFICA  REGIAO   #####
###############################

if (!isset($_GET['regiao']) || empty($_GET["regiao"]) || !is_numeric($_GET["regiao"])){
	echo '<h2>Erro ao processar</h2>Não foi possivel completar a operação. <BR />Regi&atilde;o não definida!'; exit();
	//echo '<script>history.back();</script>';
}

//$queryStr = "SELECT * FROM `modules` WHERE mod_id=$_GET[module]";
$Banco->selecionaTabela("`regiao`","`reg_id` AS ID, `reg_nome` AS Nome, `reg_nivel` AS Nivel, `reg_status` AS Status","WHERE reg_id=$_GET[regiao]");
$rsRegiao = mysql_fetch_object($Banco->resultado);

if(!$rsRegiao){
	echo "<h2>Erro ao processar!!</h2><BR />Entre em contato com o admin do site."; exit();
	//echo '<script>history.back();</script>';
}

#############################
#####  VERIFICA NIVEL   #####
#############################

if (!isset($_GET['lvl']) || empty($_GET["lvl"]) || !is_numeric($_GET["lvl"])){
	echo '<h2>Erro ao processar</h2>Não foi possivel completar a operação. <BR />N&iacute;vel n&atilde;o definido!'; exit();
	//echo '<script>history.back();</script>';
}

//$queryStr = "SELECT * FROM `modules_item` WHERE mdi_id=$_GET[item]";
$Banco->selecionaTabela("`nivel`","`lvl_id` AS ID, `lvl_nome` AS Nome, `lvl_status` AS Status","WHERE lvl_id=$_GET[lvl]");
$rsNivel = mysql_fetch_object($Banco->resultado);
//echo "<script>alert($rsModItens)</script>";
if(!$rsNivel || $rsNivel->ID != $rsRegiao->Nivel){
	echo "<h2>Erro ao processar!!</h2><BR />Entre em contato com o admin do site."; exit();
	//echo '<script>history.back();</script>';
}


/*   ###### Testes     ###############
$queryStr = "SELECT * FROM `modules` WHERE mod_id=$_GET[module]";
$qr = mysql_query($queryStr) or die (mysql_error());
echo $qr; echo mysql_num_rows($qr);
print_r(mysql_fetch_object($qr));
if(!$qr){
//if(mysql_num_rows($qr) <= 0){
	echo 'Não foi possivel completar a operação.'; exit();
}

$rsModules = mysql_fetch_object($qr);

echo (!$rsModules) ? "<h2>Erro ao processar!!</h2><BR />Entre em contato com o admin do site." : "";
//echo "<PRE>"; print_r($rsModules); echo "</PRE>";  */


?>

<div id="content">
	<h1>Altera&ccedil;&atilde;o de Regi&atilde;o
    <a href="<?php echo URL.MODULES?>lst_regiao_list.php">Cancelar</a></h1>
	
	<div id="return"></div>
	<div id="load"><img src="<?php echo URL.IMG ?>loading.gif" alt ="" /><br />Aguarde, processando...</div>
	
	<form id="form">
		<input type="hidden" name="action" id="action" value="updateRegiao" />
		<input type="hidden" name="reg_id" id="reg_id" value="<?php echo $_GET['regiao']?>" />
		
				<p>
			<label for="nome">Nome:</label>
			<input type="text" value="<?php echo $rsRegiao->Nome; ?>" name="nome" id="nome" />
		</p>
		
<!-- 		<p> -->
<!-- 			<label for="nickname">Apelido:</label> -->
<!-- 			<input type="text" value="" name="nickname" id="nickname" /> -->
<!-- 		</p> -->

		<p>
			<label for="nivel">N&iacute;vel:</label>
			<select name="nivel" id="nivel">
				<option value="<?php echo $rsNivel->ID; ?>"><?php echo $rsNivel->Nome; ?></option>
			<?php 
				//$rsModules2 = mysql_query("SELECT * FROM `modules` WHERE mod_id<>$_GET[module]") or die("Erro na base de dados: ".mysql_error());
				$Banco->selecionaTabela("`nivel`","`lvl_id` AS ID, `lvl_nome` AS Nome, `lvl_status` AS Status","WHERE lvl_id<>$_GET[lvl]");
                $rsNiveis2 = $Banco->resultado;
                if(mysql_num_rows($rsNiveis2)>0):
					while($row = mysql_fetch_object($rsNiveis2)):
						echo '<option value="'.$row->ID.'">'.$row->Nome.'</option>';
					endwhile;
				endif;
			?>
			</select>
		</p>
        
		<p>
			<label for="status">Ativo:</label>
			<select name="status" id="status">
				<option value="1" <?php echo ($rsRegiao->Status) ? 'selected="selected"' : ''; ?>>Sim</option>
				<option value="0" <?php echo (!$rsRegiao->Status) ? 'selected="selected"' : ''; ?>>N&atilde;o</option>
			</select>
		</p>
		
		<p>
			<input type="submit" value="Salvar" />
			<input type="reset" style="display: none;" id="clean" />
		</p>
	
	</form>

</div><!--### DIV id="content" ###-->

<?php include_once DIR.INCLUDES.'fundo.php'; ?>