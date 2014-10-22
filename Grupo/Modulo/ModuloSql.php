<?php

namespace Sappiens\Grupo\Modulo;

class ModuloSql
{
    public function filtrarSql()
    {
        $sql = "SELECT UfCidadeCod, UfCidadeNome 
            FROM uf_cidade 
            WHERE 1 ";

        return $sql;
    }
}
