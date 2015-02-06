<?php

namespace Sappiens\Sistema\Grupo;

class GrupoSql
{

    protected $con;

    public function __construct()
    {
        $this->con = \Zion\Banco\Conexao::conectar();
    }

    public function filtrarSql($objForm, $colunas)
    {
        $fil = new \Pixel\Filtro\Filtrar($objForm);
        $util = new \Pixel\Crud\CrudUtil();

        $qb = $this->con->qb();

        $qb->select('grupoCod, grupoNome, grupoPacote, grupoPosicao, grupoClass')
                ->from('_grupo', '');

        $util->getSqlFiltro($fil, $objForm, $colunas, $qb);

        return $qb;
    }

    public function getDadosSql($cod)
    {
        $qb = $this->con->qb();

        $qb->select('grupoCod', 'grupoNome', 'grupoPacote', 'grupoPosicao', 'grupoClass')
                ->from('_grupo', '')
                ->where($qb->expr()->eq('grupoCod', ':grupoCod'))
                ->setParameter('grupoCod', $cod);

        return $qb;
    }
    
    public function gruposSql()
    {
        $qb = $this->con->qb();

        $qb->select(['grupoCod',
                    'grupoNome',
                    'grupoPacote',
                    'grupoClass'])
                ->from('_grupo', '')
                ->orderBy('grupoPosicao', 'ASC');

        return $qb;
    }
}
