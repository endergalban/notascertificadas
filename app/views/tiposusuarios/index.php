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
						  <li><a href="<?php echo site_url(array('user','tipousuario'));?>">Ver Registros</a>
						  </li>
						  <li><a href="<?php echo site_url(array('user','tipousuario', 'nuevotipousuario'));?>">Nuevo Registro</a>
						  </li>
						</ul>
						</li>
						<li><a class="close-link"><i class="fa fa-close"></i></a>
						</li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Código</th>
                          <th>Tipo de Usuario</th>
                          <th>Usuarios</th>
                          <th>Modulos</th>
                          <th>Acción</th>
                        </tr>
                      </thead>


                      <tbody>
					  <?php

						foreach ($rs_tipousuario->result_array() as $fila)
						{
							echo '
						<tr>
							<td  class="text-center">'.str_pad($fila["idtipousuario"],5,'0',STR_PAD_LEFT).'</td>
							<td>'.$fila["descripcion"].'</td>
							<td  class="text-center">'.$fila["bloqueado2"].'</td>
							<td  class="text-center">'.$fila["bloqueado"].'</td>
							<td class="text-left">
								<a href="'.site_url(array('user','tipousuario','editartipousuario',$fila["idtipousuario"])).'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Editar </a>
								<a href="'.site_url(array('user','tipousuario','permisotipousuario',$fila["idtipousuario"])).'" class="btn btn-success btn-xs"><i class="fa fa-bars"></i> Funciones </a>';
								if($fila["bloqueado"]==0 && $fila["bloqueado2"]==0){
									echo'<a href="addDialog"  class="btn btn-danger btn-xs open-AddDialog" data-toggle="modal" data-url="'.site_url(array('user','tipousuario','eliminartipousuario',$fila["idtipousuario"])).'"><i class="fa fa-trash-o"></i> Eliminar </a>';
								}else{
									echo'<a href="#" class="btn btn-danger btn-xs"  title="Bloqueado por poseer registros dependientes"><i class="fa fa-lock"></i> Eliminar</a>';
								}
								echo'
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

