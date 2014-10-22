<?php

namespace Sappiens\Grupo\Modulo;

class ModuloJavaScript
{

    public function ajax()
    {
        $jQuery = new \Zion\JQuery\JQuery();               
        
        echo $jQuery->ajax()
                ->post()
                ->setUrl('http://www.globo.com')
                ->setContentType('json')
                ->setDone('alert("fechei");')
                ->criar();
        
        $jQuery->ajax()
                ->get()
                ->setUrl();
                
        
//        parent::setFuncoes($Ajax->ajaxUpdate(array(
//        "Nome"       => "sis_filtrar",
//        "URL"        => MODULO.".ajax.php?Op=Fil",
//        "Form"       => "FormFiltro",
//        "VarPar"     => "PARFIL",
//        "Metodo"     => "get",
//        "TipoDado"   => 'script',
//        "Conteiner"  => 'corpoPrincipal')));
    }

}
