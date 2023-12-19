<?php
include_once '/home/rafasan/public_html/EMkt/includes/config.php';

include_once DIR.INCLUDES.'topo.php';
include_once DIR.INCLUDES.'menu.html';

include_once DIR.CLASSES.'db.class.php';
    $Banco = new DB(HOST,USER,PASS,DB_NAME);
    $Banco->DBError();

include_once DIR.INCLUDES.'func_jQuery.php';
    ajaxjQuery('index.php', 'action', 'location.href="'.URL.MODULES.'lst_email_list.php";');
    checkBoxAll("regioes[]");

##############################
#####  VERIFICA  EMAIL   #####
##############################

if (!isset($_GET['email']) || empty($_GET["email"]) || !is_numeric($_GET["email"])){
	echo '<h2>Erro ao processar</h2>N&atilde;o foi possivel completar a opera&ccedil;&atilde;o. <BR />Email n&atilde;o definido!'; exit();
	//echo '<script>history.back();</script>';
}

//$queryStr = "SELECT * FROM `modules` WHERE mod_id=$_GET[module]";
$Banco->selecionaTabela("lista_email","`lst_id` AS ID, `lst_email` as Email, `lst_nome_tratamento` as Tratamento, `lst_primeiro_nome` AS primeiroNome, `lst_nome_meio` AS nomeMeio, `lst_sobrenome`AS Sobrenome, `lst_sexo` AS Sexo, `lst_nivel` AS Nivel, `lst_status` AS Status","WHERE lst_id=$_GET[email]");
$rsEmail = mysql_fetch_object($Banco->resultado);

if(!$rsEmail){
	echo "<h2>Erro ao processar!!</h2><BR />Entre em contato com o admin do site."; exit();
	//echo '<script>history.back();</script>';
}


/*###############################
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
}    */

#############################
#####  VERIFICA NIVEL   #####
#############################

if (!isset($_GET['lvl']) || empty($_GET["lvl"]) || !is_numeric($_GET["lvl"])){
	echo '<h2>Erro ao processar</h2>N&atilde;o foi possivel completar a opera&ccedil;&atilde;o. <BR />N&iacute;vel não definido!'; exit();
	//echo '<script>history.back();</script>';
}

