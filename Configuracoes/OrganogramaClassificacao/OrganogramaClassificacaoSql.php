<?php

namespace Sappiens\Configuracoes\OrganogramaClassificacao;

class OrganogramaClassificacaoSql
{

    public function filtrarSql($objForm, $colunas)
    {
        $fil = new \Pixel\Filtro\Filtrar($objForm);
        $util = new \Pixel\Crud\CrudUtil();

        $sql = "SELECT a.*,
                       CASE 
                            WHEN a.organogramaClassificacaoStatus = 'A' THEN 'Ativo'
                            WHEN a.organogramaClassificacaoStatus = 'I' THEN 'Inativo'
                       END AS organogramaClassificacaoStatus
	              FROM organograma_classificacao a, organograma b
	             WHERE INSTR(a.organogramaClassificacaoAncestral,CONCAT('|', b.OrganogramaClassificacaoCod,'|')) > 0
                 AND b.organogramaCod = " . $_SESSION['organogramaCod'];

        $sql .= $util->getSqlFiltro($fil, $objForm, $colunas);

        return $sql;
    }

    public function getDadosSql($cod)
    {
        return "SELECT *
                  FROM  organograma_classificacao
                 WHERE  organogramaClassificacaoCod = ".$cod;
    }

    public function getOrdem($cod, $modo = '')
    {

        $sqlAdd = '';
        if($modo == 'referencia') {
            $sqlAdd = "Referencia";
        }
            return "SELECT MAX(organogramaClassificacaoOrdem) AS ordemAtual
                      FROM organograma_classificacao
                     WHERE organogramaClassificacao".$sqlAdd."Cod = ".$cod;

    }

    public function getOrganogramaClassificacaoReferenciaCod($cod)
    {
        return "SELECT organogramaClassificacaoCod chave, CONCAT(organogramaClassificacaoNome) valor
                  FROM organograma_classificacao
                 WHERE organogramaClassificacaoTipoCod = ".$cod;
    }     

    public function getDadosOrganogramaByOrganogramaCod($cod)
    {
        return "SELECT *
                  FROM  organograma
                 WHERE  organogramaCod = ".$cod;
    }    

}
