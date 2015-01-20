<?php

//session_start();

require '../Config.php';

$con = \Zion\Banco\Conexao::conectar();
$manipulaArquivo = new \Zion\Arquivo\ManipulaArquivo();

$modo = \filter_input(\INPUT_GET, 'modo');
$uploadCod = (int) \filter_input(\INPUT_GET, 'uploadCod'); 

if ($modo != 'download' and $modo != 'ver') {
    exit("Modo de Visualização inválido");
}

    try{

        //Buscando mais informações
        $sqlArquivo = "SELECT uploadNomeFisico, uploadNomeOriginal, uploadDataCadastro, uploadMime FROM _upload WHERE uploadCod = " . $uploadCod;
        
        $dadosArquivo = $con->execLinha($sqlArquivo);
        
        $arquivo = SIS_DIR_BASE . 'Storage/' . \str_replace('-', '/', $dadosArquivo['uploadDataCadastro']) . '/' . $dadosArquivo['uploadNomeFisico'];
        
        if (!file_exists($arquivo)) {
            exit("Arquivo não encontrado");
        }
        
        $extensaoAtual = \strtolower($manipulaArquivo->extenssaoArquivo($dadosArquivo['uploadNomeOriginal']));
        
        if ($modo == 'ver') { //Visualizar icone do arquivo, se for imagem mostrar ela mesma
            //Extenssões que é possivel ele ver
            $extensoesVer = ['jpeg', 'gif', 'png'];
        
            if (\in_array($extensaoAtual, $extensoesVer)) {
                \header('Content-Type: image/' . $extensaoAtual);
                \readfile($arquivo);
            } else {
                //Caminho para Uma Imagem Padrão
                \header('Content-Type: image/gif');
                //\readfile($_SESSION['DirBase'] . 'figuras/icone0.gif');
            }
        } else { //Download do Arquivo
            //Atualiza Numero de Dowloads
            $con->executar("UPDATE _upload SET uploadDownloads = (uploadDownloads +1) WHERE uploadCod = $uploadCod");
        
            \set_time_limit(0);
        
            \header("Pragma: public");
            \header("Expires: 0");
            \header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            \header("Cache-Control: private", false);
            //header("Content-Type:".mime_content_type($arquivo)."");
            \header("Content-Disposition: attachment; filename=\"" . $dadosArquivo['uploadNomeOriginal'] . "\";");
            \header("Content-Transfer-Encoding: binary");
            \header("Content-Length: " . filesize($arquivo));
        
            \readfile("$arquivo") or die("Arquivo não encontrado.");
        }

    } catch(Exception $e){
        exit($e->getMessage());
    }