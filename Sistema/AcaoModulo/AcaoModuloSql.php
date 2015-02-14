<?php

namespace Sappiens\Sistema\AcaoModulo;

class AcaoModuloSql
{
    /**
     * @var \Zion\Banco\Conexao
     */
    protected $con;

    public function __construct()
    {
        $this->con = \Zion\Banco\Conexao::conectar();
    }

    public function acoesDoModuloSql($moduloCod)
    {
        $qb = $this->con->link()->createQueryBuilder();

        $qb->select(['acaoModuloCod',
                    'moduloCod',
                    'acaoModuloPermissao',
                    'acaoModuloIdPermissao',
                    'acaoModuloIcon',
                    'acaoModuloToolTipComPermissao',
                    'acaoModuloToolTipeSemPermissao',
                    'acaoModuloFuncaoJS',
                    'acaoModuloPosicao',
                    'acaoModuloApresentacao'])
                ->from('_acao_modulo', '')
                ->where($qb->expr()->eq('moduloCod', '?'))
                ->setParameter(0, $moduloCod)
                ->orderBy('acaoModuloPosicao', 'ASC');

        return $qb;
    }

}
