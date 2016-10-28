 <!-- footer content -->
        <footer >
          <div class="pull-right">
            Desarrollado por - Ing. Ender A. Galbán R. - Email: <a href="mailto:endergalban@gmail.com">endergalban@gmail.com</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

     <div  id="Dialog" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-lg">
				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					  </button>
					  <h4 class="modal-title" id="myModalLabel2">Mensaje</h4>
					</div>
					<div class="modal-body">
						<h4 id="tituloalert"></h4>
					  <p id="mensajealert"></p>
					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					</div>

				  </div>
				</div>
		  </div>
	  </div>
	</div>


    <!-- jQuery -->
    <script src="<?php echo site_url();?>vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo site_url();?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo site_url();?>vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo site_url();?>vendors/nprogress/nprogress.js"></script>

     <!-- validator -->
    <script src="<?php echo site_url();?>/vendors/validator/validator.js"></script>

	  <!-- Datatables -->
    <script src="<?php echo site_url();?>vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo site_url();?>vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo site_url();?>js/moment/moment.min.js"></script>
    <script src="<?php echo site_url();?>js/datepicker/daterangepicker.js"></script>

    <script src="<?php echo site_url();?>/vendors/select2/dist/js/select2.full.min.js"></script>


    <!-- Custom Theme Scripts -->
    <script src="<?php echo site_url();?>js/custom.min.js"></script>

     <!-- validator -->
    <script>
      // initialize the validator function
      validator.message.date = 'No es una fecha real';

      // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
      $('form')
        .on('blur', 'input[required], input.optional, select.required', validator.checkField)
        .on('change', 'select.required', validator.checkField)
        .on('keypress', 'input[required][pattern]', validator.keypress);

      $('.multi.required').on('keyup blur', 'input', function() {
        validator.checkField.apply($(this).siblings().last()[0]);
      });

      $('form').submit(function(e) {
        e.preventDefault();
        var submit = true;

        // evaluate the form using generic validaing
        if (!validator.checkAll($(this))) {
          submit = false;
        }

        if (submit)
          this.submit();

        return false;
      });
    </script>
    <!-- /validator -->

	 <!-- Modal -->
    <script>
	$(document).on("click", ".open-AddDialog", function () {
			 var Url = $(this).data('url');
			 $("#btnsi").attr("href",Url);
			$('#addDialog').modal('show');
		});

	$(document).on("click", ".open-Dialog", function () {
		 var titulo = $(this).data('titulo');
		 var mensaje = $(this).data('mensaje');
		 $("#tituloalert").text(titulo);
		 $("#mensajealert").text(mensaje);
		$('#Dialog').modal('show');
	});
	</script>
	 <!-- Modal -->

    <!-- Datatables -->
     <script>

		$(document).ready(function() {
			$('#datatable').dataTable({

				"language":{
						"url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"
				}

			});
		});

         //datatables

	</script>
	<!-- Datatables -->

	<!-- Otras -->
	<script>

	$(document).ready(function() {
		$(".select2_single").select2({
          placeholder: "Select a state",
          allowClear: true
        });

         $('.date-picker').daterangepicker({
          singleDatePicker: true,
          format: 'DD-MM-YYYY',
          calender_style: "picker_2",
          showDropdowns: true,
           "singleDatePicker": true,
			"showDropdowns": true,
			"showWeekNumbers": true,
			"locale": {
				"format": 'DD-MM-YYYY',
				"separator": " - ",
				"applyLabel": "Apply",
				"cancelLabel": "Cancel",
				"fromLabel": "Desde",
				"toLabel": "hasta",
				"customRangeLabel": "Custom",
				"weekLabel": "S",
				"daysOfWeek": ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'	],
				"monthNames": ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				"firstDay": 1
			},
			"showCustomRangeLabel": false

        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });

      });
    </script>


    <!-- /Otras -->
    <?php
    if(isset($javascript)){
	echo$javascript;
	}
	?>
</body>
</html>
