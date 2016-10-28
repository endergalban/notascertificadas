		<div class="form login_form">
          <section class="login_content">
           <?php echo form_open('login',array('class'=>'mode2','id'=>'','novalidate'=>'')); ?>
              <h1>Iniciar Sesión</h1>
                <?php echo validation_errors();?>
                <p><?php echo $message;?></p>



				<div class="item form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="email" required="required" value="<?php echo set_value('email'); ?>" />
              </div>

              <div class="item form-group">
                <input type="password" data-validate-length-range="6,20" class="form-control" placeholder="Password"  name="password" id="password" required="required" />
              </div>
              <div>
                <button class="btn btn-default submit" type="submit">Ingresar</button>
                <a class="reset_pass" href="<?php echo site_url('login/restablecer');?>">Olvidaste tu clave?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">No tienes cuenta?
                  <a href="<?php echo site_url('login/registro');?>" class="to_register"> Crea una Nueva </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1>Notas Certificadas!</h1>
                  <p>©2016 Todos los derechos reservados.</p>
                </div>
              </div>
            </form>
          </section>
        </div>
