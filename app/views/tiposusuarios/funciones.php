<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Funciones del <?php echo $descripcion;?></h2>
                    <ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>
						<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
						<ul class="dropdown-menu" role="menu">
						  <li><a href="<?php echo site_url(array('user','tipousuario'));?>">Ver Registros</a>
						  </li>
						  <li><a href="<?php echo site_url(array('user','tipousuario', 'nuevotipousuario'));?>">Nuevo Registro</a>
						  </li>
						</ul>
						</li>
						<li><a class="close-link"><i class="fa fa-close"></i></a>
						</li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
				<?php echo form_open(current_url(),array('class'=>'form-horizontal form-label-left','novalidate'=>'','id'=>'form')); ?>
					<div class="form-group">
						<div class="col-md-6">
						  <button id="send" type="submit" class="btn btn-success">Guardar</button>
						</div>
					</div>
                    <table  class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Nro</th>
                          <th>Función</th>
						  <th>Marcar</th>
                        </tr>
                      </thead>


                      <tbody>
					  <?php

						$i=0;
						foreach ($rs_funciones->result_array() as $fila)
						{
							$i+=1;
							$chequeo='';
							if($fila["activo"]>0){$chequeo='checked';}
							echo '
						<tr>
							<td class="text-center">'.$i.'</td>
							<td class="text-left">'.$fila["descripcion"].'</td>
							<td class="text-center"><input class="flat" type="checkbox" '.$chequeo.' name="funciones[]" id="funciones[]" value="'.$fila["idmodulo"].'"/></td>

						</tr>';
						}

						?>
                      </tbody>
                    </table>
                    <div class="form-group">
						<div class="col-md-6">
						  <button id="send" name="send" type="submit" class="btn btn-success">Guardar</button>
						  <input type="hidden" name="id" id="id" value="<?php echo $idtipousuario;?>"/>
						</div>
					</div>
				<?php echo form_close();?>
			  </div>
			</div>
