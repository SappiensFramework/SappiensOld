<?

namespace Sappiens\includes;

class Template extends \Zion\Layout\Padrao
{

	public function getTemplate($modo = '')
	{

		switch ($modo) {

			case 'cabecalho':

				return $this->getCabecalho();

			break;	

			case 'inicioCorpo':

				return $this->getInicioCorpo();

			break;						

			case 'barraSuperior':

				return $this->getBarraSuperior();

			break;

			case 'barraLateral':

				return $this->getBarraLateral();

			break;

			case 'miolo':

				return $this->getMiolo();

			break;	

			case 'fimCorpo':

				return $this->getFimCorpo();

			break;					

			case 'rodape':

				return $this->getRodape();

			break;
			
			default:
				
				$buffer  = '';
				$buffer .= $this->getEstatisticas('starts');
				$buffer .= $this->getCabecalho();
				$buffer .= $this->getInicioCorpo();
				$buffer .= $this->getBarraSuperior();
				$buffer .= $this->getBarraLateral();
				$buffer .= $this->getMiolo();
				$buffer .= $this->getFimCorpo();
				$buffer .= $this->getRodape();
				$buffer .= $this->getEstatisticas('ends');

				return $buffer;

			break;

		}

	}

    private function getCabecalho()
    {

		$buffer  = '';
		$buffer .= $this->html->abreComentario() . 'Zion Framework: starting generic header' . $this->html->fechaComentario();
		$buffer .= $this->topo();
		$buffer .= $this->html->abreComentario() . 'Zion Framework: ending generic header' . $this->html->fechaComentario();
		$buffer .= $this->html->abreComentario() . 'Zion Framework: starting template header' . $this->html->fechaComentario();
		$buffer .= $this->html->abreTagAberta('link', array('href' => 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin', 'rel' => 'stylesheet', 'type' => 'text/css'));
		$buffer .= $this->html->abreTagAberta('link', array('href' => SIS_URL_BASE_STATIC . SIS_VENDOR_TEMPLATE . '/' . SIS_VENDOR_TEMPLATE_VERSION . '/assets/stylesheets/bootstrap.min.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
		$buffer .= $this->html->abreTagAberta('link', array('href' => SIS_URL_BASE_STATIC . SIS_VENDOR_TEMPLATE . '/' . SIS_VENDOR_TEMPLATE_VERSION . '/assets/stylesheets/pixel-admin.min.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
		$buffer .= $this->html->abreTagAberta('link', array('href' => SIS_URL_BASE_STATIC . SIS_VENDOR_TEMPLATE . '/' . SIS_VENDOR_TEMPLATE_VERSION . '/assets/stylesheets/widgets.min.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
		$buffer .= $this->html->abreTagAberta('link', array('href' => SIS_URL_BASE_STATIC . SIS_VENDOR_TEMPLATE . '/' . SIS_VENDOR_TEMPLATE_VERSION . '/assets/stylesheets/pages.min.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
		$buffer .= $this->html->abreTagAberta('link', array('href' => SIS_URL_BASE_STATIC . SIS_VENDOR_TEMPLATE . '/' . SIS_VENDOR_TEMPLATE_VERSION . '/assets/stylesheets/rtl.min.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
		$buffer .= $this->html->abreTagAberta('link', array('href' => SIS_URL_BASE_STATIC . SIS_VENDOR_TEMPLATE . '/' . SIS_VENDOR_TEMPLATE_VERSION . '/assets/stylesheets/themes.min.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
		$buffer .= $this->html->fechaTag('head');
		$buffer .= $this->html->abreComentario() . 'Zion Framework: ending template header' . $this->html->fechaComentario();

		return $buffer;

	}

	private function getInicioCorpo()
	{

		$buffer  = '';
		$buffer .= $this->html->abreComentario() . 'Zion Framework: starting body app' . $this->html->fechaComentario();
		$buffer .= $this->html->abreTagAberta('body', array('class' => 'theme-clean main-menu-animated'));
		$buffer .= '<script>var init = [];</script><script src="'. SIS_URL_BASE_STATIC . SIS_VENDOR_TEMPLATE . '/' . SIS_VENDOR_TEMPLATE_VERSION . '/assets/demo/demo.js"></script>';
		$buffer .= $this->html->abreTagAberta('div', array('id' => 'main-wrapper'));		

		return $buffer;

	}

	private function getBarraSuperior()
	{

		$buffer  = '';
		$buffer .= $this->html->abreTagAberta('div', array('id' => 'main-navbar', 'class' => 'navbar navbar-inverse', 'role' => 'navigation'));

			$buffer .= $this->html->abreTagAberta('button', array('id' => 'main-menu-toggle'));
			$buffer .= $this->html->abreTagFechada('i', array('class' => 'navbar-icon fa fa-bars icon'));
			$buffer .= $this->html->abreTagAberta('span', array('class' => 'hide-menu-text')) . 'ESCONDER MENU' . $this->html->fechaTag('span');
			$buffer .= $this->html->fechaTag('button');

			$buffer .= $this->html->abreTagAberta('div', array('class' => 'navbar-inner'));

				$buffer .= $this->html->abreTagAberta('div', array('class' => 'navbar-header'));

					// carrega o logo do sistema na barra superior
					$buffer .= $this->getLogoSuperior();

					$buffer .= $this->html->abreTagAberta('button', array('type' => 'button', 'class' => 'navbar-toggle collapsed', 'data-toggle' => 'collapse', 'data-target' => '#main-navbar-collapse'));
						$buffer .= $this->html->abreTagFechada('i', array('class' => 'navbar-icon fa fa-bars'));
					// end: button
					$buffer .= $this->html->fechaTag('button');

				// end: navbar-header
				$buffer .= $this->html->fechaTag('div');

				$buffer .= $this->html->abreTagAberta('div', array('id' => 'main-navbar-collapse', 'class' => 'collapse navbar-collapse main-navbar-collapse'));

					$buffer .= $this->html->abreTagAberta('div');

						// carrega o menu da barra superior
						$buffer .= $this->getMenuSuperior();

						$buffer .= $this->html->abreTagAberta('div', array('id' => 'icone-notificacoes', 'class' => 'right clearfix'));

							$buffer .= $this->html->abreTagAberta('ul', array('class' => 'nav navbar-nav pull-right right-navbar-nav'));

								// carrega as notificações da barra superior
								$buffer .= $this->getNotificacoes();

								// carrega as mensagens da barra superior
								$buffer .= $this->getMensagens();	

								// carrega o form de pesquisa da barra superior
								$buffer .= $this->getFormPesquisa();					

							// end: navbar-nav
							$buffer .= $this->html->fechaTag('ul');					

						// end: icone-notificacoes
						$buffer .= $this->html->fechaTag('div');

					$buffer .= $this->html->fechaTag('div');	

				// end: main-navbar-collapse
				$buffer .= $this->html->fechaTag('div');		

			// end: navbar-inner
			$buffer .= $this->html->fechaTag('div');

		// end: main-navbar
		$buffer .= $this->html->fechaTag('div');

		return $buffer;

	}

	private function getLogoSuperior()
	{

		$buffer  = '';
		$buffer .= $this->html->abreTagAberta('a', array('href' => './?ref=navbar-brand', 'class' => 'navbar-brand'));

			$buffer .= $this->html->abreTagAberta('div');
				$buffer .= $this->html->abreTagAberta('img', array('alt' => 'Início', 'src' => SIS_URL_BASE_STATIC . SIS_VENDOR_TEMPLATE . '/' . SIS_VENDOR_TEMPLATE_VERSION . '/assets/images/pixel-admin/main-navbar-logo.png'));
			$buffer .= $this->html->fechaTag('div');
			$buffer .= SIS_ID_NAMESPACE_PROJETO;

		// end: navbar-brand
		$buffer .= $this->html->fechaTag('a');

		return $buffer;

	}

	private function getMenuSuperior()
	{

		$buffer  = '';
		$buffer .= $this->html->abreTagAberta('ul', array('class' => 'nav navbar-nav'));
			$buffer .= $this->html->abreTagAberta('li');
				$buffer .= $this->html->abreTagAberta('a', array('href' => './?ref=navbar-nav'));
					$buffer .= "Início";
				$buffer .= $this->html->fechaTag('a');	
			$buffer .= $this->html->fechaTag('li');	

			// inicio menu Administrativo
			$buffer .= $this->html->abreTagAberta('li', array('class' => 'dropdown'));

				$buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'));
					$buffer .= "Gestão Administrativa";
				$buffer .= $this->html->fechaTag('a');	

				$buffer .= $this->html->abreTagAberta('ul', array('class' => 'dropdown-menu'));

					$buffer .= $this->html->abreTagAberta('li');
						$buffer .= $this->html->abreTagAberta('a', array('href' => './?ref=navbar-nav-option-1'));
							$buffer .= "Cadastros";
						$buffer .= $this->html->fechaTag('a');
					$buffer .= $this->html->fechaTag('li');	

					$buffer .= $this->html->abreTagAberta('li');
						$buffer .= $this->html->abreTagAberta('a', array('href' => './?ref=navbar-nav-option-1'));
							$buffer .= "Protocolo";
						$buffer .= $this->html->fechaTag('a');
					$buffer .= $this->html->fechaTag('li');		

					$buffer .= $this->html->abreTagAberta('li');
						$buffer .= $this->html->abreTagAberta('a', array('href' => './?ref=navbar-nav-option-1'));
							$buffer .= "Recursos Humanos";
						$buffer .= $this->html->fechaTag('a');
					$buffer .= $this->html->fechaTag('li');		

					$buffer .= $this->html->abreTagAberta('li');
						$buffer .= $this->html->abreTagAberta('a', array('href' => './?ref=navbar-nav-option-1'));
							$buffer .= "Folha de Pagamento";
						$buffer .= $this->html->fechaTag('a');
					$buffer .= $this->html->fechaTag('li');																							

				$buffer .= $this->html->fechaTag('ul');	

			$buffer .= $this->html->fechaTag('li');	
			// fim menu Administrativo

			// inicio menu Gestao Estrategica
			$buffer .= $this->html->abreTagAberta('li', array('class' => 'dropdown'));
			
				$buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'));
					$buffer .= "Gestão Estratégica";
				$buffer .= $this->html->fechaTag('a');	

				$buffer .= $this->html->abreTagAberta('ul', array('class' => 'dropdown-menu'));

					$buffer .= $this->html->abreTagAberta('li');
						$buffer .= $this->html->abreTagAberta('a', array('href' => './?ref=navbar-nav-option-1'));
							$buffer .= "Compras e Licitações";
						$buffer .= $this->html->fechaTag('a');
					$buffer .= $this->html->fechaTag('li');	

					$buffer .= $this->html->abreTagAberta('li');
						$buffer .= $this->html->abreTagAberta('a', array('href' => './?ref=navbar-nav-option-1'));
							$buffer .= "Patrimônio e Almoxarifado";
						$buffer .= $this->html->fechaTag('a');
					$buffer .= $this->html->fechaTag('li');									

				$buffer .= $this->html->fechaTag('ul');	

			$buffer .= $this->html->fechaTag('li');		
			// fim menu Gestao Estrategica	

			// inicio menu Inteligencia Corporativa
			$buffer .= $this->html->abreTagAberta('li', array('class' => 'dropdown'));
			
				$buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'));
					$buffer .= "Gestão da Inteligência Corporativa";
				$buffer .= $this->html->fechaTag('a');	

				$buffer .= $this->html->abreTagAberta('ul', array('class' => 'dropdown-menu'));

					$buffer .= $this->html->abreTagAberta('li');
						$buffer .= $this->html->abreTagAberta('a', array('href' => './?ref=navbar-nav-option-1'));
							$buffer .= "Opção 1";
						$buffer .= $this->html->fechaTag('a');
					$buffer .= $this->html->fechaTag('li');	

				$buffer .= $this->html->fechaTag('ul');	

			$buffer .= $this->html->fechaTag('li');		
			// fim menu Inteligencia Corporativa	

			// inicio menu Gestão Social
			$buffer .= $this->html->abreTagAberta('li', array('class' => 'dropdown'));
			
				$buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'));
					$buffer .= "Gestão Social";
				$buffer .= $this->html->fechaTag('a');	

				$buffer .= $this->html->abreTagAberta('ul', array('class' => 'dropdown-menu'));

					$buffer .= $this->html->abreTagAberta('li');
						$buffer .= $this->html->abreTagAberta('a', array('href' => './?ref=navbar-nav-option-1'));
							$buffer .= "Opção 1";
						$buffer .= $this->html->fechaTag('a');
					$buffer .= $this->html->fechaTag('li');	

				$buffer .= $this->html->fechaTag('ul');	

			$buffer .= $this->html->fechaTag('li');		
			// fim menu Gestão Social															

		// end: nav navbar-nav
		$buffer .= $this->html->fechaTag('ul');	

		return $buffer;

	}	

	private function getNotificacoes()
	{

		$buffer  = '';
		$buffer .= $this->html->abreTagAberta('li', array('class' => 'nav-icon-btn nav-icon-btn-danger dropdown'));

			$buffer .= $this->html->abreTagAberta('a', array('href' => '#notifications', 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'));
				
				$buffer .= $this->html->abreTagAberta('span', array('class' => 'label'));
					$buffer .= "5";
				$buffer .= $this->html->fechaTag('span');	
				$buffer .= $this->html->abreTagFechada('i', array('class' => 'nav-icon fa fa-bullhorn'));
				$buffer .= $this->html->abreTagAberta('span', array('class' => 'small-screen-text'));
					$buffer .= "Notificações";
				$buffer .= $this->html->fechaTag('span');									

			$buffer .= $this->html->fechaTag('a');	

			$buffer .= $this->html->abreTagAberta('script');
				$buffer .= 'init.push(function () {$(\'#main-navbar-notifications\').slimScroll({ height: 250 });});';
			$buffer .= $this->html->fechaTag('script');

			$buffer .= $this->html->abreTagAberta('div', array('class' => 'dropdown-menu widget-notifications no-padding', 'style' => 'width: 300px'));

				$buffer .= $this->html->abreTagAberta('div', array('id' => 'main-navbar-notifications', 'class' => 'notifications-list'));

					$buffer .= $this->html->abreTagAberta('div', array('class' => 'notification'));

						$buffer .= $this->html->abreTagAberta('div', array('class' => 'notification-title text-danger')) . 'SYSTEM' . $this->html->fechaTag('div');
						$buffer .= $this->html->abreTagAberta('div', array('class' => 'notification-description')) . '<strong>Error 500</strong>: Syntax error in index.php at line <strong>461</strong>.' . $this->html->fechaTag('div');
						$buffer .= $this->html->abreTagAberta('div', array('class' => 'notification-ago')) . '12h atrás' . $this->html->fechaTag('div');
						$buffer .= $this->html->abreTagAberta('div', array('class' => 'notification-icon fa fa-hdd-o bg-danger')) . $this->html->fechaTag('div');

					$buffer .= $this->html->fechaTag('div');

					$buffer .= $this->html->abreTagAberta('div', array('class' => 'notification'));

						$buffer .= $this->html->abreTagAberta('div', array('class' => 'notification-title text-info')) . 'SYSTEM' . $this->html->fechaTag('div');
						$buffer .= $this->html->abreTagAberta('div', array('class' => 'notification-description')) . '<strong>Error 500</strong>: Syntax error in index.php at line <strong>461</strong>.' . $this->html->fechaTag('div');
						$buffer .= $this->html->abreTagAberta('div', array('class' => 'notification-ago')) . '12h atrás' . $this->html->fechaTag('div');
						$buffer .= $this->html->abreTagAberta('div', array('class' => 'notification-icon fa fa-hdd-o bg-info')) . $this->html->fechaTag('div');

					$buffer .= $this->html->fechaTag('div');									

				$buffer .= $this->html->fechaTag('div');

				$buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'class' => 'notifications-link')) . 'VER MAIS NOTIFICAÇÕES' . $this->html->fechaTag('a');

			$buffer .= $this->html->fechaTag('div');

		$buffer .= $this->html->fechaTag('li');

		return $buffer;

	}	

	private function getMensagens()
	{

		$buffer  = '';
		$buffer .= $this->html->abreTagAberta('li', array('class' => 'nav-icon-btn nav-icon-btn-success dropdown'));			

			$buffer .= $this->html->abreTagAberta('a', array('href' => '#messages', 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'));
				
				$buffer .= $this->html->abreTagAberta('span', array('class' => 'label'));
					$buffer .= "12";
				$buffer .= $this->html->fechaTag('span');	
				$buffer .= $this->html->abreTagFechada('i', array('class' => 'nav-icon fa fa-envelope'));
				$buffer .= $this->html->abreTagAberta('span', array('class' => 'small-screen-text')) . "Mensagens" . $this->html->fechaTag('span');									

			$buffer .= $this->html->fechaTag('a');		

			$buffer .= $this->html->abreTagAberta('script');
				$buffer .= 'init.push(function () {$(\'#main-navbar-messages\').slimScroll({ height: 250 });});';
			$buffer .= $this->html->fechaTag('script');			

			$buffer .= $this->html->abreTagAberta('div', array('class' => 'dropdown-menu widget-messages-alt no-padding', 'style' => 'width: 300px'));	

				$buffer .= $this->html->abreTagAberta('div', array('id' => 'main-navbar-messages', 'class' => 'messages-list'));	

					$buffer .= $this->html->abreTagAberta('div', array('class' => 'message'));

						$buffer .= $this->html->abreTagAberta('img', array('src' => SIS_URL_BASE_STATIC . SIS_VENDOR_TEMPLATE . '/' . SIS_VENDOR_TEMPLATE_VERSION . '/assets/demo/avatars/3.jpg', 'class' => 'message-avatar'));
						$buffer .= $this->html->abreTagAberta('a', array('class' => 'message-subject')) . 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.' . $this->html->fechaTag('a');
						$buffer .= $this->html->abreTagAberta('div', array('class' => 'message-description')) . 'from ' . $this->html->abreTagAberta('a', array('href' => '#')) . 'Vinícius Pozzebon' . $this->html->fechaTag('a') . ' há 2h' . $this->html->fechaTag('div');

					$buffer .= $this->html->fechaTag('div');									
				
				$buffer .= $this->html->fechaTag('div');	

				$buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'class' => 'messages-link')) . 'VER MAIS MENSAGENS' . $this->html->fechaTag('a');																					
			
			$buffer .= $this->html->fechaTag('div');																

		$buffer .= $this->html->fechaTag('li');	

		return $buffer;

	}	

	private function getFormPesquisa()
	{

	    $formSmart 	= new \Sappiens\dashboard\Smart();
	    $form 		= $formSmart->getFormSmart();		

		$buffer  = '';
		$buffer .= $this->html->abreTagAberta('li');	

			//$buffer .= $form->montaForm();				

		$buffer .= $this->html->fechaTag('li');	

		return $buffer;

	}

	private function getBarraLateral()
	{

		$buffer  = '';

		$buffer .= $this->html->abreTagAberta('div', array('id' => 'main-menu', 'role' => 'navigation'));

			$buffer .= $this->html->abreTagAberta('div', array('id' => 'main-menu-inner'));

				// carrega o bloco lateral esquerdo (sobre o menu) com a foto do usuário logado
				$buffer .= $this->getBlocoUsuario();

				// carrega o menu lateral
				$buffer .= $this->getMenuLateral();

			// end: main-menu-inner
			$buffer .= $this->html->fechaTag('div');
		// end: main-menu
		$buffer .= $this->html->fechaTag('div');

		return $buffer;

	}

	private function getBlocoUsuario()
	{

		$buffer  = '';
		$buffer .= $this->html->abreTagAberta('div', array('id' => 'menu-content-demo', 'class' => 'menu-content top'));		

			$buffer .= $this->html->abreTagAberta('div');

				$buffer .= $this->html->abreTagAberta('div', array('class' => 'text-bg'));

					$buffer .= $this->html->abreTagAberta('span', array('class' => 'text-slim')) . 'Vinícius Pozzebon' . $this->html->fechaTag('span');

				$buffer .= $this->html->fechaTag('div');

				$buffer .= $this->html->abreTagAberta('img', array('src' => SIS_URL_BASE_STATIC . SIS_VENDOR_TEMPLATE . '/' . SIS_VENDOR_TEMPLATE_VERSION . '/assets/demo/avatars/1.jpg', 'class' => ''));

				$buffer .= $this->html->abreTagAberta('div', array('class' => 'btn-group'));

					// envelope
					$buffer .= $this->html->abreTagAberta('a', array('href' => SIS_URL_BASE . './messages?ref=fa-envelope', 'class' => 'btn btn-xs btn-primary btn-outline dark'));
						$buffer .= $this->html->abreTagAberta('i', array('class' => 'fa fa-envelope')) . $this->html->fechaTag('i');
					$buffer .= $this->html->fechaTag('a');	

					// perfil
					$buffer .= $this->html->abreTagAberta('a', array('href' => SIS_URL_BASE . './user?ref=fa-user', 'class' => 'btn btn-xs btn-primary btn-outline dark'));
						$buffer .= $this->html->abreTagAberta('i', array('class' => 'fa fa-user')) . $this->html->fechaTag('i');
					$buffer .= $this->html->fechaTag('a');	

					// configuracoes
					$buffer .= $this->html->abreTagAberta('a', array('href' => SIS_URL_BASE . './config?ref=fa-cog', 'class' => 'btn btn-xs btn-primary btn-outline dark'));
						$buffer .= $this->html->abreTagAberta('i', array('class' => 'fa fa-cog')) . $this->html->fechaTag('i');
					$buffer .= $this->html->fechaTag('a');	

					// sair
					$buffer .= $this->html->abreTagAberta('a', array('href' => SIS_URL_BASE . './logout?ref=fa-power-off', 'class' => 'btn btn-xs btn-danger btn-outline dark'));
						$buffer .= $this->html->abreTagAberta('i', array('class' => 'fa fa-power-off')) . $this->html->fechaTag('i');
					$buffer .= $this->html->fechaTag('a');																									

				$buffer .= $this->html->fechaTag('div');	

			$buffer .= $this->html->fechaTag('div');	
		
		// end: menu-content-demo
		$buffer .= $this->html->fechaTag('div');

		return $buffer;

	}

	private function getMenuLateral()
	{

		$buffer  = '';
		$buffer .= $this->html->abreTagAberta('ul', array('class' => 'navigation'));	

			$buffer .= $this->html->abreTagAberta('li');

				$buffer .= $this->html->abreTagAberta('a', array('href' => '#'));
					$buffer .= $this->html->abreTagAberta('i', array('class' => 'menu-icon fa fa-dashboard')) . $this->html->fechaTag('i');
					$buffer .= $this->html->abreTagAberta('span', array('class' => 'mm-text')) . 'Dashboard' . $this->html->fechaTag('span');
				$buffer .= $this->html->fechaTag('a');		

			$buffer .= $this->html->fechaTag('li');		

			$buffer .= $this->html->abreTagAberta('li', array('class' => 'mm-dropdown'));

				$buffer .= $this->html->abreTagAberta('a', array('href' => '#'));
					$buffer .= $this->html->abreTagAberta('i', array('class' => 'menu-icon fa fa-th')) . $this->html->fechaTag('i');
					$buffer .= $this->html->abreTagAberta('span', array('class' => 'mm-text')) . 'Layouts' . $this->html->fechaTag('span');
				$buffer .= $this->html->fechaTag('a');	

				$buffer .= $this->html->abreTagAberta('ul');		
					$buffer .= $this->html->abreTagAberta('li');

						$buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'tabindex' => '-1'));
							$buffer .= $this->html->abreTagAberta('i', array('class' => 'menu-icon fa fa-user')) . $this->html->fechaTag('i');
							$buffer .= $this->html->abreTagAberta('span', array('class' => 'mm-text')) . 'Menu 1' . $this->html->fechaTag('span');
						$buffer .= $this->html->fechaTag('a');	
						$buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'tabindex' => '-1'));
							$buffer .= $this->html->abreTagAberta('i', array('class' => 'menu-icon fa fa-user')) . $this->html->fechaTag('i');
							$buffer .= $this->html->abreTagAberta('span', array('class' => 'mm-text')) . 'Menu 2' . $this->html->fechaTag('span');
						$buffer .= $this->html->fechaTag('a');											

					$buffer .= $this->html->fechaTag('li');		
				$buffer .= $this->html->fechaTag('ul');		

			$buffer .= $this->html->fechaTag('li');		

		// end: ul inicial
		$buffer .= $this->html->fechaTag('ul');		

		return $buffer;

	}	

	private function getMiolo()
	{

		$buffer  = '';
		$buffer .= $this->html->abreTagAberta('div', array('id' => 'content-wrapper'));

		// carrega o breadcrumb
		$buffer .= $this->getBreadCrumb();

		// carrega o page header
		$buffer .= $this->getPageHeader();

		$buffer .= 'O conteúdo supostamente vem aqui!';

		// end: content-wrapper
		$buffer .= $this->html->fechaTag('div');
		$buffer .= $this->html->abreTagAberta('div', array('id' => 'main-menu-bg')) . $this->html->fechaTag('div');
		// end: main-navbar
		$buffer .= $this->html->fechaTag('div');

		return $buffer;

	}	

	private function getBreadCrumb()
	{

		$buffer  = '';
		$buffer .= $this->html->abreTagAberta('ul', array('class' => 'breadcrumb breadcrumb-page'));
			$buffer .= $this->html->abreTagAberta('div', array('class' => 'breadcrumb-label text-light-gray')) . 'Você, supostamente, está aqui: ' . $this->html->fechaTag('div');
			$buffer .= $this->html->abreTagAberta('li');
				$buffer .= $this->html->abreTagAberta('a', array('href' => '#')) . 'Início' . $this->html->fechaTag('a');
			$buffer .= $this->html->fechaTag('li');
			$buffer .= $this->html->abreTagAberta('li', array('class' => 'active'));
				$buffer .= $this->html->abreTagAberta('a', array('href' => './?ref='. DEFAULT_MODULO_NOME)) . 'Dashboard' . $this->html->fechaTag('a');
			$buffer .= $this->html->fechaTag('li');				
		$buffer .= $this->html->fechaTag('ul');

		return $buffer;

	}

	private function getPageHeader()
	{

		$buffer  = '';
		$buffer .= $this->html->abreTagAberta('div', array('class' => 'page-header'));
			$buffer .= $this->html->abreTagAberta('div', array('class' => 'row'));

				$buffer .= $this->html->abreTagAberta('h1', array('class' => 'col-xs-12 col-sm-4 text-center text-left-sm'));
					$buffer .= $this->html->abreTagAberta('i', array('class' => 'fa fa-dashboard page-header-icon')) . $this->html->fechaTag('i') . '&nbsp;&nbsp;' . DEFAULT_MODULO_NOME;
				$buffer .= $this->html->fechaTag('h1');

			$buffer .= $this->html->fechaTag('div');				
		$buffer .= $this->html->fechaTag('div');

		return $buffer;

	}

	private function getFimCorpo()
	{

		$buffer  = '';
		// end: main-wrapper
		$buffer .= $this->html->fechaTag('div');
		$buffer .= $this->html->abreComentario() . 'Zion Framework: ending body app' . $this->html->fechaComentario();

		return $buffer;

	}	

	private function getRodape()
	{

		$buffer  = '';
		$buffer .= $this->html->abreComentario() . 'Zion Framework: starting scripts block' . $this->html->fechaComentario();
		$buffer .= $this->html->abreTagAberta('script', array('src' => 'https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js')) . $this->html->fechaTag('script');
		$buffer .= $this->html->abreTagAberta('script', array('src' => SIS_URL_BASE_STATIC . SIS_VENDOR_TEMPLATE . '/' . SIS_VENDOR_TEMPLATE_VERSION . '/assets/javascripts/bootstrap.min.js')) . $this->html->fechaTag('script');
		$buffer .= $this->html->abreTagAberta('script', array('src' => SIS_URL_BASE_STATIC . SIS_VENDOR_TEMPLATE . '/' . SIS_VENDOR_TEMPLATE_VERSION . '/assets/javascripts/pixel-admin.min.js')) . $this->html->fechaTag('script');		
		$buffer .= $this->html->abreTagAberta('script', array('type' => 'text/javascript')) . 'window.PixelAdmin.start(init);'. $this->html->fechaTag('script');	
		$buffer .= $this->html->abreComentario() . 'Zion Framework: ending scripts block' . $this->html->fechaComentario();	
		$buffer .= $this->html->abreComentario() . 'Zion Framework: starting generic footer' . $this->html->fechaComentario();		
		$buffer .= $this->rodape();
		$buffer .= $this->html->abreComentario() . 'Zion Framework: ending generic footer' . $this->html->fechaComentario();
		$buffer .= $this->html->abreComentario() . 'Zion Framework: good by!' . $this->html->fechaComentario();

		return $buffer;

	}

	private function getEstatisticas($modo = '')
	{

		$buffer  = '';

		switch ($modo) {
			case 'starts':
				
				list($usec, $sec) = explode(' ', microtime());
				$_SESSION['script_start'] = (float) $sec + (float) $usec;

				$buffer .= $this->html->abreComentario() . 'Zion Framework starting at [' . $_SESSION['script_start'] . '] miliseconds' . $this->html->fechaComentario();
				$buffer .= $this->html->abreComentario() . 'Zion Framework memory peak usage [' . round(((memory_get_peak_usage(true) / 1024) / 1024), 2) . '] Mb ' . $this->html->fechaComentario();

			break;
			
			case 'ends':

				list($usec, $sec) = explode(' ', microtime());
				$script_end = (float) $sec + (float) $usec;
				$elapsed_time = round($script_end - $_SESSION['script_start'], 5);

				$buffer .= $this->html->abreComentario() . 'Zion Framework ending at [' . $elapsed_time . '] miliseconds' . $this->html->fechaComentario();
				$buffer .= $this->html->abreComentario() . 'Zion Framework memory peak usage [' . round(((memory_get_peak_usage(true) / 1024) / 1024), 2) . '] Mb ' . $this->html->fechaComentario();

			break;
		}


		return $buffer;

	}	

}

