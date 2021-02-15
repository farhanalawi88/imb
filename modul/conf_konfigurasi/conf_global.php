<?php		
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtNama'])=="") {
			$message[] = "Nama perpustakaan tidak boleh kosong";		
		}
		if (trim($_POST['txtMeta'])=="") {
			$message[] = "meta tidak boleh kosong !";		
		}
		if (trim($_POST['txtAlamat'])=="") {
			$message[] = "alamat perpustakaan tidak boleh kosong";		
		}
		if (trim($_POST['txtTelp'])=="") {
			$message[] = "no. telp perpustakaan tidak boleh kosong";		
		}
						
		$txtNama		= $_POST['txtNama'];
		$txtMeta		= $_POST['txtMeta'];
		$txtTelp		= $_POST['txtTelp'];
		$txtAlamat		= $_POST['txtAlamat'];
		$txtEmail		= $_POST['txtEmail'];
		$txtFooter	= $_POST['txtFooter'];
							
		if(count($message)==0){	
			if (empty($_FILES['namaFile']['tmp_name'])) {
				$file_image = $_POST['txtNamaFile'];
			}
			else  {
				if(! $_POST['txtNamaFile']=="") {
					if(file_exists("images/".$_POST['txtNamaFile'])) {
						unlink("images/".$_POST['txtNamaFile']);	
					}
				}
	
				$file_image = $_FILES['namaFile']['name'];
				$file_image = stripslashes($file_image);
				$file_image = str_replace("'","",$file_image);
				
				$file_image = date('ymdhis').".".$file_image;
				copy($_FILES['namaFile']['tmp_name'],"images/".$file_image);					
			}

			try{
		        $query = "UPDATE sys_setting SET sys_setting_nama='$txtNama', 
												sys_setting_telp='$txtTelp', 
												sys_setting_alamat='$txtAlamat', 
												sys_setting_email='$txtEmail',
												sys_setting_logo='$file_image',
												sys_setting_footer='$txtFooter',
							  					sys_setting_meta='$txtMeta'";
		        $stmt = $koneksidb->prepare($query);
		        if($stmt->execute()){
		            $_SESSION['pesan'] = 'Pengaturan umum berhasil diperbaharui';
					echo '<script>window.location="?page='.base64_encode(globalconf).'"</script>';
		        }else{
		            $_SESSION['pesan'] = 'Pengaturan umum gagal diperbaharui';
					echo '<script>window.location="?page='.base64_encode(globalconf).'"</script>';
		        }
		         
		    }
		     
		    catch(PDOException $exception){
		        die('ERROR: ' . $exception->getMessage());
		    }



		}	
					
		if (! count($message)==0 ){
			echo "<div class='alert alert-danger alert-dismissable'>
                      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'></button>";
				$Num=0;
				foreach ($message as $indeks=>$pesan_tampil) { 
				$Num++;
				echo "&nbsp;&nbsp;$Num. $pesan_tampil<br>";	
			} 
				echo "</div>"; 
		}
	} 

	$sqlShow    = "SELECT * FROM sys_setting";
	$qryShow    = $koneksidb->prepare($sqlShow);
	$qryShow->execute();
	$dataShow    = $qryShow->fetch(PDO::FETCH_ASSOC);
	
	$dataNama		= isset($dataShow['sys_setting_nama']) ?  $dataShow['sys_setting_nama'] : $_POST['txtNama'];
	$dataTelp		= isset($dataShow['sys_setting_telp']) ?  $dataShow['sys_setting_telp'] : $_POST['txtTelp'];
	$dataAlamat		= isset($dataShow['sys_setting_alamat']) ?  $dataShow['sys_setting_alamat'] : $_POST['txtAlamat'];
	$dataEmail		= isset($dataShow['sys_setting_email']) ?  $dataShow['sys_setting_email'] : $_POST['txtEmail'];
	$dataMeta		= isset($dataShow['sys_setting_meta']) ?  $dataShow['sys_setting_meta'] : $_POST['txtMeta'];
	$dataFooter 	= isset($dataShow['sys_setting_footer']) ?  $dataShow['sys_setting_footer'] : $_POST['txtFooter'];

			
?>

<div class="card-box">
    <h4 class="m-t-0 m-b-15 header-title">Pengaturan Umum</h4>
    <div class="batas2"></div>
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="post" class="form-horizontal" enctype="multipart/form-data">
        <div class="form-group row">
            <label class="col-2 col-form-label">Nama :</label>
            <div class="col-4">
                <input type="text" class="form-control" name="txtNama" value="<?php echo $dataNama; ?>">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">Meta :</label>
            <div class="col-7">
                <input type="text" class="form-control" name="txtMeta"  value="<?php echo $dataMeta; ?>">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">Email :</label>
            <div class="col-3">
                <input type="text" class="form-control" name="txtEmail" value="<?php echo $dataEmail; ?>">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">Alamat :</label>
            <div class="col-10">
				<input type="text" class="form-control" name="txtAlamat" value="<?php echo $dataAlamat; ?>">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">No. Telp :</label>
            <div class="col-3">
                <input type="text" class="form-control" name="txtTelp" value="<?php echo $dataTelp; ?>">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">Footer :</label>
            <div class="col-10">
				<input type="text" class="form-control" name="txtFooter" value="<?php echo $dataFooter; ?>">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">Logo :</label>
            <div class="col-3">
                <input type="file" class="form-control" name="namaFile">
                <img style="margin-top: 10px; margin-bottom: 10px" height="50px" src="images/<?php if($dataShow['sys_setting_logo']==''){ echo "no_image.png";}else{ echo "".$dataShow['sys_setting_logo']."";} ?>"/></span></span>
		        <input name="txtNamaFile" type="hidden" value="<?php echo $dataShow['sys_setting_logo']; ?>" />
            </div>
        </div>
        <div class="batas2"></div>
        <div class="form-group mb-0 justify-content-end row">
            <div class="col-10">
                <button type="submit" name="btnSave" class="btn btn-info"><i class="fa fa-save"></i> Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>

