<?php

namespace Sappiens\Sistema\Perfil;

class PerfilForm
{

    public function getFormFiltro()
    {
        $form = new \Pixel\Form\FormFiltro();

        $form->config('sisFormFiltro');

        $campos[] = $form->suggest('perfilNome', 'Perfil','')
                ->setTabela('_perfil')
                ->setCampoBusca('perfilNome')
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
                ->setHeader('Perfils');

        $campos[] = $form->hidden('cod')
                ->setValor($form->retornaValor('cod'));

        $campos[] = $form->texto('perfilNome', 'Perfil', true)
                ->setMaximoCaracteres(100)
                ->setMinimoCaracteres(2)
                ->setValor($form->retornaValor('perfilNome'));

        $campos[] = $form->textArea('perfilDescricao', 'Descrição', false)
                ->setMaximoCaracteres(1000)
                ->setLinhas(4)
                ->setValor($form->retornaValor('perfilDescricao'));
               
        $campos[] = $form->layout('Permissões', (new \Sappiens\Sistema\Permissao\PermissaoClass())->montaPermissao($acao, $formCod));

        $campos[] = $form->botaoSalvarPadrao();

        $campos[] = $form->botaoDescartarPadrao();

        return $form->processarForm($campos);
    }

    public function getJSEstatico()
    {
        $js = '
        $(".panel-title").css("user-select", "none");
        
    //esconder e aparecer painel quando clicar
    function toggleBody(obj) {
         $(obj).parents(".permissoes-usuario").find(".panel-body").toggle("fast");
           //trocar icones de + e _ no canto do titulo
        if($(".panel-title i").hasClass("fa-minus-square-o")){
        $(obj).find("i").removeClass("fa-minus-square-o");
        $(obj).find("i").addClass("fa-plus-square-o");
    }else {
            $(obj).find("i").removeClass("fa-plus-square-o");
            $(obj).find("i").addClass("fa-minus-square-o");
            
    }
    }

function contar(obj){
        if($(obj).hasClass("marca")){
            $(obj).parents(".permissoes-usuario").find("input").prop("checked",true);
    }else if($(obj).hasClass("desmarca")){
            $(obj).parents(".permissoes-usuario").find("input").prop("checked",false);
    }


        //seletor para os checkbox
        var checkbox = $(obj).parents(".permissoes-usuario").find("input:checkbox:checked");
        //array para armazenar os valores
        var val = [];
        //função each para pegar os selecionados
        checkbox.each(function(){
            val.push($(this).val());
        });
         //exibe no console o array com os valores selecionados
        var marcados = val.length;
        var desmarcados = $(obj).parents(".permissoes-usuario").find("input:checkbox").length - marcados;



    // $(obj).parents(".permissoes-usuario").find(".label-s").html(marcados);
    // $(obj).parents(".permissoes-usuario").find(".label-no").html(desmarcados);
    
}
function marcarLinha(obj){

            
            if($(obj).parents(".iten-com-checkbox").find("input").prop("checked")){
                $(obj).parents(".iten-com-checkbox").find("input").prop("checked",false);
            }else {
                $(obj).parents(".iten-com-checkbox").find("input").prop("checked",true);
            }
}


    ';
        
        $jsStatic = \Pixel\Form\FormJavaScript::iniciar();

        //$jsStatic->setFunctions($js);

        return $jsStatic->getFunctions();
    }

}
