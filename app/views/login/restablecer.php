		 <div class="form">
          <section class="login_content">
            <?php echo form_open(current_url(),'id="login-form"  novalidate=""'); ?>
              <h1>Reset Password</h1>
               <p><?php echo validation_errors(); echo $message;?></p>

              <div>
                <input type="email" class="form-control" placeholder="Email" name="email" id="email" required="required"  />
              </div>

              <div>
		  <div class="g-recaptcha" data-sitekey="6LeqJwcUAAAAAAGMndOCX6ftOBTKkwnAwawJxd_V"></div>
              </div>
	      <br/>
              <div>
                <button class="btn btn-default submit" type="submit">Enviar</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">


                <div>
                  <h1>Notas Certificadas!</h1>
                  <p>©2016 Todos los derechos reservados.</p>
                </div>
              </div>
            </form>
          </section>
        </div>
