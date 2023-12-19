<?php

    class Template {
        
        var $dados = array();
        var $arquivo;
        var $pasta;
        //var $pasta = 'show';
        var $ext = '.fah';
        
        function Template ($pst='',$arq='',  $ext='') {
            $this->pasta = ($pst == '') ? 'show' : $pst; 
            //$this->ext = ($ext = '') ? 'show' : $ext;
            $this->arquivo = $arq;
        }

        function setDados($dados, $valor) {
            $this->dados[$dados] = $valor;
        }

        function setArquivo($arquivo) {
            $this->arquivo = $arquivo;
        }

        function setPasta($pasta) {
            $this->pasta = $pasta;
        }

        function setExt($ext) {
            $this->ext = $ext;
        }

        function getDados() {
            return $this->dados;
        }

        function getArquivo() {
            return $this->arquivo;
        }

        function getPasta() {
            return $this->pasta;
        }

        function getExt() {
            return $this->ext;
        }

        function carregaArquivo(){
            //echo $this->pasta.'/'.$this->arquivo;
            if(file_exists($this->pasta.'/'.$this->arquivo)){
                $arquivo = file_get_contents($this->pasta.'/'.$this->arquivo);
                return $arquivo;
            } else {
                echo ('Erro ao carregar o arquivo: '.$this->arquivo);
            }
           
        }
        
        function mostrarPagina() {
            try {
                $arquivo = $this->carregaArquivo();
                //print_r($this->dados);
                foreach ($this->dados as $k => $v) {
                    $troca = '[$'.$k.']';
                    $arquivo = str_replace($troca, $v, $arquivo);
                }
                echo $arquivo;
            } catch (Exception $e) {
                echo $e->getTraceAsString().'<br />';
                echo $e->getCode().' - '.$e->getMessage().' - '.$e->getLine();
            }
                
        }
        
        function loadEmail() {
            try {
                $arquivo = $this->carregaArquivo();
                //print_r($this->dados);
                foreach ($this->dados as $k => $v) {
                    $troca = '[$'.$k.']';
                    $arquivo = str_replace($troca, $v, $arquivo);
                }
                return $arquivo;
            } catch (Exception $e) {
                echo $e->getTraceAsString().'<br />';
                echo $e->getCode().' - '.$e->getMessage().' - '.$e->getLine();
            }
                
        }
        

    }

?>