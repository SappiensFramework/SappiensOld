<?php

namespace Sappiens\Grupo\Modulo;

class ModuloSql
{
    public function filtrarSql()
    {
        $sql = "SELECT ufCidadeCod, ufCidadeNome, ufCidadeNomeUfNome
	              FROM v_uf_cidade
	             WHERE 1 ";

        return $sql;
    }
}
