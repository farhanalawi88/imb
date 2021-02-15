<?php
		
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtNama'])=="") {
			$message[] = "Nama Lengkap tidak boleh kosong!";		
		}
		if (trim($_POST['txtUser'])=="") {
			$message[] = "Username tidak boleh kosong!";		
		}
		if (trim($_POST['cmbLevel'])=="BLANK") {
			$message[] = "Level tidak boleh kosong, silahkan pilih terlebih dahulu!";		
		}
		if (trim($_POST['cmbStatus'])=="") {
			$message[] = "status tidak boleh kosong!";		
		}
		
		$txtNama		= $_POST['txtNama'];
		$txtUser		= $_POST['txtUser'];
		$txtTelp		= $_POST['txtTelp'];
		$txtEmail		= $_POST['txtEmail'];
		$txtUserLm		= $_POST['txtUserLm'];
		$txtPassLama	= $_POST['txtPassLama'];
		$txtPassBaru	= $_POST['txtPassBaru'];
		$cmbLevel		= $_POST['cmbLevel'];
		$cmbStatus		= $_POST['cmbStatus'];
		$txtPelanggan	= $_POST['txtPelanggan'];
		$txtProduk		= $_POST['txtProduk'];

		$checkUsername 	= $koneksidb->prepare("SELECT * FROM ms_user WHERE username_user='$txtUser' AND NOT(username_user='$txtUserLm')");
		$checkUsername->execute();
		$numCheck		= $checkUsername->rowCount();	
		if($num>=1){
			$message[] 	= "Maaf, Username <b> $txtUsername </b> sudah ada, ganti dengan username lain";
		}
				
		if(count($message)==0){			
			if (trim($txtPassBaru)=="") {
				$sqlSub = " password_user='$txtPassLama'";
			}
			else {
				$sqlSub = "  password_user='".md5($txtPassBaru)."'";
			}


			if (empty($_FILES['namaFile']['tmp_name'])) {
					$file_foto = $_POST['txtNamaFile'];
			}
			else  {
				if(! $_POST['txtNamaFile']=="") {
					if(file_exists("images/".$_POST['txtNamaFile'])) {
						unlink("images/".$_POST['txtNamaFile']);	
					}
				}
		
				$file_foto = $_FILES['namaFile']['name'];
				$file_foto = stripslashes($file_foto);
				$file_foto = str_replace("'","",$file_foto);
						
				$file_foto = date('ymdhis').".".$file_foto;
				copy($_FILES['namaFile']['tmp_name'],"images/".$file_foto);					
			}
		

			$saveRow 	= $koneksidb->prepare("UPDATE ms_user SET nama_user='$txtNama', 
																	telp_user='$txtTelp',  
																	username_user='$txtUser',
																	$sqlSub, 
												  					user_group='$cmbLevel', 
																	email_user='$txtEmail',
																	fotoUser='$file_foto',
																	status_user='$cmbStatus' 
																WHERE kode_user='".$_POST['txtKode']."'");
			$saveRow->execute();
			if($saveRow){
				$_SESSION['pesan'] = 'Data admin & kasir berhasil diperbaharui';
				echo '<script>window.location="?page='.base64_encode(datauser).'"</script>';
			}
		}	
		
		if (! count($message)==0 ){
			echo "<div class='alert alert-error'>";
				$Num=0;
				foreach ($message as $indeks=>$pesan_tampil) { 
				$Num++;
					echo "&nbsp;&nbsp;$Num. $pesan_tampil<br>";	
				} 
			echo "</div>"; 
		}
	} 
	$KodeEdit	= isset($_GET['id']) ?  $_GET['id'] : $_POST['txtKode']; 
	$qryShow 	= $koneksidb->prepare("SELECT * FROM ms_user WHERE kode_user='$KodeEdit'");
	$qryShow->execute();
	$dataShow    = $qryShow->fetch(PDO::FETCH_ASSOC);


	$dataKode	= $dataShow['kode_user'];
	$dataNama	= isset($dataShow['nama_user']) ?  $dataShow['nama_user'] : $_POST['txtNama'];
	$dataTelp	= isset($dataShow['telp_user']) ?  $dataShow['telp_user'] : $_POST['txtTelp'];
	$dataUser	= isset($dataShow['username_user']) ?  $dataShow['username_user'] : $_POST['txtUser'];
	$dataUserLm	= $dataShow['username_user'];
	$dataPass	= isset($dataShow['password_user']) ?  $dataShow['password_user'] : $_POST['txtPassBaru'];
	$dataLevel 	= isset($dataShow['user_group']) ?  $dataShow['user_group'] : $_POST['cmbLevel'];
	$dataStatus = isset($dataShow['status_user']) ?  $dataShow['status_user'] : $_POST['cmbStatus'];
	$dataEmail	= isset($dataShow['email_user']) ?  $dataShow['email_user'] : $_POST['txtEmail'];
			

