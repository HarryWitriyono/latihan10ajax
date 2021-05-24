<html>  
    <head>  
        <title>PHP Ajax Crud using JQuery UI Dialog</title>  
		<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<!--<link rel="stylesheet" href="jquery-ui.css">
        <link rel="stylesheet" href="bootstrap.min.css" />
		<script src="jquery.min.js"></script>  
		<script src="jquery-ui.js"></script>-->
    </head>  
    <body>  
        <div class="container">
			<br />
			
			<h3 align="center">PHP Ajax Crud using JQuery UI Dialog</a></h3><br />
			<br />
			<div align="right" style="margin-bottom:5px;">
			<button type="button" name="add" id="add" class="btn btn-success btn-xs">Add</button>
			</div>
			<div class="table-responsive" id="user_data">
				
			</div>
			<br />
		</div>
		
		<div id="user_dialog" title="Add Data">
			<form method="post" id="user_form">
				<div class="form-group">
					<label>Enter Kode Barang</label>
					<input type="text" name="kodebarang" id="kodebarang" class="form-control" />
					<span id="error_kode_barang" class="text-danger"></span>
				</div>
				<div class="form-group">
					<label>Enter Nama Barang</label>
					<input type="text" name="namabarang" id="namabarang" class="form-control" />
					<span id="error_nama_barang" class="text-danger"></span>
				</div>
				<div class="form-group">
					<label>Enter Jumlah Stok terakhir</label>
					<input type="text" name="jumlah" id="jumlah" class="form-control" />
					<span id="error_jumlah_barang" class="text-danger"></span>
				</div>
				<div class="form-group">
					<label>Enter Satuan Barang</label>
					<input type="text" name="satuan" id="satuan" class="form-control" />
					<span id="error_satuan_barang" class="text-danger"></span>
				</div>
				<div class="form-group">
					<label>Enter Harga Satuan</label>
					<input type="text" name="hargasatuan" id="hargasatuan" class="form-control" />
					<span id="error_hargasatuan_barang" class="text-danger"></span>
				</div>
				<div class="form-group">
					<input type="hidden" name="action" id="action" value="insert" />
					<input type="hidden" name="hidden_id" id="hidden_id" />
					<input type="submit" name="form_action" id="form_action" class="btn btn-info" value="Insert" />
				</div>
			</form>
		</div>
		
		<div id="action_alert" title="Action">
			
		</div>
		
		<div id="delete_confirmation" title="Confirmation">
		<p>Are you sure you want to Delete this data?</p>
		</div>
		
    </body>  
</html>  




<script>  
$(document).ready(function(){  

	load_data();
    
	function load_data()
	{
		$.ajax({
			url:"fetch.php",
			method:"POST",
			success:function(data)
			{
				$('#user_data').html(data);
			}
		});
	}
	
	$("#user_dialog").dialog({
		autoOpen:false,
		width:400
	});
	
	$('#add').click(function(){
		$('#user_dialog').attr('title', 'Add Data');
		$('#action').val('insert');
		$('#form_action').val('Insert');
		$('#user_form')[0].reset();
		$('#form_action').attr('disabled', false);
		$("#user_dialog").dialog('open');
	});
	
	$('#user_form').on('submit', function(event){
		event.preventDefault();
		var error_kode_barang = '';
		var error_nama_barang = '';
		if($('#kodebarang').val() == '')
		{
			error_kode_barang = 'Kode barang wajib diisi !';
			$('#error_kode_barang').text(error_kode_barang);
			$('#kodebarang').css('border-color', '#cc0000');
		}
		else
		{
			error_kode_barang = '';
			$('#error_kode_barang').text(error_kode_barang);
			$('#kodebarang').css('border-color', '');
		}
		if($('#namabarang').val() == '')
		{
			error_nama_barang = 'Nama barang wajib diisi';
			$('#error_nama_barang').text(error_nama_barang);
			$('#namabarang').css('border-color', '#cc0000');
		}
		else
		{
			error_nama_barang = '';
			$('#error_nama_barang').text(error_nama_barang);
			$('#namabarang').css('border-color', '');
		}
		
		if(error_kode_barang != '' || error_nama_barang != '')
		{
			return false;
		}
		else
		{
			$('#form_action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url:"action.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					$('#user_dialog').dialog('close');
					$('#action_alert').html(data);
					$('#action_alert').dialog('open');
					load_data();
					$('#form_action').attr('disabled', false);
				}
			});
		}
		
	});
	
	$('#action_alert').dialog({
		autoOpen:false
	});
	
	$(document).on('click', '.edit', function(){
		var id = $(this).attr('id');
		var action = 'fetch_single';
		$.ajax({
			url:"action.php",
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data)
			{
				$('#kodebarang').val(data.kodebarang);
				$('#namabarang').val(data.namabarang);
				$('#jumlah').val(data.jumlah);
				$('#satuan').val(data.satuan);
				$('#hargasatuan').val(data.hargasatuan);
				$('#user_dialog').attr('title', 'Edit Data');
				$('#action').val('update');
				$('#hidden_id').val(id);
				$('#form_action').val('Update');
				$('#user_dialog').dialog('open');
			}
		});
	});
	
	$('#delete_confirmation').dialog({
		autoOpen:false,
		modal: true,
		buttons:{
			Ok : function(){
				var id = $(this).data('id');
				var action = 'delete';
				$.ajax({
					url:"action.php",
					method:"POST",
					data:{id:id, action:action},
					success:function(data)
					{
						$('#delete_confirmation').dialog('close');
						$('#action_alert').html(data);
						$('#action_alert').dialog('open');
						load_data();
					}
				});
			},
			Cancel : function(){
				$(this).dialog('close');
			}
		}	
	});
	
	$(document).on('click', '.delete', function(){
		var id = $(this).attr("id");
		$('#delete_confirmation').data('id', id).dialog('open');
	});
	
});  
</script>
