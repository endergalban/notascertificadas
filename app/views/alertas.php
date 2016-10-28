<?php
	if($tipo==0)
	{
		if(validation_errors())
		{
			echo validation_errors('
			<div class="alert alert-warning alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>','
			</div>');
		}
	}elseif($tipo==1){
		echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				Operación realizada con éxito!
			</div>';
	}elseif($tipo==2){
		echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				Registro eliminado con éxito!
			</div>';
	}elseif($tipo==3){
		echo '<div class="alert alert-warning alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				Registro no encontrado!
			</div>';
	}elseif($tipo==6){
		echo '<div class="alert alert-warning alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				El código de verficación a caducado. Debe registrar una nueva cuenta de usuario.
			</div>';
	}elseif($tipo==10){
		echo '<div class="alert alert-warning alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				'.$this->upload->display_errors().'
			</div>';
	}

?>
