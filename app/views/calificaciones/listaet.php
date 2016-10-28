		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo ''.$estudiante['apellido'].' '.$estudiante['nombre'].' - '.$grado.' Año';?></h2>
                    <ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>
						<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo site_url(array('user','calificaciones','listaet',$estudiante['idestudiante'],$grado));?>">Registros de Materias Educ. Trab.</a>
								</li>
							<li><a href="<?php echo site_url(array('user','calificaciones','nuevoet',$estudiante['idestudiante'],$grado));?>">Nueva Materia  Educ. Trab.</a>
							</li>
							<li><a href="<?php echo site_url(array('user','calificaciones','grados',$estudiante['idestudiante']));?>">Ver Grados</a>
							</li>
							<li><a href="<?php echo site_url(array('user','calificaciones'));?>">Estudiantes</a>
							</li>
							<li><a target="_BLANK"  href="<?php echo site_url(array('reportes','rep_certificaciones'));?>">Descagar Certificación en Blanco</a>
							</li>
							<li><a target="_BLANK"  href="<?php echo site_url(array('reportes','rep_certificaciones',$estudiante['idestudiante'],$grado));?>">Descagar Certificación del Estudiante</a>
							</li>
						</ul>
						</li>
						<li><a class="close-link"><i class="fa fa-close"></i></a>
						</li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					    <a class="btn btn-default btn-sm" href="<?php echo site_url(array('user','calificaciones','listaet',$estudiante['idestudiante'],$grado));?>">Registros de Materias Educ. Trab.</a>
					    <a class="btn btn-default btn-sm" href="<?php echo site_url(array('user','calificaciones','nuevoet',$estudiante['idestudiante'],$grado));?>">Nueva Materia  Educ. Trab.</a>
					    <a class="btn btn-default btn-sm" href="<?php echo site_url(array('user','calificaciones','grados',$estudiante['idestudiante']));?>">Ver Grados</a>
						<a class="btn btn-default btn-sm" href="<?php echo site_url(array('user','calificaciones'));?>">Estudiantes</a>
						<a class="btn btn-default btn-sm" target="_BLANK"  href="<?php echo site_url(array('reportes','rep_certificaciones',$estudiante['idestudiante'],$grado));?>">Descagar Certificación del Estudiante</a>.
						<a class="btn btn-default btn-sm" target="_BLANK"  href="<?php echo site_url(array('reportes','rep_certificaciones'));?>">Descagar Certificación en Blanco</a>
					</div>
                  <div class="x_content">

                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
						  <th>Orden</th>
                          <th>Materia</th>
                          <th>Horas</th>
                          <th>Acción</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php

						$i=0;
						foreach ($rs_materiaset->result_array() as $fila)
						{
							$i+=1;

							echo '
						<tr >
							<td>'.$i.'</td>
							<td>'.$fila["nombre"].'</td>
							<td class="text-center">'.str_pad($fila["horas"],2,'0',STR_PAD_LEFT).'</td>
							<td class="text-left">
								<a href="'.site_url(array('user','calificaciones','editaret',$fila["idestudiante"],$grado,$fila['idmateriaet'])).'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Editar </a>
								<a href="addDialog"  class="btn btn-danger btn-xs open-AddDialog" data-toggle="modal" data-url="'.site_url(array('user','calificaciones','eliminaret',$fila["idestudiante"],$grado,$fila['idmateriaet'])).'"><i class="fa fa-trash-o"></i> Eliminar </a>
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
			</div>
		</div>
