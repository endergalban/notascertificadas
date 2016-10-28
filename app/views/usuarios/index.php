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
						  <li><a href="<?php echo site_url(array('user','usuarios','nuevousuario'));?>">Nuevo Registro</a>
						  </li>
						   <li><a href="<?php echo site_url(array('user','usuarios'));?>">Ver Registros</a>
						  <li><a target="_BLANK" href="<?php echo site_url(array('reportes','rep_usuarios'));?>">Descargar</a>
						  </li>
						</ul>
						</li>
						<li><a class="close-link"><i class="fa fa-close"></i></a>
						</li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <table id="datatableServerSide" class="table table-striped table-bordered">
                      <thead>
                        <tr>
						  <th>Imagen</th>
                          <th>Nombre</th>
                          <th>Email</th>
                          <th>Tipo de Usuario</th>
                          <th>Restablecer Clave</th>
                          <th>Estatus</th>
                          <th>Acción</th>
                        </tr>
                      </thead>


                      <tbody>

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

