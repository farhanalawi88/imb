<?php
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtNama'])=="") {
			$message[] = "Nama lengkap tidak boleh kosong!";		
		}
		if (trim($_POST['txtUsername'])=="") {
			$message[] = "Username tidak boleh kosong";		
		}
		
		$txtNama		= $_POST['txtNama'];
		$txtUsername	= $_POST['txtUsername'];
		$txtTelp		= $_POST['txtTelp'];
		$txtEmail		= $_POST['txtEmail'];
		$txtUsernameLm	= $_POST['txtUsernameLm'];


		$query 		= "SELECT * FROM ms_user WHERE username_user='$txtUsername' AND NOT(username_user='$txtUsernameLm')";
		$stmt 		= $koneksidb->prepare($query);
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num>=1){
			$message[] = "Maaf, Username <b> $txtUsername </b> sudah ada, ganti dengan username lain";
		}
				
		if(count($message)==0){		

			try{
		        $query = "UPDATE ms_user SET nama_user='$txtNama', 
											telp_user='$txtTelp', 
											email_user='$txtEmail', 
											username_user='$txtUsername'
									WHERE kode_user='".$_POST['txtKode']."'";
		        $stmt = $koneksidb->prepare($query);
		        if($stmt->execute()){
		            $_SESSION['pesan'] = 'Profile anda berhasil diperbaharui';
					echo '<script>window.location="?page='.base64_encode(confprofile).'"</script>';
		        }else{
		            $_SESSION['pesan'] = 'Profile gagal diperbaharui';
					echo '<script>window.location="?page='.base64_encode(confprofile).'"</script>';
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


	$sqlShow    = "SELECT * FROM ms_user WHERE kode_user='".$_SESSION['kode_user']."'";
	$qryShow    = $koneksidb->prepare($sqlShow);
	$qryShow->execute();
	$dataShow    = $qryShow->fetch(PDO::FETCH_ASSOC);

	$dataKode		= $dataShow['kode_user'];
	$dataNama		= isset($dataShow['nama_user']) ?  $dataShow['nama_user'] : $_POST['txtNama'];
	$dataTelp		= isset($dataShow['telp_user']) ?  $dataShow['telp_user'] : $_POST['txtTelp'];
	$dataEmail		= isset($dataShow['email_user']) ?  $dataShow['email_user'] : $_POST['txtEmail'];
	$dataAlamat		= isset($dataShow['alamat_user']) ?  $dataShow['alamat_user'] : $_POST['txtAlamat'];
	$dataUsername	= isset($dataShow['username_user']) ?  $dataShow['username_user'] : $_POST['txtUsername'];
	$dataUsernameLm	= $dataShow['username_user'];
?>
<div class="card-box">
    <h4 class="m-t-0 m-b-15 header-title">Form Data Profil</h4>
    <div class="batas2"></div>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="post" class="form-horizontal" enctype="multipart/form-data">
		<div class="form-body">
			<div class="form-group row">
				<label class="col-2 col-form-label">Nama Lengkap :</label>
				<div class="col-2">
					<input type="text" class="form-control" name="txtNama" value="<?php echo $dataNama; ?>">
					<input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-2 col-form-label">Username :</label>
				<div class="col-4">
					<input class="form-control" type="text" name="txtUsername"  value="<?php echo $dataUsername; ?>"/>
					<input name="txtUsernameLm" type="hidden" value="<?php echo $dataUsernameLm; ?>" />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-2 col-form-label">No. Telp :</label>
				<div class="col-3">
					<input class="form-control" name="txtTelp" type="text" value="<?php echo $dataTelp; ?>"/>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-2 col-form-label">Email :</label>
				<div class="col-3">
					<input class="form-control" name="txtEmail" type="text" value="<?php echo $dataEmail; ?>"/>
				</div>
			</div>
		</div> 
        <div class="batas2"></div>
        <div class="form-group mb-0 justify-content-end row">
            <div class="col-10">
                <button type="submit" name="btnSave" class="btn btn-info"><i class="fa fa-save"></i> Simpan Data</button>
            </div>
        </div>
    </form>
</div>