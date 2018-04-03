<?php 
/* osztály html form elemek megjelenítéséhez */

class Form  {
	
	public function Open($FormID = 'SimpleForm', $Action = '') {
		return '<form id="'.$FormID.'" method="post"  />';
	}

	public function TextField($Name = 'name', $Label = 'Név', $Value = '') {
		return '<label for="'.$Name.'">'.$Label.'</label><input type="text" name="'.$Name.'" value="'.$Value.'" />';
	}

	public function Hidden($Name, $Value) {
		return '<input type="hidden" name="'.$Name.'" value="'.$Value.'" />';
	}
	
	public function Submit() {
		return '<input type="submit" name="submit" value="Save" />';
	}	
	
	public function Close() {
		return '</form>';
	}
	
}
