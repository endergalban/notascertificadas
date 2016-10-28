		 <div class="form">
          <section class="login_content">
            <?php echo form_open(current_url(),'id="login-form"  novalidate=""'); ?>
              <h1>Reset Password</h1>
               <p><?php echo validation_errors(); echo $message;?></p>

              <div>
               <input type="password" class="form-control" placeholder="Password"  name="password" id="password" required="required" />
              </div>

               <div>
               <input type="password" class="form-control" placeholder="Password de Confirmación"  name="passconf" id="passconf" required="required" />
              </div>



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
