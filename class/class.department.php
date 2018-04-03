<?php 

class Department  {
	
	
	public $Name = '';
	
	
	public function __construct($Item = NULL, $smarty = NULL){
	
		$this->Name = isset($Item['name']) ? $Item['name'] : '';
	
	}
	
	public function Get($ID, $smarty = NULL) {
	
		$DBQueryResult = $this->GetFromDB($ID);
		$this->Name = $DBQueryResult[0]['Name'];
	}
	
	public function Set($ID) {
		
		$Validation = new Validation();

		$Validation->ValidateMandatory($this->Name, 'Név');
		$Validation->ValidateStrLen($this->Name, 3, 255, 'Név');

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
		
		// hány tagja van a részlegnek?
		$DBQueryResult1 = $this->GetNoOfMembersFromDB($ID);
		
		$Validation = new Validation();
		$Validation->ValidateDelete($DBQueryResult1[0]['NoOfMembers'], 'részleget');
		
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

	
	public function GetNoOfMembersFromDB($ID) {
		$db = ADONewConnection('mysql');
		//$db->debug = true;
		$db->Connect(DBHOST, DBUSER, DBPASS, DBNAME);
		
		$db->SetFetchMode(ADODB_FETCH_ASSOC);
		
		$DBQueryResult = $db->Execute("SELECT NoOfMembers FROM Department WHERE ID = $ID");
		
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
		
		if($ID == '') $DBQueryResult = $db->Execute("SELECT * FROM Department $sortttext");
		else $DBQueryResult = $db->Execute("SELECT * FROM Department WHERE ID = $ID");
		
		if (!$DBQueryResult) print $db->ErrorMsg();
		else return $DBQueryResult->GetRows();
		
	}
	
	public function Save2DB($ID){

		$db = ADONewConnection('mysql');
		//$db->debug = true;
		$db->Connect(DBHOST, DBUSER, DBPASS, DBNAME);
		
		$Name = htmlspecialchars($this->Name, ENT_QUOTES);
		
		// update vagy insert?
		if($ID == '') $DBQueryResult = $db->Execute("INSERT INTO Department (Name) values ('$Name')");
		else $DBQueryResult = $db->Execute("UPDATE Department SET Name='$Name' WHERE ID='$ID'");
		
		if (!$DBQueryResult) print $db->ErrorMsg();
		else return $DBQueryResult;

	}
	
	public function DeleteFromDB($ID){

		$db = ADONewConnection('mysql');
		//$db->debug = true;
		$db->Connect(DBHOST, DBUSER, DBPASS, DBNAME);
		
		$DBQueryResult = $db->Execute("DELETE FROM Department WHERE ID='$ID'");
		
		if (!$DBQueryResult) print $db->ErrorMsg();
		else return $DBQueryResult;

	}	
	
	
}
