<?php
include_once '/home/rafasan/public_html/EMkt/includes/config.php';

include_once DIR.INCLUDES.'topo.php';
include_once DIR.INCLUDES.'menu.html';

include_once DIR.CLASSES.'db.class.php';
    $Banco = new DB(HOST,USER,PASS,DB_NAME);
    $Banco->DBError();

include_once DIR.INCLUDES.'func_jQuery.php';
    ajaxjQuery('index.php', 'action', 'history.go();');
    checkBoxAll("templates2delete[]");

$pagAtual=1;
$totalTemplates = $Banco->totalRegistrosTabela("`template`","*");
$totalPaginas = (($totalTemplates % 30) == 0) ? $totalTemplates / 30 : intval($totalTemplates/30)+1 ;
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
	<h1>Templates para Email Marketing 
    <a href="<?php echo URL.MODULES?>emk_template_add.php">Novo</a></h1>
	
	<div id="return"></div>
	<div id="load"><img src="<?php echo URL.IMG ?>loading.gif" alt ="" /><br />Aguarde, processando...</div>
	
	<form id="form">
	   <input type="hidden" name="action" id="action" value="deleteTemplate" />
	   <table cellspacing ="0">
	   <pre><?php echo "\t Pagina $pagAtual / $totalPaginas \t\t" . montaListaPagina($totalPaginas,$pagAtual,"emk_template_list.php") . "\r\n\r\n"; ?></pre>
       <tr class="header">
			<td>Nome</td>
			<td>Arquivo</td>
			<td>URL das Imagens</td>
			<td>Status (ativo)</td>
			<td></td>
			<td><input type=checkbox name="selectAll" onClick="CheckAll(this)"></td>
	   </tr>
		
		<?php
			$Banco->selecionaTabela("`template` AS tpl","tpl.`tpl_id` AS ID, tpl.`tpl_nome`AS Nome, tpl.`tpl_arquivo` AS nomeArquivo, tpl.`tpl_img_url` AS urlImagem, tpl.`tpl_msg_padrao` AS mensagemPadrao, tpl.`tpl_status` AS Status","WHERE 27=27 LIMIT $limiteInicio,$limiteTotal");
            $rsListaTemplate = $Banco->resultado; 
            
            if(mysql_num_rows($rsListaTemplate)>0):
				$i=1;
				while($row = mysql_fetch_object($rsListaTemplate)):
					//$cor = ($i % 2 == 0) ? 'class="listra"' : '';
					$cor = ($i % 2 == 0) ? 'class="listra"' : '';
	   ?>
					<tr <?php echo $cor ?>>
						<td><?php echo $row->Nome ?></td>
						<td><?php echo $row->nomeArquivo ?></td>
						<td><?php echo $row->urlImagem ?></td>
						<td><?php echo ($row->Status == 1) ? '<span class="sim">Sim</span>' : '<span class="nao">N&atilde;o</span>' ?></td>
						<td><a href="<?php echo URL.MODULES?>emk_template_update.php?tpl=<?php echo $row->ID; ?>"><img src="<?php echo URL.IMG?>bt_edit.png" alt="Editar registro" title="Titulo Editar" /></a></td>
						<td><input type="checkbox" name="templates2delete[]" value="<?php echo $row->ID; ?>"> <img src="<?php echo URL.IMG?>bt_delete.png" alt="Excluir registro" title="Titulo Excluir" /></a></td>
					</tr>
			<?php 
				$i++;
				endwhile;
                //$firstPage = "<<"; $pageB4 = "<"; $pageNum = ""; $nextPage = ">"; $lastPage = ">>";
                //echo "<tr><td></td><td>$firstPage</td><td>$pageB4</td><td>$pageNum</td><td>$nextPage</td><td>$lastPage</td><td></td></tr>";
                //echo "Pagina $pagAtual / $totalPaginas";
 
                //$pageNum = montaListaPagina($totalPaginas,$pagAtual,"lst_email_list.php");
                $pageNum = "<td ALIGN=\"CENTER\" style=\"border: none;\" >".montaListaPagina($totalPaginas,$pagAtual,"lst_template_list.php")."</td>";
                $pagAnterior=($pagAtual==1)?"<td style=\"border: none;\"></td>":"<td ALIGN=\"LEFT\" style=\"border: none;\"> < <a href=\"?pag=".($pagAtual-1)."\">Ant.</a></td>";
                $proxPagina=($pagAtual==$totalPaginas)?"<td style=\"border: none;\"></td>":"<td ALIGN=\"RIGHT\" style=\"border: none;\"><a href=\"?pag=".($pagAtual+1)."\">Prox.</a> ></td>";
                //echo '<tr>'.$pagAnterior.'<td colspan="3" ALIGN="center">'."$firstPage  $pageB4 | $pageNum | $nextPage  $lastPage </td><td></td><td></td>$proxPagina</tr>";
                echo '<tr><table style="width: 100%; border: none;"><tr class="listaPaginas">'.$pagAnterior.$pageNum.$proxPagina.'</tr></table></tr>';
			else:
				echo '<tr><td colspan="5">Nenhum registro encontrado!</td></tr>';
			
			endif;
		?>
	</table>

	<?php if(mysql_num_rows($rsListaTemplate)>0){ echo '<input type="submit" value="Excuir" class="btnDel" />';} ?>
	</form>

</div><!--### DIV id="content" ###-->

<?php include_once DIR.INCLUDES.'fundo.php'; ?>