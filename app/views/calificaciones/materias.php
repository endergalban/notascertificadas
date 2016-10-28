			<h2><?php echo $estudiante['apellido'].' '.$estudiante['nombre'].' - '.$grado.' Año';?></h2>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
					  <div class="x_title">
						<h2>Plan de Estudio</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
								</li>
								<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
								<ul class="dropdown-menu" role="menu">

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
							<a class="btn btn-default btn-sm" href="<?php echo site_url(array('user','calificaciones'));?>">Estudiantes</a>
							<a class="btn btn-default btn-sm" href="<?php echo site_url(array('user','calificaciones','grados',$estudiante['idestudiante']));?>">Ver Grados</a>
							<a class="btn btn-default btn-sm" target="_BLANK"  href="<?php echo site_url(array('reportes','rep_certificaciones',$estudiante['idestudiante'],$grado));?>">Descagar Certificación del Estudiante</a>.
							<a class="btn btn-default btn-sm" target="_BLANK"  href="<?php echo site_url(array('reportes','rep_certificaciones'));?>">Descagar Certificación en Blanco</a>
						</div>
					  <div class="x_content">

						<?php echo form_open(current_url(),array('class'=>'form-horizontal form-label-left','novalidate'=>'')); ?>
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Escuela">Escuela <span class="required">*</span>
								</label>
								<div class="col-md-3 col-sm-3 col-xs-12">
									<?php
									$options = $rs_escuelas;
									$js = array('id'=> 'idescuela','class' => 'select2_single form-control','tabindex' => '-1','required'=>'required');
									if(isset($rs_plan)){
										echo form_dropdown('idescuela', $options, $rs_plan['idescuela'],$js);
									}elseif(isset($rs_plan_precargado)){
										echo form_dropdown('idescuela', $options, $rs_plan_precargado['idescuela'],$js);
									}else{
										echo form_dropdown('idescuela', $options, set_value('idescuela'),$js);
									}
									?>
								</div>
							</div>
							<div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="apellido">Plan <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <input class="form-control col-md-7 col-xs-12" data-validate-length-range="1,100" name="plan" id="plan" placeholder="Plan de Estudio" required="required" type="text" value="<?php if(isset($rs_plan)){echo $rs_plan['plan'];}elseif(isset($rs_plan_precargado)){echo $rs_plan_precargado['plan'];}else{echo set_value('plan');} ?>">
							</div>
						  </div>

						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="apellido">Código <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <input class="form-control col-md-7 col-xs-12" data-validate-length-range="1,8" name="codigo" id="codigo" placeholder="Código" required="required" type="text" value="<?php if(isset($rs_plan)){echo $rs_plan['codigo'];}elseif(isset($rs_plan_precargado)){echo $rs_plan_precargado['codigo'];}else{echo set_value('codigo');} ?>">
							</div>
						  </div>

						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12"  for="mencion">Mención <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <input class="form-control col-md-7 col-xs-12" data-validate-length-range="1,100" name="mencion" id="mencion" placeholder="Mención" required="required" type="text" value="<?php if(isset($rs_plan)){echo $rs_plan['mencion'];}elseif(isset($rs_plan_precargado)){echo $rs_plan_precargado['mencion'];}else{echo set_value('mencion');} ?>">
							</div>
						  </div>

						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="mencion">Obervaciones
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <input class="form-control col-md-7 col-xs-12" data-validate-length-range="0,500"  name="observacion" id="observacion" placeholder=""  type="text" value="<?php if(isset($rs_plan)){echo $rs_plan['observacion'];}else{echo set_value('observacion');} ?>">
							</div>
						  </div>
						  <div class="ln_solid"></div>
					  </div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
								<h2>Materias</h2>

								 <ul class="nav navbar-right panel_toolbox">
									<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
									</li>
									<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
									<ul class="dropdown-menu" role="menu">
										<li><a href="<?php echo site_url(array('user','calificaciones'));?>">Ver lista de estudiantes</a>
										</li>
										<li><a href="<?php echo site_url(array('user','calificaciones','grados',$estudiante['idestudiante']));?>">Ver Grados del Estudiante</a>
										</li>
										<li><a target="_BLANK"  href="<?php echo site_url(array('reportes','rep_certificaciones'));?>">Descagar certificación en blanco</a>
										</li>
										<li><a target="_BLANK"  href="<?php echo site_url(array('reportes','rep_certificaciones',$estudiante['idestudiante'],$grado));?>">Descagar certificación del Estudiante</a>
										</li>
									</ul>
									</li>
									<li><a class="close-link"><i class="fa fa-close"></i></a>
									</li>
								</ul>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">

							<div class="col-md-1 col-sm-12 col-xs-12 form-group">
								<label class="control-label" for="materia">Nro
							</div>

							<div class="col-md-3 col-sm-12 col-xs-12 form-group">
								<label class="control-label" for="materia">Asignatura
							</div>

							<div class="col-md-1 col-sm-12 col-xs-12 form-group">
								<label class="control-label" for="calificacion">Calificación
							</div>

							<div class="col-md-1 col-sm-12 col-xs-12 form-group">
								<label class="control-label" for="tipo">T.E.
							</div>

							<div class="col-md-1 col-sm-12 col-xs-12 form-group">
								<label class="control-label" for="mes">Mes
							</div>

							<div class="col-md-1 col-sm-12 col-xs-12 form-group">
								<label class="control-label" for="anio">Año
							</div>

							<div class="col-md-4 col-sm-12 col-xs-12 form-group">
								<label class="control-label" for="plantel">Plantel
							</div>
								  <?php
									$i=0;
									foreach($rs_materias->result_array() as $fila)
									{
										$i=$i+1;
										echo '
											<div class="col-md-1 col-sm-12 col-xs-12 form-group ">
												<input type="text" value="'.$i.'" class="form-control text-center" disabled>
											  </div>

											  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
												<input type="text" id="materias[]" name="materias[]" value="'.$fila['materia'].'" class="form-control">
											  </div>

											  <div class="col-md-1 col-sm-12 col-xs-12 form-group">
												<input type="text" id="notas[]" name="notas[]" value="'.$fila['nota'].'" class="form-control">
											  </div>



											  <div class="col-md-1 col-sm-12 col-xs-12 form-group">
												';
												$options =  array(''=> '','F'=> 'F','R'=> 'R','P'=> 'P','PR'=> 'PR','EX'=> 'EX','EQ'=> 'EQ','CAB'=> 'CAB','C'=> 'C');
												$js = array('id'=> 'tipos[]','class' => 'select2_single form-control','tabindex' => '-1');
												if($rs_materias){
													echo form_dropdown('tipos[]', $options, $fila['tipo'],$js);
												}else{
													echo form_dropdown('tipos[]', $options, '',$js);
												}
												echo'
											  </div>

											  <div class="col-md-1 col-sm-12 col-xs-12 form-group">
												';
												$options =  array(''=> '','1'=> '01','2'=> '02','3'=> '03','4'=> '04','5'=> '05','6'=> '06','7'=> '07','8'=> '08','9'=> '09','10'=> '10','11'=> '11','12'=> '12',);
												$js = array('id'=> 'mess[]','class' => 'select2_single form-control','tabindex' => '-1');
												if($rs_materias){
													echo form_dropdown('mess[]', $options, $fila['mes'],$js);
												}else{
													echo form_dropdown('mess[]', $options, '',$js);
												}
												echo'
											  </div>

											  <div class="col-md-1 col-sm-12 col-xs-12 form-group">
												<input type="text" placeholder="" id="anios[]" name="anios[]" value="'.$fila['anio'].'" class="form-control">
											  </div>

											  <div class="col-md-4 col-sm-12 col-xs-12 form-group">';

												$options = $rs_escuelasforaneas;
												$js = array('id'=> 'idescuelaforaneas[]','class' => 'select2_single form-control','tabindex' => '-1');
												if($rs_materias){
													echo form_dropdown('idescuelaforaneas[]', $options, $fila['idescuelaforanea'],$js);
												}else{
													echo form_dropdown('idescuelaforaneas[]', $options, '0',$js);
												}
												echo'
												</div>
										';
									}

									if($i==0)
									{
										foreach($rs_materias_precargada->result_array() as $fila)
										{
											$i=$i+1;
											echo '
												<div class="col-md-1 col-sm-12 col-xs-12 form-group ">
													<input type="text" value="'.$i.'" class="form-control text-center" disabled>
												  </div>

												  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
													<input type="text" id="materias[]" name="materias[]" value="'.$fila['materia'].'" class="form-control">
												  </div>

												  <div class="col-md-1 col-sm-12 col-xs-12 form-group">
													<input type="text" id="notas[]" name="notas[]" value="" class="form-control">
												  </div>



												  <div class="col-md-1 col-sm-12 col-xs-12 form-group">
													';
													$options =  array(''=> '','F'=> 'F','R'=> 'R','P'=> 'P','PR'=> 'PR','EX'=> 'EX','EQ'=> 'EQ','CAB'=> 'CAB','C'=> 'C');
													$js = array('id'=> 'tipos[]','class' => 'select2_single form-control','tabindex' => '-1');
													if($rs_materias_precargada){
														echo form_dropdown('tipos[]', $options, 'F',$js);
													}else{
														echo form_dropdown('tipos[]', $options, '',$js);
													}
													echo'
												  </div>

												  <div class="col-md-1 col-sm-12 col-xs-12 form-group">
													';
													$options =  array(''=> '','1'=> '01','2'=> '02','3'=> '03','4'=> '04','5'=> '05','6'=> '06','7'=> '07','8'=> '08','9'=> '09','10'=> '10','11'=> '11','12'=> '12',);
													$js = array('id'=> 'mess[]','class' => 'select2_single form-control','tabindex' => '-1');
													if($rs_materias_precargada){
														echo form_dropdown('mess[]', $options, '7',$js);
													}else{
														echo form_dropdown('mess[]', $options, '',$js);
													}
													echo'
												  </div>

												  <div class="col-md-1 col-sm-12 col-xs-12 form-group">
													<input type="text" placeholder="" id="anios[]" name="anios[]" value="'.$fila['anio'].'" class="form-control">
												  </div>

												  <div class="col-md-4 col-sm-12 col-xs-12 form-group">';

													$options = $rs_escuelasforaneas;
													$js = array('id'=> 'idescuelaforaneas[]','class' => 'select2_single form-control','tabindex' => '-1');
													if($rs_materias_precargada){
														echo form_dropdown('idescuelaforaneas[]', $options, $fila['idescuelaforanea'],$js);
													}else{
														echo form_dropdown('idescuelaforaneas[]', $options, '0',$js);
													}
													echo'
													</div>
											';
										}


									}

									for($i=$i;$i<17;$i++)
									{
									echo '
										<div class="col-md-1 col-sm-12 col-xs-12 form-group">
												<input type="text" value="'.($i+1).'" class="form-control text-center" disabled>
											  </div>

										  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
											<input type="text" id="materias[]" name="materias[]" class="form-control" value="'.set_value('materias['.$i.']').'">
										  </div>

										  <div class="col-md-1 col-sm-12 col-xs-12 form-group">
											<input type="text" id="notas[]" name="notas[]" class="form-control" value="'.set_value('notas['.$i.']').'">
										  </div>



										  <div class="col-md-1 col-sm-12 col-xs-12 form-group">
											';
											$options =  array(''=> '','F'=> 'F','R'=> 'R','P'=> 'P','PR'=> 'PR','EX'=> 'EX','EQ'=> 'EQ','CAB'=> 'CAB','C'=> 'C');
											$js = array('id'=> 'tipos[]','class' => 'select2_single form-control','tabindex' => '-1');
											echo form_dropdown('tipos[]', $options, set_value('tipos['.$i.']'),$js);
											echo'
										  </div>

										  <div class="col-md-1 col-sm-12 col-xs-12 form-group">
											';
											$options =  array(''=> '','1'=> '01','2'=> '02','3'=> '03','4'=> '04','5'=> '05','6'=> '06','7'=> '07','8'=> '08','9'=> '09','10'=> '10','11'=> '11','12'=> '12',);
											$js = array('id'=> 'mess[]','class' => 'select2_single form-control','tabindex' => '-1');
											echo form_dropdown('mess[]', $options,  set_value('mess['.$i.']'),$js);
											echo'
										  </div>

										  <div class="col-md-1 col-sm-12 col-xs-12 form-group">
													<input type="text" placeholder="" id="anios[]" name="anios[]" value="'.set_value('anios['.$i.']').'" class="form-control">
												  </div>

										  <div class="col-md-4 col-sm-12 col-xs-12 form-group">';

											$options = $rs_escuelasforaneas;
											$js = array('id'=> 'idescuelaforaneas[]','class' => 'select2_single form-control','tabindex' => '-1');
											echo form_dropdown('idescuelaforaneas[]', $options,  set_value('idescuelaforaneas['.$i.']'),$js);
											echo'
											</div>
									';
									}

									?>

									<div class="form-group">
										<div class="col-md-12 text">
										  <button id="send" type="submit" class="btn btn-success">Guardar</button>
										</div>
									</div>
								<?php echo form_close();?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<br/><br/>
