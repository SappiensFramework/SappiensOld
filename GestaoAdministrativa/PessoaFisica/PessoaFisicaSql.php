<?php

namespace Sappiens\GestaoAdministrativa\PessoaFisica;

class PessoaFisicaSql
{

    public function filtrarSql($objForm, $colunas)
    {
        $fil = new \Pixel\Filtro\Filtrar($objForm);
        $util = new \Pixel\Crud\CrudUtil();

        $sql = "SELECT *,
                       CASE 
                            WHEN a.pessoaFisicaStatus = 'A' THEN 'Ativo'
                            WHEN a.pessoaFisicaStatus = 'I' THEN 'Inativo'
                       END AS pessoaFisicaStatus
	              FROM pessoa_fisica a
	             WHERE a.organogramaCod = ". $_SESSION['organogramaCod'];

        $sql .= $util->getSqlFiltro($fil, $objForm, $colunas);

        return $sql;
    }

    public function getDadosSql($cod)
    {
        return "SELECT *
                  FROM pessoa_fisica
                 WHERE pessoaFisicaCod = ".$cod;
    } 

    public function getCamposSql($cod)
    {
        return "SELECT *
                  FROM pessoa_documento_tipo
                 WHERE pessoaDocumentoTipoReferenciaCod = ".$cod;
    }    

    public function getRelacionamento($cod, $modo = 'select')
    {

      if($modo == 'select') {
        
        return "SELECT *
                  FROM pessoa_documento_tipo_relacionamento
                 WHERE pessoaDocumentoTipoCod = ".$cod;

      } elseif($modo == 'input') {

        return "SELECT *
                  FROM pessoa_documento_tipo
                 WHERE pessoaDocumentoTipoCod = ".$cod;

      }

      return false;

    }      

    public function getValorSql($cod, $pessoaCod, $modo = '')
    {

      if($modo == "suggest") {

        return "SELECT *
                  FROM pessoa_documento a, pessoa_documento_tipo_relacionamento b
                 WHERE a.organogramaCod = " . $_SESSION['organogramaCod'] . " 
                   AND a.pessoaCod = " . $pessoaCod . "
                   AND a.pessoaDocumentoTipoCod = " . $cod . "
                   AND a.pessoaDocumentoTipoCod = b.pessoaDocumentoTipoCod
                   AND a.pessoaDocumentoStatus LIKE 'A'
              ORDER BY a.pessoaDocumentoCod DESC";

      }

        return "SELECT *
                  FROM pessoa_documento a
                 WHERE a.organogramaCod = " . $_SESSION['organogramaCod'] . " 
                   AND a.pessoaCod = " . $pessoaCod . "
                   AND a.pessoaDocumentoTipoCod = " . $cod . "
                   AND a.pessoaDocumentoStatus LIKE 'A'
              ORDER BY a.pessoaDocumentoCod DESC";
    }     

    public function getValorSuggest($array)
    {

      if(is_array($array)) {

        $cod            = $array['pessoaDocumentoValor'];
        $tabela         = $array['pessoaDocumentoTipoRelacionamentoTabelaNome'];
        $chavePrimaria  = $array['pessoaDocumentoTipoRelacionamentoTabelaChave'];
        $colunaNome     = $array['pessoaDocumentoTipoRelacionamentoTabelaColunaNome'];

        return "SELECT " . $colunaNome . "
                  FROM " . $tabela . "
                 WHERE " . $chavePrimaria . " = " . $cod;

      }

      return false;

    }    

    public function getValorPersistencia($cod, $pessoaCod)
    {

        return "SELECT *
                  FROM pessoa_documento a
                 WHERE a.organogramaCod = " . $_SESSION['organogramaCod'] . " 
                   AND a.pessoaCod = " . $pessoaCod . "
                   AND a.pessoaDocumentoTipoCod = " . $cod . "
                   AND a.pessoaDocumentoStatus LIKE 'A'
              ORDER BY a.pessoaDocumentoCod DESC
                 LIMIT 1";
    }     

    public function setDocumentoInativo($pessoaDocumentoTipoCod, $pessoaCod, $pessoaDocumentoCod)
    {

        return "UPDATE pessoa_documento
                   SET pessoaDocumentoStatus = 'I'
                 WHERE organogramaCod = " . $_SESSION['organogramaCod'] . " 
                   AND pessoaCod = " . $pessoaCod . "
                   AND pessoaDocumentoTipoCod = " . $pessoaDocumentoTipoCod;

    }     

}
