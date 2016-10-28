				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
						  <div class="x_title">
							<h2><?php if(isset($idestudiante)){echo 'Editando '.$apellido.' '.$nombre;}else{echo 'Creando nuevo estudiante';}?></h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
								</li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
									<ul class="dropdown-menu" role="menu">

										<li><a href="<?php echo site_url(array('user','estudiantes'));?>">Registros</a></li>
										<li><a href="<?php echo site_url(array('user','estudiantes', 'nuevoestudiante'));?>">Nuevo Registro</a></li>
										<li><a target="_BLANK" href="<?php echo site_url(array('reportes', 'rep_estudiantes'));?>">Descargar</a></li>
									</ul>
								</li>
								<li><a class="close-link"><i class="fa fa-close"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						  </div>
						  <div class="x_content">
							  <a class="btn btn-default btn-sm" href="<?php echo site_url(array('user','estudiantes'));?>">Registros</a>
							  <a class="btn btn-default btn-sm" href="<?php echo site_url(array('user','estudiantes', 'nuevoestudiante'));?>">Nuevo Registro</a>
							  <a class="btn btn-default btn-sm" target="_BLANK" href="<?php echo site_url(array('reportes', 'rep_estudiantes'));?>">Descargar</a>
						  </div>
						  <div class="x_content">

							<?php echo form_open(current_url(),array('class'=>'form-horizontal form-label-left','novalidate'=>'')); ?>
								<div class="item form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="apellido">Apellido <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12" data-validate-length-range="1,80" name="apellido" id="apellido" placeholder="Apellido del estudiante" required="required" type="text" value="<?php if(isset($apellido)){echo $apellido;}else{echo set_value('apellido');} ?>">
								</div>
							  </div>
							  <div class="item form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="nombre">Nombre <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12" data-validate-length-range="1,80" name="nombre" id="nombre" placeholder="Nombre del estudiante" required="required" type="text" value="<?php if(isset($idestudiante)){echo $nombre;}else{echo set_value('nombre');} ?>">
								</div>
							  </div>

							  <div class="item form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" data-validate-length-range="1,15" for="cedula">Identificación<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12" name="cedula" id="cedula" placeholder="V15000000" required="required" type="text" value="<?php if(isset($cedula)){echo $cedula;}else{echo set_value('cedula');} ?>">
								</div>
							  </div>

							   <div class="item form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="fechanac">Fecha de Nacimiento<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="date-picker form-control col-md-7 col-xs-12 active" name="fechanac" id="fechanac" placeholder="28-12-1981" required="required" type="date" value="<?php if(isset($fechanac)){echo date("d-m-Y",strtotime($fechanac));}else{echo set_value('fechanac');} ?>">
								</div>
							  </div>

							  <div class="item form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" data-validate-length-range="1,50" for="entidad">Entidad o País de Nacimiento<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12" data-validate-length-range="1,50" name="entidad" id="entidad"  required="required" type="text" value="<?php if(isset($entidad)){echo $entidad;}else{echo set_value('entidad');} ?>">
								</div>
							  </div>

							  <div class="item form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="lugarnacimiento">Lugar de Nacimiento<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12" name="lugarnacimiento" id="lugarnacimiento"  required="required" type="text" value="<?php if(isset($lugarnacimiento)){echo $lugarnacimiento;}else{echo set_value('lugarnacimiento');} ?>">
								</div>
							  </div>
							  <div class="ln_solid"></div>
							  <div class="form-group">
								<div class="col-md-6">
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
