<?php
include_once('classes/db.class.php');
include_once('classes/Template.class.php');

	$banco = new DB('localhost', 'rafasan_adm', 'ADMonly', 'rafasan_emailmkt');
	$banco->DBError();

    if(isset($_POST["disparar_email"])) {
    	//echo "recebeu os dados do post. <BR><pre>";
        //print_r($_POST);
        //echo "</pre>";
    	$tpl_file = $_POST["tpl_file"];
        $image_URL = $_POST["image_URL"];
        $cond_where = $_POST["cond_where"];
        
    	$banco->selecionaTabela('lista_email', '`lst_email`, `lst_nome_tratamento`,`lst_primeiro_nome`,`lst_nome_meio`,`lst_sobrenome`',$cond_where);
        //echo $banco->resultado;
        //print_r($banco->resultado);
        
        $temp = $banco->resultado;
        //print_r($temp);
        $lst_email = array();
        $lst_tabela = array();
        while($row = mysql_fetch_assoc($banco->resultado)){
            $lst_email[]=$row;
            $lst_tabela[] = $row;
        }
        //print_r($lst_email);
        $cor_imobiliaria = "blue";        
        $max = count($lst_email);
    
        for($i=0; $i < $max; $i++){

			//echo "<B>*</B> ['$k']-> $v<BR>";
            $tpl = new Template('',$tpl_file);
            $tpl->setPasta('templates');
            
            $tpl->setDados('IMG_URL',$image_URL);
            $tpl->setDados('tpl_name',$tpl_file);
            
            //$tpl->setDados('tratamento',$lst_email[$i]['lst_nome_tratamento']);
            $vTratamento = ((!$lst_email[$i]['lst_nome_tratamento'] == "") ? $lst_email[$i]['lst_nome_tratamento'] : "Caro(a)");
            $tpl->setDados('tratamento',$vTratamento);
            //$tpl->setDados('nome', ((!$lst_email[$i]['lst_primeiro_nome'] == '') ? $lst_email[$i]['lst_primeiro_nome'] : 'Você'));
            $vPrimNome = ((!$lst_email[$i]['lst_primeiro_nome'] == "") ? $lst_email[$i]['lst_primeiro_nome'] : 'morador(a)');
            $tpl->setDados('nome',$vPrimNome);
            
            $tpl->setDados('sobrenome', $lst_email[$i]['lst_sobrenome']);
            $tpl->setDados('cidade','Limeria');
            $tpl->setDados('endereco','Rua Candido Souza de Oliveira, 2.325 - Vila Rosalia');
            $tpl->setDados('nome_consultor','Rafael Santoni');
            $tpl->setDados('imobiliaria_consultor','<font color="'.$cor_imobiliaria.'">'.'PULZE'.'</FONT>');
            $tpl->setDados('tel_consultor','(19) 9.9208-3160');
            $tpl->setDados('mensagem', 'Hello world!!');
            
            $msg = $tpl->loadEmail();
            //echo $msg;
            //$to = ' "'.$lst_email[$i]['lst_primeiro_nome'].'" <'.$lst_email[$i]['lst_email'].'>';
            //$to = " \"$vPrimNome\" <" . $lst_email[$i]['lst_email']  .">";
            $to = ' "' . $vPrimNome . '" <' . $lst_email[$i]['lst_email'] . '>';
            //print_r($to);
            $subject = "Convite especial para " . $vPrimNome;
            
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
            
            // More headers
            $headers .= 'From: "Rafael Santoni" <santoni@pulze.com.br>' . "\r\n";
            $headers .= 'Bcc: rafael.pulze@hotmail.com' . "\r\n";
            
            if (mail($to,$subject,$msg,$headers))
            	//echo "email enviado com sucesso para ".$vPrimNome." ".$lst_email[$i]['lst_email']."<BR>";
                $lst_tabela[$i]['status_email'] = "OK";
            else
            	//echo "<B>não</B> foi possivel enviar o email para $vPrimNome" . $lst_email[$i]['lst_email'] . "<BR>";
                $lst_tabela[$i]['status_email'] = "<font color=red>Não</font>";
    
        }   /*****  END LOOP  *****/
    	
    }   /*****  END IF  *****/

?>

<!DOCTYPE html>
<html>
<head>
    <title>E-Mkt Sender 1.0 - By Rafasantoni</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 <!--   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">   -->
    <link rel="stylesheet" href="CSS/menu.css" type="text/css" />
