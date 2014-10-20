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
						<button type="button" class="btn btn-lg dropdown-toggle" data-toggle="dropdown">
                                                    <i class="fa fa-check-square-o"></i>&nbsp;<i class="fa fa-caret-down"></i></button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#">Selecionar todos</a></li>
							<li><a href="#">Deselecionar todos</a></li>
						</ul>
					</div>
					
				</div>
				<!-- finaliza o grupo do check-all -->

				<!-- inicia o grupo das opcoes Vis, Cad, Alt, Del -->
				<div class="btn-group">
                                        <button type="button" class="btn btn-lg hidden-xs" title="Atualizar"><i class="fa fa-repeat"></i></button>
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
		<table class="table table-bordered">
			<thead>
				<tr>
					<th class="l45px alinC"></th>
					<th class="alinC"><i class="fa fa-sort recD10px"></i> First Name <i class="fa fa-sort-alpha-asc alinD recE10px"></i></th>
					<th class="alinC">Last Name</th>
					<th class="alinC hidden-xs">Username</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="l45px"><label class="px-single recE5px recS5px recD5px"><input type="checkbox" class="px" checked="checked"><span class="lbl"></span></label></td>
					<td>Mark</td>
					<td>Otto</td>
					<td class="hidden-xs">@mdo</td>
				</tr>
				<tr>
					<td class="l45px"><label class="px-single recE5px recS5px recD5px"><input type="checkbox" class="px"><span class="lbl"></span></label></td>
					<td>Jacob</td>
					<td>Thornton</td>
					<td class="hidden-xs">@fat</td>
				</tr>
				<tr>
					<td class="l45px"><label class="px-single recE5px recS5px recD5px"><input type="checkbox" class="px"><span class="lbl"></span></label></td>
					<td>Larry</td>
					<td>the Bird</td>
					<td class="hidden-xs">@twitter</td>
			  </tr>
			</tbody>
		</table>
		<div class="table-footer alinD">
			<em>Mostrando 30 de 825 registro(s)</em>
		</div>
	</div>
</div>
<?

	$html = ob_get_clean();
	return utf8_encode($html);

?>