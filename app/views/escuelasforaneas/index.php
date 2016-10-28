		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Registros Almacenados</h2>
                    <ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>
						<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo site_url(array('user','escuelasforaneas'));?>">Ver Registros</a>
							</li>
							<li><a href="<?php echo site_url(array('user','escuelasforaneas', 'nuevaescuela'));?>">Nuevo Registro</a>
							</li>
							<li><a target="_BLANK" href="<?php echo site_url(array('reportes', 'rep_escuelasforaneas'));?>">Descargar</a>
							</li>
						</ul>
						</li>
						<li><a class="close-link"><i class="fa fa-close"></i></a>
						</li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                <div class="x_content">
					<a class="btn btn-default btn-sm" href="<?php echo site_url(array('user','escuelasforaneas'));?>">Registros</a>
					<a class="btn btn-default btn-sm" href="<?php echo site_url(array('user','escuelasforaneas', 'nuevaescuela'));?>">Nuevo Registro</a>
					<a class="btn btn-default btn-sm" target="_BLANK" href="<?php echo site_url(array('reportes', 'rep_escuelasforaneas'));?>">Descargar</a>
				</div>
				<div class="x_content">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Código</th>
                          <th>Nombre</th>
                          <th>Localidad</th>
                          <th>Entidad Federal</th>
                          <th>Acción</th>
                        </tr>
                      </thead>


                      <tbody>
					  <?php

						foreach ($rs_escuelas->result_array() as $fila)
						{
							echo '
						<tr class="text-center">
							<td>'.str_pad($fila["idescuelaforanea"],5,'0',STR_PAD_LEFT).'</td>
							<td>'.$fila["nombre"].'</td>
							<td>'.$fila["localidad"].'</td>
							<td class="text-center">'.$fila["entidad"].'</td>
							<td class="text-center">
								<a href="'.site_url(array('user','escuelasforaneas','editarescuela',$fila["idescuelaforanea"])).'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Editar </a>';
								if($fila["bloqueado"]==0){
									echo'<a href="addDialog"  class="btn btn-danger btn-xs open-AddDialog" data-toggle="modal" data-url="'.site_url(array('user','escuelasforaneas','eliminarescuela',$fila["idescuelaforanea"])).'"><i class="fa fa-trash-o"></i> Eliminar </a>';
								}else{
									echo'<a href="#" class="btn btn-danger btn-xs" title="Bloqueado por poseer registros dependientes"><i class="fa fa-lock"></i> Eliminar</a>';
								}
								echo '
							</td>
						</tr>';
						}

						?>
                      </tbody>
                    </table>
                     <div  id="addDialog" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-sm">
							  <div class="modal-content">
								<div class="modal-header">
								  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
								  </button>
								  <h4 class="modal-title" id="myModalLabel2">Confirmación</h4>
								</div>
								<div class="modal-body">
								  <p>Esta seguro que desea continuar con la operación?</p>
								</div>
								<div class="modal-footer">
								  <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
								  <a id="btnsi" class="btn btn-primary">Si</a>
								</div>

							  </div>
							</div>
					  </div>
                  </div>
                </div>

