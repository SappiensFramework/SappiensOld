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

namespace Sappiens\Grupo\Modulo;

class ModuloClass extends ModuloSql
{

    public $chavePrimaria;
    public $crudUtil;
    public $tabela;
    public $prefixo;
    private $colunasCrud;
    private $colunasGrid;
    private $filtroDinamico;

    public function __construct()
    {

        parent::__construct();
        $this->crudUtil = new \Pixel\Crud\CrudUtil();

        $this->tabela = 'uf';
        $this->prefixo = 'uf';
        $this->chavePrimaria = $this->prefixo . 'Cod';

        $this->colunasCrud = [
            $this->prefixo . 'Sigla',
            $this->prefixo . 'Nome',
            $this->prefixo . 'IbgeCod',
            $this->prefixo . 'TextArea',
            $this->prefixo . 'Descricao',
            $this->prefixo . 'EscolhaSelect',
            $this->prefixo . 'ChosenSimples',
            $this->prefixo . 'Chosenmultiplo[]',
            $this->prefixo . 'EscolhaVarios[]',
            $this->prefixo . 'EscolhaDois',
            $this->prefixo . 'MarqueUm'
        ];

        $this->colunasGrid = [
            $this->prefixo . 'Cod' => "Cód",
            $this->prefixo . 'Sigla' => "Sigla",
            $this->prefixo . 'Nome' => "Nome"
        ];
        
        $this->filtroDinamico = [
            $this->prefixo . 'Cod' => "",
            $this->prefixo . 'Sigla' => "",
            $this->prefixo . 'Nome' => ""
        ];
    }

    public function filtrar($objForm)
    {
        $grid = new \Pixel\Grid\GridPadrao();

        \Zion\Paginacao\Parametros::setParametros("GET", $this->crudUtil->getParametrosGrid($objForm));
        
        $grid->setColunas($this->colunasGrid);

        $grid->setSql(parent::filtrarSql($objForm, $this->filtroDinamico));
        $grid->setChave($this->chavePrimaria);
        //$grid->setSelecaoMultipla(false);

        return $grid->montaGridPadrao();
    }

    public function cadastrar($objForm)
    {
        return $this->crudUtil->insert($this->tabela, $this->colunasCrud, $objForm);
    }

    public function alterar($objForm)
    {
        return $this->crudUtil->update($this->tabela, $this->colunasCrud, $objForm, $this->chavePrimaria);
    }

    public function remover($cod)
    {
        return $this->crudUtil->delete($this->tabela, $cod, $this->chavePrimaria);
    }

    public function setValoresFormManu($cod, $formIntancia)
    {
        $con = \Zion\Banco\Conexao::conectar();

        $objForm = $formIntancia->getFormManu('alterar', $cod);

        $parametrosSql = $con->execLinhaArray(parent::getDadosSql($cod));

        $this->crudUtil->setParametrosForm($objForm, $parametrosSql, $cod);

        return $objForm;
    }
    
    public function setValoresFormManu2($cod, $formIntancia)
    {
        $con = \Zion\Banco\Conexao::conectar();

        $objForm = $formIntancia->getFormManu2('alterar', $cod);

        $parametrosSql = $con->execLinhaArray(parent::getDadosSql($cod));

        $objetos = $objForm->getObjetos();

        //Intervenção para o campo escolha
        $objetos['ufEscolhaVarios[]']->setValor(\explode(',', $parametrosSql['ufescolhavarios']));

        //Intervenção para o campo chosen
        $objetos['ufChosenmultiplo[]']->setValor(\explode(',', $parametrosSql['ufchosenmultiplo']));

        $this->crudUtil->setParametrosForm($objForm, $parametrosSql, $cod);

        return $objForm;
    }

}
