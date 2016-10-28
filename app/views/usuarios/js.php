<script>
		$(document).ready(function() {

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
					"url": "<?php echo site_url('user/ajax_usuarios')?>",
					"type": "POST"
				},
				aoColumns:[
						{"sClass":"text-center"},
						{"sClass":""},
						{"sClass":""},
						{"sClass":"text-center"},
						{"sClass":"text-center"},
						{"sClass":"text-center"},
						{"sClass":"text-center"},
				],


				//Set column definition initialisation properties.
				"columnDefs": [
				{
					"targets": [ 0,4,5,6], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
			});
		});
	</script>
