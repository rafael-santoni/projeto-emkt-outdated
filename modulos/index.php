<?php
include_once '/home/rafasan/public_html/EMkt/includes/config.php';

$action = '';
//print_r($_POST); exit();
//print_r($_GET); exit();
if (isset($_POST['action']) && !empty($_POST['action'])) {
	$action = $_POST['action'];
}

if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = $_GET['action'];
}

/*VERIFICANTO A ACTION*/

if(empty($action)){  // Verifica se usuário forçou entrada ou veio de links externos
	echo '<script>history.back();</script>';
}

$err = array();
include_once DIR.CLASSES.'db.class.php';
$Banco = new DB(HOST,USER,PASS,DB_NAME);
$Banco->DBError();


                                            //######################
                                            //###  Popula Linha  ###
                                            //######################

if($action == "populaLinha"){
    $idEmail = $_POST['idEmail'];

    $Banco->selecionaTabela('`lista_email` AS lst INNER JOIN `email_regiao` AS emreg ON (emreg.`lst_id` = lst.`lst_id`) INNER JOIN `regiao` AS reg ON (emreg.`reg_id` = reg.`reg_id`) INNER JOIN `nivel` AS lvl ON (lvl.`lvl_id`=lst.`lst_nivel`)','lvl.`lvl_id` AS idNivel, lvl.`lvl_nome` AS Nivel, reg.`reg_id` AS idRegiao, reg.`reg_nome` AS Regiao','WHERE lst.`lst_id`='.$idEmail);
    $rsEmailRegiao = $Banco->resultado;
    if (mysql_num_rows($rsEmailRegiao)==0) {
        $resultRegiao = "<li>Nenhuma Regi&atilde;o Encontrada</li>";
    } else {
        while($row = mysql_fetch_object($rsEmailRegiao)){
            $resultRegiao .= "<li>" . $row->Regiao . "</li>";
            //$resultNivel .= "<li>" . $row->Nivel . "</li>";
        }
    }
    
    $Banco->selecionaTabela('`lista_email` AS lst INNER JOIN `nivel` AS lvl ON (lvl.`lvl_id`=lst.`lst_nivel`)','lvl.`lvl_id` AS idNivel, lvl.`lvl_nome` AS Nivel','WHERE lst.`lst_id`='.$idEmail);
    $rsEmailNivel = $Banco->resultado;
    if (mysql_num_rows($rsEmailNivel)==0) {
        $rsEmailNivel = "<li>Nenhuma N&iacute;vel Encontrado</li>";
    } else {
        while($row = mysql_fetch_object($rsEmailNivel)){
            //$resultRegiao .= "<li>" . $row->Regiao . "</li>";
            $resultNivel .= "<li>" . $row->Nivel . "</li>";
        }
    }
    
    echo '<td COLSPAN=15 ALIGN="center">';
    echo "<ul><b>Regi&otilde;es</b>$resultRegiao</ul><ul><b>N&iacute;veis:</b>$resultNivel</ul>";
    echo '</td>';
}

                                            //################
                                            //###  REGIAO  ###
                                            //################

//----------------       S A V E       ----------------
if($action == "saveRegiao"){
	/*echo '<pre>';
	print_r($_POST);
	echo '</pre>';*/
	
	if (empty($_POST['regiao'])){
		$err[] = 'Informe o Nome da Regi&atilde;o.';
	}
    
    if ($_POST['nivel'] == 0){
		$err[] = 'Informe o N&iacute;vel da Regi&atilde;o.';
	}
	
	if(count($err)>0){
		echo 'errors+<h1>Erro:</h1>';
		foreach ($err as $e){
			echo $e.'<br />';
		}
		return;
	}
	else{
		/*$save = mysql_query("INSERT INTO `modules` 
							(mod_name, mod_nickname, mod_url, mod_status) 
							VALUES('".$_POST['name']."','".
									  $_POST['nickname']."','".
									  $_POST['url']."','".
									  $_POST['status']."')") or die(mysql_error()); */
		
		/*$save = mysql_query("INSERT INTO `modules`
							(mod_name, mod_url, mod_status)
							VALUES('$_POST[name]','$_POST[url]','$_POST[status]')") or die('errors+'.mysql_error()); */
		$Banco->inserirTabela("`regiao` (reg_id, reg_nome, reg_nivel, reg_status)","('','".$_POST['regiao']."','".$_POST['nivel']."','".$_POST['status']."')");
		$save = $Banco->resultado;
		//echo "valor save: $save"; exit();
		if($save){
			echo 'sucess+Dados salvos com sucesso!  (Aguarde...)';
		}
		else{
			echo 'errors+Houve um erro ao salvar!';
		}
	}
}

