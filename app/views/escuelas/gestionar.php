			<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
						  <div class="x_title">
							<?php if(isset($idescuela)){echo 'Editando '.$nombre;}else{echo 'Creando una nueva escuela';}?>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
								</li>
								<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
								<ul class="dropdown-menu" role="menu">
								  <li><a href="<?php echo site_url(array('user','escuelas'));?>">Registros</a>
								  </li>
								   <li><a href="<?php echo site_url(array('user','escuelas', 'nuevaescuela'));?>">Nuevo Registro</a>
									</li>
								</ul>
								</li>
								<li><a class="close-link"><i class="fa fa-close"></i></a>
								</li>
							</ul>
							<div class="clearfix"></div>
						  </div>
						  <div class="x_content">
							  <a class="btn btn-default btn-sm" href="<?php echo site_url(array('user','escuelas'));?>">Registros</a>
							  <a class="btn btn-default btn-sm" href="<?php echo site_url(array('user','escuelas', 'nuevaescuela'));?>">Nuevo Registro</a>
						  </div>
						  <div class="x_content">

							<?php echo form_open(current_url(),array('class'=>'form-horizontal form-label-left','novalidate'=>'')); ?>

							<div class="item form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="director">Director <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12"  data-validate-length-range="5,50" name="director" id="director" placeholder="Nombre del Director" required="required" type="text" value="<?php if(isset($director)){echo $director;}else{echo set_value('director');} ?>">
								</div>
							</div>

							<div class="item form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12"  for="director">Cédula del Director <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12" data-validate-length-range="6,20" name="ceduladirector" id="ceduladirector" placeholder="V-15938686" required="required" type="text" value="<?php if(isset($ceduladirector)){echo $ceduladirector;}else{echo set_value('ceduladirector');} ?>">
								</div>
							</div>

							<div class="item form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="codigo">Código DEA<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12"  data-validate-length-range="6,20" name="codigo" id="codigo" placeholder="PXXXXXXXXX" required="required" type="text" value="<?php if(isset($codigo)){echo $codigo;}else{echo set_value('codigo');} ?>">
								</div>
							</div>

							<div class="item form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="nombre">Nombre <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12"  data-validate-length-range="5,80" name="nombre" id="nombre" placeholder="Nombre de la Escuela" required="required" type="text" value="<?php if(isset($idescuela)){echo $nombre;}else{echo set_value('nombre');} ?>">
								</div>
							</div>

							<div class="item form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="telefono">Teléfono<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12"  data-validate-length-range="12,12" name="telefono" id="telefono" placeholder="0261-7555555" required="required" type="text" value="<?php if(isset($telefono)){echo $telefono;}else{echo set_value('telefono');} ?>">
								</div>
							</div>

							<div class="item form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="telefono">Distrito<span class="required">*</span>
								</label>
								<div class="col-md-2 col-sm-2 col-xs-4">
								  <input class="form-control col-md-7 col-xs-12" data-validate-minmax="1,100" name="distrito" id="distrito" placeholder="13" required="required" type="number" value="<?php if(isset($distrito)){echo $distrito;}else{echo set_value('distrito');} ?>">
								</div>
							</div>

							<div class="item form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="entidad">Entidad<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12" data-validate-length-range="1,50" name="entidad" id="entidad"  placeholder="ZULIA" required="required" type="text" value="<?php if(isset($entidad)){echo $entidad;}else{echo set_value('entidad');} ?>">
								</div>
							</div>

							<div class="item form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="entidadabreviado">Entidad Abreviado<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12" data-validate-length-range="1,4" name="entidadabreviado" id="entidadabreviado"  placeholder="ZU" required="required" type="text" value="<?php if(isset($entidadabreviado)){echo $entidadabreviado;}else{echo set_value('entidadabreviado');} ?>">
								</div>
							</div>

							<div class="item form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="municipio">Municipio<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12" data-validate-length-range="1,50" name="municipio" id="municipio" placeholder="MARACAIBO" required="required" type="text" value="<?php if(isset($municipio)){echo $municipio;}else{echo set_value('municipio');} ?>">
								</div>
							</div>

							<div class="item form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="zona">Zona Educativa<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12" data-validate-length-range="1,50" name="zona" id="zona"  required="required" placeholder="ZULIA" type="text" value="<?php if(isset($zona)){echo $zona;}else{echo set_value('zona');} ?>">
								</div>
							</div>

							<div class="item form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="direccion">Dirección<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12" data-validate-length-range="5,300" name="direccion" id="direccion"  required="required" type="text" value="<?php if(isset($direccion)){echo $direccion;}else{echo set_value('direccion');} ?>">
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
