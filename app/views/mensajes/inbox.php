		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Registros Almacenados</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="" class="table table-striped projects">
                      <thead>
                        <tr>
						  <th>Imagen</th>
						  <th>Usuario</th>
                          <th>Asunto</th>
                           <th>Fecha</th>
                          <th>Ver</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php

						foreach ($rs_mensajes->result_array() as $fila)
						{
							echo '
						<tr >
							<td class="text-center"><img class="avatar" src="'.site_url(array('images','users',$fila['miniatura'])).'" /></td>
							<td>'.$fila["usuario"].'</td>
							<td>'.$fila["asunto"].'</td>
							<td>'.nice_date($fila["fechahora"],'d-m-Y h:i:s a').'</td>
							<td class="text-center">
							<a href="Dialog" class="btn btn-primary btn-xs open-Dialog"  data-toggle="modal" data-titulo="'.$fila['asunto'].'" data-mensaje="'.$fila['mensaje'].'" ><i class="fa fa-search"></i> Ver</a>
							</td>
						</tr>';
						}

						?>
                      </tbody>
                    </table>
