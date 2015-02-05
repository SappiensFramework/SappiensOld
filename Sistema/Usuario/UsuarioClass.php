<?php

namespace Sappiens\Sistema\Usuario;

class UsuarioClass extends UsuarioSql
{

    private $chavePrimaria;
    private $crudUtil;
    private $tabela;
    private $colunasCrud;
    private $colunasGrid;
    private $filtroDinamico;

    public function __construct()
    {
        parent::__construct();

        $this->crudUtil = new \Pixel\Crud\CrudUtil();

        $this->tabela = '_usuario';
        $this->chavePrimaria = 'usuarioCod';

        $this->colunasCrud = [
            'organogramaCod',
            'perfilCod',
            'usuarioLogin',
            'usuarioSenha'
        ];

        $this->colunasGrid = [
            'perfilNome' => 'Perfil',
            'usuarioLogin' => 'Login',
            'numeroAcessos' => 'Acessos',
            'usuarioDataCadastro' => 'Data de Cadastro',
            'usuarioUltimoAcesso' => 'Último Acesso'
        ];

        $this->filtroDinamico = [
            'perfilNome' => 'b',
            'usuarioLogin' => 'a',
            'numeroAcessos' => 'a',
            'usuarioDataCadastro' => 'a',
            'usuarioUltimoAcesso' => 'a'
        ];
    }

    public function filtrar($objForm)
    {
        $grid = new \Pixel\Grid\GridPadrao();

        \Zion\Paginacao\Parametros::setParametros("GET", $this->crudUtil->getParametrosGrid($objForm));

        $grid->setColunas($this->colunasGrid);

        $grid->setSql(parent::filtrarSql($objForm, $this->filtroDinamico));
        $grid->setChave($this->chavePrimaria);
        $grid->substituaPor('numeroAcessos', ['<i>nunca acessou</i>']);
        $grid->substituaPor('usuarioUltimoAcesso', ['<i>nunca acessou</i>']);
        $grid->setFormatarComo('usuarioDataCadastro', 'DataHora');
        $grid->setFormatarComo('usuarioUltimoAcesso', 'DataHora');

        return $grid->montaGridPadrao();
    }

    public function cadastrar($objForm)
    {
        $this->validaSenha($objForm);
        $this->loginDuplicado($objForm);
        return $this->crudUtil->insert($this->tabela, $this->colunasCrud, $objForm);
    }

    public function alterar($objForm)
    {
        $this->validaSenha($objForm);
        $this->loginDuplicado($objForm);
        return $this->crudUtil->update($this->tabela, $this->colunasCrud, $objForm, [$this->chavePrimaria => $objForm->get('cod')]);
    }

    public function remover($cod)
    {
        $permissao = new \Sappiens\Sistema\Permissao\PermissaoClass();

        if ($this->con->existe('_usuario', 'usuarioCodReferente', $cod)) {
            throw new \Exception('Não é possível remover este módulo pois ele possui um ou mais módulos dependentes!');
        }

        $this->crudUtil->startTransaction();

        $permissao->removerPorUsuarioCod($cod);

        $this->crudUtil->delete('_acao_usuario', [$this->chavePrimaria => $cod]);

        $removidos = $this->crudUtil->delete($this->tabela, [$this->chavePrimaria => $cod]);

        $this->crudUtil->stopTransaction();

        return $removidos;
    }

    public function setValoresFormManu($cod, $formIntancia)
    {
        $objForm = $formIntancia->getFormManu('alterar', $cod);

        $parametrosSql = $this->con->execLinhaArray(parent::getDadosSql($cod));

        $this->crudUtil->setParametrosForm($objForm, $parametrosSql, $cod);

        return $objForm;
    }

    private function validaSenha($objForm)
    {
        $senha1 = $objForm->get('usuarioSenha');
        $senha2 = $objForm->get('usuarioRepitaSenha');

        if ($senha1 OR $senha2) {

            if ($senha1 !== $senha2) {
                throw new \Exception("Campo Senha e Repita Senha, se preenchidos devem ser iguais!");
            }

            $senhaCriptografada = (new \Pixel\Login\LoginClass())->getSenhaHash($senha1);

            $objForm->set('usuarioSenha', $senhaCriptografada);
        }
    }

    private function loginDuplicado($objForm)
    {
        $login = $objForm->get('usuarioLogin');
        $usuarioCod = $objForm->get('cod');
        $acao = $objForm->getAcao();

        $qb = $this->con->link()->createQueryBuilder();
        $qb->select("usuarioCod")
                ->from('_usuario', '')
                ->where($qb->expr()->eq('usuarioLogin', ':usuarioLogin'))
                ->setParameter('usuarioLogin', $login, \PDO::PARAM_STR);

        if ($usuarioCod and $acao === 'alterar') {
            $qb->andWhere($qb->expr()->neq('usuarioCod', ':usuarioCod'))
                    ->setParameter('usuarioCod', $usuarioCod, \PDO::PARAM_INT);
        }

        if ($this->con->execNLinhas($qb) > 0) {
            throw new \Exception("Este login já existe no sistema e não pode ser usado!");
        }
    }

}
