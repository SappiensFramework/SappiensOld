<?

namespace Sappiens\includes;

class Template
{

    /**
     * 
     * @return Header
     */
    public function getCabecalho()
    {

		$html    = new \Zion\Layout\Html();

		$buffer  = false;
		$buffer .= $html->abreTagAberta('link', array('href' => 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin', 'rel' => 'stylesheet', 'type' => 'text/css'));
		$buffer .= $html->abreTagAberta('link', array('href' => URL_BASE_STATIC . CFG_VENDOR_TEMPLATE . '/' . CFG_VENDOR_TEMPLATE_VERSION . '/assets/stylesheets/bootstrap.min.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
		$buffer .= $html->abreTagAberta('link', array('href' => URL_BASE_STATIC . CFG_VENDOR_TEMPLATE . '/' . CFG_VENDOR_TEMPLATE_VERSION . '/assets/stylesheets/pixel-admin.min.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
		$buffer .= $html->abreTagAberta('link', array('href' => URL_BASE_STATIC . CFG_VENDOR_TEMPLATE . '/' . CFG_VENDOR_TEMPLATE_VERSION . '/assets/stylesheets/widgets.min.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
		$buffer .= $html->abreTagAberta('link', array('href' => URL_BASE_STATIC . CFG_VENDOR_TEMPLATE . '/' . CFG_VENDOR_TEMPLATE_VERSION . '/assets/stylesheets/pages.min.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
		$buffer .= $html->abreTagAberta('link', array('href' => URL_BASE_STATIC . CFG_VENDOR_TEMPLATE . '/' . CFG_VENDOR_TEMPLATE_VERSION . '/assets/stylesheets/rtl.min.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
		$buffer .= $html->abreTagAberta('link', array('href' => URL_BASE_STATIC . CFG_VENDOR_TEMPLATE . '/' . CFG_VENDOR_TEMPLATE_VERSION . '/assets/stylesheets/themes.min.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
		$buffer .= $html->fechaTag('head');

		return $buffer;

	}

	public function getBarraSuperior()
	{

		$html    	= new \Zion\Layout\Html();
	    $formSmart 	= new \Sappiens\dashboard\Smart();
	    $form 		= $formSmart->getFormSmart();		

		$buffer  = false;
		$buffer .= $html->abreTagAberta('div', array('id' => 'main-navbar', 'class' => 'navbar navbar-inverse', 'role' => 'navigation'));

		$buffer .= $html->abreTagAberta('button', array('id' => 'main-menu-toggle'));
		$buffer .= $html->abreTagFechada('i', array('class' => 'navbar-icon fa fa-bars icon'));
		$buffer .= $html->abreTagAberta('span', array('class' => 'hide-menu-text')) . 'ESCONDER MENU' . $html->fechaTag('span');
		$buffer .= $html->fechaTag('button');

		$buffer .= $html->abreTagAberta('div', array('class' => 'navbar-inner'));

			$buffer .= $html->abreTagAberta('div', array('class' => 'navbar-header'));

				$buffer .= $html->abreTagAberta('a', array('href' => './?ref=navbar-brand', 'class' => 'navbar-brand'));

					$buffer .= $html->abreTagAberta('div');
						$buffer .= $html->abreTagAberta('img', array('alt' => 'Início', 'src' => URL_BASE_STATIC . CFG_VENDOR_TEMPLATE . '/' . CFG_VENDOR_TEMPLATE_VERSION . '/assets/images/pixel-admin/main-navbar-logo.png'));
					$buffer .= $html->fechaTag('div');
					$buffer .= CFG_SIS_NOME;

				// end: navbar-brand
				$buffer .= $html->fechaTag('a');

				$buffer .= $html->abreTagAberta('button', array('type' => 'button', 'class' => 'navbar-toggle collapsed', 'data-toggle' => 'collapse', 'data-target' => '#main-navbar-collapse'));
					$buffer .= $html->abreTagFechada('i', array('class' => 'navbar-icon fa fa-bars'));
				// end: button
				$buffer .= $html->fechaTag('button');

			// end: navbar-header
			$buffer .= $html->fechaTag('div');

			$buffer .= $html->abreTagAberta('div', array('id' => 'main-navbar-collapse', 'class' => 'collapse navbar-collapse main-navbar-collapse'));

				$buffer .= $html->abreTagAberta('div');
					$buffer .= $html->abreTagAberta('ul', array('class' => 'nav navbar-nav'));

						$buffer .= $html->abreTagAberta('li');
							$buffer .= $html->abreTagAberta('a', array('href' => './?ref=navbar-nav'));
								$buffer .= "Início";
							$buffer .= $html->fechaTag('a');	
						$buffer .= $html->fechaTag('li');	

						$buffer .= $html->abreTagAberta('li', array('class' => 'dropdown'));
							$buffer .= $html->abreTagAberta('a', array('href' => '#', 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'));
								$buffer .= "Opções";
							$buffer .= $html->fechaTag('a');	

							$buffer .= $html->abreTagAberta('ul', array('class' => 'dropdown-menu'));

								$buffer .= $html->abreTagAberta('li');
									$buffer .= $html->abreTagAberta('a', array('href' => './?ref=navbar-nav-option-1'));
										$buffer .= "Opção 1";
									$buffer .= $html->fechaTag('a');
								$buffer .= $html->fechaTag('li');	

							$buffer .= $html->fechaTag('ul');	

						$buffer .= $html->fechaTag('li');	

					// end: nav navbar-nav
					$buffer .= $html->fechaTag('ul');	

					$buffer .= $html->abreTagAberta('div', array('id' => 'icone-notificacoes', 'class' => 'right clearfix'));

						$buffer .= $html->abreTagAberta('ul', array('class' => 'nav navbar-nav pull-right right-navbar-nav'));

							$buffer .= $html->abreTagAberta('li', array('class' => 'nav-icon-btn nav-icon-btn-danger dropdown'));

								$buffer .= $html->abreTagAberta('a', array('href' => '#notifications', 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'));
									
									$buffer .= $html->abreTagAberta('span', array('class' => 'label'));
										$buffer .= "5";
									$buffer .= $html->fechaTag('span');	
									$buffer .= $html->abreTagFechada('i', array('class' => 'nav-icon fa fa-bullhorn'));
									$buffer .= $html->abreTagAberta('span', array('class' => 'small-screen-text'));
										$buffer .= "Notificações";
									$buffer .= $html->fechaTag('span');									

								$buffer .= $html->fechaTag('a');	

								$buffer .= $html->abreTagAberta('script');
									$buffer .= 'init.push(function () {$(\'#main-navbar-notifications\').slimScroll({ height: 250 });});';
								$buffer .= $html->fechaTag('script');

								$buffer .= $html->abreTagAberta('div', array('class' => 'dropdown-menu widget-notifications no-padding', 'style' => 'width: 300px'));

									$buffer .= $html->abreTagAberta('div', array('id' => 'main-navbar-notifications', 'class' => 'notifications-list'));

										$buffer .= $html->abreTagAberta('div', array('class' => 'notification'));

											$buffer .= $html->abreTagAberta('div', array('class' => 'notification-title text-danger')) . 'SYSTEM' . $html->fechaTag('div');
											$buffer .= $html->abreTagAberta('div', array('class' => 'notification-description')) . '<strong>Error 500</strong>: Syntax error in index.php at line <strong>461</strong>.' . $html->fechaTag('div');
											$buffer .= $html->abreTagAberta('div', array('class' => 'notification-ago')) . '12h atrás' . $html->fechaTag('div');
											$buffer .= $html->abreTagAberta('div', array('class' => 'notification-icon fa fa-hdd-o bg-danger')) . $html->fechaTag('div');

										$buffer .= $html->fechaTag('div');

										$buffer .= $html->abreTagAberta('div', array('class' => 'notification'));

											$buffer .= $html->abreTagAberta('div', array('class' => 'notification-title text-info')) . 'SYSTEM' . $html->fechaTag('div');
											$buffer .= $html->abreTagAberta('div', array('class' => 'notification-description')) . '<strong>Error 500</strong>: Syntax error in index.php at line <strong>461</strong>.' . $html->fechaTag('div');
											$buffer .= $html->abreTagAberta('div', array('class' => 'notification-ago')) . '12h atrás' . $html->fechaTag('div');
											$buffer .= $html->abreTagAberta('div', array('class' => 'notification-icon fa fa-hdd-o bg-info')) . $html->fechaTag('div');

										$buffer .= $html->fechaTag('div');									

									$buffer .= $html->fechaTag('div');

									$buffer .= $html->abreTagAberta('a', array('href' => '#', 'class' => 'notifications-link')) . 'VER MAIS NOTIFICAÇÕES' . $html->fechaTag('a');

								$buffer .= $html->fechaTag('div');

							$buffer .= $html->fechaTag('li');

							// end: notificacoes
							// start: messagens

							$buffer .= $html->abreTagAberta('li', array('class' => 'nav-icon-btn nav-icon-btn-success dropdown'));			

								$buffer .= $html->abreTagAberta('a', array('href' => '#messages', 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'));
									
									$buffer .= $html->abreTagAberta('span', array('class' => 'label'));
										$buffer .= "12";
									$buffer .= $html->fechaTag('span');	
									$buffer .= $html->abreTagFechada('i', array('class' => 'nav-icon fa fa-envelope'));
									$buffer .= $html->abreTagAberta('span', array('class' => 'small-screen-text')) . "Mensagens" . $html->fechaTag('span');									

								$buffer .= $html->fechaTag('a');		

								$buffer .= $html->abreTagAberta('script');
									$buffer .= 'init.push(function () {$(\'#main-navbar-messages\').slimScroll({ height: 250 });});';
								$buffer .= $html->fechaTag('script');			

								$buffer .= $html->abreTagAberta('div', array('class' => 'dropdown-menu widget-messages-alt no-padding', 'style' => 'width: 300px'));	

									$buffer .= $html->abreTagAberta('div', array('id' => 'main-navbar-messages', 'class' => 'messages-list'));	

										$buffer .= $html->abreTagAberta('div', array('class' => 'message'));

											$buffer .= $html->abreTagAberta('img', array('src' => URL_BASE_STATIC . CFG_VENDOR_TEMPLATE . '/' . CFG_VENDOR_TEMPLATE_VERSION . '/assets/demo/avatars/3.jpg', 'class' => 'message-avatar'));
											$buffer .= $html->abreTagAberta('a', array('class' => 'message-subject')) . 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.' . $html->fechaTag('a');
											$buffer .= $html->abreTagAberta('div', array('class' => 'message-description')) . 'from ' . $html->abreTagAberta('a', array('href' => '#')) . 'Vinícius Pozzebon' . $html->fechaTag('a') . ' há 2h' . $html->fechaTag('div');

										$buffer .= $html->fechaTag('div');									
									
									$buffer .= $html->fechaTag('div');	

									$buffer .= $html->abreTagAberta('a', array('href' => '#', 'class' => 'messages-link')) . 'VER MAIS MENSAGENS' . $html->fechaTag('a');																					
								
								$buffer .= $html->fechaTag('div');																

							$buffer .= $html->fechaTag('li');		

							$buffer .= $html->abreTagAberta('li');	

								$buffer .= $form->montaForm();				

							$buffer .= $html->fechaTag('li');						

						// end: navbar-nav
						$buffer .= $html->fechaTag('ul');					

					// end: icone-notificacoes
					$buffer .= $html->fechaTag('div');

				$buffer .= $html->fechaTag('div');	

			// end: main-navbar-collapse
			$buffer .= $html->fechaTag('div');		

		// end: navbar-inner
		$buffer .= $html->fechaTag('div');

	// end: main-navbar
	$buffer .= $html->fechaTag('div');

		return $buffer;

	}

	public function getMenuLateral()
	{

		$html    = new \Zion\Layout\Html();

		$buffer  = false;
		// start: main-menu
		$buffer .= $html->abreTagAberta('div', array('id' => 'main-menu', 'role' => 'navigation'));

			// start: main-menu-inner
			$buffer .= $html->abreTagAberta('div', array('id' => 'main-menu-inner'));
			// end: main-menu-inner
			$buffer .= $html->fechaTag('div');

		// end: main-menu
		$buffer .= $html->fechaTag('div');

		return $buffer;

	}

	public function getRodape()
	{

		$html    = new \Zion\Layout\Html();

		$buffer  = false;
		$buffer .= $html->abreTagAberta('script', array('src' => 'https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js')) . $html->fechaTag('script');
		$buffer .= $html->abreTagAberta('script', array('src' => URL_BASE_STATIC . CFG_VENDOR_TEMPLATE . '/' . CFG_VENDOR_TEMPLATE_VERSION . '/assets/javascripts/bootstrap.min.js')) . $html->fechaTag('script');
		$buffer .= $html->abreTagAberta('script', array('src' => URL_BASE_STATIC . CFG_VENDOR_TEMPLATE . '/' . CFG_VENDOR_TEMPLATE_VERSION . '/assets/javascripts/pixel-admin.min.js')) . $html->fechaTag('script');
		

		return $buffer;

	}

}