//----------------       U P D A T E       ----------------
if($action == "updateRegiao"){
	/*echo '<pre>';
	print_r($_POST);
	echo '</pre>';*/

	if (empty($_POST['nome'])){
		$err[] = 'Informe o Nome da Regi&atilde;o.';
	}

	// 	if (empty($_POST['nickname'])){
	// 		$err[] = 'Informe o apelido.';
	// 	}

    //  if (empty($_POST['url'])){
    //		$err[] = 'Informe a URL.';
    //	}

	if(count($err)>0){
		echo 'errors+<h1>Erro:</h1>';
		foreach ($err as $e){
			echo $e.'<br />';
		}
		return;
	}
	else{

//#		$up = mysql_query("UPDATE `modules` SET mod_name='$_POST[name]',".
//#												mod_nickname='$_POST[nickname]',
//#												"mod_url='$_POST[url]',
//#												mod_status=$_POST[status] WHERE mod_id=$_POST[module_id] LIMIT 1") or die('errors+'.mysql_error());
        $Banco->atualizaTabela("`regiao`","`reg_nome`='$_POST[nome]', `reg_nivel`=$_POST[nivel], `reg_status`=$_POST[status]","WHERE `reg_id`=$_POST[reg_id] LIMIT 1");
		$upOk = $Banco->resultado;
        //echo "resultado de upOk : $upOk"; exit();
        if($upOk){
			echo 'sucess+Dados salvos com sucesso!  (Aguarde...)';
		}
		else{
			echo 'errors+Houve um erro ao atualizar!';
		}
	}
}

//----------------       D E L E T E       ----------------
if($action == "deleteRegiao"){
	
	if(!empty($_POST['regioes2delete'])){
		foreach($_POST['regioes2delete'] as $reg){
			//mysql_query('DELETE FROM `regiao` WHERE mod_id='.$reg) or die('errors+'.mysql_error());
            $Banco->deletaTabela("`regiao`","WHERE `reg_id`=".$reg);
		}
		echo 'sucess+Dados exclu&iacute;dos com sucesso!  (Aguarde...)';
	}
}


                                            //###############
                                            //###  NIVEL  ###
                                            //###############

//----------------       S A V E       ----------------
if($action == "saveNivel"){
	/*echo '<pre>';
	print_r($_POST);
	echo '</pre>';*/
	
	if (empty($_POST['nivel'])){
		$err[] = 'Informe o Nome do N&iacute;vel.';
	}
    if (empty($_POST['id'])){
        $err[] = 'Informe o C&oacute;digo do N&iacute;vel.';
    } else {
        $Banco->selecionaTabela("`nivel`","`lvl_id`","WHERE `lvl_id`=".$_POST['id']." LIMIT 1");
        //echo "valor de post[id] : ".$_POST['id']." ,  banco-> resultado : ".mysql_num_rows($Banco->resultado);
        $jaExiste = mysql_num_rows($Banco->resultado);
        if ($jaExiste){
            $err[] = 'C&oacute;digo j&aacute; existe! Tente novamente.';
        }
    }
	
	if(count($err)>0){
		echo 'errors+<h1>Erro:</h1>';
		foreach ($err as $e){
			echo $e.'<br />';
		}
		return;
	}
	else{
		/*$save = mysql_query("INSERT INTO `modules` 
							(mod_name, mod_nickname, mod_url, mod_status) 
							VALUES('".$_POST['name']."','".
									  $_POST['nickname']."','".
									  $_POST['url']."','".
									  $_POST['status']."')") or die(mysql_error()); */
		
		/*$save = mysql_query("INSERT INTO `modules`
							(mod_name, mod_url, mod_status)
							VALUES('$_POST[name]','$_POST[url]','$_POST[status]')") or die('errors+'.mysql_error()); */
		$Banco->inserirTabela("`nivel` (lvl_id, lvl_nome, lvl_status)","('".$_POST['id']."','".$_POST['nivel']."','".$_POST['status']."')");
		$saveOk = $Banco->resultado;
		//echo "valor save: $save"; exit();
		if($saveOk){
			echo 'sucess+Dados salvos com sucesso!  (Aguarde...)';
		}
		else{
			echo 'errors+Houve um erro ao salvar!';
		}
	}
}

