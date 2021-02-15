<div class="row">
  <div class="col-12">
      <div class="card-box table-responsive">
          <div class="page-title-box">
              <div class="btn-group pull-right">
                  <ol class="breadcrumb hide-phone">
                      <li class="breadcrumb-item"><a href="?page=<?php echo base64_encode(tambahuser)?>" class="btn btn-info btn-sm"><i class="icon-plus"></i> TAMBAH DATA</a></li>
                  </ol>
              </div>
              <h4 class="page-title header-title">Data User Pengguna</h4>
          </div>
          <div class="batas2"></div>
          <table id="datatable" class="table table-bordered table-condensed table-striped">
				<thead>
                    <tr>
       	  	  	  	  	<th width="5%"><div align="center">NO</div></th>
                        <th width="15%">NAMA USER</th>
                        <th width="15%">USERNAME</th>
						<th width="15%">EMAIL</th>
						<th width="15%">GROUP</th>
						<th width="10%"><div align="center">AKSI</div></th>
                    </tr>
				</thead>
				<tbody>
               <?php
               		$dataSql    = "SELECT * FROM ms_user a 
									INNER JOIN sys_group b ON a.user_group=b.group_id
									ORDER BY kode_user DESC";
	                $dataQry    = $koneksidb->prepare($dataSql);
	                $dataQry->execute();
	                $nomor  = 0; 
	                while ($data    = $dataQry->fetch(PDO::FETCH_ASSOC)) {
						$nomor++;
						$Kode = $data['kode_user'];
		                if($data ['status_user']=='Active'){
		                  $dataStatus = "Y";
		                  $dataWarna  = "";
		                }else{
		                  $dataStatus ="N";
		                  $dataWarna  = "class='table-danger'";
		                }
				?>
                    <tr class="odd gradeX">
                        <td><div align="center"><?php echo $nomor ?></div></td>
						<td><?php echo $data ['nama_user']; ?></td>
						<td><?php echo $data ['username_user']; ?></td>
						<td><?php echo $data ['email_user']; ?></td>
						<td><?php echo $data ['group_nama']; ?></td>
						<td>
	                    <div align="center">
	                      <a href="?page=<?php echo base64_encode(hapususer)?>&amp;id=<?php echo $Kode; ?>" class="btn-danger btn-sm"><i class="icon-trash"></i></a>
	                      <a href="?page=<?php echo base64_encode(ubahuser)?>&amp;id=<?php echo $Kode; ?>" class="btn-info btn-sm"><i class="icon-book-open"></i></a>
	                    </div>
	                  	</td>
                    </tr>
                    <?php
                        
                    }
                    ?>
				</tbody>
            </table>
  		</div>
	</div>
</form>