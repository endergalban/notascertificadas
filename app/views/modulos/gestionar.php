				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
						  <div class="x_title">
							<?php if(isset($idmodulo)){echo 'Editando '.$descripcion;}else{echo 'Creando nuevo módulo';}?>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
								</li>
								<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="<?php echo site_url(array('user','modulos'));?>">Ver Registros</a>
									</li>
									<li><a href="<?php echo site_url(array('user','modulos','nuevomodulo'));?>">Nuevo Registro</a>
									</li>
								</ul>
								</li>
								<li><a class="close-link"><i class="fa fa-close"></i></a>
								</li>
							</ul>
							<div class="clearfix"></div>
						  </div>
						  <div class="x_content">
							<?php echo form_open(current_url(),array('class'=>'form-horizontal form-label-left','novalidate'=>'')); ?>
							  <div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="descripcion">Nombre <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12" data-validate-length-range="5,50" name="descripcion" id="descripcion" placeholder="Nombre del módulo" required="required" type="text" value="<?php if(isset($descripcion)){echo $descripcion;}else{echo set_value('descripcion');} ?>">
								</div>
							  </div>

							  <div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="archivo">Función<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12"  data-validate-length-range="5,100" name="archivo" id="archivo" placeholder="" required="required" type="text" value="<?php if(isset($archivo)){echo $archivo;}else{echo set_value('archivo');} ?>">
								</div>
							  </div>

							   <div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12"  for="orden">Orden<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12"  data-validate-minmax="1,99" name="orden" id="orden"  required="required" type="number" value="<?php if(isset($orden)){echo $orden;}else{echo set_value('orden');} ?>">
								</div>
							  </div>

							  <div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="icono">Icono<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12"  data-validate-length-range="5,30" name="icono" id="icono"  required="required" type="text" value="<?php if(isset($icono)){echo $icono;}else{echo set_value('icono');} ?>">
								</div>
							  </div>

							  <div class="item form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="activo">Visible<span class="required">*</span>
									</label>

									 <div class="col-md-3 col-sm-3 col-xs-12">
										<?php
										$options = array('1' => 'Si','0' => 'No');
										$js = array('id'   => 'visible','class' => 'select2_single form-control','tabindex' => '-1','required'=>'required');
										if(isset($idusuario)){
											echo form_dropdown('visible', $options, $visible,$js);
										}else{
											echo form_dropdown('visible', $options, set_value('visible'),$js);
										}
										?>
									</div>
								</div>
							  <div class="ln_solid"></div>
							  <div class="form-group">
								<div class="col-md-6 col-md-offset-3">
								  <button type="reset" class="btn btn-primary">Cancelar</button>
								  <button id="send" type="submit" class="btn btn-success">Guardar</button>
								</div>
							  </div>
							<?php echo form_close();?>
						  </div>
						</div>
					  </div>
					</div>