//----------------       U P D A T E       ----------------
if($action == "updateNivel"){
	/*echo '<pre>';
	print_r($_POST);
	echo '</pre>';*/

	if (empty($_POST['nome'])){
		$err[] = 'Informe o Nome do N&iacute;vel.';
	}
 
    if (empty($_POST['codigo'])){
        $err[] = 'Informe o C&oacute;digo do N&iacute;vel.';
    } else {
        if ($_POST['codigo'] != $_POST['lvl_last_id']){
            $Banco->selecionaTabela("`nivel`","`lvl_id`","WHERE `lvl_id`=".$_POST['codigo']." LIMIT 1");
            //echo "valor de post[id] : ".$_POST['id']." ,  banco-> resultado : ".mysql_num_rows($Banco->resultado);
            $jaExiste = mysql_num_rows($Banco->resultado);
            if ($jaExiste){
                $err[] = 'C&oacute;digo j&aacute; existe! Tente novamente.';
            }
        }
    }

    //  if (empty($_POST['url'])){
    //		$err[] = 'Informe a URL.';
    //	}

	if(count($err)>0){
		echo 'errors+<h1>Erro:</h1>';
		foreach ($err as $e){
			echo $e.'<br />';
		}
		return;
	}
	else{

//#		$up = mysql_query("UPDATE `modules` SET mod_name='$_POST[name]',".
//#												mod_nickname='$_POST[nickname]',
//#												"mod_url='$_POST[url]',
//#												mod_status=$_POST[status] WHERE mod_id=$_POST[module_id] LIMIT 1") or die('errors+'.mysql_error());
        $Banco->atualizaTabela("`nivel`","`lvl_id`=$_POST[codigo], `lvl_nome`='$_POST[nome]', `lvl_status`=$_POST[status]","WHERE `lvl_id`=$_POST[lvl_last_id] LIMIT 1");
		$upOk = $Banco->resultado;
        //echo "resultado de upOk : $upOk"; exit();
        if($upOk){
			echo 'sucess+Dados salvos com sucesso!  (Aguarde...)';
		}
		else{
			echo 'errors+Houve um erro ao atualizar!';
		}
	}
}

//----------------       D E L E T E       ----------------
if($action == "deleteNivel"){
	
	if(!empty($_POST['niveis2delete'])){
		foreach($_POST['niveis2delete'] as $lvl){
			//mysql_query('DELETE FROM `regiao` WHERE mod_id='.$reg) or die('errors+'.mysql_error());
            $Banco->deletaTabela("`nivel`","WHERE `lvl_id`=".$lvl);
		}
		echo 'sucess+Dados exclu&iacute;dos com sucesso!  (Aguarde...)';
	}
}


                                            //######################
                                            //###   LISTA EMAIL  ###
                                            //######################

//----------------       S A V E       ----------------
if($action == "saveEmail"){
	/*echo 'sucess+ <pre>';
	//print_r($_POST);
    echo "total de regioes: ".count($_POST['regioes']);
    //print_r($_POST['regioes']);
    foreach($_POST['regioes'] as $row){
        list($id, $nome) = explode("+", $row);
        echo "id: $id - Nome: $nome";
    }
    echo '</pre>';
    return;*/


	if (empty($_POST['tratamento'])){
		$err[] = 'Informe a Forma de Tratamento. (Ex. Sr., Sra., Dr., Ilmo, Caro...)';
	}
    
    if (empty($_POST['primeiroNome'])){
		$err[] = 'Informe o Primeiro Nome da Pessoa.';
	}
    
//    if (empty($_POST['nomeMeio'])){
//		$err[] = 'Informe o Nome do meio da Pessoa.';
//	}
    
    if (empty($_POST['sobrenome'])){
		$err[] = 'Informe o Sobrenome da Pessoa.';
	}
    
    if (empty($_POST['email'])){
		$err[] = 'Informe o Endere&ccedil;o de Email da Pessoa.';
	}
    
    if ($_POST['nivel'] == 0){
		$err[] = 'Informe o N&iacute;vel do Email.';
	}
    
    if (count($_POST['regioes']) == 0){
		$err[] = 'Informe pelo menos uma Regi&atilde;o para disparo de E-Marketing.';
	}
	
	if(count($err)>0){
		echo 'errors+<h1>Erro:</h1>';
		foreach ($err as $e){
			echo $e.'<br />';
		}
		return;
	}
	else{
		
        $rsTableStatus = mysql_fetch_array(mysql_query("SHOW TABLE STATUS LIKE 'lista_email'"));
        $proxId_ListaEmail = $rsTableStatus['Auto_increment'];
        
        $Banco->inserirTabela("`lista_email` (lst_id, lst_email, lst_nome_tratamento, lst_primeiro_nome, lst_nome_meio, lst_sobrenome, lst_sexo, lst_nivel, lst_status)","('','".$_POST['email']."','".$_POST['tratamento']."','".$_POST['primeiroNome']."','".$_POST['nomeMeio']."','".$_POST['sobrenome']."','".$_POST['sexo']."','".$_POST['nivel']."','".$_POST['status']."')");
		$saveListaEmail = $Banco->resultado;
		
        if($saveListaEmail){
            foreach($_POST['regioes'] as $row){
                list($idReg, $nomeReg) = explode("+", $row);
                $Banco->inserirTabela("`email_regiao` (lst_id, reg_id)","('$proxId_ListaEmail','$idReg')");
                if(!$Banco->resultado){
                    //$saveEmailRegiao = "";
                    $errSalvaEmailRegiao[]= " -Regi&atilde;o ID # $idReg - $nomeReg";
                }
                //echo "$row";
            }
            if(count($errSalvaEmailRegiao)==0){
                echo 'sucess+Dados salvos com sucesso!  (Aguarde...)';
                //$saveEmailRegiao = $Banco->resultado;
            }      
            else{
                echo 'errors+<h1>Erro ao adicionar regi&atilde;o:</h1>';
        		foreach ($errSalvaEmailRegiao as $e){
        			echo $e.'<br />';
        		}
                echo "Obs. Use a op&ccedil;&atilde;o 'Editar Email' para adicionar";
        		return;
            }
        
		}
		else{
			echo 'errors+<h1>Houve um erro ao salvar!</h1> Tente novamente.';
		}
	}
}

