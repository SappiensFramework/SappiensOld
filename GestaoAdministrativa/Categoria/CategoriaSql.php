<?php

namespace Sappiens\GestaoAdministrativa\Categoria;

class CategoriaSql
{

    public function filtrarSql($objForm, $filtroDinamico = array())
    {
        $fil = new \Pixel\Filtro\Filtrar($objForm);
        $util = new \Pixel\Crud\CrudUtil();

        $qb = $this->con->link()->createQueryBuilder();

        $qb->select("a.*", "b.*")
            ->from("website_con_cat", "a")
            ->innerJoin('a', 'website_dom', 'b', 'b.organogramaCod = a.organogramaCod')
            ->where($qb->expr()->isNotNull("a.websiteConCatCod"));

        $util->getSqlFiltro($fil, $objForm, $filtroDinamico, $qb);
        return $qb;
    }

    public function getDadosSql($cod)
    {
        $qb = $this->con->link()->createQueryBuilder();
        return $qb->select("*")
                ->from("website_con_cat")
                ->where($qb->expr()->eq("websiteConCatCod", ":websiteConCatCod"))
                ->setMaxResults(1)
                ->setParameter('websiteConCatCod', $cod, \PDO::PARAM_INT);
    }
    
    public function getDominiosOrganogramaCod($organogramaCod)
    {
        $qb = $this->con->link()->createQueryBuilder();
        return $qb->select("a.websiteDomCod", "a.websiteDom")
                  ->from("website_dom", "a")
                  ->where($qb->expr()->eq("a.organogramaCod", ':organogramaCod'))
                  ->setParameter('organogramaCod', $organogramaCod, \PDO::PARAM_INT);

    }

}
