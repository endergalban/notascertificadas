				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
						  <div class="x_title">
							<h2>Perfil</h2>
							<div class="clearfix"></div>
						  </div>
						  <div class="x_content">
							<?php echo form_open_multipart(current_url(),array('class'=>'form-horizontal form-label-left','novalidate'=>'')); ?>
							   <div class="item form-group">
								   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="userfile">Imagen
								   </label>

								   <div class="col-md-6 col-sm-6 col-xs-12">
									   <img src="<?php
										  if(file_exists('images/users/'.$miniatura))
										   {
												echo site_url(array('images','users',$miniatura));
										   }else{
												echo site_url(array('images','users','user.png'));
										   }
											?>"/>
										<input type="file" id="userfile" name="userfile" size="20" />
									</div>
								</div>
							   <div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input  class="form-control col-md-7 col-xs-12" name="email" id="email" placeholder="" disabled="disabled" type="email" value="<?php echo $email; ?>">
								</div>
							  </div>

							  <div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="archivo">Nombre<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input  class="form-control col-md-7 col-xs-12" data-validate-length-range="1,100" name="nombre" id="nombre" placeholder="" required="required" type="text" value="<?php echo $nombre; ?>">
								</div>
							  </div>
							  <div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12" data-validate-length-range="6,20" name="password" id="password" placeholder=""  type="password" >
								</div>
							  </div>
							  <div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="archivo">Confirmación
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input class="form-control col-md-7 col-xs-12" name="passconf" id="passconf" placeholder="" data-validate-linked='password' type="password" >
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
