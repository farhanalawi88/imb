
<?php
	// Menghapus Data

	if(isset($_GET['id'])){
		$txtID 		 	= $_GET['id'];

		$deleteHeader 	= $koneksidb->prepare("DELETE FROM ms_sbu WHERE idSbu='$txtID'");
		$deleteHeader->execute();

		if($deleteHeader){
	        $_SESSION['pesan'] = 'Data SBU berhasil dihapus';
	        echo '<script>window.location="?page='.base64_encode(datasbu).'"</script>';
	    }
	}	
?>