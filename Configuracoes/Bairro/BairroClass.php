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

namespace Sappiens\Configuracoes\Bairro;

class BairroClass extends BairroSql
{
    
    private $chavePrimaria;
    private $tabela;
    private $precedencia;
    private $colunas;
    private $colunasGrid;
    private $con;
    
    public function __construct()
    {

        parent::__construct();

        $this->crudUtil = new \Pixel\Crud\CrudUtil();
        $this->con = \Zion\Banco\Conexao::conectar();

        $this->tabela           = 'uf_cidade_bairro';        
        $this->precedencia      = 'ufCidadeBairro';                   
        $this->chavePrimaria    = $this->precedencia . 'Cod';
        $this->colunasCrud = [
                                         'ufCidadeCod',
                    $this->precedencia . 'Nome'
        ];
        
        $this->colunasGrid = [                 
            
                    $this->precedencia  . 'Nome'              => 'Bairro',
                                          'ufCidadeNome'      => 'Cidade',
                                          'ufNome'            => 'Estado'
        ];    
        $this->filtroDinamico = [
            $this->precedencia . 'Nome'             => "a",
                                 'ufCidadeCod'      => "b",
                                 'ufCod'            => "c"
        ];

    }   

    public function getParametrosGrid($objForm)
    {
        $fil = new \Pixel\Filtro\Filtrar();

        $padrao = ["pa", "qo", "to"];

        $meusParametros = $this->crudUtil->getParametrosForm($objForm);
        $hiddenParametros = $fil->getHiddenParametros($meusParametros);

        return array_merge($padrao, $meusParametros, $hiddenParametros);

    }

    public function filtrar($objForm)
    {

        $grid = new \Pixel\Grid\GridPadrao();

        \Zion\Paginacao\Parametros::setParametros("GET", $this->getParametrosGrid($objForm));

        $grid->setColunas($this->colunasGrid);

        //$grid->setSql(parent::filtrarSql($objForm,$this->colunasGrid));
        $grid->setSql(parent::filtrarSql($objForm, $this->filtroDinamico));
        $grid->setChave($this->chavePrimaria);
        $grid->setSelecaoMultipla(true);
        //$grid->setAlinhamento(array('organogramaOrdem' => 'DIREITA'));
        $grid->setTipoOrdenacao(filter_input(INPUT_GET, 'to'));
        $grid->setQuemOrdena(filter_input(INPUT_GET, 'qo'));
        $grid->setPaginaAtual(filter_input(INPUT_GET, 'pa'));

        return $grid->montaGridPadrao();

    }

    public function cadastrar($objForm)
    {
        return $this->crudUtil->insert($this->tabela, $this->colunasCrud, $objForm);

    }
    
    public function alterar($objForm)
    {
        return $this->crudUtil->update($this->tabela, $this->colunasCrud, $objForm, [$this->chavePrimaria => $objForm->getObjetos("cod")->getValor()]);

    }
    
    public function remover($cod)
    {
        return $this->crudUtil->delete($this->tabela, [$this->chavePrimaria => $cod]);

    }

    public function setValoresFormManu($cod, $formInstancia)
    {

        $objForm = $formInstancia->getFormManu('alterar', $cod);
        $parametrosSql = $this->con->execLinhaArray(parent::getDadosSql($cod));
        $objetos = $objForm->getObjetos();

        $this->crudUtil->setParametrosForm($objForm, $parametrosSql, $cod);

        return $objForm;

    }

    public function getDadosGrupo()
    {
        
        return $this->con->execLinhaArray(parent::getDadosGrupoSql());

    }     

    public function getDadosModulo()
    {
        
        return $this->con->execLinhaArray(parent::getDadosModuloSql());

    }     

    public function getUfCod($cod, $modo = '')
    {

        return ($modo == "alterar") ? $this->con->execRLinha(parent::getUfCod($cod, $modo)) : $this->con->paraArray(parent::getUfCod($cod, $modo));

    }    
    public function getCidadeEstadoFiltro($ufCod)
    {
        return $this->con->paraArray(parent::getCidadeEstadoFiltroSql($ufCod));
    }
    
    public function getBairroCidadeFiltro($ufCidadeCod)
    {
        return $this->con->paraArray(parent::getBairroCidadeFiltroSql($ufCidadeCod));
    }

}