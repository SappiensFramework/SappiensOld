<?php

namespace Sappiens\Accounts\Login;

class LoginSql
{

    public function filtrarSql($objForm, $colunas)
    {
        $fil = new \Pixel\Filtro\Filtrar($objForm);
        $util = new \Pixel\Crud\CrudUtil();

        $sql = "SELECT *,
                       CASE 
                            WHEN a.organogramaStatus = 'A' THEN 'Ativo'
                            WHEN a.organogramaStatus = 'I' THEN 'Inativo'
                       END AS organogramaStatus
	              FROM organograma a, organograma_classificacao b
	             WHERE INSTR(a.organogramaAncestral,CONCAT('|', " . $_SESSION['organogramaCod'] . ",'|')) > 0
                 AND a.organogramaClassificacaoCod = b.organogramaClassificacaoCod";

        $sql .= $util->getSqlFiltro($fil, $objForm, $colunas);

        return $sql;
    }

    public function getAuth($l, $p)
    {
        return "SELECT usuarioCod, organogramaCod
                  FROM _usuario
                 WHERE usuarioLogin = '" . $l . "' AND usuarioSenha = '" . $p . "' ";
    }

    public function getDadosUsuario($cod)
    {
        return "SELECT *
                  FROM  _usuario
                 WHERE  usuarioCod = ".$cod;
    }    

    public function getOrdem($cod, $modo = '')
    {

        $sqlAdd = '';
        if($modo == 'referencia') {
            $sqlAdd = "Referencia";
        }
            return "SELECT MAX(organogramaOrdem) AS ordemAtual
                      FROM organograma
                     WHERE organograma".$sqlAdd."Cod = ".$cod;

    }

    public function getOrganogramaClassificacaoCod($cod)
    {
        return "SELECT organogramaClassificacaoCod chave, CONCAT(organogramaClassificacaoNome) valor
                  FROM organograma_classificacao
                 WHERE organogramaClassificacaoTipoCod = ".$cod;
    }    

    public function getOrganogramaClassificacaoCodByOrganogramaCod($cod)
    {
        return "SELECT organogramaClassificacaoCod
                  FROM organograma
                 WHERE organogramaCod = ".$cod;
    }     

    public function getOrganogramaClassificacaoTipoCodByOrganogramaClassificacaoCod($cod)
    {
        return "SELECT organogramaClassificacaoTipoCod
                  FROM organograma_classificacao
                 WHERE organogramaClassificacaoCod = ".$cod;
    }    

    public function getOrganogramaClassificacaoCodByOrganogramaClassificacaoTipoCod($cod)
    {
        return "SELECT a.organogramaClassificacaoCod chave, CONCAT(a.organogramaClassificacaoNome) valor
                  FROM organograma_classificacao a
                 WHERE a.organogramaClassificacaoTipoCod = ".$cod;
    }     

    public function getClassificacaoReordenavel($cod)
    {
        return "SELECT organogramaClassificacaoReordenavel
                  FROM organograma a, organograma_classificacao b
                 WHERE a.organogramaCod = ".$cod." 
                   AND a.organogramaClassificacaoCod = b.organogramaClassificacaoCod";
    }      

    public function getOrganogramaClassificacaoByReferencia($cod)
    {
        return "SELECT organogramaClassificacaoCod chave, CONCAT(organogramaClassificacaoNome) valor
                  FROM organograma_classificacao
                 WHERE INSTR(organogramaClassificacaoAncestral,CONCAT('|', " . $cod . ",'|')) > 1";
    }     

}
