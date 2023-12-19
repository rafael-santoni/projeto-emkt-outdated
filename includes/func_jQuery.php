<?php
include_once '/home/rafasan/public_html/EMkt/includes/config.php';

// <script>

// jQuery(function(){

// 	$("#form").submit(function(e){

// 		e.preventDefault();

// 		$("#load").show();
// 		$("#return").empty().hide();

// 		$.post("arquivo.php", $("#form").serialize(),function(return){

// 			$("#load").hide();
// 			#("#return").show().html(return);
				
// 		})

// 	});

// });

// </script>

//setTimeout(function(){$("#return").fadeOut("slow") }, 1500);
function ajaxjQuery($arquivo, $idFocus, $str=null, $idForm='form'){

	$str = ($str != null && is_string($str)) ? $str : '$("#'.$idFocus.'").focus();';
	
	$jq = '
    <script>

		jQuery(function(){
		
			$("#'.$idFocus.'").focus();
		
			$("#'.$idForm.'").submit(function(e){
		
				e.preventDefault();
		
				$("#load").show();
				$("#return").empty().hide();
		
				$.post("'.$arquivo.'", $("'.$idForm.'").serialize(),function(ret){
					
					alert(ret);
					retorno= ret.split("+");
						
					classe = (retorno[0] == "sucess") ? "sucess" : "errors";
					if(classe == "sucess"){
						$("#clean").trigger("click");
						setTimeout(function(){$("#return").empty().fadeOut("slow"); '.$str.' }, 1500);
					}
		
					$("#load").hide();
					$("#return").show().html("<span class=\'"+classe+"\'>"+retorno[1]+"</span>");
					
				})
				
			});
			
		});
		
	</script>';
	
	echo $jq;
}

function jQueryMultiUpload($arquivo ,$idFocus, $str=null, $idForm='multiform'){
    
    $str = ($str != null && is_string($str)) ? $str : '$("#'.$idFocus.'").focus();';
    
	$jq = '
    <script>
        $(document).ready(function(){
            
            $("#'.$idFocus.'").focus();
            
            $(\'#upload\').click(function(){
    
                //alert("ooii");
                //console.log(\'upload button clicked!\')
                
				$("#load").show();
				$("#return").empty().hide();
                
                //var fd = new FormData();    
                //fd.append(\'userfile\', $(\'#userfile\')[0].files[0]);
                var data1 = new FormData($(\'input[name^="imagens"]\'));
                $.each($(\'input[name^="imagens"]\')[0].files, function(i, file) {
                    data1.append(i, file);
                });
                
                var oOutput = document.getElementById("output");
                var oData = new FormData(document.forms.namedItem("multiform"));
    
                $.ajax({
                  url: \''.$arquivo.'\',
                  data: oData,
                  processData: false,
                  contentType: false,
                  type: \'POST\',
                  enctype: \'multipart/form-data\',
                  success: function(ret){
                    
				    alert(ret);
					retorno= ret.split("+");
						
					classe = (retorno[0] == "sucess") ? "sucess" : "errors";
					if(classe == "sucess"){
						$("#clean").trigger("click");
						setTimeout(function(){$("#return").empty().fadeOut("slow"); '.$str.' }, 1500);
					}
		
					$("#load").hide();
					$("#return").show().html("<span class=\'"+classe+"\'>"+retorno[1]+"</span>");
                    
                    //console.log(\'upload success!\')
                    //alert("sucesso: "+data);
                    //$(\'#data\').empty();
                    //$(\'#data\').append(data);
    
                  }
                });
            });
        });
    </script>';
	
	echo $jq;
}

function checkBoxAll($chkName){
    $jq = "
    <script language=javascript>
		function CheckAll(nome){
            for (var i=0;i<nome.form.elements.length;i++) {
                var x = nome.form.elements[i];
                if (x.name == '$chkName') { 
                    x.checked = nome.form.selectAll.checked;
                } 
            }
		}
	</script>";
	
	echo $jq;
}

function botaoAddCampo($nome,$tipo){

	$jq = '
    <script>
        function adicionaCampo(){
        	var campo = document.createElement("INPUT");
        	campo.setAttribute("name", "'.$nome.'");
        	campo.setAttribute("type", "'.$tipo.'");
        	result.appendChild(campo);
            var campo2 = document.createElement("BR");
            result.appendChild(campo2);
        }
    
    </script>';
	
	echo $jq;
}

function ajaxPopulaLinha(){
    
    $jq = "
    <script type=\"text/javascript\" language=\"javascrip\">
        $(function($) {
            
            // Quando clicando em uma ninha da tabela
            $(\"tr#linhaPrincipal\").click(function(event) {
                
                //Verifica se click veio de uma img OU um input
                var target = $(event.target);
                if (target.is(\"img\") || target.is(\"input\")){
                    return;
                }
                

                var vID = $(this).attr(\"idEmail\");
                var vSubLinha = 'subLinha-'+vID;
                var vFlagLinha = document.getElementById(\"flagLinha-\"+vID).value;
                //alert(vFlagLinha);
                //alert(vID);
                
                //Verifica se o conteudo esta fechado para inclusao dos dados
                if(vFlagLinha == 'fechado'){
                    $(\"tr#\"+vSubLinha).html(\"<td COLSPAN=15><img src='".URL.IMG."loading.gif' /><br />Aguarde, processando...</td>\");
                    
                    $.post(\"index.php\", {action: 'populaLinha', idEmail: vID}, function(resposta) {
                       // Limpa a mensagem de carregamento
                       $(\"tr#\"+vSubLinha).empty();
                       // Coloca as regiões e níveis na subLinha
                       $(\"tr#\"+vSubLinha).append(resposta);
                    });
                    //alterar status do flag linha
                    document.getElementById(\"flagLinha-\"+vID).value = 'aberto';
                }
                else {
                    $('#'+vSubLinha).empty();
                    document.getElementById(\"flagLinha-\"+vID).value = 'fechado';
                }
                //return;
            });
        });
    </script>";
	
	echo $jq;

}

function montaListaPagina($totPag,$pagAtu,$link){
    $pag="";
    for($i=1;$i<=$totPag;$i++){
        if($i==$pagAtu){
            $pag .= ($i==$totPag) ? "[ $i ]" : "[ $i ] - " ;
        }
        else{
            $pag .= ($i==$totPag) ? "[ <a href=\"$link?pag=$i\">$i</a> ]" : "[ <a href=\"$link?pag=$i\">$i</a> ] - " ;
        }
    }
    return $pag;
}
?>