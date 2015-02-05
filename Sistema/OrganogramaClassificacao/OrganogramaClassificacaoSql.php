<?php
/*

    Sappiens Framework
    Copyright (C) 2014, BRA Consultoria

    Website do autor: www.braconsultoria.com.br/sappiens
    Email do autor: sappiens@braconsultoria.com.br

    Website do projeto, equipe e documentação: www.sappiens.com.br
   
    Este programa é software livre; você pode redistribuí-lo e/ou
    modificá-lo sob os termos da Licença Pública Geral GNU, conforme
    publicada pela Free Software Foundation, versão 2.

    Este programa é distribuído na expectativa de ser útil, mas SEM
    QUALQUER GARANTIA; sem mesmo a garantia implícita de
    COMERCIALIZAÇÃO ou de ADEQUAÇÃO A QUALQUER PROPÓSITO EM
    PARTICULAR. Consulte a Licença Pública Geral GNU para obter mais
    detalhes.
 
    Você deve ter recebido uma cópia da Licença Pública Geral GNU
    junto com este programa; se não, escreva para a Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
    02111-1307, USA.

    Cópias da licença disponíveis em /Sappiens/_doc/licenca

*/

namespace Sappiens\Configuracoes\OrganogramaClassificacao;

class OrganogramaClassificacaoSql
{

    public function filtrarSql($objForm, $colunas)
    {
        $fil = new \Pixel\Filtro\Filtrar($objForm);
        $util = new \Pixel\Crud\CrudUtil();

        $sql = "SELECT a.*,
                       CASE 
                            WHEN a.organogramaClassificacaoStatus = 'A' THEN 'Ativo'
                            WHEN a.organogramaClassificacaoStatus = 'I' THEN 'Inativo'
                       END AS organogramaClassificacaoStatus
	              FROM organograma_classificacao a, organograma b
	             WHERE INSTR(a.organogramaClassificacaoAncestral,CONCAT('|', b.OrganogramaClassificacaoCod,'|')) > 0
                 AND b.organogramaCod = " . $_SESSION['organogramaCod'];

        $sql .= $util->getSqlFiltro($fil, $objForm, $colunas);

        return $sql;
    }

    public function getDadosSql($cod)
    {
        return "SELECT *
                  FROM  organograma_classificacao
                 WHERE  organogramaClassificacaoCod = ".$cod;
    }

    public function getOrdem($cod, $modo = '')
    {

        $sqlAdd = '';
        if($modo == 'referencia') {
            $sqlAdd = "Referencia";
        }
            return "SELECT MAX(organogramaClassificacaoOrdem) AS ordemAtual
                      FROM organograma_classificacao
                     WHERE organogramaClassificacao".$sqlAdd."Cod = ".$cod;

    }

    public function getOrganogramaClassificacaoReferenciaCod($cod)
    {
        return "SELECT organogramaClassificacaoCod chave, CONCAT(organogramaClassificacaoNome) valor
                  FROM organograma_classificacao
                 WHERE organogramaClassificacaoTipoCod = ".$cod;
    }     

    public function getDadosOrganogramaByOrganogramaCod($cod)
    {
        return "SELECT *
                  FROM  organograma
                 WHERE  organogramaCod = ".$cod;
    }    

}
