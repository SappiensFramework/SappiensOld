<?php

namespace Sappiens\Grupo\Modulo;

class ModuloAjax
{

    public function ajax()
    {
        $jQuery = new \Zion\JQuery\JQuery();               
        
        echo $jQuery->ajax()
                ->post()
                ->setUrl('http://www.globo.com')
                ->setDone('alert("fechei");')
                ->criar();
    }

}
