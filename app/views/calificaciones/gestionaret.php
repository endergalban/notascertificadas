				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
						  <div class="x_title">
							<h2><?php if(isset($rs_materia)){echo $estudiante['apellido'].' '.$estudiante['nombre'].' - '.$grado.' Año - Materia Educ. Trab. '.$rs_materia['nombre'];}else{echo $estudiante['apellido'].' '.$estudiante['nombre'].' - '.$grado.' Año - Nueva materia Educ. Trab.';}?></h2>
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
										<li><a target="_BLANK"  href="<?php echo site_url(array('reportes','rep_certificaciones',$estudiante['idestudiante'],$grado,3));?>">Descagar Certificación del Estudiante</a>
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
								<a class="btn btn-default btn-sm" target="_BLANK"  href="<?php echo site_url(array('reportes','rep_certificaciones',$estudiante['idestudiante'],3));?>">Descagar Certificación del Estudiante</a>.
								<a class="btn btn-default btn-sm" target="_BLANK"  href="<?php echo site_url(array('reportes','rep_certificaciones'));?>">Descagar Certificación en Blanco</a>
							</div>
						  <div class="x_content">

							<?php echo form_open(current_url(),array('class'=>'form-horizontal form-label-left','novalidate'=>'')); ?>
								<div class="item form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="nombre">Nombre de Materia <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12" data-validate-length-range="1,100" name="nombre" id="nombre" placeholder="Nombre de materia" required="required" type="text" value="<?php if(isset($rs_materia)){echo $rs_materia['nombre'];}else{echo set_value('nombre');} ?>">
								</div>
							  </div>
							  <div class="item form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12"  for="horas">Horas de Clases <span class="required">*</span>
								</label>
								<div class="col-md-2 col-sm-2 col-xs-4	">
								  <input class="form-control col-md-7 col-xs-12" data-validate-length-range="1,2" data-validate-minmax="1,99" name="horas" id="horas" placeholder="04" required="required" type="number" value="<?php if(isset($rs_materia)){echo $rs_materia['horas'];}else{echo set_value('horas');} ?>">
								</div>
							  </div>

							  <div class="ln_solid"></div>
							  <div class="form-group">
								<div class="col-md-6 ">
								  <button type="reset" class="btn btn-primary">Cancelar</button>
								  <button id="send" type="submit" class="btn btn-success">Guardar</button>
								</div>
							  </div>
							<?php echo form_close();?>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
				</div>
