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

							<li><a href="<?php echo site_url(array('user','calificaciones'));?>">Ver lista de estudiantes</a>
							</li>
							<li><a target="_BLANK" href="<?php echo site_url(array('reportes','rep_certificaciones'));?>">Descagar certificación en blanco</a>
							</li>
						</ul>
						</li>
						<li><a class="close-link"><i class="fa fa-close"></i></a>
						</li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					  <a class="btn btn-default btn-sm" href="<?php echo site_url(array('user','calificaciones'));?>">Estudiantes</a>
					  <a class="btn btn-default btn-sm" target="_BLANK" href="<?php echo site_url(array('reportes','rep_certificaciones'));?>">Descagar certificación en blanco</a>
				  </div>
                  <div class="x_content">


                    <table id="datatableServerSide" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Apellido</th>
                          <th>Nombre</th>
                          <th>Cédula</th>
                          <th>Fecha de Nacimiento</th>
                          <th>Lugar de Nacimiento</th>
                          <th>Entidad o País</th>
                          <th>Acción</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                  </div>
                </div>
			</div>
		</div>