//$queryStr = "SELECT * FROM `modules_item` WHERE mdi_id=$_GET[item]";
$Banco->selecionaTabela("`nivel`","`lvl_id` AS ID, `lvl_nome` AS Nome, `lvl_status` AS Status","WHERE lvl_id=$_GET[lvl]");
$rsNivel = mysql_fetch_object($Banco->resultado);
//echo "<script>alert($rsModItens)</script>";
if(!$rsNivel || $rsNivel->ID != $rsEmail->Nivel){
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
	<h1>Altera&ccedil;&atilde;o de Emails Para Envio
    <a href="<?php echo URL.MODULES?>lst_email_list.php">Cancelar</a></h1>
	
	<div id="return"></div>
	<div id="load"><a href="javascript:void(0);" style="outline: none;" id="topFocus"><img src="<?php echo URL.IMG ?>loading.gif" alt ="" /></a><br />Aguarde, processando...</div>
	
	<form id="form">
		<input type="hidden" name="action" id="action" value="updateEmail" />
		<input type="hidden" name="lst_id" id="lst_id" value="<?php echo $_GET['email']?>" />
		
		<p>
			<label for="email">Email da Pessoa:</label>
			<input type="text" value="<?php echo $rsEmail->Email; ?>" name ="email" id = "email" />
		</p>
        
        <p>
			<label for="tratamento">Nome Tratamento:</label>
			<input type="text" value="<?php echo $rsEmail->Tratamento; ?>" name ="tratamento" id = "tratamento" />
		</p>
        
        <p>
			<label for="primeiroNome">Primeiro Nome:</label>
			<input type="text" value="<?php echo $rsEmail->primeiroNome; ?>" name ="primeiroNome" id = "primeiroNome" />
		</p>
        
        <p>
			<label for="nomeMeio">Nome do Meio:</label>
			<input type="text" value="<?php echo $rsEmail->nomeMeio; ?>" name ="nomeMeio" id = "nomeMeio" />
		</p>
        
        <p>
			<label for="sobrenome">Sobrenome:</label>
			<input type="text" value="<?php echo $rsEmail->Sobrenome; ?>" name ="sobrenome" id = "sobrenome" />
		</p>
		
        <p>
			<label for="regiao">Regi&atilde;o:</label>
            <div>
            <table style="margin-left: 18px; width: 75%; border: 0px !important;">
            <tr><th><input type="checkbox" name="selectAll" onClick="CheckAll(this)" /><label> Todas as Regi&otilde;es</label></th></tr>
            <?php
				$Banco->selecionaTabela("`regiao`","`reg_id` as ID, `reg_nome` AS Nome, `reg_status` as Status","WHERE `reg_status`=1 OR `reg_status`=0");
                $rsRegioes = $Banco->resultado;
                
                $Banco->selecionaTabela('`lista_email` AS lst INNER JOIN `email_regiao` AS emreg ON (emreg.`lst_id` = lst.`lst_id`) INNER JOIN `regiao` AS reg ON (emreg.`reg_id` = reg.`reg_id`) INNER JOIN `nivel` AS lvl ON (lvl.`lvl_id`=lst.`lst_nivel`)','lvl.`lvl_id` AS idNivel, lvl.`lvl_nome` AS Nivel, reg.`reg_id` AS idRegiao, reg.`reg_nome` AS Regiao','WHERE lst.`lst_id`='.$_GET['email']);
                $rsEmailRegiao = $Banco->resultado;
                
                if (mysql_num_rows($rsEmailRegiao)==0) {
                    //$resultRegiao = "<li>Nenhuma Regi&atilde;o Encontrada</li>";
                } else {
                    while($row = mysql_fetch_object($rsEmailRegiao)){
                        $arrEmRe[]= $row->idRegiao;
                        //$resultRegiao .= "<li>" . $row->Regiao . "</li>";
                        //$resultNivel .= "<li>" . $row->Nivel . "</li>";
                    }
                }
                
                if(mysql_num_rows($rsRegioes)>0):
                    $count = 0;echo "<pre>";
                    while($row = mysql_fetch_object($rsRegioes)):
                        $vDisabled = "";
                        $vChecked = "";
                        $vInativo = "";

    					if (($row->Status == 0 && (isset($arrEmRe) && in_array($row->ID, $arrEmRe))) || $row->Status == 1 ):
                            if($count==0):
                                echo '<tr>';
                            endif;
                            
                            if (isset($arrEmRe) && in_array($row->ID, $arrEmRe)):
                                $vChecked = "CHECKED";
                            endif;
                            
                            if($row->Status == 0):
                                $vDisabled = "DISABLED";
                                $vInativo = ' <font style="color: #f93; text-decoration: underline; font-style: oblique ;">(Inativo)</font>';
                            endif;
                        
                            echo '<td><input type="checkbox" id="regioes[]" name="regioes[]" value="'.$row->ID.'+'.$row->Nome.'" '.$vDisabled.' '.$vChecked.'><label for="regioes[]">'.$row->Nome.$vInativo.'</label></td>';
                            $count++;
                            if($count==3):
                                echo '</tr>';
                                $count = 0;
                            endif;
                        else:    // Status = 0  OU  email nao pertence a regiao
                        
                        endif;
                        
						//echo '<input type="checkbox" id="regioes[]" name="regioes[]" value="'.$row->ID.'"><label for="regioes[]">'.$row->Nome.'</label>'."\t\t";
                    endwhile;
                    echo "</pre>";
				else:
					echo 'Nenhuma regi&atilde;o encontrada';
				endif;
			?>
            </table>
            </div>
		</p>

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
			<label for="sexo">Sexo:</label>
			<select name="sexo" id="sexo">
				<option value="1" <?php echo ($rsEmail->Sexo == 1) ? 'selected="selected"' : ''; ?>>Masculino</option>
                <option value="2" <?php echo ($rsEmail->Sexo == 2) ? 'selected="selected"' : ''; ?>>Feminino</option>
				<option value="3" <?php echo ($rsEmail->Sexo == 3) ? 'selected="selected"' : ''; ?>>N&atilde;o Informado</option>
			</select>
		</p>
  
		<p>
			<label for="status">Ativo:</label>
			<select name="status" id="status">
				<option value="1" <?php echo ($rsEmail->Status) ? 'selected="selected"' : ''; ?>>Sim</option>
				<option value="0" <?php echo (!$rsEmail->Status) ? 'selected="selected"' : ''; ?>>N&atilde;o</option>
			</select>
		</p>
		
		<p>
			<input type="submit" value="Salvar" />
			<input type="reset" style="display: none;" id="clean" />
		</p>
	
	</form>

</div><!--### DIV id="content" ###-->

<?php include_once DIR.INCLUDES.'fundo.php'; ?>