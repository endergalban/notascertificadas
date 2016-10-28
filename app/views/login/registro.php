		 <div class="form">
          <section class="login_content">
            <?php echo form_open(current_url(),'id="login-form"  novalidate=""'); ?>
              <h1>Nueva Cuenta</h1>
               <p><?php echo validation_errors(); echo $message;?></p>
              <div>
                <input type="text" class="form-control" placeholder="Tu Nombre" name="nombre" id="nombre" required="required" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Email" name="email" id="email" required="required"  />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" name="password" id="password" required="required" />
              </div>
              <div>
		  <div class="g-recaptcha" data-sitekey="6LeqJwcUAAAAAAGMndOCX6ftOBTKkwnAwawJxd_V"></div>
              </div>
 	      <br/>
              <div>
                <button class="btn btn-default submit" type="submit">Registrame</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Ya tienes cuenta ?
                  <a href="<?php echo site_url('login/');?>" class="to_register"> Inicia Sesión </a>
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