</head>
<body>
    <CENTER>
    <H1>E-Mkt Sender 1.0</H1>
    <?php
    include('menu.html');
    ?>
    </CENTER>
    <p>
    <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Inserir Email</strong></font>
    </p>
    
    <form name="dipara_email" method="post" action="form_dispara_email.php">
        <table width="75%" border="0" cellspacing="10" cellpadding="0">
		<tr>
            <td width="20%" ALIGN="right">
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Nome do arquivo Template:</strong></font>
            </td>
            <td width="80%">
                <input type="text" name="tpl_file" id="tpl_file" size="10" maxlength="50" VALUE="terrazzo.tpl">
            </td>
        </tr>
		<tr>
            <td width="20%" ALIGN="right">
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>URL das Imagens:</strong></font>
            </td>
            <td width="80%">
                <input type="text" name="image_URL" id="image_URL" size="30" maxlength="100" value="http://emkt.rafasantoni.heliohost.org/templates/images">
            </td>
        </tr>
        <tr>
            <td width="20%" ALIGN="right">
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>WHERE:</strong></font>
            </td>
            <td width="80%">
                <input type="text" name="cond_where" id="cond_where" size="50" maxlength="100" value="WHERE `lst_status`=1 AND `lst_nivel`=127 LIMIT 3">
            </td>
        </tr>
        <tr>
            <td width="20%" ALIGN="right">
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Mensagem:</strong></font>
            </td>
            <td width="80%">
                <textarea name="email_msg" id="email_msg" cols="50" rows="4"></textarea>
            </td>
        </tr>
<!--		<tr>
            <td width="20%" ALIGN="right">
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Sexo:</strong></font>
            </td>
            <td width="80%">
                <input type="text" name="email_sexo" id="email_sexo" size="1" maxlength="1" VALUE="2">
				1 - Masculino  |  2 - Feminino  |  3 - N&atilde;o Informado
            </td>
        </tr>
        <tr>
            <td width="20%" ALIGN="right">
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Nível:</strong></font>
            </td>
            <td width="80%">
                <input type="text" name="email_nivel" id="email_nivel" size="1" maxlength="3" VALUE="97">
				<B>1</b> - Teste | <B>2</B> - Normal | <B>27</B> - MASTER | <B>97</B> - N&atilde;o Verif. | <B>98</B> - Outro Corretor | <B>99</B> - DESCONHECIDO | <B>127</B> - ERRO
            </td>
        </tr>
		<tr>
            <td width="20%" ALIGN="right">
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Status:</strong></font>
            </td>
            <td width="80%">
                <input type="text" name="email_status" id="email_status" size="1" maxlength="1" VALUE="1">
            </td>
        </tr>
        <tr>
            <td width="20%">
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Status:</strong></font>
            </td>
            <td width="80%">
                <textarea name="email_status" id="email_status" cols="50" rows="4"></textarea>
            </td>
        </tr>  -->
        </table>
        <p>
        <input type="submit" name="disparar_email" value="Disparar">
        </p>
    </form>

<?php
    //$banco->selecionaTabela('lista_email','*','');
    //echo "banco->resultado".$banco->resultado;
    
    //$temp=$banco->resultado;
    //while($row = mysql_fetch_assoc($temp)){
    //    $lst[]=$row;
    //}
//    echo "<pre>";
    //echo $banco->resultado;
//    print_r($lst[0]);
    //print_r($lst_tabela);
//    echo "</pre>";

	echo "
	<table border=0>
	<TR><TH></TH><TH>email</TH><TH>Trat.</TH><TH>Nome</TH><TH>__</TH><TH>sobrenome</TH><TH>sexo</TH><TH>Nivel</TH><TH>Status</TH><TH> - ENVIO - </TR>";
    
    $max = count($lst_tabela);
//    echo "count(lst) $max";
	
    for($i=0; $i < $max; $i++){
		echo "<tr><TD>**</TD>";
        foreach($lst_tabela[$i] as $k=>$v){

            //echo ($k == 'lst_nome_meio') ? "<TD>----</TD>" : ($k == 'status_email') ? "<TD></TD><TD></TD><TD></TD><TD>$v</TD>" : "<TD>$v</TD>";
            //echo "<TD>$v</TD>";
			//echo "<B>*</B> ['$k']-> $v<BR>";
            echo ($k != 'lst_nome_meio') ? (($k == 'status_email') ? "<TD></TD><TD></TD><TD></TD><TD>$v</TD>" : "<TD>$v</TD>") : "<TD>----</TD>";
            
        }
		echo "</tr>";
    }
	echo "</table>";
?>
	
</body>
</html>