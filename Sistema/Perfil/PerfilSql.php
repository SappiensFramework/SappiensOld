<?php

namespace Sappiens\Sistema\Perfil;

class PerfilSql
{

    /**
     * @var \Zion\Banco\Conexao
     */
    protected $con;

    public function __construct()
    {
        $this->con = \Zion\Banco\Conexao::conectar();
    }

    public function filtrarSql($objForm, $filtroDinamico = [])
    {
        $fil = new \Pixel\Filtro\Filtrar($objForm);
        $util = new \Pixel\Crud\CrudUtil();

        $qb = $this->con->link()->createQueryBuilder();

        $qb->select(['perfilCod', 'perfilNome', 'perfilDescricao'])
                ->from('_perfil', '');

        $util->getSqlFiltro($fil, $objForm, $filtroDinamico, $qb);

        return $qb;
    }

    public function getDadosSql($cod)
    {
        $qb = $this->con->link()->createQueryBuilder();

        $qb->select(['perfilCod','perfilNome','perfilDescricao'])
                ->from('_perfil', '')
                ->where($qb->expr()->eq('perfilCod', '?'))
                ->setParameter(0, $cod);

        return $qb;
    }

}
