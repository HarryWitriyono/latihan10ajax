<?php

//fetch.php

include("dbconnect.php");

$query = "SELECT * FROM barang";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();
$output = '
<table class="table table-striped table-bordered">
	<tr>
		<th>Kode Barang</th>
		<th>Nama Barang</th>
		<th>Jumlah</th>
		<th>Satuan</th>
		<th>Harga Satuan</th>
		<th>Edit</th>
		<th>Hapus</th>
	</tr>
';
if($total_row > 0)
{
	foreach($result as $row)
	{
		$output .= '
		<tr>
			<td width="40%">'.$row["kodebarang"].'</td>
			<td width="40%">'.$row["namabarang"].'</td>
			<td width="40%">'.$row["jumlah"].'</td>
			<td width="40%">'.$row["satuan"].'</td>
			<td width="40%">'.$row["hargasatuan"].'</td>
			<td width="10%">
				<button type="button" name="edit" class="btn btn-primary btn-xs edit" id="'.$row["kodebarang"].'">Edit</button>
			</td>
			<td width="10%">
				<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["kodebarang"].'">Delete</button>
			</td>
		</tr>
		';
	}
}
else
{
	$output .= '
	<tr>
		<td colspan="4" align="center">Data not found</td>
	</tr>
	';
}
$output .= '</table>';
echo $output;
?>