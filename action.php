<?php

//action.php

include('dbconnect.php');

if(isset($_POST["action"]))
{
	if($_POST["action"] == "insert")
	{
		$query = "
		INSERT INTO barang (kodebarang,namabarang,jumlah,satuan,hargasatuan) VALUES ('".$_POST["kodebarang"]."', '".$_POST["namabarang"]."','".$_POST['jumlah']."','".$_POST['satuan']."','".$_POST['hargasatuan']."')
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>Data Inserted...</p>';
	}
	if($_POST["action"] == "fetch_single")
	{
		$query = "
		SELECT * FROM barang WHERE kodebarang = '".$_POST["id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['kodebarang'] = $row['kodebarang'];
			$output['namabarang'] = $row['namabarang'];
			$output['jumlah'] = $row['jumlah'];
			$output['satuan'] = $row['satuan'];
			$output['hargasatuan'] = $row['hargasatuan'];
		}
		echo json_encode($output);
	}
	if($_POST["action"] == "update")
	{
		$query = "
		UPDATE barang 
		SET namabarang = '".$_POST["namabarang"]."', 
		jumlah = '".$_POST["jumlah"]."',
        satuan = '".$_POST["satuan"]."',
        hargasatuan = '".$_POST['hargasatuan']."' 		
		WHERE kodebarang = '".$_POST["hidden_id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>Data Updated</p>';
	}
	if($_POST["action"] == "delete")
	{
		$query = "DELETE FROM barang WHERE kodebarang = '".$_POST["id"]."'";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>Data Deleted</p>';
	}
}

?>