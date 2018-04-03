<?php 
/* osztály a feladatban megadott különféle feltételek ellenőrzéséhez */

class Validation  {
	
	private $_ValidationErrors = array(); // ez a tömb tárolja a hibákat
	
	public function GetValidationErrors() {
		return $this->_ValidationErrors;
	}

	public function ValidateEmail($Email) {
	
		if(!preg_match('/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/', $Email)) $this->_ValidationErrors[] = "A(z) $Email e-mail cím formátuma nem megfelelő!";
		
	}
	
	public function ValidateStrLen($String, $Min, $Max, $Field){
    $Len = strlen($String);
    if($Len < $Min){
        $this->_ValidationErrors[] =  "A(z) $Field mező túl rövid, legalább $Min karakter hosszúnak kell lennie!";
    }
    elseif($Len > $Max){
        $this->_ValidationErrors[] =  "A(z) $Field mező túl hosszú, legfeljebb $Max karakter hosszú lehet!";
    }
	}	
	
	public function ValidateMandatory($Item, $Field) {
			if(!isset($Item) || empty($Item)) $this->_ValidationErrors[] = "A(z) $Field mező kitöltése kötelező!";
	}
	
	public function ValidateDelete($Num, $Field) {
			if($Num > 0) $this->_ValidationErrors[] = "Nem törölheted a $Field, amíg alkalmazott van hozzárendelve!";
	}	
	
	public function ValidateLPNumber($LPNumber) {
			if(!preg_match('/^[0-9]{3}-[A-Za-z]{3}$/', $LPNumber)) $this->_ValidationErrors[] = "A rendszám formátuma nem megfelelő! (a helyes formátum: XXX-YYY, ahol X szám, Y csak betű lehet)";
		
	}
	
}
