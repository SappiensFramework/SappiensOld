<?php
/**
*
*    Sappiens Framework
*    Copyright (C) 2014, BRA Consultoria
*
*    Website do autor: www.braconsultoria.com.br/sappiens
*    Email do autor: sappiens@braconsultoria.com.br
*
*    Website do projeto, equipe e documentação: www.sappiens.com.br
*   
*    Este programa é software livre; você pode redistribuí-lo e/ou
*    modificá-lo sob os termos da Licença Pública Geral GNU, conforme
*    publicada pela Free Software Foundation, versão 2.
*
*    Este programa é distribuído na expectativa de ser útil, mas SEM
*    QUALQUER GARANTIA; sem mesmo a garantia implícita de
*    COMERCIALIZAÇÃO ou de ADEQUAÇÃO A QUALQUER PROPÓSITO EM
*    PARTICULAR. Consulte a Licença Pública Geral GNU para obter mais
*    detalhes.
* 
*    Você deve ter recebido uma cópia da Licença Pública Geral GNU
*    junto com este programa; se não, escreva para a Free Software
*    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
*    02111-1307, USA.
*
*    Cópias da licença disponíveis em /Sappiens/_doc/licenca
*
*/

namespace Sappiens\Configuracoes\Cidade;

class CidadeSql
{

    private $con;
    private $util;

    public function __construct()
    {

        $this->con = \Zion\Banco\Conexao::conectar();
        $this->util = new \Pixel\Crud\CrudUtil();

    }    

    public function filtrarSql($objForm, $colunas)
    {

        $qb = $this->con->link()->createQueryBuilder();
        $fil = new \Pixel\Filtro\Filtrar($objForm);

        $qb->select('*')
           ->from('uf_cidade', 'a')
           ->innerJoin('a', 'uf', 'b', 'a.ufCod = b.ufCod')
           ->where('1');

        $this->util->getSqlFiltro($fil, $objForm, $colunas, $qb);    

        return $qb;    

    }

    public function getDadosSql($cod)
    {

        $qb = $this->con->link()->createQueryBuilder();

        $qb->select('*')
           ->from('uf_cidade', 'a')
           ->innerJoin('a', 'uf', 'b', 'a.ufCod = b.ufCod')
           ->where('ufCidadeCod = :ufCidadeCod')
           ->setParameters(['ufCidadeCod' => $cod]);

        return $qb;

    }

    public function getDadosGrupoSql()
    {

        $qb = $this->con->link()->createQueryBuilder();

        $qb->select('*')
           ->from('_grupo', 'a')
           ->where('a.grupoPacote = :grupoPacote')
           ->setParameter('grupoPacote', GRUPO);

        return $qb;     

    }

    public function getDadosModuloSql()
    {

        $qb = $this->con->link()->createQueryBuilder();

        $qb->select('*')
           ->from('_modulo', 'a')
           ->where('a.moduloNome = :moduloNome')
           ->setParameter('moduloNome', MODULO);

        return $qb;     

    }    

    public function getUfCod($cod, $modo = '')
    {

        $qb = $this->con->link()->createQueryBuilder();

        if($modo == "alterar") {

          return $qb->select('a.ufCod')
                    ->from('uf_cidade', 'a')
                    ->where($qb->expr()->eq('a.ufCidadeCod', ':ufCidadeCod'))
                    ->setParameter('ufCidadeCod', $cod, \PDO::PARAM_INT);

        }

        return $qb->select('*')
                  ->from('uf', 'a')
                  ->where($qb->expr()->eq('a.paisCod', ':paisCod'))
                  ->setParameter('paisCod', $cod, \PDO::PARAM_INT);

    }    

}
