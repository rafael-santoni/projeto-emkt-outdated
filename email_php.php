<?php/*
$pessoa = 'Teane Araujo';

$to = ' "Teane" <te.araujo88@gmail.com>, emaildorafa@gmx.com';
$subject = "Convite especial para $pessoa";

$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>This email contains HTML Tags!</p>
<table border=1>
<tr>
<th>Firstname</th>
<th>Lastname</th>
</tr>
<tr>
<td>John</td>
<td>Doe</td>
</tr>
<TR>
<TD>Jose</TD>
<TD>Roela</TD>
</TR>
</table>
<BR><BR><BR>
<P>Teste de envio: 2</P>
OBS: *Modificado as bordas da tabela para melhor visualização.<BR>
*incluido um \"subject\" personalizado.<BR>
*adicionado o nome da pessoa quem envia e adicionado nome personalizado do remetente.<BR>
*testanto o Bcc que não funionou por estar como Cco.<BR>
<P>Fim da mensagem</P>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: "Rafael Santoni" <santoni@pulze.com.br>' . "\r\n";
$headers .= 'Bcc: rafael.pulze@hotmail.com' . "\r\n";

if (mail($to,$subject,$message,$headers))
	echo "email enviado com sucesso para $to";
else
	echo "não foi possivel enviar o email para $to";

*/?>

email_php.php