				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
						  <div class="x_title">
							<?php if(isset($idusuario)){echo 'Editando '.$nombre;}else{echo 'Creando nuevo usuario';}?>
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
						<?php echo form_open_multipart(current_url(),array('class'=>'form-horizontal form-label-left','novalidate'=>'')); ?>
							 <div class="item form-group">
								   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="userfile">Imagen Max. 100KB
								   </label>
								   <div class="col-md-6 col-sm-6 col-xs-12">
									   <img src="<?php
									   if(isset($idusuario)){
										   if(file_exists('images/users/'.$miniatura))
										   {
												echo site_url(array('images','users',$miniatura));
										   }else{
												echo site_url(array('images','users','user.png'));
										   }
										}else{
											echo site_url(array('images','users','user.png'));
										}
									   ?>"/>
										<input type="file" name="userfile" size="20" />
									</div>
								</div>
							  <div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12"   name="email" id="email" placeholder="" required="required" type="email" value="<?php if(isset($email)){echo $email;}else{echo set_value('email');} ?>">
								</div>
							  </div>

							  <div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12"  data-validate-length-range="1,100" name="nombre" id="nombre" placeholder="" required="required" type="text" value="<?php if(isset($nombre)){echo $nombre;}else{echo set_value('nombre');} ?>">
								</div>
							  </div>

							   <div class="item form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="idtipousuario">Tipo de Usuario<span class="required">*</span>
									</label>

									 <div class="col-md-3 col-sm-3 col-xs-12">
									  <?php
										$options = array('1'=> 'Administrador','2' => 'Usuario');
										$js = array('id'=> 'idtipousuario','class' => 'select2_single form-control','tabindex' => '-1','required'=>'required');
										if(isset($idusuario)){
											echo form_dropdown('idtipousuario', $options, $idtipousuario,$js);
										}else{
											echo form_dropdown('idtipousuario', $options, set_value('idtipousuario'),$js);
										}
										?>
									</div>
								</div>
								<div class="item form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="activo">Estatus<span class="required">*</span>
									</label>

									 <div class="col-md-3 col-sm-3 col-xs-12">
										<?php
										$options = array('0' => 'Inactivo','1' => 'Activo');
										$js = array('id'       => 'activo','class' => 'select2_single form-control','tabindex' => '-1','required'=>'required');
										if(isset($idusuario)){
											echo form_dropdown('activo', $options, $activo,$js);
										}else{
											echo form_dropdown('activo', $options, set_value('activo'),$js);
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
				  </div>
				</div>
