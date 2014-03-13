<?php
	class SignUpModel extends Model{
		public function getTeamName(){
			$tname = $_POST['teamName'];
			return $tname;
		}
	}

?>