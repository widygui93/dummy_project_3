<?php
class Flasher {
	public static function setFlash($icon, $title, $text, $type){
		$_SESSION['flash'] = [
			'icon' => $icon,
			'title' => $title,
			'text' => $text,
			'type' => $type
		];
	}

	public static function flash(){
		if( isset($_SESSION['flash']) ){
			$icon = $_SESSION['flash']['icon'];
			$title = $_SESSION['flash']['title'];
			$text = $_SESSION['flash']['text'];
			$type = $_SESSION['flash']['type'];
			echo "<script>
					
					swal({
						icon: '";echo "$icon";echo"',
						title: '";echo "$title";echo"',
						text: '";echo "$text";echo"',
					    type: '";echo "$type";echo"'
					});

				</script>";

			unset($_SESSION['flash']);
		}
	}
}