
<?php
	$pg=$_GET['page'];
		if($pg==base64_encode(home)){ include"modul/home.php"; }
	// DATA KONFIGURASI
		elseif($pg==base64_encode(globalconf)){ include"modul/conf_konfigurasi/conf_global.php"; }
		elseif($pg==base64_encode(confprofile)){ include"modul/conf_konfigurasi/conf_profil.php"; }
		elseif($pg==base64_encode(confpassword)){ include"modul/conf_konfigurasi/conf_password.php"; }
	// DATA USER
		elseif($pg==base64_encode(datauser)){ include"modul/ms_user/ms_user_data.php"; }
		elseif($pg==base64_encode(tambahuser)){ include"modul/ms_user/ms_user_tambah.php"; }
		elseif($pg==base64_encode(ubahuser)){ include"modul/ms_user/ms_user_ubah.php"; }
		elseif($pg==base64_encode(hapususer)){ include"modul/ms_user/ms_user_hapus.php"; }
	// DATA GROUP
		elseif($pg==base64_encode(datagroup)){ include"modul/ms_group/ms_group_data.php"; }
		elseif($pg==base64_encode(tambahgroup)){ include"modul/ms_group/ms_group_tambah.php"; }
		elseif($pg==base64_encode(ubahgroup)){ include"modul/ms_group/ms_group_ubah.php"; }
		elseif($pg==base64_encode(hapusgroup)){ include"modul/ms_group/ms_group_hapus.php"; }
	// DATA SBU
		elseif($pg==base64_encode(datasbu)){ include"modul/ms_sbu/ms_sbu_data.php"; }
		elseif($pg==base64_encode(tambahsbu)){ include"modul/ms_sbu/ms_sbu_tambah.php"; }
		elseif($pg==base64_encode(ubahsbu)){ include"modul/ms_sbu/ms_sbu_ubah.php"; }
		elseif($pg==base64_encode(hapussbu)){ include"modul/ms_sbu/ms_sbu_hapus.php"; }
	// DATA DATA MODUL
		elseif($pg==base64_encode(datamodul)){ include"modul/ms_modul/ms_modul_data.php"; }
		elseif($pg==base64_encode(tambahmodul)){ include"modul/ms_modul/ms_modul_tambah.php"; }
		elseif($pg==base64_encode(ubahmodul)){ include"modul/ms_modul/ms_modul_ubah.php"; }
		elseif($pg==base64_encode(hapusmodul)){ include"modul/ms_modul/ms_modul_hapus.php"; }
		else {
		echo "<div class='col-md-12'><div class='alert alert-dismissable alert-warning'><i class='icon-exclamation-sign'></i> Belum Ada Modul</div></div>";
		}
?>
		
		