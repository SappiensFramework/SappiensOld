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

namespace Sappiens\Configuracoes\Organograma;

class OrganogramaSql
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
           ->from('organograma', 'a')
           ->innerJoin('a', 'organograma_classificacao', 'b', 'a.organogramaClassificacaoCod = b.organogramaClassificacaoCod')
           ->where('INSTR(a.organogramaAncestral,CONCAT("|", ' . $_SESSION['organogramaCod'] . ',"|")) > 0');

        $this->util->getSqlFiltro($fil, $objForm, $colunas, $qb);    

        return $qb;    
/*
        $sql = "SELECT *,
                       CASE 
                            WHEN a.organogramaStatus = 'A' THEN 'Ativo'
                            WHEN a.organogramaStatus = 'I' THEN 'Inativo'
                       END AS organogramaStatus
	              FROM organograma a, organograma_classificacao b
	             WHERE INSTR(a.organogramaAncestral,CONCAT('|', " . $_SESSION['organogramaCod'] . ",'|')) > 0
                 AND a.organogramaClassificacaoCod = b.organogramaClassificacaoCod ";

        $sql .= $util->getSqlFiltro($fil, $objForm, $colunas);

        return $sql;
*/        
    }

    public function getDadosSql($cod)
    {
        return "SELECT *
                  FROM  organograma
                 WHERE  organogramaCod = ".$cod;
    }

    public function getOrdem($cod, $modo = '')
    {

        $sqlAdd = '';
        if($modo == 'referencia') {
            $sqlAdd = "Referencia";
        }
            return "SELECT MAX(organogramaOrdem) AS ordemAtual
                      FROM organograma
                     WHERE organograma".$sqlAdd."Cod = ".$cod;

    }

    public function getOrganogramaClassificacaoCod($cod)
    {
        return "SELECT organogramaClassificacaoCod chave, CONCAT(organogramaClassificacaoNome) valor
                  FROM organograma_classificacao
                 WHERE organogramaClassificacaoTipoCod = ".$cod;
    }    

    public function getOrganogramaClassificacaoCodByOrganogramaCod($cod)
    {
        return "SELECT organogramaClassificacaoCod
                  FROM organograma
                 WHERE organogramaCod = ".$cod;
    }     

    public function getOrganogramaClassificacaoTipoCodByOrganogramaClassificacaoCod($cod)
    {
        return "SELECT organogramaClassificacaoTipoCod
                  FROM organograma_classificacao
                 WHERE organogramaClassificacaoCod = ".$cod;
    }    

    public function getOrganogramaClassificacaoCodByOrganogramaClassificacaoTipoCod($cod)
    {
        return "SELECT a.organogramaClassificacaoCod chave, CONCAT(a.organogramaClassificacaoNome) valor
                  FROM organograma_classificacao a
                 WHERE a.organogramaClassificacaoTipoCod = ".$cod;
    }     

    public function getClassificacaoReordenavel($cod)
    {
        return "SELECT organogramaClassificacaoReordenavel
                  FROM organograma a, organograma_classificacao b
                 WHERE a.organogramaCod = ".$cod." 
                   AND a.organogramaClassificacaoCod = b.organogramaClassificacaoCod";
    }      

    public function getOrganogramaClassificacaoByReferencia($cod)
    {
        return "SELECT organogramaClassificacaoCod chave, CONCAT(organogramaClassificacaoNome) valor
                  FROM organograma_classificacao
                 WHERE INSTR(organogramaClassificacaoAncestral,CONCAT('|', " . $cod . ",'|')) > 1";
    }     

}
