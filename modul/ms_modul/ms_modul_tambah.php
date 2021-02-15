<?php
	
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtModul'])=="") {
			$message[] = "<b>Nama Modul</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtLink'])=="") {
			$message[] = "<b>Link modul</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbMenu'])=="") {
			$message[] = "<b>Menu utama</b> tidak boleh kosong !";		
		}
		
		$txtModul		= $_POST['txtModul'];
		$txtLink		= $_POST['txtLink'];
		$cmbMenu		= $_POST['cmbMenu'];
		$txtUrutan		= $_POST['txtUrutan'];

		if(count($message)==0){
			$saveRow 	= $koneksidb->prepare("INSERT INTO sys_submenu SET submenu_nama='$txtModul', 
												 							submenu_link='$txtLink', 
																			submenu_menu='$cmbMenu', 
																			submenu_urutan='$txtUrutan',
																			submenu_dibuat='".date('Y-m-d')."'");
			$saveRow->execute();
			
			if($saveRow){
				$_SESSION['pesan'] = 'Data modul berhasil ditambahkan';
				echo '<script>window.location="?page='.base64_encode(datamodul).'"</script>';
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
	
	$dataModul		= isset($_POST['txtModul']) ? $_POST['txtModul'] : '';
	$dataLink		= isset($_POST['txtLink']) ? $_POST['txtLink'] : '';
	$dataMenu		= isset($_POST['cmbMenu']) ? $_POST['cmbMenu'] : ''; 
	$dataUrutan		= isset($_POST['txtUrutan']) ? $_POST['txtUrutan'] : ''; 
?>
<div class="card-box">
    <h4 class="m-t-0 m-b-15 header-title">Form Data Modul & Menu</h4>
    <div class="batas2"></div>
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal" autocomplete="off">
    	<div class="form-body">
	        <div class="form-group row">
				<label class="col-2 col-form-label">Nama Modul :</label>
				<div class="col-3">
					<input type="text" name="txtModul" value="<?php echo $dataModul; ?>" class="form-control"/>
	             </div>
			</div>
	        <div class="form-group row">
				<label class="col-2 col-form-label">Link Modul :</label>
				<div class="col-3">
					<input type="text" name="txtLink" value="<?php echo $dataLink; ?>" class="form-control"/>
	             </div>
			</div>
			<div class="form-group row">
				<label class="col-2 col-form-label">Menu Utama :</label>
				<div class="col-3">
					<select name="cmbMenu" data-placeholder="- Pilih Menu -" class="select2 form-control">
						<option value=""></option> 
						<?php
							$showRow 	= $koneksidb->prepare("SELECT * FROM sys_menu ORDER BY menu_id DESC");
							$showRow->execute();
							while ($dataRow    = $showRow->fetch(PDO::FETCH_ASSOC)){
								if ($dataMenu == $dataRow['menu_id']) {
									$cek = " selected";
								} else { $cek=""; }
								echo "<option value='$dataRow[menu_id]' $cek>$dataRow[menu_nama]</option>";
							}
							$sqlData ="";
						?>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-2 col-form-label">Urutan Modul :</label>
				<div class="col-2">
					<input type="number" name="txtUrutan" value="<?php echo $dataUrutan; ?>" class="form-control"/>
	             </div>
			</div>
		</div>
	    <div class="batas2"></div>
        <div class="form-group mb-0 justify-content-end row">
            <div class="col-10">
                <button type="submit" name="btnSave" class="btn btn-info"><i class="fa fa-save"></i> Simpan Data</button>
			    <a href="?page=<?php echo base64_encode(datamodul)?>" class="btn btn-info"><i class="fa fa-undo"></i> Batalkan</a>
            </div>
        </div>
    </form>
</div>