<?php
class Flasher {
	public static function setFlash($pesan, $aksi, $tipe){
		$_SESSION['flash'] = [
			'pesan' => $pesan,
			'aksi' => $aksi,
			'tipe' => $tipe
		];
	}

	public static function flash(){
		if( isset($_SESSION['flash']) ){
			echo '
				<div style="margin:0 10px;padding:10px;text-align:center;background-color: ' . $_SESSION['flash']['tipe'] . ';">
				  Data student <strong>' . $_SESSION['flash']['pesan'] . '</strong> ' . $_SESSION['flash']['aksi'] . '
				</div>
			';

			unset($_SESSION['flash']);
		}
	}
}