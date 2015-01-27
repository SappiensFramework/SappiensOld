<?php

namespace Sappiens\Sistema\Modulo;

class ModuloSql
{

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

        $qb->select('a.moduloCod', 'b.grupoNome', 'c.ModuloNome as moduloNomeReferente', 'a.moduloNome', 'a.moduloNomeMenu', 'a.moduloDesc', 'a.moduloVisivelMenu', 'a.moduloPosicao', 'a.moduloBase', 'a.moduloClass')
                ->from('_modulo', 'a')
                ->innerJoin('a', '_grupo', 'b', 'a.grupoCod = b.grupoCod')
                ->leftJoin('a', '_modulo', 'c', 'a.moduloCodReferente = c.moduloCod');                 

        $util->getSqlFiltro($fil, $objForm, $filtroDinamico, $qb);          

        return $qb;
    }

    public function getDadosSql($cod)
    {
        $qb = $this->con->link()->createQueryBuilder();

        $qb->select('moduloCod', 'grupoCod', 'moduloCodReferente', 'moduloNome', 'moduloNomeMenu', 'moduloDesc', 'moduloVisivelMenu', 'moduloPosicao', 'moduloBase', 'moduloClass')
                ->from('_modulo', '')
                ->where($qb->expr()->eq('moduloCod', ':cod'))
                ->setParameter(':cod', $cod);
        
        return $qb;
    }
    
    public function getDadosModuloSql($modulo)
    {

        $qb = $this->con->link()->createQueryBuilder();

        $qb->select('*')
           ->from('_modulo', 'a')
           ->where('a.moduloNome = :moduloNome')
           ->setParameter('moduloNome', $modulo);

        return $qb;     

    }     

}
