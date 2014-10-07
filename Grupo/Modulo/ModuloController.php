<?php

namespace Sappiens\Grupo\Modulo;

class ModuloController
{

    public function __construct($acao)
    {
        if (!method_exists($this, $acao)) {
            throw new Exception("Opção inválida!");
        }

        try {
            echo $this->{$acao}();
        } catch (Exception $e) {

            $tratar = new \Zion\Validacao\Valida();

            echo json_encode(array('sucesso' => 'false', 'retorno' => $tratar->texto()->trata($e->getMessage())));
        }
    }

    private function cadastrar()
    {
        return json_encode(array('sucesso' => 'true', 'retorno' => 'ret'));
    }

}

new ModuloController($_GET['acao']);
