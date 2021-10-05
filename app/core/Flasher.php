<?php
class Flasher {
	public static function setFlash($icon, $title, $text){
		$_SESSION['flash'] = [
			'icon' => $icon,
			'title' => $title,
			'text' => $text
		];
	}

	public static function flash(){
		if( isset($_SESSION['flash']) ){
			$icon = $_SESSION['flash']['icon'];
			$title = $_SESSION['flash']['title'];
			$text = $_SESSION['flash']['text'];
			
			echo <<< SWEET_ALERT
			<script>	
				swal({
					icon: "$icon",
					title: '$title',
					text: '$text'
				});
			</script>
			SWEET_ALERT;

			unset($_SESSION['flash']);
		}
	}
}