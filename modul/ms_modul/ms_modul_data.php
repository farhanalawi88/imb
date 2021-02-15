<div class="row">
  	<div class="col-12">
      	<div class="card-box table-responsive">
          	<div class="page-title-box">
              	<div class="btn-group pull-right">
                  	<ol class="breadcrumb hide-phone">
                      	<li class="breadcrumb-item"><a href="?page=<?php echo base64_encode(tambahmodul)?>" class="btn btn-info btn-sm"><i class="icon-plus"></i> TAMBAH DATA</a></li>
                  	</ol>
              	</div>
              	<h4 class="page-title header-title">Data Modul & Menu</h4>
          	</div>
          	<div class="batas2"></div>
          	<table id="datatable" class="table table-bordered table-condensed table-striped">
				<thead>
	                <tr>
	   	  	  	  	  	<th width="5%"><div align="center">NO</div></th>
	                    <th width="30%">NAMA MODUL</th>
	                    <th width="20%"> MENU</th>
						<th width="20%">LINK</th>
						<th width="10%"><div align="center">URUTAN</div></th>
						<th width="12%"><div align="center">AKSI</div></th>
	                </tr>
				</thead>
				<tbody>
	           <?php


					$qryShow 	= $koneksidb->prepare("SELECT * FROM sys_submenu a
														INNER JOIN sys_menu b ON a.submenu_menu=b.menu_id
														ORDER BY a.submenu_id DESC");
					$qryShow->execute();
					$nomor  	= 0; 
					while ($data    = $qryShow->fetch(PDO::FETCH_ASSOC)){
						$nomor++;
						$Kode = $data['submenu_id'];
				?>
	                <tr class="odd gradeX">
	                    <td><div align="center"><?php echo $nomor ?></div></td>
						<td><?php echo $data ['submenu_nama']; ?></td>
						<td><?php echo $data['menu_nama']; ?></td>
						<td><?php echo $data['submenu_link']; ?></td>
						<td><div align="center"><?php echo $data ['submenu_urutan'] ?></div></td>
						<td>
	                    <div align="center">
	                      <a href="?page=<?php echo base64_encode(hapusmodul)?>&amp;id=<?php echo $Kode; ?>" class="btn-danger btn-sm"><i class="icon-trash"></i></a>
	                      <a href="?page=<?php echo base64_encode(ubahmodul)?>&amp;id=<?php echo $Kode; ?>" class="btn-info btn-sm"><i class="icon-book-open"></i></a>
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
</div>
    	