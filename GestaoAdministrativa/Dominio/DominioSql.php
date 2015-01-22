<?php

namespace Sappiens\GestaoAdministrativa\Dominio;

class DominioSql
{

    public function filtrarSql($objForm, $filtroDinamico = array())
    {
        $fil = new \Pixel\Filtro\Filtrar($objForm);
        $util = new \Pixel\Crud\CrudUtil();

        $qb = $this->con->link()->createQueryBuilder();
        
        $sql = $qb->select("websiteDomCod", "organogramaCod", "websiteDom", "websiteDomEmail", "websiteDomNomeAbreviado", "websiteDomNomeExtenso", "websiteDomDescricao", "websiteDomPalavrasChave", "websiteDomStatus")
                  ->from("website_dom")
                  ->where($qb->expr()->isNotNull("websiteDomCod"));

        $sql .= $util->getSqlFiltro($fil, $objForm, $filtroDinamico, $this->con->link()->createQueryBuilder());        
        
        return $sql;
    }

    public function getDadosSql($cod)
    {
        $qb = $this->con->link()->createQueryBuilder();
        return $qb->select("*")
                ->from("website_dom")
                ->where($qb->expr()->eq("websiteDomCod", ":websiteDomCod"))
                ->setMaxResults(1)
                ->setParameter('websiteDomCod', $cod, \PDO::PARAM_INT);
    }
}
