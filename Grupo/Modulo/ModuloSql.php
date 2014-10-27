<?php

namespace Sappiens\Grupo\Modulo;

class ModuloSql
{

    public function filtrarSql($objForm, $colunas)
    {
        $fil = new \Pixel\Filtro\Filtrar($objForm);
        $util = new \Pixel\Crud\CrudUtil();

        $sql = "SELECT ufCidadeCod, ufCidadeNome, ufCidadeNomeUfNome
	              FROM v_uf_cidade
	             WHERE 1 ";

        $sql .= $util->getSqlFiltro($fil, $objForm, $colunas);

        return $sql;
    }

    public function cadastrarSql($objForm)
    {
        $util = new \Pixel\Crud\CrudUtil();

        $sql = "INSERT INTO uf 
                (SistemaNome, DirBase, BancoNome, PastaNome) VALUES 
                (%s, %s, %s, %s)";

        $var = $util->getSqlInsertUpdate($objForm, $sql);

        return vsprintf($sql, $var);
    }

}
