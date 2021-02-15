<?php
	
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtKode'])=="") {
			$message[] = "<b>Kode</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtNama'])=="") {
			$message[] = "<b>Nama</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbStatus'])=="") {
			$message[] = "<b>Status</b> tidak boleh kosong !";		
		}
		
		$txtKode		= $_POST['txtKode'];
		$txtNama		= $_POST['txtNama'];
		$cmbStatus		= $_POST['cmbStatus'];
		$txtAlamat		= $_POST['txtAlamat'];

		if(count($message)==0){
			$saveRow 	= $koneksidb->prepare("INSERT INTO ms_sbu SET kodeSbu='$txtKode', 
										 							namaSbu='$txtNama', 
																	alamatSbu='$txtAlamat', 
																	statusSbu='$cmbStatus',
																	createdAtSbu='".date('Y-m-d h:i:s')."',
																	createdBySbu='".$_SESSION['kode_user']."'");
			$saveRow->execute();
			
			if($saveRow){
				$_SESSION['pesan'] = 'Data SBU berhasil ditambahkan';
				echo '<script>window.location="?page='.base64_encode(datasbu).'"</script>';
			}
			exit;
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
	
	$dataKode		= isset($_POST['txtKode']) ? $_POST['txtKode'] : '';
	$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
	$dataStatus		= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : ''; 
	$dataAlamat		= isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : ''; 
?>
<div class="card-box">
    <h4 class="m-t-0 m-b-15 header-title">Form SBU</h4>
    <div class="batas2"></div>
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal" autocomplete="off">
    	<div class="form-body">
	        <div class="form-group row">
				<label class="col-2 col-form-label">Kode :</label>
				<div class="col-3">
					<input type="text" name="txtKode" value="<?php echo $dataKode; ?>" class="form-control"/>
	             </div>
			</div>
	        <div class="form-group row">
				<label class="col-2 col-form-label">Nama :</label>
				<div class="col-5">
					<input type="text" name="txtNama" value="<?php echo $dataNama; ?>" class="form-control"/>
	             </div>
			</div>
	        <div class="form-group row">
				<label class="col-2 col-form-label">Alamat :</label>
				<div class="col-10">
					<textarea type="text" name="txtAlamat" class="form-control"><?php echo $dataAlamat; ?></textarea>
	             </div>
			</div>
			<div class="form-group row">
				<label class="col-md-2 col-form-label">Status :</label>
				<div class="col-lg-2">
					<select class="form-control select2" data-placeholder="Pilih Status" name="cmbStatus">
	                	<option value=""></option>
	               		<?php
						  $pilihan	= array("Y", "N");
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
		</div>
	    <div class="batas2"></div>
        <div class="form-group mb-0 justify-content-end row">
            <div class="col-10">
                <button type="submit" name="btnSave" class="btn btn-info"><i class="fa fa-save"></i> Simpan Data</button>
			    <a href="?page=<?php echo base64_encode(datasbu)?>" class="btn btn-info"><i class="fa fa-undo"></i> Batalkan</a>
            </div>
        </div>
    </form>
</div>