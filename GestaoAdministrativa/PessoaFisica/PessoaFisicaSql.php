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

namespace Sappiens\GestaoAdministrativa\PessoaFisica;

class PessoaFisicaSql
{

    private $con;
    private $util;

    public function __construct()
    {

        $this->con = \Zion\Banco\Conexao::conectar();
        $this->util = new \Pixel\Crud\CrudUtil();

    }  

    public function filtrarSql($objForm, $filtroDinamico = array())
    {

        $qb = $this->con->link()->createQueryBuilder();
        $fil = new \Pixel\Filtro\Filtrar($objForm);

        $qb->select('*')
           ->from('pessoa_fisica', 'a')
           ->where($qb->expr()->eq('a.organogramaCod', 'a.organogramaCod'))
           ->setParameter('a.organogramaCod', $_SESSION['organogramaCod'], \PDO::PARAM_INT);

        $this->util->getSqlFiltro($fil, $objForm, $filtroDinamico, $qb);

        return $qb;
    }

    public function getDadosSql($cod)
    {

        $qb = $this->con->link()->createQueryBuilder();

        $qb->select('*')
           ->from('pessoa_fisica', 'a')
           ->where($qb->expr()->eq('a.pessoaFisicaCod', ':pessoaFisicaCod'))
           ->setParameter('pessoaFisicaCod', $cod, \PDO::PARAM_INT);

        return $qb;

    } 

    public function getCamposSql($cod)
    {

        $qb = $this->con->link()->createQueryBuilder();

        $qb->select('*')
           ->from('pessoa_documento_tipo', 'a')
           ->where('a.pessoaDocumentoTipoReferenciaCod = :pessoaDocumentoTipoReferenciaCod')
           ->setParameter('pessoaDocumentoTipoReferenciaCod', $cod, \PDO::PARAM_INT);

        return $qb;

    }    

    public function getRelacionamento($cod, $modo = 'select')
    {

        $qb = $this->con->link()->createQueryBuilder();

        if($modo == 'select') {

            $qb->select('*')
               ->from('pessoa_documento_tipo_relacionamento', 'a')
               ->where('a.pessoaDocumentoTipoCod = :pessoaDocumentoTipoCod')
               ->setParameter('pessoaDocumentoTipoCod', $cod, \PDO::PARAM_INT);   

            return $qb;         

        } elseif($modo == 'input') {

            $qb->select('*')
               ->from('pessoa_documento_tipo', 'a')
               ->where('a.pessoaDocumentoTipoCod = :pessoaDocumentoTipoCod')
               ->setParameter('pessoaDocumentoTipoCod', $cod, \PDO::PARAM_INT); 

            return $qb;

        }

        return false;

    }      

    public function getValorSql($cod, $pessoaCod, $modo = '')
    {

        $qb = $this->con->link()->createQueryBuilder();

        if($modo == "suggest") {         

            $qb->select('*')
               ->from('pessoa_documento', 'a')
               ->innerJoin('a', 'pessoa_documento_tipo_relacionamento', 'b', 'a.pessoaDocumentoTipoCod = b.pessoaDocumentoTipoCod')
               ->where($qb->expr()->eq('a.organogramaCod',':organogramaCod'))
               ->andWhere($qb->expr()->eq('a.pessoaCod',':pessoaCod'))
               ->andWhere($qb->expr()->eq('a.pessoaDocumentoTipoCod',':pessoaDocumentoTipoCod'))
               ->andWhere($qb->expr()->like('a.pessoaDocumentoStatus', $qb->expr()->literal('A')))
               ->setParameters(['organogramaCod' => $_SESSION['organogramaCod'], 'pessoaCod' => $pessoaCod, 'pessoaDocumentoTipoCod' => $cod])
               ->orderBy('a.pessoaDocumentoCod', 'DESC');   

            return $qb;                

        }

        $qb->select('*')
           ->from('pessoa_documento', 'a')
           ->where($qb->expr()->eq('a.organogramaCod',':organogramaCod'))
           ->andWhere($qb->expr()->eq('a.pessoaCod',':pessoaCod'))
           ->andWhere($qb->expr()->eq('a.pessoaDocumentoTipoCod',':pessoaDocumentoTipoCod'))
           ->andWhere($qb->expr()->like('a.pessoaDocumentoStatus', $qb->expr()->literal('A')))
           ->setParameters(['organogramaCod' => $_SESSION['organogramaCod'], 'pessoaCod' => $pessoaCod, 'pessoaDocumentoTipoCod' => $cod])
           ->orderBy('a.pessoaDocumentoCod', 'DESC');

        return $qb;        
              
    }     

