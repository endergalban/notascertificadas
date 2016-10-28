				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
						  <div class="x_title">
							  <?php if(isset($idescuelaforanea)){echo 'Editando '.$nombre;}else{echo 'Creando una nueva escuela foranea';}?>
							<h2></h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
								</li>
								<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="<?php echo site_url(array('user','escuelasforaneas'));?>">Ver Registros</a>
									</li>
									<li><a href="<?php echo site_url(array('user','escuelasforaneas', 'nuevaescuela'));?>">Nuevo Registro</a>
									</li>
									<li><a target="_BLANK" href="<?php echo site_url(array('reportes', 'rep_escuelasforaneas'));?>">Descargar</a>
									</li>
								</ul>
								</li>
								<li><a class="close-link"><i class="fa fa-close"></i></a>
								</li>
							</ul>
							<div class="clearfix"></div>
						  </div>
						  <div class="x_content">
							<a class="btn btn-default btn-sm" href="<?php echo site_url(array('user','escuelasforaneas'));?>">Registros</a>
							<a class="btn btn-default btn-sm" href="<?php echo site_url(array('user','escuelasforaneas', 'nuevaescuela'));?>">Nuevo Registro</a>
							<a class="btn btn-default btn-sm" target="_BLANK" href="<?php echo site_url(array('reportes', 'rep_escuelasforaneas'));?>">Descargar</a>
						 </div>
						 <div class="x_content">
							<?php echo form_open(current_url(),array('class'=>'form-horizontal form-label-left','novalidate'=>'')); ?>
							<div class="item form-group">
								<label class="control-label col-md-1 col-sm-1 col-xs-12" for="nombre">Nombre <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12" data-validate-length-range="5,80" name="nombre" id="nombre" placeholder="Nombre de la Escuela" required="required" type="text" value="<?php if(isset($idescuelaforanea)){echo $nombre;}else{echo set_value('nombre');} ?>">
								</div>
							</div>
							<div class="item form-group">
								<label class="control-label col-md-1 col-sm-1 col-xs-12" for="localidad">Localidad<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12" data-validate-length-range="1,50" name="localidad" id="localidad"  placeholder="MARACAIBO" required="required" type="text" value="<?php if(isset($localidad)){echo $localidad;}else{echo set_value('localidad');} ?>">
								</div>
							</div>
							<div class="item form-group">
								<label class="control-label col-md-1 col-sm-1 col-xs-12" for="entidad">Entidad<span class="required">*</span>
								</label>
								<div class="col-md-2 col-sm-2 col-xs-4">
								  <input class="form-control col-md-7 col-xs-12" data-validate-length-range="1,4" name="entidad" id="entidad" placeholder="ZU" required="required" type="text" value="<?php if(isset($entidad)){echo $entidad;}else{echo set_value('entidad');} ?>">
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
