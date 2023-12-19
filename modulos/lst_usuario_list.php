<?php
include_once '/home/rafasan/public_html/EMkt/includes/config.php';

include_once DIR.INCLUDES.'topo.php';
include_once DIR.INCLUDES.'menu.html';

include_once DIR.CLASSES.'db.class.php';
    $Banco = new DB(HOST,USER,PASS,DB_NAME);
    $Banco->DBError();

include_once DIR.INCLUDES.'func_jQuery.php';
    ajaxjQuery('index.php', 'action', 'history.go();');
    checkBoxAll("users2delete[]");
//    ajaxPopulaLinha();

$pagAtual=1;
$totalUsuarios = $Banco->totalRegistrosTabela("`usuario`","*");
$totalPaginas = (($totalUsuarios % 30) == 0) ? $totalUsuarios / 30 : intval($totalUsuarios/30)+1 ;
if (isset($_GET['pag']) || !empty($_GET["pag"])){
	if ($_GET['pag']>$totalPaginas || !is_numeric($_GET['pag'])){
        echo '<h2>Erro ao processar</h2>N&atilde;o foi possivel completar a opera&ccedil;&atilde;o. <BR />P&aacute;gina n&atilde;o definida!'; exit();
	}
    $pagAtual = $_GET['pag'];
}
$limiteInicio = ""; //$limiteFim = ""; 
$limiteTotal = 30; 
$limiteInicio = ($pagAtual*$limiteTotal)-$limiteTotal;
//$limiteFim = $pagAtual*$limiteTotal;
?>

