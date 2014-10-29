<?php

namespace Sappiens\Grupo\Modulo;

class ModuloSql
{

    public function filtrarSql($objForm, $colunas)
    {
        $fil = new \Pixel\Filtro\Filtrar($objForm);
        $util = new \Pixel\Crud\CrudUtil();

        $sql = "SELECT ufCod, ufSigla, ufNome 
	              FROM uf
	             WHERE 1 ";

        $sql .= $util->getSqlFiltro($fil, $objForm, $colunas);

        return $sql;
    }

    public function getDadosSql($cod)
    {
        return "SELECT ufCod, ufSigla, ufNome, ufIbgeCod 
                FROM  uf
                WHERE  ufCod = $cod";
    }
}
