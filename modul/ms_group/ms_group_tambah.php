<?php

if(isset($_POST['btnSave'])){
	$message = array();
	if (trim($_POST['txtNama'])=="") {
		$message[] = "<b>Nama group</b> tidak boleh kosong, silahkan isi terlebih dahulu !";		
	}
	if (trim($_POST['cmbStatus'])=="") {
		$message[] = "<b>Status group</b> tidak boleh kosong, silahkan isi terlebih dahulu !";		
	}
	if (empty($_POST['txtModul'])) {
		$message[] = "<b>Modul</b> tidak boleh kosong, silahkan isi terlebih dahulu !";		
	}

	$txtNama		= $_POST['txtNama'];
	$txtKeterangan	= $_POST['txtKeterangan'];
	$cmbStatus		= $_POST['cmbStatus'];
	$txtModul		= $_POST['txtModul'];
	

	$query 		= "SELECT * FROM sys_group WHERE group_nama='$txtNama'";
	$stmt 		= $koneksidb->prepare($query);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num>=1){
		$message[] = "Maaf, nama group <b>$txtNama</b> sudah ada yang menggunakan, silahkan ganti dengan yang lain";
	}
			
	if(count($message)==0){	
		try{
	        $query = "INSERT INTO sys_group SET group_nama='$txtNama',
												group_keterangan='$txtKeterangan',
												group_status='$cmbStatus'";
	        $stmt = $koneksidb->prepare($query);
	        if($stmt->execute()){
	        	$last_id = $koneksidb->lastInsertId();
	        	foreach ($txtModul as $id_key) {		
					$query = "INSERT INTO sys_akses SET akses_group='$last_id',
														akses_submenu='$id_key',
														akses_dibuat='".date('Y-m-d H:i:s')."'";
		        	$stmt = $koneksidb->prepare($query);
		        	$stmt->execute();
				}	
	           	$_SESSION['pesan'] = 'Group akses baru berhasil dibuat dengan id '.$last_id.'';
				echo '<script>window.location="?page='.base64_encode(datagroup).'"</script>';
	        }else{
	            $_SESSION['pesan'] = 'Group akses baru gagal dibuat';
				echo '<script>window.location="?page='.base64_encode(datagroup).'"</script>';
	        }
	         
	    }
	     
	    catch(PDOException $exception){
	        die('ERROR: ' . $exception->getMessage());
	    }
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

$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataKeteranngan= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataStatus		= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : '';
?>	
<div class="card-box">
    <h4 class="m-t-0 m-b-15 header-title">Form Data Group & Akses</h4>
    <div class="batas2"></div>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd">
			<div class="form-body">
		    	<div class="row">
		      		<div class="col-lg-4">
		        		<div class="form-group">
		          		<label class="form-control-label">Nama Group :</label>
		          		<input class="form-control" type="text" name="txtNama" value="<?php echo $dataNama ?>" placeholder="Masukkan Nama">
		          		</div>
		        	</div>
				    <div class="col-lg-6">
				    	<div class="form-group">
				        	<label class="form-control-label">Keterangan :</label>
				          	<input class="form-control" type="text" name="txtKeterangan" value="<?php echo $dataKeterangan ?>" placeholder="Masukkan Keterangan">
				        </div>
				    </div><!-- col-4 -->
				    <div class="col-lg-2">
				        <div class="form-group">
				    	    <label class="form-control-label">Status Group :</label>
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
				    </div><!-- col-4 -->
				</div>
				<div class="batas2"></div>
			    <div class="row">
			     	<div class="col-lg-12">    	
		            <table id="key-table" class="table table-bordered table-condensed">
						<thead>
		                    <tr>
		       	  	  	  	  	<th width="10%"><div align="center">CEKLIST</div></th>
							  	<th width="50%">NAMA MODUL</th>
								<th width="40%">MENU UTAMA</th>
							</tr>
						</thead>
						<tbody>
							<?php

								$dataSql    = "SELECT * FROM sys_submenu
												INNER JOIN sys_menu ON sys_submenu.submenu_menu=sys_menu.menu_id
												ORDER BY sys_submenu.submenu_id DESC";
				                $dataQry    = $koneksidb->prepare($dataSql);
				                $dataQry->execute();
				                $nomor  = 0; 
				                while ($data    = $dataQry->fetch(PDO::FETCH_ASSOC)) {
				                	$nomor++;
									$Kode = $data['submenu_id'];

							?>
							<tr class="odd gradeX">
		                        <td>
		                        	<div align="center">
		                                <input type="checkbox" value="<?php echo $Kode; ?>" name="txtModul[<?php echo $Kode; ?>]" />
		                            </div> 
		                        </td>
								<td><?php echo $data ['submenu_nama']; ?></td>
								<td><?php echo $data ['menu_nama']; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		<div class="batas2"></div>
        <div class="form-group mb-0 justify-content-end row">
            <div class="col-12">
                <button type="submit" name="btnSave" class="btn btn-info"><i class="fa fa-save"></i> Simpan Data</button>
                <a href="?page=<?php echo base64_encode(datagroup)?>" class="btn btn-info"><i class="fa fa-undo"></i> Batalkan</a>
            </div>
        </div>
    </form>
</div>