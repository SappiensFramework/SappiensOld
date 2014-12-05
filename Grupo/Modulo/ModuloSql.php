<?php

namespace Sappiens\Grupo\Modulo;

class ModuloSql
{

    public function filtrarSql($objForm, $colunas)
    {
        $fil = new \Pixel\Filtro\Filtrar($objForm);
        $util = new \Pixel\Crud\CrudUtil();

        $sql = "SELECT ufCod, ufSigla, ufNome, ufDescricao  
	              FROM uf
	             WHERE 1 ";

        $sql .= $util->getSqlFiltro($fil, $objForm, $colunas);        

        return $sql;
    }

    public function getDadosSql($cod)
    {
        return "SELECT ufCod, ufSigla, ufNome, ufIbgeCod, ufTextArea, ufDescricao, 
                       ufChosenSimples, ufChosenmultiplo, 
                       ufEscolhaSelect, ufEscolhaVarios, ufEscolhaDois, 
                       ufMarqueUm
                FROM  uf
                WHERE  ufCod = $cod";
    }
}