//----------------       U P D A T E       ----------------
if($action == "updateEmail"){
	/*echo 'error+<pre>';
	print_r($_POST);
	echo '</pre>';
    return;*/

	if (empty($_POST['tratamento'])){
		$err[] = 'Informe a Forma de Tratamento. (Ex. Sr., Sra., Dr., Ilmo, Caro...)';
	}
    
    if (empty($_POST['primeiroNome'])){
		$err[] = 'Informe o Primeiro Nome da Pessoa.';
	}
    
//    if (empty($_POST['nomeMeio'])){
//		$err[] = 'Informe o Nome do meio da Pessoa.';
//	}
    
    if (empty($_POST['sobrenome'])){
		$err[] = 'Informe o Sobrenome da Pessoa.';
	}
    
    if (empty($_POST['email'])){
		$err[] = 'Informe o Endere&ccedil;o de Email da Pessoa.';
	}
    
    if ($_POST['nivel'] == 0){
		$err[] = 'Informe o N&iacute;vel do Email.';
	}

    if (count($_POST['regioes']) == 0){
		$err[] = 'Informe pelo menos uma Regi&atilde;o para disparo de E-Marketing.';
	}

	if(count($err)>0){
		echo 'errors+<h1>Erro:</h1>';
		foreach ($err as $e){
			echo $e.'<br />';
		}
		return;
	}
	else{

//#		$up = mysql_query("UPDATE `modules` SET mod_name='$_POST[name]',".
//#												mod_nickname='$_POST[nickname]',
//#												"mod_url='$_POST[url]',
//#												mod_status=$_POST[status] WHERE mod_id=$_POST[module_id] LIMIT 1") or die('errors+'.mysql_error());
        $Banco->atualizaTabela("`lista_email`","`lst_email`='$_POST[email]', `lst_nome_tratamento`='$_POST[tratamento]',`lst_primeiro_nome`='$_POST[primeiroNome]',`lst_nome_meio`='$_POST[nomeMeio]',`lst_sobrenome`='$_POST[sobrenome]',`lst_sexo`='$_POST[sexo]', `lst_nivel`=$_POST[nivel], `lst_status`=$_POST[status]","WHERE `lst_id`=$_POST[lst_id] LIMIT 1");
		$upOk = $Banco->resultado;
        //echo "resultado de upOk : $upOk"; return;
        if($upOk){
            
            $Banco->deletaTabela("`email_regiao`","WHERE `lst_id`=$_POST[lst_id]");
            $delRegiaoOK = $Banco->resultado;
            
            if($delRegiaoOK){
            //echo "resultado de delRegiaoOk: $delRegiaoOK<BR>"; print_r($_POST['regioes']); return;
                foreach($_POST['regioes'] as $row){
                    list($idReg, $nomeReg) = explode("+", $row);
                    $Banco->inserirTabela("`email_regiao` (lst_id, reg_id)","('$_POST[lst_id]','$idReg')");
                    if(!$Banco->resultado){
                        //$saveEmailRegiao = "";
                        $errSalvaEmailRegiao[]= " -Regi&atilde;o ID # $idReg - $nomeReg";
                    }
                    //echo "$row";
                }
                if(count($errSalvaEmailRegiao)==0){
                    echo 'sucess+Dados salvos com sucesso!  (Aguarde...)';
                    //$saveEmailRegiao = $Banco->resultado;
                }      
                else{
                    echo 'errors+<h1>Erro ao tentar atualizar regi&atilde;o:</h1>';
            		foreach ($errSalvaEmailRegiao as $e){
            			echo $e.'<br />';
            		}
                    echo "Obs. Use a op&ccedil;&atilde;o 'Editar Email' para adicionar";
            		return;
                }
                
    			//echo 'sucess+Dados salvos com sucesso!  (Aguarde...)';
            }
            else{    //  Nao foi possivel deletar os dados da tabela email_regiao
                echo 'errors+<h1>Erro ao tentar atualizar regi&otilde;es:</h1>';
                echo 'Obs. Use a op&ccedil;&atilde;o \'Editar Email\' para adicionar';
                return;
            }
		}
		else{     // Nao foi possivel atualizar os dados da tablea lista_email
			echo 'errors+Houve um erro ao atualizar!';
		}
	}
}

