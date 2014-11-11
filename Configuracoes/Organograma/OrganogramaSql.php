<?php

namespace Sappiens\Configuracoes\Organograma;

class OrganogramaSql
{

    public function filtrarSql($objForm, $colunas)
    {
        $fil = new \Pixel\Filtro\Filtrar($objForm);
        $util = new \Pixel\Crud\CrudUtil();

        $sql = "SELECT a.*,
                       CASE 
                            WHEN a.organogramaStatus = 'A' THEN 'Ativo'
                            WHEN a.organogramaStatus = 'I' THEN 'Inativo'
                       END AS organogramaStatus
	              FROM v_organograma a
	             WHERE 1";

        $sql .= $util->getSqlFiltro($fil, $objForm, $colunas);

        return $sql;
    }

    public function getDadosSql($cod)
    {
        return "SELECT *
                  FROM  organograma
                 WHERE  organogramaCod = ".$cod;
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

}