<div id="content">
	<h1>Listagem de Usu&aacute;rios do Sistema 
    <a href="<?php echo URL.MODULES?>lst_usuario_add.php">Novo</a></h1>
	
	<pre><?php echo "\t Pagina $pagAtual / $totalPaginas \t\t" . montaListaPagina($totalPaginas,$pagAtual,"lst_usuario_list.php") . "\r\n\r\n"; ?></pre>
    <div id="return"></div>
	<div id="load"><a href="javascript:void(0);" style="outline: none;" id="topFocus"><img src="<?php echo URL.IMG ?>loading.gif" alt ="" /></a><br />Aguarde, processando...</div>
	
	<form id="form">
	   <input type="hidden" name="action" id="action" value="deleteUsuario" />
	   <table cellspacing ="0">
	   
       <tr class="header">
			<td>Login ID</td>
			<td>Nome</td>
            <td>Email</td>
			<td>Sexo</td>
            <td>N&iacute;vel</td>
			<td>Status (ativo)</td>
			<td></td>
			<td><input type="checkbox" name="selectAll" onClick="CheckAll(this)" /></td>
	   </tr>
		
		<?php
			//$Banco->selecionaTabela("lista_email","`lst_id` AS ID, `lst_email` as Email, `lst_nome_tratamento` as Tratamento, `lst_primeiro_nome` AS primeiroNome, `lst_nome_meio` AS nomeMeio, `lst_sobrenome`AS Sobrenome, `lst_sexo` AS Sexo, `lst_nivel` AS Nivel, `lst_status` AS Status","");
            $Banco->selecionaTabela("`usuario` AS usr INNER JOIN  `nivel` AS lvl ON ( lvl.lvl_id = usr.usr_nivel )","usr.`usr_id` AS ID, usr.`usr_login_id` as loginID, usr.`usr_pass` as Password, usr.`usr_nome` AS Nome, usr.`usr_sobrenome` AS Sobrenome, usr.`usr_apelido`AS Apelido, usr.`usr_email` AS Email, usr.`usr_telefone` AS Telefone, usr.`usr_sexo` AS Sexo, usr.`usr_data_cadastro` AS dataCadastro, usr.`usr_nivel` AS idNivel, lvl.`lvl_nome` AS nomeNivel, usr.`usr_status` AS Status","WHERE 27=27 LIMIT $limiteInicio,$limiteTotal");
            $rsUsuarios = $Banco->resultado; 
            //$lstEmail = array();
            //$lstEmail = mysql_fetch_object($Banco->resultado);
            /*$rsModules = mysql_query("SELECT 
										mI.mdi_id AS 'mItemId',
										mI.mod_id AS 'mItemModId',
										mI.mdi_name AS 'mItemName',
										mI.mdi_url AS 'mItemURL',
										mI.mdi_status AS 'mItemStatus',
										m.mod_id AS 'moduleId',
										m.mod_name AS 'moduleName' 
									FROM `modules_item` mI, `modules` m
									WHERE mI.mod_id = m.mod_id") or die (mysql_error());      */
			//echo 'lista: '; print_r($rsUsuarios);
            if(mysql_num_rows($rsUsuarios)>0):
				$i=1;
				while($row = mysql_fetch_object($rsUsuarios)):
					//$cor = ($i % 2 == 0) ? 'class="listra"' : '';
					$cor = ($i % 2 == 0) ? 'class="listra"' : '';
	// 				echo '<PRE>';
	// 				print_r($row);
	// 				echo '</PRE>';  ?>
					<tr <?php echo $cor  /*onclick="javascript:;" id="linhaPrincipal"*/ ?> id="linhaPrincipal" idEmail="<?php echo $row->ID ?>" style="cursor: hand; cursor: pointer;">
                        <input type="hidden" id="flagLinha-<?php echo $row->ID ?>" value="fechado" />
						<td><?php echo $row->loginID ?></td>
						<td><?php echo $row->Nome.' '.$row->Sobrenome.' ('.$row->Apelido.') ' ?></td>
                        <td><?php echo $row->Email ?></td>
						<td><?php echo (($row->Sexo == 1) ? '<span class="masculino">Masculino</span>' : (($row->Sexo == 2) ? '<span class="feminino">Feminino</span>' : '-----'))?></td>
                        <td><?php echo $row->nomeNivel ?></td>
						<td><?php echo ($row->Status == 1) ? '<span class="sim">Sim</span>' : '<span class="nao">N&atilde;o</span>' ?></td>
						<td><a href="<?php echo URL.MODULES?>lst_usuario_update.php?usr=<?php echo $row->ID; ?>&lvl=<?php echo $row->idNivel; ?>"><img src="<?php echo URL.IMG?>bt_edit.png" alt="Editar registro" title="Titulo Editar" /></a></td>
						<td onclick="javascript: void(0);"><input type="checkbox" name="usuarios2delete[]" value="<?php echo $row->ID; ?>"> <img src="<?php echo URL.IMG?>bt_delete.png" alt="Excluir registro" title="Titulo Excluir" /></a></td>
					</tr>
                    <tr id="subLinha-<?php echo $row->ID ?>" onclick="javascript:$('#subLinha-<?php echo $row->ID ?>').empty();" ALIGN="center" class="subLinha"></tr>
			<?php 
				    $i++;
				endwhile;
                //$firstPage = "<<"; $previousPage = "<"; $pageNum = ""; $nextPage = ">"; $lastPage = ">>";
                //echo "<tr><td></td><td>$firstPage</td><td>$pageB4</td><td>$pageNum</td><td>$nextPage</td><td>$lastPage</td><td></td></tr>";
                //echo "Pagina $pagAtual / $totalPaginas";
 
                //$pageNum = montaListaPagina($totalPaginas,$pagAtual,"lst_email_list.php");
                $pageNum = "<td ALIGN=\"CENTER\" style=\"border: none;\" >".montaListaPagina($totalPaginas,$pagAtual,"lst_email_list.php")."</td>";
                $pagAnterior=($pagAtual==1)?"<td style=\"border: none;\"></td>":"<td ALIGN=\"LEFT\" style=\"border: none;\"> < <a href=\"?pag=".($pagAtual-1)."\">Ant.</a></td>";
                $proxPagina=($pagAtual==$totalPaginas)?"<td style=\"border: none;\"></td>":"<td ALIGN=\"RIGHT\" style=\"border: none;\"><a href=\"?pag=".($pagAtual+1)."\">Prox.</a> ></td>";
                //echo '<tr>'.$pagAnterior.'<td colspan="3" ALIGN="center">'."$firstPage  $pageB4 | $pageNum | $nextPage  $lastPage </td><td></td><td></td>$proxPagina</tr>";
                echo '<tr><table style="width: 100%; border: none;"><tr class="listaPaginas">'.$pagAnterior.$pageNum.$proxPagina.'</tr></table></tr>';
			else:
				echo '<tr><td colspan="8">Nenhum registro encontrado!</td></tr>';
			
			endif;
		?>
	</table>

	<?php if(mysql_num_rows($rsUsuarios)>0){ echo '<input type="submit" value="Excuir" class="btnDel" />';} ?>
	</form>

</div><!--### DIV id="content" ###-->

<?php include_once DIR.INCLUDES.'fundo.php'; ?>