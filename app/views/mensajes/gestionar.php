				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
						  <div class="x_title">
							  <?php if(isset($idmensaje)){echo 'Editando Mensaje';}else{echo 'Creando nuevo mensaje';}?>
							<h2></h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
								</li>
								<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="<?php echo site_url(array('user','mensajes'));?>">Ver Registros</a>
									</li>
									<li><a href="<?php echo site_url(array('user','mensajes', 'nuevomensaje'));?>">Nuevo Registro</a>
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
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="asunto">Asunto <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12" data-validate-length-range="1,500" name="asunto" id="asunto" placeholder="" required="required" type="text" value="<?php if(isset($asunto)){echo $asunto;}else{echo set_value('asunto');} ?>">
								</div>
							</div>
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="mensaje">Mensaje<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <textarea data-validate-length-range="1,5000" name="mensaje" id="mensaje" rows="10" placeholder="" required="required" class="form-control col-md-7 col-xs-12"><?php if(isset($mensaje)){echo $mensaje;}else{echo set_value('mensaje');} ?></textarea>
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
