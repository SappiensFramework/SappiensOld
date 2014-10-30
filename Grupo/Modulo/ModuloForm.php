<?php

namespace Sappiens\Grupo\Modulo;

class ModuloForm
{

    public function getFormFiltro()
    {
        $form = new \Pixel\Form\Form();

        $form->config('formFiltro', 'GET');

        $campos[] = $form->suggest('uf', 'Unidade Federativa')
                ->setTabela('uf')                
                ->setCampoBusca('ufNome')
                ->setCampoDesc('ufNome')
                ->setEmColunaDeTamanho(10);

        $campos[] = $form->botaoSubmit('enviar', 'Enviar')
                ->setClassCss('btn btn-primary');

        return $form->processarForm($campos);
    }

    /**
     * 
     * @return \Pixel\Form\Form
     */
    public function getFormManu($acao, $cod = null)
    {
        $form = new \Pixel\Form\Form();

        $form->setAcao($acao);

        $form->config('formManu' . $cod, 'POST')
                ->setHeader('Estados');

        $campos[] = $form->hidden('cod')
                ->setValor($form->retornaValor('cod'));

        $campos[] = $form->texto('ufSigla', 'Sigla da Unidade Federativa', true)
                ->setMaximoCaracteres(2)
                ->setMinimoCaracteres(2)
                ->setCaixa('ALTA')
                ->setValor($form->retornaValor('ufSigla'));

        $campos[] = $form->texto('ufNome', 'Nome da Unidade Federativa', false)
                ->setMaximoCaracteres(100)
                ->setValor($form->retornaValor('ufNome'));

        $campos[] = $form->numero('ufIbgeCod', 'Código do IBGE', true)
                ->setValor($form->retornaValor('ufNome'))
                ->setMaximoCaracteres(10)
                ->setValor($form->retornaValor('ufIbgeCod'));

        $campos[] = $form->botaoSubmit('enviar', 'Salvar')
                ->setClassCss('btn btn-primary');

        $campos[] = $form->botaoReset('limpar', 'Limpar')
                ->setClassCss('btn btn-default');

        return $form->processarForm($campos);
    }

    public function getJSEstatico()
    {
        $jsStatic = \Pixel\Form\FormJavaScript::iniciar();

        $jQuery = new \Zion\JQuery\JQuery();

        //Filtrar
        $jsStatic->setFunctions(
                $jQuery->ajax()
                        ->get()
                        ->setUrl('?acao=filtrar')
                        ->setDataType('json')
                        ->setData('p')
                        ->setDone(' $("#sisContainerGrid").html(ret.retorno); ')
                        ->setFuncao('sisFiltrar(p)')
                        ->criar());

        //Layout do Cadastro
        $jsStatic->setFunctions(
                $jQuery->ajax()
                        ->get()
                        ->setUrl('?acao=cadastrar')
                        ->setDataType('json')
                        ->setDone(' $("#sisContainerManu").html(ret.retorno); ')
                        ->setFuncao('sisCadastrarLayout()')
                        ->criar());

        //Efetivar o cadastro no banco de dados
        $jsStatic->setFunctions(
                $jQuery->ajax()
                        ->post()
                        ->setData('$("#"+nomeForm).serialize()')
                        ->setUrl('?acao=cadastrar')
                        ->setDataType('json')
                        ->setDone(' setAlert(ret.sucesso, ret.retorno); ')
                        ->setFuncao('sisCadastrar(nomeForm)')
                        ->criar());

        //Layout da Alteração
        $jsStatic->setFunctions(
                $jQuery->ajax()
                        ->get()
                        ->setUrl('?acao=alterar')
                        ->setDataType('json')
                        ->setData('$("#formGrid").serialize()')
                        ->setDone(' $("#sisContainerManu").html(ret.retorno); ')
                        ->setFuncao(' sisAlterarLayout()')
                        ->criar());

        //Efetivar a alteração no banco de dados
        $jsStatic->setFunctions(
                $jQuery->ajax()
                        ->post()
                        ->setData('$("#"+nomeForm).serialize()')
                        ->setUrl('?acao=alterar')
                        ->setDataType('json')
                        ->setDone(' setAlert(ret.sucesso, ret.retorno); ')
                        ->setFuncao('sisAlterar(nomeForm)')
                        ->criar());

        //Efetivar remoção do banco
        $jsStatic->setFunctions(
                $jQuery->ajax()
                        ->post()
                        ->setData('$("#formGrid").serialize()')
                        ->setUrl('?acao=remover')
                        ->setDataType('json')
                        ->setDone(' sisRetornoRemover(ret) ')
                        ->setFuncao('sisApagar()')
                        ->criar());

        //Visualizar registros
        $jsStatic->setFunctions(
                $jQuery->ajax()
                        ->get()
                        ->setUrl('?acao=visualizar')
                        ->setDataType('json')
                        ->setData('$("#formGrid").serialize()')
                        ->setDone(' $("#sisContainerManu").html(ret.retorno); ')
                        ->setFuncao('sisVisualizar()')
                        ->criar());


        $jsStatic->sisCadastrar('sisCadastrar(nomeForm)');
        $jsStatic->sisAlterar('sisAlterar(nomeForm)');

        return $jsStatic->getFunctions();
    }

}