    public function getValorSuggest($array)
    {

        $qb = $this->con->link()->createQueryBuilder();

        if(is_array($array)) {

            $cod            = $array['pessoadocumentovalor'];
            $tabela         = $array['pessoadocumentotiporelacionamentotabelanome'];
            $chavePrimaria  = $array['pessoadocumentotiporelacionamentotabelachave'];
            $colunaNome     = $array['pessoadocumentotiporelacionamentotabelacolunanome'];

            $qb->select($colunaNome)
               ->from($tabela, 'a')
               ->where($qb->expr()->eq($chavePrimaria,':cod'))
               ->setParameter('cod', $cod); 

            return $qb;                         

        }

      return false;

    }    

    public function getValorPersistencia($cod, $pessoaCod)
    {

        $qb = $this->con->link()->createQueryBuilder();

        $qb->select('*')
           ->from('pessoa_documento', 'a')
           ->where($qb->expr()->eq('a.organogramaCod',':organogramaCod'))
           ->andWhere($qb->expr()->eq('a.pessoaCod',':pessoaCod'))
           ->andWhere($qb->expr()->eq('a.pessoaDocumentoTipoCod',':pessoaDocumentoTipoCod'))
           ->andWhere($qb->expr()->like('a.pessoaDocumentoStatus', $qb->expr()->literal('A')))
           ->setParameters(['organogramaCod' => $_SESSION['organogramaCod'], 'pessoaCod' => $pessoaCod, 'pessoaDocumentoTipoCod' => $cod])
           ->orderBy('a.pessoaDocumentoCod', 'DESC')
           ->setFirstResult(0)
           ->setMaxResults(1);    

        return $qb;    
/*
        return "SELECT *
                  FROM pessoa_documento a
                 WHERE a.organogramaCod = " . $_SESSION['organogramaCod'] . " 
                   AND a.pessoaCod = " . $pessoaCod . "
                   AND a.pessoaDocumentoTipoCod = " . $cod . "
                   AND a.pessoaDocumentoStatus LIKE 'A'
              ORDER BY a.pessoaDocumentoCod DESC
                 LIMIT 1";
*/                 
    }     

    public function setDocumentoInativo($pessoaDocumentoTipoCod, $pessoaCod, $pessoaDocumentoCod)
    {

        $qb = $this->con->link()->createQueryBuilder();

        $qb->update('pessoa_documento', 'a')
           ->set('a.pessoaDocumentoStatus', 'I')
           ->where($qb->expr()->eq('a.organogramaCod',':organogramaCod'))
           ->andWhere($qb->expr()->eq('a.pessoaCod',':pessoaCod'))
           ->andWhere($qb->expr()->eq('a.pessoaDocumentoTipoCod',':pessoaDocumentoTipoCod'))
           ->setParameters(['organogramaCod' => $_SESSION['organogramaCod'], 'pessoaCod' => $pessoaCod, 'pessoaDocumentoTipoCod' => $pessoaDocumentoTipoCod]);     

        return $qb;   
/*
        return "UPDATE pessoa_documento
                   SET pessoaDocumentoStatus = 'I'
                 WHERE organogramaCod = " . $_SESSION['organogramaCod'] . " 
                   AND pessoaCod = " . $pessoaCod . "
                   AND pessoaDocumentoTipoCod = " . $pessoaDocumentoTipoCod;
*/
    }     

    public function setUploadCodReferencia($pessoaDocumentoTipoCod, $pessoaDocumentoCod)
    {

        $qb = $this->con->link()->createQueryBuilder();

        $qb->update('_upload', 'a')
           ->set('a.uploadCodReferencia', $pessoaDocumentoTipoCod)
           ->where($qb->expr()->eq('a.uploadCodReferencia',':pessoaDocumentoCod'))
           ->setParameter('pessoaDocumentoCod', $pessoaDocumentoCod);

        return $qb;       
/*
        return "UPDATE _upload
                   SET uploadCodReferencia = " . $pessoaDocumentoTipoCod . "
                 WHERE uploadCodReferencia = " . $pessoaDocumentoCod;
*/                 

    } 

}
