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
