
<div class="row">
  <div class="col-12">
      <div class="card-box table-responsive">
          <div class="page-title-box">
              <div class="btn-group pull-right">
                  <ol class="breadcrumb hide-phone">
                      <li class="breadcrumb-item"><a href="?page=<?php echo base64_encode(tambahgroup)?>" class="btn btn-info btn-sm"><i class="icon-plus"></i> TAMBAH DATA</a></li>
                  </ol>
              </div>
              <h4 class="page-title header-title">Data Group Akses</h4>
          </div>
          <div class="batas2"></div>
          <table id="datatable" class="table table-bordered table-condensed table-striped">
              <thead>
              <tr>
                  <th width="5%"><div align="center">NO</div></th>
                  <th width="30%">NAMA GROUP</th>
                  <th width="40%">KETERANGAN</th>
                  <th width="5%"><div align="center">STATUS</div></th>
                  <th width="10%"><div align="center">AKSI</div></th>
              </tr>
              </thead>
              <tbody>
              <?php
                $dataSql    = "SELECT * FROM sys_group ORDER BY group_id DESC";
                $dataQry    = $koneksidb->prepare($dataSql);
                $dataQry->execute();
                $nomor  = 0; 
                while ($data    = $dataQry->fetch(PDO::FETCH_ASSOC)) {
                $nomor++;
                $Kode = $data['group_id'];
                if($data ['group_status']=='Active'){
                  $dataStatus = "Y";
                  $dataWarna  = "";
                }else{
                  $dataStatus ="N";
                  $dataWarna  = "class='table-danger'";
                }
              ?>
              <tr>
                  <td><div align="center"><?php echo $nomor ?></div></td>
                  <td <?php echo $dataWarna ?>><?php echo $data['group_nama'] ?></td>
                  <td><?php echo $data['group_keterangan'] ?></td>
                  <td><div align="center"><?php echo $dataStatus ?></div></td>
                  <td>
                    <div align="center">
                      <a href="?page=<?php echo base64_encode(hapusgroup)?>&amp;id=<?php echo $Kode; ?>" class="btn-danger btn-sm"><i class="icon-trash"></i></a>
                      <a href="?page=<?php echo base64_encode(ubahgroup)?>&amp;id=<?php echo $Kode; ?>" class="btn-info btn-sm"><i class="icon-book-open"></i></a>
                    </div>
                  </td>
              </tr>
              <?php } ?>
              </tbody>
          </table>
      </div>
  </div>
</div> <!-- end row -->


