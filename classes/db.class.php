<?php

# db.class.php

class DB {
    
    /** ### PHP4 ###   **/
    var $conexao;
    var $resultado;
    
    function DB($dominio, $usr, $pws, $db) {
        if (!$this->conexao = mysql_connect($dominio, $usr, $pws)){
            echo "Não foi possivel fazer a conexão com o MySQL";
            exit;
        }
        if (! mysql_select_db($db, $this->conexao)){
            echo "Não foi possivel fazer a conexao com o Banco de Dados <b>$db</b>";
            exit;
        }
        
        if (! mysql_set_charset("utf8")){
            echo "Não foi possivel configurar o pack de carcteres <b>$db</b>";
            exit;
        }
        
        mysql_query("SET NAMES 'utf8'");
        mysql_query("SET CHARACTER SET utf8");
        mysql_query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");
    }
    
    /** ### PHP5 ###
    public $conexao;
    public $resultado;
    
    function __construct($dominio, $usr, $pws, $db) {
        $this->conexao = mysql_connect($dominio, $usr, $pws);
        mysql_select_db($db, $this->conexao);
    }
    **/
    
    function DBError(){
        echo mysql_error($this->conexao);
    }
    
    function inserirTabela($tab, $campos){
        $query = "INSERT INTO $tab VALUES $campos";
        //echo $query;
        $this->resultado = mysql_query($query) or die('errors+'.mysql_error());
        //echo "Valor do this->resultado : ".$this->resultado; exit();
        
    }
    
    function selecionaTabela($tab, $campos, $condicao){
        $query = "SELECT $campos FROM $tab $condicao";
        //echo $query;
        //$this->resultado = mysql_query($query, $this->conexao);
        $this->resultado = mysql_query($query) or die('errors+'.mysql_error());
    }
    
    function deletaTabela($tab, $condicao){
        $query = "DELETE FROM $tab $condicao";
        $this->resultado = mysql_query($query) or die('errors+'.mysql_error());
    }
    
    function atualizaTabela($tab, $campos,$condicao){
        $query = "UPDATE $tab SET $campos $condicao";
        //echo $query; exit();
        $this->resultado = mysql_query($query) or die('errors+'.mysql_error());
        //echo $this->resultado; exit();
    }
    
    function totalRegistrosTabela($tab, $campo){
        //$query = "SELECT COUNT(*) AS TotalRecords FROM Orders";
        //$this->resultado = mysql_query($query);
        $query = "SELECT COUNT($campo) AS TotalRecords FROM $tab";
        return mysql_result(mysql_query($query), 0,"TotalRecords");
    }
}
?>