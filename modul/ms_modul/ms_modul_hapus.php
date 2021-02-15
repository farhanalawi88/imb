
<?php
	// Menghapus Data

	if(isset($_GET['id'])){
		$txtID 		 	= $_GET['id'];

		$deleteHeader 	= $koneksidb->prepare("DELETE FROM sys_submenu WHERE submenu_id='$txtID'");
		$deleteHeader->execute();

		if($deleteHeader){
	        $_SESSION['pesan'] = 'Data modul berhasil dihapus';
	        echo '<script>window.location="?page='.base64_encode(datamodul).'"</script>';
	    }
	}	
?>