<?php

namespace Sappiens\Sistema\Modulo;

class ModuloForm
{

    public function getFormFiltro()
    {
        $form = new \Pixel\Form\FormFiltro();

        $form->config('sisFormFiltro');

        $campos[] = $form->suggest('moduloNome', 'Modulo', 'a')
                ->setTabela('_modulo')
                ->setCampoBusca('moduloNome')
                ->setCampoDesc('moduloNome');

        $campos[] = $form->escolha('grupoCod', 'Grupo', 'b')
                ->setTabela('_grupo')
                ->setCampoCod('grupoCod')
                ->setCampoDesc('grupoNome');

        $campos[] = $form->escolha('moduloVisivelMenu', 'Visivel no menu?', 'a')
                ->setTabela('_grupo')
                ->setArray(['S' => 'Sim', 'N' => 'Não']);

        $campos[] = $form->numero('moduloPosicao', 'Posição', 'a');

        return $form->processarForm($campos);
    }

    /**
     * 
     * @return \Pixel\Form\Form
     */
    public function getFormManu($acao, $formCod = null)
    {
        $form = new \Pixel\Form\Form();

        $form->setAcao($acao);

        $form->config('formManu' . $formCod, 'POST')
                ->setHeader('Modulos');

        $campos[] = $form->hidden('cod')
                ->setValor($form->retornaValor('cod'));

        $campos[] = $form->chosen('grupoCod', 'Grupo', true)
                ->setTabela('_grupo')
                ->setCampoCod('grupoCod')
                ->setCampoDesc('grupoNome')
                ->setValor($form->retornaValor('grupoCod'));

        $campos[] = $form->chosen('moduloCodReferente', 'Módulo de Referência', false)
                ->setArray([]) //fake input
                ->setInicio('Sem referência')
                ->setDependencia('grupoCod', 'getFormModulo', __CLASS__)
                ->setValor($form->retornaValor('moduloCodReferente'));

        $campos[] = $form->texto('moduloNome', 'Nome do Módulo', true)
                ->setMaximoCaracteres(70)
                ->setValor($form->retornaValor('moduloNome'));

        $campos[] = $form->texto('moduloNomeMenu', 'Nome no Menu', true)
                ->setMaximoCaracteres(50)
                ->setValor($form->retornaValor('moduloNomeMenu'));

        $campos[] = $form->textArea('moduloDesc', 'Descrição do Módulo', true)
                ->setMaximoCaracteres(250)
                ->setLinhas(4)
                ->setValor($form->retornaValor('moduloDesc'));

        $campos[] = $form->escolha('moduloVisivelMenu', 'Será visivel no menu?', true)
                ->setExpandido(true)
                ->setOrdena(false)
                ->setArray(['S' => 'Sim', 'N' => 'Não'])
                ->setValor($form->retornaValor('moduloVisivelMenu'));

        $campos[] = $form->numero('moduloPosicao', 'Posição', true)
                ->setValorMaximo(99)
                ->setValorMinimo(1)
                ->setValor($form->retornaValor('moduloPosicao'));

        $campos[] = $form->escolha('moduloBase', 'Módulo Base')
                ->setInicio('Nenhum')
                ->setArray(['Sistema' => 'Sistema'])
                ->setValor($form->retornaValor('moduloBase'));

        $campos[] = $form->texto('moduloClass', 'Icone')
                ->setMaximoCaracteres(30)
                ->setToolTipMsg('Deve conter o nome da classe do repositório do Bootstrap ou Fontes Awesome')
                ->setIconFA('fa-font')
                ->setValor($form->retornaValor('moduloClass'));


        $objPai = new \Pixel\Form\Form();
        $objPai->setAcao($acao);

        $inicio = [
            0 => [
                'acaoModuloPermissao' => 'Atualizar',
                'acaoModuloIdPermissao' => 'filtrar',
                'acaoModuloIcon' => 'fa fa-repeat',
                'acaoModuloToolTipComPermissao' => '',
                'acaoModuloToolTipeSemPermissao' => '',
                'acaoModuloFuncaoJS' => 'sisFiltrarPadrao()',
                'acaoModuloPosicao' => '1',
                'acaoModuloApresentacao' => 'E'
            ],
            1 => [
                'acaoModuloPermissao' => 'Visualizar',
                'acaoModuloIdPermissao' => 'visualizar',
                'acaoModuloIcon' => 'fa fa-search',
                'acaoModuloToolTipComPermissao' => '',
                'acaoModuloToolTipeSemPermissao' => '',
                'acaoModuloFuncaoJS' => 'sisVisualizarPadrao()',
                'acaoModuloPosicao' => '2',
                'acaoModuloApresentacao' => 'E'
            ],
            2 => [
                'acaoModuloPermissao' => 'Cadastrar',
                'acaoModuloIdPermissao' => 'cadastrar',
                'acaoModuloIcon' => 'fa fa-plus',
                'acaoModuloToolTipComPermissao' => '',
                'acaoModuloToolTipeSemPermissao' => '',
                'acaoModuloFuncaoJS' => 'sisCadastrarLayoutPadrao()',
                'acaoModuloPosicao' => '3',
                'acaoModuloApresentacao' => 'E'
            ],
            3 => [
                'acaoModuloPermissao' => 'Alterar',
                'acaoModuloIdPermissao' => 'alterar',
                'acaoModuloIcon' => 'fa fa-pencil',
                'acaoModuloToolTipComPermissao' => '',
                'acaoModuloToolTipeSemPermissao' => '',
                'acaoModuloFuncaoJS' => 'sisAlterarLayoutPadrao()',
                'acaoModuloPosicao' => '4',
                'acaoModuloApresentacao' => 'E'
            ],
            4 => [
                'acaoModuloPermissao' => 'Remover',
                'acaoModuloIdPermissao' => 'remover',
                'acaoModuloIcon' => 'fa fa-trash-o',
                'acaoModuloToolTipComPermissao' => '',
                'acaoModuloToolTipeSemPermissao' => '',
                'acaoModuloFuncaoJS' => 'sisRemoverPadrao()',
                'acaoModuloPosicao' => '5',
                'acaoModuloApresentacao' => 'E'
            ],
            5 => [
                'acaoModuloPermissao' => 'Imprimir',
                'acaoModuloIdPermissao' => 'imprimir',
                'acaoModuloIcon' => 'fa fa-print',
                'acaoModuloToolTipComPermissao' => '',
                'acaoModuloToolTipeSemPermissao' => '',
                'acaoModuloFuncaoJS' => 'sisImprimir()',
                'acaoModuloPosicao' => '2',
                'acaoModuloApresentacao' => 'R'
            ],
            6 => [
                'acaoModuloPermissao' => 'Salvar em arquivo PDF',
                'acaoModuloIdPermissao' => 'salvarPDF',
                'acaoModuloIcon' => 'fa fa-file-pdf-o',
                'acaoModuloToolTipComPermissao' => '',
                'acaoModuloToolTipeSemPermissao' => '',
                'acaoModuloFuncaoJS' => 'sisSalvarPDF()',
                'acaoModuloPosicao' => '1',
                'acaoModuloApresentacao' => 'R'
            ]
        ];

        $confCampos = [
            'acaoModuloPermissao' => $objPai->texto('acaoModuloPermissao', 'Permissão', true)
                    ->setEmColunaDeTamanho(6),
            'acaoModuloIdPermissao' => $objPai->texto('acaoModuloIdPermissao', 'Id da Permissão', true)
                    ->setEmColunaDeTamanho(6),
            'acaoModuloIcon' => $objPai->texto('acaoModuloIcon', 'Ícone', true)
                    ->setEmColunaDeTamanho(6),
            'acaoModuloToolTipComPermissao' => $objPai->texto('acaoModuloToolTipComPermissao', 'Tooltip c/ Permissão', false)
                    ->setEmColunaDeTamanho(6),
            'acaoModuloToolTipeSemPermissao' => $objPai->texto('acaoModuloToolTipeSemPermissao', 'Tooltip c/ Permissão', false)
                    ->setEmColunaDeTamanho(6),
            'acaoModuloFuncaoJS' => $objPai->texto('acaoModuloFuncaoJS', 'Função JS', true)
                    ->setEmColunaDeTamanho(6),
            'acaoModuloPosicao' => $objPai->numero('acaoModuloPosicao', 'Posição', true)
                    ->setEmColunaDeTamanho(6),
            'acaoModuloApresentacao' => $objPai->chosen('acaoModuloApresentacao', 'Apresentação', true)
                    ->setEmColunaDeTamanho(6)
                    ->setArray(['E' => 'Expandido', 'R' => 'Recolhido', 'I' => 'Acao invisivel'])];

        $campos[] = $form->masterDetail('acoes', 'Ações do módulo')
                ->setTabela('_acao_modulo')
                ->setCodigo('acaoModuloCod')
                ->setCampoReferencia('moduloCod')
                ->setCodigoReferencia($formCod)
                ->setObjetoPai($objPai)
                ->setObjetoRemover(new \Sappiens\Sistema\Permissao\PermissaoClass(), 'removerPorAcaoModuloCod')
                ->setTotalItensInicio(7)
                ->setValorItensDeInicio($inicio)
                ->setCampos($confCampos);

        $campos[] = $form->botaoSalvarPadrao();

        $campos[] = $form->botaoDescartarPadrao();

        return $form->processarForm($campos);
    }

