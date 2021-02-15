<?php
	// Menghapus Data

	if(isset($_GET['id'])){
		$txtID 		 	= $_GET['id'];

		$deleteHeader 	= $koneksidb->prepare("DELETE FROM ms_user WHERE kode_user='$txtID'");
		$deleteHeader->execute();

		if($deleteHeader){
	        $_SESSION['pesan'] = 'Data user berhasil dihapus';
	        echo '<script>window.location="?page='.base64_encode(datauser).'"</script>';
      	}
	}	
?>