//----------------       D E L E T E       ----------------
if($action == "deleteEmail"){
	
	if(!empty($_POST['emails2delete'])){
		foreach($_POST['emails2delete'] as $eml){
			//mysql_query('DELETE FROM `regiao` WHERE mod_id='.$reg) or die('errors+'.mysql_error());
            $Banco->deletaTabela("`lista_email`","WHERE `lst_id`=".$eml);
            $Banco->deletaTabela("`email_regiao`","WHERE `lst_id`=".$eml);
		}
		echo 'sucess+Dados exclu&iacute;dos com sucesso!  (Aguarde...)';
	}
}


                                            //##################
                                            //###  TEMPLATE  ###
                                            //##################

//----------------       S A V E       ----------------
if($action == "saveTemplate_temp"){
    //header("Content-type: text/plain");
    echo "error+chegou aqui";
    echo '<pre>';
    echo "o valor do post: "; print_r($_POST);
    echo "<BR>o Template: "; print_r($_FILES['arquivo']);
    echo "<BR>as imagens "; print_r($_FILES['imagens']);
	//print_r($_POST);
    //print_r($_FILES['arquivo']);
    //print_r($_FILES['imagens']);
    //print_r($_FILES);
    //if($_FILES==null) echo "\$_FILES esta nulo";
	echo '</pre>';
    return;
    
    //  ###################   U P L O A D   ###################
    
    $j = 0;     // Variable for indexing uploaded image.
    //$target_path = "templates/catotas.teste.txt/";     
    $tpl_name = $_FILES['arquivo']['name'];
    $target_path = DIR."templates/imagens/$tpl_name/";  //$_FILES['arquivo']['name'];  // Declaring Path for uploaded images.
    if(!is_dir($target_path)) {
        mkdir($target_path);
        //mkdir("templates/imagens/".$tpl_name);
        //@mkdir("templates/".$tpl_name, 0666, true);
    }
    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], DIR."templates/".$tpl_name)) {
        // If file moved to uploads folder.
        echo $j. ').<span id="noerror">O arquivo template foi carregado!.</span><br/><br/>';
    } else {     //  If File Was Not Moved.
        echo $j. ').<span id="error">N&atilde;o foi possivel carregar o arquivo!.</span><br/><br/>';
    }
    
    
    for ($i = 0; $i < count($_FILES['imagens']['name']); $i++) {
        // Loop to get individual element from the array
        $validExtensions = array("jpeg", "jpg", "png", "gif");      // Extensions which are allowed.
        $ext = explode('.', basename($_FILES['imagens']['name'][$i]));   // Explode file name from dot(.)
        $file_extension = end($ext); // Store extensions in the variable.
        $imgName = $target_path . $_FILES['imagens']['name'][$i]; //. "." . $ext[count($ext) - 1];     // Set the target path with a new name of image.
        $j = $j + 1;      // Increment the number of uploaded images according to the files in array.
        //if (($_FILES["file"]["size"][$i] < 100000)     // Approx. 100kb files can be uploaded.
        if (($_FILES["imagens"]["size"][$i] < 3000000)     // Approx. 2.86 Mb files can be uploaded.
                                    && in_array($file_extension, $validExtensions)) {
            ##if ($_FILES['files']['error'][$i] == 4) {
            ##continue; // Skip file if any error found
            ##}
            ##if ($_FILES['files']['error'][$i] == 0) {
            ##// No error found! Move uploaded files
            if (move_uploaded_file($_FILES['imagens']['tmp_name'][$i], $imgName)) {
            // If file moved to uploads folder.
                echo $j. ').<span id="noerror">Image ('.$_FILES['imagens']['name'][$i].') uploaded successfully!.</span><br/><br/>';
            } else {     //  If File Was Not Moved.
                echo $j. ').<span id="error">please try again!.</span><br/><br/>';
            }
            ##}
        } else {     //   If File Size And File Type Was Incorrect.
            echo $j. ').<span id="error">***Invalid file Size or Type***</span><br/><br/>';
        }
    }
}

