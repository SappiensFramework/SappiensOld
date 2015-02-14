<?php

namespace Sappiens\Sistema\Permissao;

class PermissaoSql
{
    /**
     * @var \Zion\Banco\Conexao
     */
    protected $con;

    public function __construct()
    {
        $this->con = \Zion\Banco\Conexao::conectar();
    }
    
    public function permissoesPerfil($moduloCod, $perfilCod)
    {
        $qb = $this->con->link()->createQueryBuilder();

        $qb->select(['d.acaoModuloCod'])
                ->from('_perfil', 'b')
                ->innerJoin('b', '_permissao', 'c', 'b.perfilCod = c.PerfilCod')
                ->innerJoin('c', '_acao_modulo', 'd', 'c.acaoModuloCod = d.acaoModuloCod')
                ->innerJoin('d', '_modulo', 'e', 'd.moduloCod = e.moduloCod')
                ->where($qb->expr()->eq('b.perfilCod', ':perfilCod'))
                ->andWhere($qb->expr()->eq('e.moduloCod', ':moduloCod'))
                ->setParameter('perfilCod', $perfilCod, \PDO::PARAM_INT)
                ->setParameter('moduloCod', $moduloCod, \PDO::PARAM_INT);

        return $qb;
    }

}
