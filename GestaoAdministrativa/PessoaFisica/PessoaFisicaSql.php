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

}
