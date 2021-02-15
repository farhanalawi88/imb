<?php
	// Menghapus Data
	if(isset($_GET['id'])){
		$txtID 		 	= $_GET['id'];

		$deleteHeader 	= $koneksidb->prepare("DELETE FROM sys_group WHERE group_id='$txtID'");
		$deleteHeader->execute();

		if($deleteHeader){
			$deleteItem 	= $koneksidb->prepare("DELETE FROM sys_akses WHERE akses_group='$txtID'");
			$deleteItem->execute();
	        $_SESSION['pesan'] = 'Data group berhasil dihapus';
	        echo '<script>window.location="?page='.base64_encode(datagroup).'"</script>';
      	}
	}	
?>