<?php
include_once('classes/db.class.php');
include_once('classes/Template.class.php');
include_once('classes/Email.class.php');
    
    $banco = new DB('localhost', 'rafasan_adm', 'ADMonly', 'rafasan_emailmkt');
	$banco->DBError();
 
    $banco->selecionaTabela('lista_email', '`lst_email`, `lst_nome_tratamento`,`lst_primeiro_nome`,`lst_sobrenome`',"WHERE `lst_status`=1 AND `lst_nivel`=1");
    //echo $banco->resultado;    

    $lst_email = array();
    while($row = mysql_fetch_assoc($banco->resultado)){
        $lst_email[]=$row;
    }

    $max = count($lst_email);
    $cor_imobiliaria = "blue";

    for($i=0; $i < $max; $i++){

        //foreach($lst_email[$i] as $k=>$v){
			//echo "<B>*</B> ['$k']-> $v<BR>";
            $tpl = new Template('','teste.fah');
            $tpl->setPasta('templates');

            $tpl->setDados('tratamento',$lst_email[$i]['lst_nome_tratamento']);
            $tpl->setDados('nome', $lst_email[$i]['lst_primeiro_nome']);
            $tpl->setDados('sobrenome', $lst_email[$i]['lst_sobrenome']);
            $tpl->setDados('cidade','Limeria');
            $tpl->setDados('endereco','Rua Candido Souza de Oliveira, 2.325 - Vila Rosalia');
            $tpl->setDados('nome_consultor','Rafael Santoni');
            $tpl->setDados('imobiliaria_consultor','<font color="'.$cor_imobiliaria.'">'.'PULZE'.'</FONT>');
            $tpl->setDados('tel_consultor','(19) 9.9208-3160');
            $tpl->setDados('mensagem', 'Hello world!!');
            
            $msg = $tpl->loadEmail();
            //echo $msg;
            $to = ' "'.$lst_email[$i]['lst_primeiro_nome'].'" <'.$lst_email[$i]['lst_email'].'>';
            $subject = "Convite especial para ".$lst_email[$i]['lst_primeiro_nome'];
            
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            
            // More headers
            $headers .= 'From: "Rafael Santoni" <santoni@pulze.com.br>' . "\r\n";
            $headers .= 'Bcc: rafael.pulze@hotmail.com' . "\r\n";
            
            if (mail($to,$subject,$msg,$headers))
            	echo "email enviado com sucesso para ".$to." <BR>";
            else
            	echo "<B>não<B> foi possivel enviar o email para ".$to."<BR>";
        //}

    }

?>