<?php
    require('classes/Template.class.php');
    
    $cor_imobiliaria = "blue";
    
    $fah = new Template('', 'terrazzo.tpl');
    $fah->setPasta('templates');

    $fah->setDados('IMG_URL','http://emkt.rafasantoni.heliohost.org/templates/images');
    $fah->setDados('tpl_name','terrazzo.tpl');
    //$fah->setDados('tratamento','Sr.');
    //$fah->setDados('nome', 'Fulano');
    //$fah->setDados('sobrenome', 'de Thal');
    //$fah->setDados('cidade','Limeria');
    //$fah->setDados('endereco','Rua Candido Souza de Oliveira, 2.325 - Vila Rosalia');
    //$fah->setDados('nome_consultor','Rafael Santoni');
    //$fah->setDados('imobiliaria_consultor','<font color="'.$cor_imobiliaria.'">'.'PULZE'.'</FONT>');
    //$fah->setDados('tel_consultor','(19) 9.9208-3160');
    //$fah->setDados('mensagem', 'Hello world!!');
    
    $fah->mostrarPagina();
?>