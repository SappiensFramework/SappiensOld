<?php

namespace Sappiens\Configuracoes\OrganogramaClassificacao;

class OrganogramaClassificacaoSql
{

    public function filtrarSql($objForm, $colunas)
    {
        $fil = new \Pixel\Filtro\Filtrar($objForm);
        $util = new \Pixel\Crud\CrudUtil();

        $sql = "SELECT *,
                       CASE 
                            WHEN organogramaClassificacaoStatus = 'A' THEN 'Ativo'
                            WHEN organogramaClassificacaoStatus = 'I' THEN 'Inativo'
                       END AS organogramaClassificacaoStatus
	              FROM v_organograma_classificacao
	             WHERE 1 ";

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

}