if($action == "saveTemplate"){
	/*echo '<pre>';
	print_r($_POST);
    print_r($_FILES);
	echo '</pre>';*/
	
	if (empty($_POST['nivel'])){
		$err[] = 'Informe o Nome do N&iacute;vel.';
	}
    if (empty($_POST['id'])){
        $err[] = 'Informe o C&oacute;digo do N&iacute;vel.';
    } else {
        $Banco->selecionaTabela("`nivel`","`lvl_id`","WHERE `lvl_id`=".$_POST['id']." LIMIT 1");
        //echo "valor de post[id] : ".$_POST['id']." ,  banco-> resultado : ".mysql_num_rows($Banco->resultado);
        $jaExiste = mysql_num_rows($Banco->resultado);
        if ($jaExiste){
            $err[] = 'C&oacute;digo j&aacute; existe! Tente novamente.';
        }
    }
	
	if(count($err)>0){
		echo 'errors+<h1>Erro:</h1>';
		foreach ($err as $e){
			echo $e.'<br />';
		}
		return;
	}
	else{
		/*$save = mysql_query("INSERT INTO `modules` 
							(mod_name, mod_nickname, mod_url, mod_status) 
							VALUES('".$_POST['name']."','".
									  $_POST['nickname']."','".
									  $_POST['url']."','".
									  $_POST['status']."')") or die(mysql_error()); */
		
		/*$save = mysql_query("INSERT INTO `modules`
							(mod_name, mod_url, mod_status)
							VALUES('$_POST[name]','$_POST[url]','$_POST[status]')") or die('errors+'.mysql_error()); */
		$Banco->inserirTabela("`nivel` (lvl_id, lvl_nome, lvl_status)","('".$_POST['id']."','".$_POST['nivel']."','".$_POST['status']."')");
		$saveOk = $Banco->resultado;
		//echo "valor save: $save"; exit();
		if($saveOk){
			echo 'sucess+Dados salvos com sucesso!  (Aguarde...)';
		}
		else{
			echo 'errors+Houve um erro ao salvar!';
		}
	}
}

//----------------       U P D A T E       ----------------
if($action == "updateNivel"){
	/*echo '<pre>';
	print_r($_POST);
	echo '</pre>';*/

	if (empty($_POST['nome'])){
		$err[] = 'Informe o Nome do N&iacute;vel.';
	}
 
    if (empty($_POST['codigo'])){
        $err[] = 'Informe o C&oacute;digo do N&iacute;vel.';
    } else {
        if ($_POST['codigo'] != $_POST['lvl_last_id']){
            $Banco->selecionaTabela("`nivel`","`lvl_id`","WHERE `lvl_id`=".$_POST['codigo']." LIMIT 1");
            //echo "valor de post[id] : ".$_POST['id']." ,  banco-> resultado : ".mysql_num_rows($Banco->resultado);
            $jaExiste = mysql_num_rows($Banco->resultado);
            if ($jaExiste){
                $err[] = 'C&oacute;digo j&aacute; existe! Tente novamente.';
            }
        }
    }

    //  if (empty($_POST['url'])){
    //		$err[] = 'Informe a URL.';
    //	}

	if(count($err)>0){
		echo 'errors+<h1>Erro:</h1>';
		foreach ($err as $e){
			echo $e.'<br />';
		}
		return;
	}
	else{

//#		$up = mysql_query("UPDATE `modules` SET mod_name='$_POST[name]',".
//#												mod_nickname='$_POST[nickname]',
//#												"mod_url='$_POST[url]',
//#												mod_status=$_POST[status] WHERE mod_id=$_POST[module_id] LIMIT 1") or die('errors+'.mysql_error());
        $Banco->atualizaTabela("`nivel`","`lvl_id`=$_POST[codigo], `lvl_nome`='$_POST[nome]', `lvl_status`=$_POST[status]","WHERE `lvl_id`=$_POST[lvl_last_id] LIMIT 1");
		$upOk = $Banco->resultado;
        //echo "resultado de upOk : $upOk"; exit();
        if($upOk){
			echo 'sucess+Dados salvos com sucesso!  (Aguarde...)';
		}
		else{
			echo 'errors+Houve um erro ao salvar!';
		}
	}
}

