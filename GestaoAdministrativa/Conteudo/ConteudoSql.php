<?php

namespace Sappiens\GestaoAdministrativa\Conteudo;

class ConteudoSql
{

    public function filtrarSql($objForm, $filtroDinamico = array())
    {
        $fil = new \Pixel\Filtro\Filtrar($objForm);
        $util = new \Pixel\Crud\CrudUtil();

        $qb = $this->con->link()->createQueryBuilder();

        $qb->select("a.websiteConCod", "a.organogramaCod", "a.websiteDomCod", "a.websiteConCatCod", "a.websiteConReferenteCod", "a.websiteConTitulo", "a.websiteConData", "b.*")
            ->from("website_con", "a")
            ->innerJoin('a', 'website_con_cat', 'b', 'b.websiteConCatCod = a.websiteConCatCod AND b.websiteDomCod = a.websiteDomCod')
            ->where($qb->expr()->isNotNull("a.websiteConCod"));

        $util->getSqlFiltro($fil, $objForm, $filtroDinamico, $qb);

        return $qb;
    }

    public function getDadosSql($cod)
    {
        $qb = $this->con->link()->createQueryBuilder();
        return $qb->select("*")
                ->from("website_con")
                ->where($qb->expr()->eq("websiteConCod", ":websiteConCod"))
                ->setMaxResults(1)
                ->setParameter('websiteConCod', $cod, \PDO::PARAM_INT);
    }
    
    public function getDominiosOrganogramaCod($organogramaCod)
    {
        $qb = $this->con->link()->createQueryBuilder();
        return $qb->select("a.websiteDomCod", "a.websiteDom")
                  ->from("website_dom", "a")
                  ->where($qb->expr()->eq("a.organogramaCod", ':organogramaCod'))
                  ->setParameter('organogramaCod', $organogramaCod, \PDO::PARAM_INT);

    }

    public function getCategoriasWebsiteDomCod($websiteDomCod)
    {
        $qb = $this->con->link()->createQueryBuilder();
        return $qb->select("a.websiteConCatCod", "a.websiteConCat")
                  ->from("website_con_cat", "a")
                  ->where($qb->expr()->eq("a.websiteDomCod", ':websiteDomCod'))
                  ->setParameter('websiteDomCod', $websiteDomCod, \PDO::PARAM_INT);

    }
    
    public function getConteudoReferenteCod($websiteConCatCod)
    {
        $qb = $this->con->link()->createQueryBuilder();
        return $qb->select("a.websiteConCod", "a.websiteConTitulo")
                  ->from("website_con", "a")
                  ->where($qb->expr()->eq("a.websiteConCatCod", ':websiteConCatCod'))
                  ->setParameter('websiteConCatCod', $websiteConCatCod, \PDO::PARAM_INT);

    }
}
