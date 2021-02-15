<?php

	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtPasswordLama'])=="") {
			$message[] = "Password lama anda tidak boleh dikosongkan!";		
		}
		if (trim($_POST['txtPasswordBaru'])=="") {
			$message[] = "Password baru anda tidak boleh kosong!";		
		}
		if (trim($_POST['txtKonfirmasi'])=="") {
			$message[] = "Konfirmasi password baru anda tidak boleh kosong!";		
		}
				
				
		$txtPasswordLama	= $_POST['txtPasswordLama'];
		$txtPasswordBaru	= $_POST['txtPasswordBaru'];
		$txtKonfirmasi		= $_POST['txtKonfirmasi'];
		
		if($txtPasswordBaru != $txtKonfirmasi){
			$message[] = "Konfirmasi password anda tidak sesuai";
		}


		$query 		= "SELECT * FROM ms_user 
						WHERE kode_user='".$_SESSION['kode_user']."' 
						AND password_user='".md5($txtPasswordLama)."'";
		$stmt 		= $koneksidb->prepare($query);
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0){
			$message[] = "Maaf, password lama anda tidak sesuai";
		}
						
		if(count($message)==0){		

			try{
		        $query = "UPDATE ms_user SET password_user='".md5($txtPasswordBaru)."' WHERE kode_user='".$_SESSION['kode_user']."'";
		        $stmt = $koneksidb->prepare($query);
		        if($stmt->execute()){
		            $_SESSION['pesan'] = 'Password baru anda berhasil diubah';
					echo '<script>window.location="?page='.base64_encode(confpassword).'"</script>';
		        }else{
		            $_SESSION['pesan'] = 'Password baru anda gagal diubah';
				echo '<script>window.location="?page='.base64_encode(confpassword).'"</script>';
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
	
?>

<div class="card-box">
    <h4 class="m-t-0 m-b-15 header-title">Form Perubahan Password</h4>
    <div class="batas2"></div>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="post" class="form-horizontal" enctype="multipart/form-data">
		<div class="form-body">
			<div class="form-group row">
				<label class="col-2 col-form-label">Password Lama :</label>
				<div class="col-3">
					<input class="form-control" type="password" name="txtPasswordLama" />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-2 col-form-label">Password Baru :</label>
				<div class="col-3">
					<input class="form-control" name="txtPasswordBaru" type="password"/>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-2 col-form-label">Verifikasi Password :</label>
				<div class="col-3">
					<input class="form-control" name="txtKonfirmasi" type="password"/>
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