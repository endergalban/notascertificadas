			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
								<h2><?php echo 'Calificaciones de '.$estudiante['apellido'].' '.$estudiante['nombre'];?></h2>
								 <ul class="nav navbar-right panel_toolbox">
									<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
									</li>
									<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
									<ul class="dropdown-menu" role="menu">

										<li><a href="<?php echo site_url(array('user','calificaciones','grados',$estudiante['idestudiante']));?>">Ver Grados del Estudiante</a>
										</li>
										<li><a href="<?php echo site_url(array('user','calificaciones'));?>">Ver Lista de Estudiantes</a>
										</li>
										 <li><a target="_BLANK"  href="<?php echo site_url(array('reportes','rep_certificaciones'));?>">Descagar Certificación en Blanco</a>
										</li>
										<li><a target="_BLANK"  href="<?php echo site_url(array('reportes','rep_certificaciones',$estudiante['idestudiante'],3));?>">Descagar Certificación del Estudiante</a>
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
								<a class="btn btn-default btn-sm" href="<?php echo site_url(array('user','calificaciones','grados',$estudiante['idestudiante']));?>">Ver Grados</a>
								<a class="btn btn-default btn-sm" target="_BLANK"  href="<?php echo site_url(array('reportes','rep_certificaciones',$estudiante['idestudiante'],3));?>">Descagar Certificación del Estudiante</a>.
								<a class="btn btn-default btn-sm" target="_BLANK"  href="<?php echo site_url(array('reportes','rep_certificaciones'));?>">Descagar Certificación en Blanco</a>
							</div>
							<div class="x_content">
								<table  class="table table-striped table-bordered">
								  <thead>
									<tr>
									  <th>Año</th>
									  <th>Materias</th>
									  <th>Educ. Trabajo</th>
									  <th>Acciones</th>
									</tr>
								  </thead>


								  <tbody>
								  <?php

									for($i=0;$i<count($array_grados);$i++)
									{

										echo '
									<tr >
										<td class="text-center">'.$array_grados[$i]['grado'].' Año</td>
										<td class="text-center">'.$array_grados[$i]['cantidad_materias'].'</td>
										<td class="text-center">'.$array_grados[$i]['cantidad_materiaset'].'</td>
										<td class="text-left">

											<a href="'.site_url(array('user','calificaciones','materias',$estudiante['idestudiante'],$array_grados[$i]['grado'])).'" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i>  Calificaciones </a>
											<a href="'.site_url(array('user','calificaciones','listaet',$estudiante['idestudiante'],$array_grados[$i]['grado'])).'" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i>  Edu. Trab. </a>
											<a target="_BLANK" href="'.site_url(array('reportes','rep_certificaciones',$estudiante['idestudiante'],$array_grados[$i]['grado'])).'" class="btn btn-info btn-xs"><i class="fa fa-file-pdf-o"></i>  Descargar </a>
										</td>
									</tr>';
									}

									?>
								  </tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
