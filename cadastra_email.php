<?php
include_once('classes/db.class.php');

	$banco = new DB('localhost', 'rafasan_adm', 'ADMonly', 'rafasan_emailmkt');
	$banco->DBError();

    if(isset($_POST["email_enviar"])) {
    	//echo "recebeu os dados do post. <BR>";
    	$email_nome_tratamento = $_POST["email_nome_tratamento"];
    	$email_primeiro_nome = $_POST["email_primeiro_nome"];
    	$email_nome_meio = $_POST["email_nome_meio"];
    	$email_sobrenome = $_POST["email_sobrenome"];
    	$email_end = $_POST["email_end"];
    	$email_sexo = $_POST["email_sexo"];
    	$email_nivel = $_POST["email_nivel"];
    	$email_status = $_POST["email_status"];
    /*	echo "\$email_end = \$_POST[\"email_end\"]; $email_end<BR>
    	\$email_nivel = \$_POST[\"email_nivel\"]; $email_nivel<BR>
    	\$email_status = \$_POST[\"email_status\"]; $email_status<BR>";  */
    
    	// inicia o banco de dados

    	
    	$campos = "('','$email_end','$email_nome_tratamento','$email_primeiro_nome','$email_nome_meio','$email_sobrenome','$email_sexo','$email_nivel','$email_status')";
    	//echo "$campos<BR>";
    
    	//$campos = "('','$titulo','$link','$descricao', '$data_publ')";
    	//echo strlen($descricao);
    	
    	$banco->inserirTabela('lista_email', $campos);
    
    	if ($banco->resultado == 1){
    		//echo "Inclusão OK <br><br><a href=\"form_noticia.html\">Voltar</a> | <a href=\"gera_feed.php\">Gerar Feed de Notícias</a>";
    		echo "Endereço <b>$email_end</b> incluido <br><br>";
    	}
    	else {
    		echo "Erro na inclusao do endereço <b>$email_end</b> <p><pre>" . $banco->DBError() . "</pre>";
    	}
    	
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulário</title>
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
    
    <form name="email_inclusao" method="post" action="cadastra_email.php">
        <table width="75%" border="0" cellspacing="10" cellpadding="0">
		<tr>
            <td width="20%" ALIGN="right">
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Tratamento:</strong></font>
            </td>
            <td width="80%">
                <input type="text" name="email_nome_tratamento" id="email_nome_tratamento" size="1" maxlength="50" VALUE="Sra.">
            </td>
        </tr>
		<tr>
            <td width="20%" ALIGN="right">
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Nome:</strong></font>
            </td>
            <td width="80%">
                <input type="text" name="email_primeiro_nome" id="email_primeiro_nome" size="10" maxlength="20">
				<input type="text" name="email_nome_meio" id="email_nome_meio" size="30" maxlength="100">
				<input type="text" name="email_sobrenome" id="email_sobrenome" size="15" maxlength="30">
            </td>
        </tr>
        <tr>
            <td width="20%" ALIGN="right">
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Endereço:</strong></font>
            </td>
            <td width="80%">
                <input type="text" name="email_end" id="email_end" size="50" maxlength="100">
            </td>
        </tr>
		<tr>
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
<!--        <tr>
            <td width="20%">
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Status:</strong></font>
            </td>
            <td width="80%">
                <textarea name="email_status" id="email_status" cols="50" rows="4"></textarea>
            </td>
        </tr>  -->
        </table>
        <p>
        <input type="submit" name="email_enviar" value="Enviar">
        </p>
    </form>

<?php
    $banco->selecionaTabela('lista_email','*','');
    //echo "banco->resultado".$banco->resultado;
    $lst = array();
    $temp=$banco->resultado;
    while($row = mysql_fetch_assoc($temp)){
        $lst[]=$row;
    }
//    echo "<pre>";
    //echo $banco->resultado;
//    print_r($lst[0]);
//    print_r($lst);
//    echo "</pre>";

	echo "
	<table border=0>
	<TR><TH></TH><TH>email</TH><TH>Trat.</TH><TH>Nome</TH><TH>__</TH><TH>sobrenome</TH><TH>sexo</TH><TH>Nivel</TH><TH>Status</TH></TR>";
    
    $max = count($lst);
//    echo "count(lst) $max";
	
    for($i=0; $i < $max; $i++){
		echo "<tr>";
        foreach($lst[$i] as $k=>$v){
            echo "<TD>$v</TD>";
			//echo "<B>*</B> ['$k']-> $v<BR>";
        }
		echo "</tr>";
    }
	echo "</table>";
?>
	
</body>
</html>