<?php

namespace Sappiens\Sistema\Modulo;

class ModuloSql
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
                ->where($qb->expr()->eq('moduloCod', '?'))
                ->setParameter(0, $cod);
        
        return $qb;
    }
    
    public function modulosDoGrupoSql($grupoCod)
    {
        $qb = $this->con->link()->createQueryBuilder();

        $qb->select(['moduloCod',
                    'grupoCod',
                    'moduloCodReferente',
                    'moduloNome',
                    'moduloDesc',
                    'moduloNomeMenu',
                    'moduloBase',
                    'moduloVisivelMenu',
                    'moduloClass'])
                ->from('_modulo', '')
                ->where($qb->expr()->eq('grupoCod', '?'))
                ->setParameter(0, $grupoCod)
                ->orderBy('moduloPosicao', 'ASC');

        return $qb;
    }

}
