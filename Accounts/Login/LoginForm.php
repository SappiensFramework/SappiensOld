<?php

namespace Sappiens\Accounts\Login;

class LoginForm
{

    public function getLogin()
    {   

        $this->html = new \Zion\Layout\Html();

        $msgErro = ($_GET['err']) ? ' ' . $_GET['err'] . ' ' : ' Acesse a sua conta ';

        $buffer = '';
        //$buffer .= $this->conteudoContainerLogin;
        $buffer .= $this->html->abreTagAberta('div', array('id' => 'page-signin-bg'));
        $buffer .= $this->html->abreTagAberta('div', array('class' => 'overlay')) . $this->html->fechaTag('div');
        $buffer .= $this->html->abreTagAberta('img', array('src' => SIS_URL_BASE_STATIC . SIS_URL_BASE_TEMPLATE . 'assets/demo/signin-bg-1.jpg'));
        $buffer .= $this->html->fechaTag('div');

        $buffer .= $this->html->abreTagAberta('div', array('class' => 'signin-container'));

        $buffer .= $this->html->abreTagAberta('div', array('class' => 'signin-info'));
        $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'class' => 'logo'));
        $buffer .= $this->html->abreTagAberta('img', array('src' => SIS_URL_BASE_STATIC . SIS_URL_BASE_TEMPLATE . 'assets/demo/logo-big.png', 'style' => 'margin-top: -5px;')) . '&nbsp;' . SIS_ID_NAMESPACE_PROJETO;
        $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->abreTagAberta('div', array('class' => 'slogan')) . SIS_SLOGAN . $this->html->fechaTag('div');
        $buffer .= $this->html->abreTagAberta('ul');
        $buffer .= $this->html->abreTagAberta('li');
        $buffer .= $this->html->abreTagAberta('i', array('class' => 'fa fa-sitemap signin-icon')) . $this->html->fechaTag('i') . 'Estrutura modular flexível';
        $buffer .= $this->html->fechaTag('li');
        $buffer .= $this->html->abreTagAberta('li');
        $buffer .= $this->html->abreTagAberta('i', array('class' => 'fa fa-file-text-o signin-icon')) . $this->html->fechaTag('i') . 'HTML5, Ajax, CSS3 e SCSS';
        $buffer .= $this->html->fechaTag('li');
        $buffer .= $this->html->abreTagAberta('li');
        $buffer .= $this->html->abreTagAberta('i', array('class' => 'fa fa-outdent signin-icon')) . $this->html->fechaTag('i') . 'Suporte técnico integrado';
        $buffer .= $this->html->fechaTag('li');
        $buffer .= $this->html->abreTagAberta('li');
        $buffer .= $this->html->abreTagAberta('i', array('class' => 'fa fa-heart signin-icon')) . $this->html->fechaTag('i') . 'Desenvolvido com amor';
        $buffer .= $this->html->fechaTag('li');
        $buffer .= $this->html->fechaTag('ul');
        // end: signin-info
        $buffer .= $this->html->fechaTag('div');

        $buffer .= $this->html->abreTagAberta('div', array('class' => 'signin-form'));
        $buffer .= $this->html->abreTagAberta('form', array('id' => 'signin-form_id', 'action' => './', 'method' => 'post'));
        $buffer .= $this->html->abreTagAberta('input', array('type' => 'hidden', 'id' => 'acao', 'name' => 'acao', 'value' => 'getAuth'));
        $buffer .= $this->html->abreTagAberta('div', array('class' => 'signin-text'));
        $buffer .= $this->html->abreTagAberta('span') . $msgErro . $this->html->fechaTag('span');
        $buffer .= $this->html->fechaTag('div');

        $buffer .= $this->html->abreTagAberta('div', array('class' => 'form-group w-icon'));
        $buffer .= $this->html->abreTagAberta('input', array('type' => 'text', 'id' => 'username_id', 'name' => 'signin_username', 'class' => 'form-control input-lg', 'placeholder' => 'Email'));
        $buffer .= $this->html->abreTagAberta('span', array('class' => 'fa fa-user signin-form-icon')) . $this->html->fechaTag('span');
        $buffer .= $this->html->fechaTag('div');

        $buffer .= $this->html->abreTagAberta('div', array('class' => 'form-group w-icon'));
        $buffer .= $this->html->abreTagAberta('input', array('type' => 'password', 'id' => 'password_id', 'name' => 'signin_password', 'class' => 'form-control input-lg', 'placeholder' => 'Senha'));
        $buffer .= $this->html->abreTagAberta('span', array('class' => 'fa fa-lock signin-form-icon')) . $this->html->fechaTag('span');
        $buffer .= $this->html->fechaTag('div');

        $buffer .= $this->html->abreTagAberta('div', array('class' => 'form-actions'));
        $buffer .= $this->html->abreTagAberta('input', array('type' => 'submit', 'id' => 'submit_id', 'value' => 'Acessar', 'class' => 'signin-btn bg-primary'));
        $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'class' => 'forgot-password', 'id' => 'forgot-password-link')) . ' Esqueceu sua senha? ' . $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('div');

        $buffer .= $this->html->abreTagAberta('div', array('class' => 'signin-with'));
        $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'class' => 'signin-with-btn', 'style' => 'background:#4f6faa;background:rgba(79, 111, 170, .8);'));
        $buffer .= ' Acessar com ' . $this->html->abreTagAberta('span') . ' Facebook ' . $this->html->fechaTag('span');
        $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('div');

        $buffer .= $this->html->fechaTag('form');

        $buffer .= $this->html->abreTagAberta('div', array('id' => 'password-reset-form', 'class' => 'password-reset-form'));
        $buffer .= $this->html->abreTagAberta('div', array('class' => 'header'));
        $buffer .= $this->html->abreTagAberta('div', array('class' => 'signin-text'));
        $buffer .= $this->html->abreTagAberta('span') . ' Redefinir senha ' . $this->html->fechaTag('span');
        $buffer .= $this->html->abreTagAberta('div', array('class' => 'close')) . '&times;' . $this->html->fechaTag('div');
        $buffer .= $this->html->fechaTag('div');
        $buffer .= $this->html->fechaTag('div');

        // reset senha
        $buffer .= $this->html->abreTagAberta('form', array('id' => 'password-reset-form-id', 'action' => '#'));
        $buffer .= $this->html->abreTagAberta('div', array('class' => 'form-group w-icon'));
        $buffer .= $this->html->abreTagAberta('input', array('type' => 'text', 'id' => 'p_email_id', 'name' => 'password-reset-email', 'class' => 'form-control input-lg', 'placeholder' => 'Informe o seu email'));
        $buffer .= $this->html->abreTagAberta('span', array('class' => 'fa fa-envelope signin-form-icon')) . $this->html->fechaTag('span');
        $buffer .= $this->html->fechaTag('div');
        $buffer .= $this->html->abreTagAberta('div', array('class' => 'form-actions'));
        $buffer .= $this->html->abreTagAberta('input', array('type' => 'submit', 'value' => 'Enviar nova senha', 'class' => 'signin-btn bg-primary'));
        $buffer .= $this->html->fechaTag('div');
        $buffer .= $this->html->fechaTag('form');
        // end: password-reset-form
        $buffer .= $this->html->fechaTag('div');

        // end: signin-form
        $buffer .= $this->html->fechaTag('div');

        // end: signin-container
        $buffer .= $this->html->fechaTag('div');

        $buffer .= $this->html->abreTagAberta('div', array('class' => 'not-a-member'));
        //$buffer .= ' Ainda não é usuário? ' . $this->html->abreTagAberta('a', array('href' => '../Cadastro')) . 'Cadastre-se' . $this->html->fechaTag('a') . ' agora mesmo!';
        $buffer .= $this->html->fechaTag('div');

        return $buffer;

    }

    public function getJSEstatico()
    {
        $jsStatic = \Pixel\Form\FormJavaScript::iniciar();

        $jQuery = new \Zion\JQuery\JQuery();                

        return $jsStatic->getFunctions($jsStatic->setFunctions($this->getMeuJS()));
    }

    private function getMeuJS()
    {

        /*
        ** var a => recebe a id do campo que invocou o evento
        ** var b => recebe o elemento que sofrerá update
        ** var c => recebe o metodo
        */
        $buffer  = '';
/*        
        $buffer .= 'function getController(a,b,c){
                        var aa = $("#"+a).val();
                        $.ajax({type: "get", url: "'.SIS_URL_BASE.'Dashboard?acao="+c+"&a="+aa, dataType: "json", beforeSend: function() {
                            $("#"+b).html(\'<i class="fa fa-refresh fa-spin" style="margin-top:10px;"></i>\');
                        }}).done(function (ret) {
                            $("#"+b).html(ret.retorno);
                            location.reload();
                        }).fail(function () {
                            sisMsgFailPadrao();
                        });  
                    }';
        $buffer .= 'function getClassificacaoByReferencia(a,b,c){
                        var aa = $("#"+a).val();
                        $.ajax({type: "get", url: "?acao="+c+"&a="+aa, dataType: "json", beforeSend: function() {
                            $("#"+b).html(\'<i class="fa fa-refresh fa-spin" style="margin-top:10px;"></i>\');
                        }}).done(function (ret) {
                            $("#"+b).html(ret.retorno);
                        }).fail(function () {
                            sisMsgFailPadrao();
                        });  
                    }';                    
        $buffer .= 'function getClassificacaoReordenavel(a,b,c){ 
                        var aa = $("#"+a).val();
                        $.ajax({type: "get", url: "?acao="+c+"&a="+aa, dataType: "json", beforeSend: function() {
                            //$("#"+b).html(\'<i class="fa fa-refresh fa-spin" style="margin-top:10px;"></i>\');
                        }}).done(function (ret) {
                            if(ret.retorno === true) {
                                //alert(ret.retorno);
                                $("#"+b).removeClass("hidden");                                                       
                            } else {
                                //alert(ret.retorno);
                                //getClassificacaoTipo(a,\'sisContainerOrganogramaClassificacaoCod\',\'getOrganogramaClassificacaoTipoCod\');
                                getClassificacaoByReferencia(a,\'sisContainerOrganogramaClassificacaoCod\',\'getOrganogramaClassificacaoByReferencia\');
                                $("#"+b).addClass("hidden");   
                            }
                        }).fail(function () {
                            sisMsgFailPadrao();
                        });  
                    }';
*/                    
        return $buffer;

    }

}
