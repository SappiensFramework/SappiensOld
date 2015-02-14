<?php

namespace Sappiens\Sistema\Usuario;

class UsuarioForm
{

    public function getFormFiltro()
    {
        $form = new \Pixel\Form\FormFiltro();

        $form->config('sisFormFiltro');

        $campos[] = $form->suggest('usuarioLogin', 'Login','a')
                ->setTabela('_usuario')
                ->setCampoBusca('usuarioLogin')
                ->setCampoDesc('usuarioLogin');

        $campos[] = $form->chosen('perfilCod', 'Perfil','a')
                ->setTabela('_perfil')
                ->setCampoCod('perfilCod')
                ->setCampoDesc('perfilNome');       

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
                ->setHeader('Usuarios');

        $campos[] = $form->hidden('cod')
                ->setValor($form->retornaValor('cod'));

        $campos[] = $form->chosen('organogramaCod', 'Órgão', true)
                ->setValor($form->retornaValor('organogramaCod'))
                ->setMultiplo(false)
                ->setCampoCod('campoCod')
                ->setOrdena(false)
                ->setSqlCompleto("SELECT a.organogramaCod AS campoCod, IF(a.organogramaOrdem != \"\",CONCAT(a.organogramaOrdem, \" - \", a.organogramaNome, \" [\", b.organogramaClassificacaoNome,\"]\"), a.organogramaNome) AS campoDesc
                                    FROM organograma a, organograma_classificacao b 
                                   WHERE INSTR(a.organogramaAncestral,CONCAT('|', " . $_SESSION['organogramaCod'] . ",'|')) > 0 
                                     AND a.organogramaClassificacaoCod = b.organogramaClassificacaoCod
                                ORDER BY a.organogramaOrdem")
                ->setCampoDesc('campoDesc');
        
        $campos[] = $form->chosen('perfilCod', 'Perfil', true)
                ->setTabela('_perfil')
                ->setCampoCod('perfilCod')
                ->setCampoDesc('perfilNome')
                ->setValor($form->retornaValor('perfilCod'));      
        
        $campos[] = $form->email('usuarioLogin', 'Login', true)
                ->setMaximoCaracteres(200)
                ->setValor($form->retornaValor('usuarioLogin')); 
        
        $campos[] = $form->senha('usuarioSenha', 'Senha', false)
                ->setMaximoCaracteres(30)
                ->setMinimoCaracteres(6)
                ->setValor($form->retornaValor('usuarioSenha')); 
        
        $campos[] = $form->senha('usuarioRepitaSenha', 'Repita Senha', false)
                ->setMaximoCaracteres(30)
                ->setMinimoCaracteres(6)
                ->setValor($form->retornaValor('usuarioRepitaSenha')); 
        
        $campos[] = $form->upload('usuarioFoto', 'Avatar', 'Imagem')
                ->setMaximoArquivos(1)
                ->setCodigoReferencia($formCod)
                ->setValor('usuarioFoto')
                ->setThumbnail(true)                
                ->setAlturaMaxima(600)
                ->setAlturaMaximaTB(160)
                ->setMultiple(false);

        $campos[] = $form->botaoSalvarPadrao();

        $campos[] = $form->botaoDescartarPadrao();

        return $form->processarForm($campos);
    }
}