    public function getFormModulo($referenciaCod)
    {
        $form = new \Pixel\Form\Form();
        $con = \Zion\Banco\Conexao::conectar();

        $qb = $con->link()->createQueryBuilder();

        $qb->select('moduloCod', 'moduloNome')
                ->from('_modulo', '')
                ->where($qb->expr()->eq('grupoCod', '?'))
                ->setParameter(0, $referenciaCod);

        $campos[] = $form->escolha('moduloCodReferente', 'Módulo de Referência')
                ->setInicio('Sem referência')
                ->setCampoCod('moduloCod')
                ->setCampoDesc('moduloNome')
                ->setSqlCompleto($qb);

        return $form->processarForm($campos);
    }

    public function getJSEstatico()
    {
        $jsStatic = \Pixel\Form\FormJavaScript::iniciar();

        $jQuery = new \Zion\JQuery\JQuery();

        $mudaPosicao = $jQuery->ajax()
                ->getJSON()
                ->setUrl('?acao=mudaPosicao')
                ->setData("{'moduloCod':moduloCod,'maisMenos':maisMenos}")
                ->setFuncao('mudaPosicao(moduloCod, maisMenos)')
                ->setDone("if (ret.sucesso === 'true') { $('#moduloPosicao'+moduloCod).html(ret.retorno); } else { sisSetCrashAlert('Erro', ret.retorno); }")
                ->setFail('sisMsgFailPadrao();')
                ->criar();

        $jsStatic->setFunctions($mudaPosicao);

        return $jsStatic->getFunctions();
    }

}
