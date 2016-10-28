<script>
		var csrf_cookie_name_notas: jquery.cookie('csrf_cookie_name_notas');
		$(document).ready(function() {
			//var csrf_test_name_notas = '<?php echo $this->security->get_csrf_hash(); ?>';
			var table = $('#datatableServerSide').DataTable({

				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
				"language":{
						"url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"
				},
				// Load data for the table's content from an Ajax source

				"ajax": {
					"dataType": "json",
					"url": "<?php echo site_url('user/ajax_estudiantes')?>",
					"type": "POST",
					"data": {"csrf_test_name_notas": csrf_cookie_name_notas }
				},
				aoColumns:[
						{"sClass":""},
						{"sClass":""},
						{"sClass":"text-center"},
						{"sClass":"text-center"},
						{"sClass":"text-center"},

				],
				//Set column definition initialisation properties.
				"columnDefs": [
				{
					"targets": [ 4], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
			});
		});
	</script>