//----------------       D E L E T E       ----------------
if($action == "deleteNivel"){
	
	if(!empty($_POST['niveis2delete'])){
		foreach($_POST['niveis2delete'] as $lvl){
			//mysql_query('DELETE FROM `regiao` WHERE mod_id='.$reg) or die('errors+'.mysql_error());
            $Banco->deletaTabela("`nivel`","WHERE `lvl_id`=".$lvl);
		}
		echo 'sucess+Dados exclu&iacute;dos com sucesso!  (Aguarde...)';
	}
}


                                            //#################
                                            //###  USUARIO  ###
                                            //#################

//----------------       S A V E       ----------------
if($action == "saveUsuario"){
	/*echo 'errors+<pre><h1>Saida:</h1>';
	print_r($_POST);
	echo '</pre>';
    return;*/

	
    if (empty($_POST['loginId'])){
        $err[] = 'Informe o Login ID de acesso ao sistema do usuário.';
    } else {
        $Banco->selecionaTabela("`usuario`","`usr_login_id`","WHERE `usr_login_id`='".$_POST['loginId']."' LIMIT 1");
        //echo "valor de post[id] : ".$_POST['id']." ,  banco-> resultado : ".mysql_num_rows($Banco->resultado);
        $jaExiste = mysql_num_rows($Banco->resultado);
        if ($jaExiste){
            $err[] = 'Login ID de acesso ao sistema j&aacute; existe! Tente novamente.';
        }
    }
    
	if (empty($_POST['pass'])){
		$err[] = 'Informe s senha inicial do Usu&aacute;rio.';
	}
 
	if (empty($_POST['nome'])){
		$err[] = 'Informe o nome do Usu&aacute;rio.';
	}
    
    if (empty($_POST['sobrenome'])){
		$err[] = 'Informe o sobrenome do Usu&aacute;rio.';
	}
    
    if (empty($_POST['email'])){
        $err[] = 'Informe o endere&ccedil;o de Email do Usu&aacute;rio.';
    } else {
        $Banco->selecionaTabela("`usuario`","`usr_id`","WHERE `usr_email`='".$_POST['email']."' LIMIT 1");
        //echo "valor de post[id] : ".$_POST['id']." ,  banco-> resultado : ".mysql_num_rows($Banco->resultado);
        $jaExiste = mysql_num_rows($Banco->resultado);
        if ($jaExiste){
            $err[] = 'Endere&ccedil;o de Email j&aacute; existe e pertende a outro Usu&aacute;rio! Tente novamente.';
        }
    }
    
	if ($_POST['nivel'] == 0){
		$err[] = 'Informe o N&iacute;vel do Usu&aacute;rio.';
	}
    
	if(count($err)>0){
		echo 'errors+<h1>Erro:</h1>';
		foreach ($err as $e){
			echo $e.'<br />';
		}
		return;
	}
	else{
		/*$save = mysql_query("INSERT INTO `modules` 
							(mod_name, mod_nickname, mod_url, mod_status) 
							VALUES('".$_POST['name']."','".
									  $_POST['nickname']."','".
									  $_POST['url']."','".
									  $_POST['status']."')") or die(mysql_error()); */
		
		/*$save = mysql_query("INSERT INTO `modules`
							(mod_name, mod_url, mod_status)
							VALUES('$_POST[name]','$_POST[url]','$_POST[status]')") or die('errors+'.mysql_error()); */
		$Banco->inserirTabela("`usuario` (`usr_id`, `usr_login_id`, `usr_pass`, `usr_nome`, `usr_sobrenome`, `usr_apelido`, `usr_email`, `usr_telefone`, `usr_sexo`, `usr_nivel`, `usr_status`)","('','".$_POST['loginId']."','".$_POST['pass']."','".$_POST['nome']."','".$_POST['sobrenome']."','".$_POST['apelido']."','".$_POST['email']."','".$_POST['telefone']."','".$_POST['sexo']."','".$_POST['nivel']."','".$_POST['status']."')");
		$saveOk = $Banco->resultado;
		//echo "valor save: $save"; exit();
		if($saveOk){
			echo 'sucess+Dados salvos com sucesso!  (Aguarde...)';
		}
		else{
			echo 'errors+Houve um erro ao salvar!';
		}
	}
}

