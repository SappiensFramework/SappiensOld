<?php

namespace Sappiens\Sistema\Usuario;

class UsuarioSql
{

    /**
     * @var \Zion\Banco\Conexao
     */
    protected $con;

    public function __construct()
    {
        $this->con = \Zion\Banco\Conexao::conectar();
    }

    public function filtrarSql($objForm, $filtroDinamico = [])
    {
        $fil = new \Pixel\Filtro\Filtrar($objForm);
        $util = new \Pixel\Crud\CrudUtil();

        $qb = $this->con->link()->createQueryBuilder();

        $qb->select(['a.usuarioCod', 'b.perfilNome', 
                    'a.usuarioLogin', 'a.numeroAcessos', 'a.usuarioDataCadastro',
                    'a.usuarioUltimoAcesso'])
                ->from('_usuario', 'a')
                ->innerJoin('a', '_perfil', 'b', 'a.perfilCod = b.perfilCod');

        $util->getSqlFiltro($fil, $objForm, $filtroDinamico, $qb);

        return $qb;
    }

    public function getDadosSql($cod)
    {
        $qb = $this->con->link()->createQueryBuilder();

        $qb->select(['usuarioCod','perfilCod','usuarioLogin',
            'numeroAcessos','usuarioDataCadastro',
            'usuarioUltimoAcesso'])
                ->from('_usuario', '')
                ->where($qb->expr()->eq('usuarioCod', '?'))
                ->setParameter(0, $cod);

        return $qb;
    }

}
