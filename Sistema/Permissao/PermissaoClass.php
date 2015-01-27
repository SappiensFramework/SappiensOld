<?php
/**
*
*    Sappiens Framework
*    Copyright (C) 2014, BRA Consultoria
*
*    Website do autor: www.braconsultoria.com.br/sappiens
*    Email do autor: sappiens@braconsultoria.com.br
*
*    Website do projeto, equipe e documentação: www.sappiens.com.br
*   
*    Este programa é software livre; você pode redistribuí-lo e/ou
*    modificá-lo sob os termos da Licença Pública Geral GNU, conforme
*    publicada pela Free Software Foundation, versão 2.
*
*    Este programa é distribuído na expectativa de ser útil, mas SEM
*    QUALQUER GARANTIA; sem mesmo a garantia implícita de
*    COMERCIALIZAÇÃO ou de ADEQUAÇÃO A QUALQUER PROPÓSITO EM
*    PARTICULAR. Consulte a Licença Pública Geral GNU para obter mais
*    detalhes.
* 
*    Você deve ter recebido uma cópia da Licença Pública Geral GNU
*    junto com este programa; se não, escreva para a Free Software
*    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
*    02111-1307, USA.
*
*    Cópias da licença disponíveis em /Sappiens/_doc/licenca
*
*/

namespace Sappiens\Sistema\Permissao;

class PermissaoClass extends PermissaoSql
{

    private $chavePrimaria;
    private $crudUtil;
    private $tabela;
    private $colunasCrud;

    public function __construct()
    {
        parent::__construct();

        $this->crudUtil = new \Pixel\Crud\CrudUtil();

        $this->tabela = '_permissao';
        $this->chavePrimaria = 'permissaoCod';

        $this->colunasCrud = [
            'usuarioCod',
            'acaoModuloCod'
        ];
    }

    public function cadastrar($objForm)
    {
        return $this->crudUtil->insert($this->tabela, $this->colunasCrud, $objForm);
    }

    public function alterar($objForm)
    {
        return $this->crudUtil->update($this->tabela, $this->colunasCrud, $objForm, [$this->chavePrimaria => $objForm->get('cod')]);
    }

    public function removerPorAcaoModuloCod($acaoModuloCod)
    {
        return $this->crudUtil->delete($this->tabela, ['acaoModuloCod' => $acaoModuloCod]);
    }

    public function removerPorModuloCod($moduloCod)
    {
        $qb = $this->con->link()->createQueryBuilder();
        $qb->select('acaoModuloCod')
                ->from('_acao_modulo', '')
                ->where($qb->expr()->eq('moduloCod', '?'))
                ->setParameter(0, $moduloCod);

        $resultados = $this->con->paraArray($qb);

        foreach ($resultados as $acaoModuloCod) {
            $this->removerPorAcaoModuloCod($acaoModuloCod);
        }
    }

}
