<?php 

class CompanyCar  {
	
	
	public $Brand = '';
	
	public $Type = '';
	
	public $LPNumber = '';
	
	
	public function __construct($Item = NULL, $smarty = NULL){
	
		$this->Brand = isset($Item['brand']) ? $Item['brand'] : '';
		$this->Type = isset($Item['type']) ? $Item['type'] : '';
		$this->LPNumber = isset($Item['lpnumber']) ? $Item['lpnumber'] : '';
	
	}
	
	public function Get($ID, $smarty = NULL) {
	
		$DBQueryResult = $this->GetFromDB($ID);
		$this->Brand = $DBQueryResult[0]['Brand'];
		$this->Type = $DBQueryResult[0]['Type'];
		$this->LPNumber = $DBQueryResult[0]['LPNumber'];		
	}
	
	public function Set($ID) {
		
		$Validation = new Validation();

		$Validation->ValidateMandatory($this->Brand, 'Márka');
		$Validation->ValidateStrLen($this->Brand, 3, 255, 'Márka');
		
		$Validation->ValidateMandatory($this->Type, 'Típus');
		$Validation->ValidateStrLen($this->Type, 3, 255, 'Típus');		
		
		$Validation->ValidateMandatory($this->LPNumber, 'Rendszám');
		$Validation->ValidateLPNumber($this->LPNumber);				

		if($Errors = $Validation->GetValidationErrors()){
			// hiba történt validáció közben -> hiba visszaküldése a felhasználónak
			return array('error', $Errors);
		}
		else {
			// Mentés az adatbázisba
			$DBQueryResult = $this->Save2DB($ID);
			return array('ok', '1');
		}
		
	}
	
	public function Delete($ID) {
		
		// hány autó van az  részlegnek?
		$DBQueryResult1 = $this->GetNoOfCarUsersFromDB($ID);
		
		$Validation = new Validation();
		$Validation->ValidateDelete($DBQueryResult1[0]['NoOfUsers'], 'autót');
		
		if($Errors = $Validation->GetValidationErrors()){
			// hiba történt validáció közben -> hiba visszaküldése a felhasználónak
			return array('error', $Errors);
		}
		else {
			// törlés az adatbázisból
			$DBQueryResult2 = $this->DeleteFromDB($ID);
			return array('ok', '1');
		}		
	}
	
	
	public static function GetMulti($sort) {
	
		$DBQueryResult = self::GetFromDB(NULL, $sort);
		return $DBQueryResult;

	}	
	

	/***********************/
	/* adatbázis műveletek */
	/***********************/

	
	public function GetNoOfCarUsersFromDB($ID) {
		$db = ADONewConnection('mysql');
		//$db->debug = true;
		$db->Connect(DBHOST, DBUSER, DBPASS, DBNAME);
		
		$db->SetFetchMode(ADODB_FETCH_ASSOC);
		
		$DBQueryResult = $db->Execute("SELECT count(*) as NoOfUsers FROM RelEmpCar WHERE CarID = $ID");
		
		if (!$DBQueryResult) print $db->ErrorMsg();
		else return $DBQueryResult->GetRows();		
		
	}
	
	
	public static function GetFromDB($ID = '', $sort = ''){

		if($sort != '') $sortttext = "order by $sort asc";
		else $sortttext = '';
	
		$db = ADONewConnection('mysql');
		//$db->debug = true;
		$db->Connect(DBHOST, DBUSER, DBPASS, DBNAME);
		
		$db->SetFetchMode(ADODB_FETCH_ASSOC);
		
		if($ID == '') $DBQueryResult = $db->Execute("SELECT * FROM CompanyCar $sortttext");
		else $DBQueryResult = $db->Execute("SELECT * FROM CompanyCar WHERE ID = $ID");
		
		if (!$DBQueryResult) print $db->ErrorMsg();
		else return $DBQueryResult->GetRows();
		
	}
	
	public function Save2DB($ID){

		$db = ADONewConnection('mysql');
		//$db->debug = true;
		$db->Connect(DBHOST, DBUSER, DBPASS, DBNAME);
		
		$Brand = htmlspecialchars($this->Brand, ENT_QUOTES);
		$Type = htmlspecialchars($this->Type, ENT_QUOTES);
		
		// update vagy insert?
		if($ID == '') $DBQueryResult = $db->Execute("INSERT INTO CompanyCar (Brand, Type, LPNumber) values ('$Brand', '$Type', '$this->LPNumber')");
		else $DBQueryResult = $db->Execute("UPDATE CompanyCar SET Brand='$Brand', Type='$Type',LPNumber='$this->LPNumber' WHERE ID='$ID'");
		
		if (!$DBQueryResult) print $db->ErrorMsg();
		else return $DBQueryResult;
	}
	
	public function DeleteFromDB($ID){

		$db = ADONewConnection('mysql');
		//$db->debug = true;
		$db->Connect(DBHOST, DBUSER, DBPASS, DBNAME);
		
		$DBQueryResult = $db->Execute("DELETE FROM CompanyCar WHERE ID='$ID'");
		
		if (!$DBQueryResult) print $db->ErrorMsg();
		else return $DBQueryResult;
	}	
	
	
	
}
