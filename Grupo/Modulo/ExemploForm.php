<?

ob_start();

?>

<div id="grid-control">

	<form class="">

		<div class="clearfix recI10px">

			<!-- inicia a barra de opcoes superior esquerda -->	
			<div class="btn-toolbar wide-btns pull-left">

				<!-- inicia o grupo do check-all -->
				<div class="btn-group hidden-xs hidden-sm recD20px">
					<div class="btn-group">
						<button type="button" class="btn btn-lg dropdown-toggle" data-toggle="dropdown"><i class="fa fa-check-square-o"></i>&nbsp;<i class="fa fa-caret-down"></i></button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#">Selecionar todos</a></li>
							<li><a href="#">Deselecionar todos</a></li>
						</ul>
					</div>
				</div>
				<!-- finaliza o grupo do check-all -->

				<!-- inicia o grupo das opcoes Vis, Cad, Alt, Del -->
				<div class="btn-group">
					<button type="button" class="btn btn-lg hidden-xs" title="Atualizar" data-type="info" data-text="Atualizando..."><i class="fa fa-repeat"></i></button>					
					<button type="button" class="btn btn-lg hidden-xs" title="Visualizar"><i class="fa fa fa-search"></i></button>
					<button type="button" class="btn btn-lg" title="Inserir"><i class="fa fa fa-plus"></i></button>
					<button type="button" class="btn btn-lg" title="Alterar"><i class="fa fa-pencil"></i></button>
					<button type="button" class="btn btn-lg" title="Remover"><i class="fa fa-trash-o"></i></button>
					<div class="btn-group">
						<button type="button" class="btn btn-lg dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i>&nbsp;<i class="fa fa-caret-down"></i></button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#"><i class="dropdown-icon fa fa-print"></i>&nbsp;&nbsp;&nbsp;Imprimir</a></li>
							<li class="hidden-xs"><a href="#"><i class="dropdown-icon fa fa-file-pdf-o"></i>&nbsp;&nbsp;&nbsp;Salvar em arquivo PDF</a></li>
							<li class="hidden-xs"><a href="#"><i class="dropdown-icon fa fa-file-code-o"></i>&nbsp;&nbsp;&nbsp;Salvar em arquivo CSV</a></li>
							<li class="hidden-xs"><a href="#"><i class="dropdown-icon fa fa-file-excel-o"></i>&nbsp;&nbsp;&nbsp;Salvar em arquivo do Excel</a></li>
						</ul>
					</div>					
				</div>	
				<!-- finaliza o grupo das opcoes Vis, Cad, Alt, Del -->	

				<!-- inicia a barra de pesquisa para dispositivos grandes (lg) -->	
				<div class="btn-toolbar pull-right recE20px hidden-xs hidden-sm hidden-md">		
					<div class="btn-group">
						<input id="busca" type="text" class="input form-control tagsinput" data-role="tagsinput" placeholder="Pesquisar em pessoa fisica">
					</div>
				</div>
				<!-- finaliza a barra de pesquisa para dispositivos grandes (lg) -->	

				<!-- inicia a barra de pesquisa exclusivamente para dispositivos medios e pequenos (md e sm) -->	
				<div class="btn-toolbar pull-right recE20px visible-md hidden-lg">		
					<div class="btn-group">
						<input id="busca" type="text" class="input form-control tagsinput" data-role="tagsinput" placeholder="Pesquisar">
					</div>
				</div>		
				<!-- finaliza a barra de pesquisa exclusivamente para dispositivos medios e pequenos (md e sm) -->		

			</div>
			<!-- finaliza a barra de opcoes superior esquerda -->	

			<!-- inicializa a barra de opcoes superior direita (paginacao, etc) -->	
			<div class="btn-toolbar pull-right">
				<div class="btn-group">
					<button type="button" class="btn btn-lg active" title="Voltar"><i class="fa fa-chevron-left"></i></button>
					<button type="button" class="btn btn-lg" title="Avan&ccedil;ar"><i class="fa fa-chevron-right"></i></button>
				</div>
			</div>	
			<!-- finaliza a barra de opcoes superior direita (paginacao, etc) -->	
			
		</div>
	</form>

	<div class="table-primary">
		<table class="table table-striped table-bordered table-mobile dataTable">
			<thead>
				<tr>
					<th class="l45px alinC"></th>
					<th class="alinC sorting_desc">First Name</th>
					<th class="alinC sorting">Last Name</th>
					<th class="alinC hidden-xs sorting">Username</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><label class="px-single recE15px"><input type="checkbox" class="px" checked="checked"><span class="lbl"></span></label></td>
					<td>Mark</td>
					<td>Otto</td>
					<td class="hidden-xs">@mdo</td>
				</tr>
				<tr>
					<td><label class="px-single recE15px"><input type="checkbox" class="px"><span class="lbl"></span></label></td>
					<td>Jacob</td>
					<td class="">Thornton</td>
					<td class="hidden-xs">@fat</td>
				</tr>
				<tr>
					<td><label class="px-single recE15px"><input type="checkbox" class="px"><span class="lbl"></span></label></td>
					<td>Larry</td>
					<td>the Bird</td>
					<td class="hidden-xs alinC">@twitter</td>
			  	</tr>
				<tr>
					<td><label class="px-single recE15px"><input type="checkbox" class="px"><span class="lbl"></span></label></td>
					<td>Jacob</td>
					<td>Thornton</td>
					<td class="hidden-xs">@fat</td>
				</tr>			  	
			</tbody>
			<tfooter>
				<tr>
					<td class="a30px"></td>
					<td class="alinV-mid alinC">Total</td>
					<td class="alinV-mid alinC">Total</td>
					<td class="alinV-mid alinC hidden-xs">Total</td>
			  	</tr>			  	
			</tfooter>
		</table>
		<div class="table-footer alinD">
			<em>Mostrando 30 de 825 registro(s)</em>
		</div>
	</div>
</div>

<div class="panel-body buttons-with-margins" id="page-alerts-dark-demo">
	<button data-type="warning" data-text="<strong>Warning!</strong> Best check yo self, you're not looking too good." class="btn btn-small btn-warning auto-close-alert">Add warning</button>&nbsp;&nbsp;
	<button data-type="danger"  data-text="<strong>Oh snap!</strong> Change a few things up and try submitting again." class="btn btn-small btn-danger auto-close-alert">Add error</button>&nbsp;&nbsp;
	<button data-type="success" data-text="<strong>Well done!</strong> You successfully read this important alert message." class="btn btn-small btn-success auto-close-alert">Add success</button>&nbsp;&nbsp;
	<button data-type="info"    data-text="<strong>Heads up!</strong> This alert needs your attention, but it's not super important." class="btn btn-small btn-info auto-close-alert">Add info</button>&nbsp;&nbsp;
</div>	

<?

	$html = ob_get_clean();
	return utf8_encode($html);

?>