<div class="row">
  	<div class="col-12">
      	<div class="card-box table-responsive">
          	<div class="page-title-box">
              	<div class="btn-group pull-right">
                  	<ol class="breadcrumb hide-phone">
                      	<li class="breadcrumb-item"><a href="?page=<?php echo base64_encode(tambahsbu)?>" class="btn btn-info btn-sm"><i class="icon-plus"></i> TAMBAH DATA</a></li>
                  	</ol>
              	</div>
              	<h4 class="page-title header-title">Data SBU</h4>
          	</div>
          	<div class="batas2"></div>
          	<table id="datatable" class="table table-bordered table-condensed table-striped">
				<thead>
	                <tr>
	   	  	  	  	  	<th width="5%"><div align="center">NO</div></th>
                        <th width="15%"><div align="center">KODE</div></th>
                        <th width="60%">NAMA</th>
						<th width="5%"><div align="center">STATUS</div></th>
						<th width="12%"><div align="center">AKSI</div></th>
                    </tr>
				</thead>
				<tbody>
                    <?php
                    	$qryShow 	= $koneksidb->prepare("SELECT * FROM ms_sbu ORDER BY idSbu DESC");
						$qryShow->execute();
						$nomor  	= 0; 
						while ($data    = $qryShow->fetch(PDO::FETCH_ASSOC)){
							$nomor++;
							$Kode = $data['idSbu'];


					?>
                    <tr class="odd gradeX">
                        <td><div align="center"><?php echo $nomor ?></div></td>
						<td><div align="center"><?php echo $data ['kodeSbu']; ?></div></td>
						<td><?php echo $data ['namaSbu']; ?></td>
						<td><div align="center"><?php echo $data ['statusSbu']; ?></div></td>
                        <td>
	                    <div align="center">
	                      <a href="?page=<?php echo base64_encode(hapussbu)?>&amp;id=<?php echo $Kode; ?>" class="btn-danger btn-sm"><i class="icon-trash"></i></a>
	                      <a href="?page=<?php echo base64_encode(ubahsbu)?>&amp;id=<?php echo $Kode; ?>" class="btn-info btn-sm"><i class="icon-book-open"></i></a>
	                    </div>
	                  	</td>
                    </tr>
                    <?php } ?>
				</tbody>
            </table>
		</div>
	</div>
</form>