?>
<div class="card-box">
    <h4 class="m-t-0 m-b-15 header-title">Form Data User Pengguna</h4>
    <div class="batas2"></div>
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="post" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
        <div class="form-group row">
            <label class="col-2 col-form-label">Nama Lengkap :</label>
            <div class="col-4">
                <input class="form-control" type="text" name="txtNama" value="<?php echo $dataNama; ?>"/>
                <input class="form-control" type="hidden" name="txtKode" value="<?php echo $dataKode; ?>"/>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">Username :</label>
            <div class="col-4">
                <input class="form-control" type="text" name="txtUser"  value="<?php echo $dataUser; ?>"/>
                <input name="txtUserLm" type="hidden" value="<?php echo $dataUserLm; ?>" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">Password :</label>
            <div class="col-4">
                <input class="form-control" name="txtPassword" type="password"  value=""/>
                <input name="txtPassLama" type="hidden" value="<?php echo $dataPass; ?>" />
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
            <div class="col-4">
                <input class="form-control" name="txtEmail" type="text" value="<?php echo $dataEmail; ?>"/>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">Level Group :</label>
            <div class="col-3">
                <select name="cmbLevel" class="select2 form-control" data-placeholder="Pilih Level">
					<option value=""> </option>
					<?php
						$show 	= $koneksidb->prepare("SELECT * FROM sys_group ORDER BY group_id DESC");
						$show->execute();
						while ($dataRow    = $show->fetch(PDO::FETCH_ASSOC)) {
						if ($dataLevel == $dataRow['group_id']) {
							$cek = " selected";
						} else { $cek=""; }
						echo "<option value='$dataRow[group_id]' $cek>$dataRow[group_nama]</option>";
					  }
					  $sqlData ="";
					?>
				</select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">Photo :</label>
            <div class="col-4">
                <input class="form-control" name="namaFile" type="file"/>
                <input name="txtNamaFile" type="hidden" value="<?php echo $dataShow['fotoUser']; ?>" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label">Status :</label>
            <div class="col-3">
                <select class="form-control select2" data-placeholder="Pilih Status" name="cmbStatus">
                	<option value=""></option>
               		<?php
					  $pilihan	= array("Active", "Non Active");
					  foreach ($pilihan as $nilai) {
						if ($dataStatus==$nilai) {
							$cek=" selected";
						} else { $cek = ""; }
						echo "<option value='$nilai' $cek>$nilai</option>";
					  }
					?>
              	</select>
            </div>
        </div>
        <div class="batas2"></div>
        <div class="form-group mb-0 justify-content-end row">
            <div class="col-10">
                <button type="submit" name="btnSave" class="btn btn-info"><i class="fa fa-save"></i> Simpan Data</button>
		    	<a href="?page=<?php echo base64_encode(datauser)?>" class="btn btn-info"><i class="fa fa-undo"></i> Batalkan</a>
            </div>
        </div>
    </form>
</div>