//----------------       U P D A T E       ----------------
if($action == "updateUsuario"){
	/*echo '<pre>';
	print_r($_POST);
	echo '</pre>';
    return;*/

	if (empty($_POST['loginId'])){
        $err[] = 'Informe o Login ID de acesso ao sistema do usuário.';
    } else {
//        $Banco->selecionaTabela("`usuario`","`usr_login_id`","WHERE `usr_login_id`='".$_POST['loginId']."' LIMIT 1");
//        //echo "valor de post[id] : ".$_POST['id']." ,  banco-> resultado : ".mysql_num_rows($Banco->resultado);
//        $jaExiste = mysql_num_rows($Banco->resultado);
//        if ($jaExiste){
//            $err[] = 'Login ID de acesso ao sistema j&aacute; existe! Tente novamente.';
//        }
    }
    
//	if (empty($_POST['pass'])){
//		$err[] = 'Informe s senha inicial do Usu&aacute;rio.';
//	}
 
	if (empty($_POST['nome'])){
		$err[] = 'Informe o nome do Usu&aacute;rio.';
	}
    
    if (empty($_POST['sobrenome'])){
		$err[] = 'Informe o sobrenome do Usu&aacute;rio.';
	}
    
    if (empty($_POST['email'])){
        $err[] = 'Informe o endere&ccedil;o de Email do Usu&aacute;rio.';
    } else {
//        $Banco->selecionaTabela("`usuario`","`usr_id`","WHERE `usr_email`='".$_POST['email']."' LIMIT 1");
//        //echo "valor de post[id] : ".$_POST['id']." ,  banco-> resultado : ".mysql_num_rows($Banco->resultado);
//        $jaExiste = mysql_num_rows($Banco->resultado);
//        if ($jaExiste){
//            $err[] = 'Endere&ccedil;o de Email j&aacute; existe e pertende a outro Usu&aacute;rio! Tente novamente.';
//        }
    }
    
	if ($_POST['nivel'] == 0){
		$err[] = 'Informe o N&iacute;vel do Usu&aacute;rio.';
	}
    
	if(count($err)>0){
		echo 'errors+<h1>Erro:</h1>';
		foreach ($err as $e){
			echo $e.'<br />';
		}
		return;
	}
	else{

//#		$up = mysql_query("UPDATE `modules` SET mod_name='$_POST[name]',".
//#												mod_nickname='$_POST[nickname]',
//#												"mod_url='$_POST[url]',
//#												mod_status=$_POST[status] WHERE mod_id=$_POST[module_id] LIMIT 1") or die('errors+'.mysql_error());
        $Banco->atualizaTabela("`usuario`","`usr_login_id`='$_POST[loginId]', `usr_pass`='$_POST[pass]', `usr_nome`='$_POST[nome]', `usr_sobrenome`='$_POST[sobrenome]', `usr_apelido`='$_POST[apelido]', `usr_email`='$_POST[email]', `usr_telefone`='$_POST[telefone]', `usr_nivel`='$_POST[nivel]', `usr_status`=$_POST[status]","WHERE `usr_id`=$_POST[usr_id] LIMIT 1");
		$upOk = $Banco->resultado;
        //echo "resultado de upOk : $upOk"; exit();
        if($upOk){
			echo 'sucess+Dados salvos com sucesso!  (Aguarde...)';
		}
		else{
			echo 'errors+Houve um erro ao atualizar!';
		}
	}
}

//----------------       D E L E T E       ----------------
if($action == "deleteUsuario"){
	
	if(!empty($_POST['usuarios2delete'])){
		foreach($_POST['usuarios2delete'] as $usr){
			//mysql_query('DELETE FROM `regiao` WHERE mod_id='.$reg) or die('errors+'.mysql_error());
            $Banco->deletaTabela("`usuario`","WHERE `usr_id`=".$usr);
		}
		echo 'sucess+Dados exclu&iacute;dos com sucesso!  (Aguarde...)';
	}
}


?>