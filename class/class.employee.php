<?php 

class Employee  {
	
	
	public $Name = '';
	
	public $Phone = '';
	
	public $Email = '';
	
	public $Note = '';
	
	public $DepID = array();
	public $DepName = array();
	
	public $CarID = array();
	public $CarName = array();	
	
	public function __construct($Item = NULL, $smarty = NULL){
	
		$this->Name = isset($Item['name']) ? $Item['name'] : '';
		$this->Phone = isset($Item['phone']) ? $Item['phone'] : '';		
    $this->Email = isset($Item['email']) ? $Item['email'] : '';	
		$this->Note = isset($Item['note']) ? $Item['note'] : '';	

		if(isset($Item['departments'])) {
			// kiválasztott részlegek a formból
			foreach($Item['departments'] as $Department){
			 $this->DepID[] = $Department;
			}
		} else $this->DepID = array();
		
		// összes részleg inicializálása
		foreach(Department::GetFromDB() as $Department){
		 $this->DefDepID[] = $Department['ID'];
		 $this->DefDepName[] = $Department['Name'];
		}
		
		// összes + kiválasztott részleg regisztrálása a smarty view-ba
		if (isset($this->DefDepID)){			
			$smarty->assign("option_values", $this->DefDepID);
			$smarty->assign("option_output", $this->DefDepName);	
			$smarty->assign("option_selected", $this->DepID);	
		}
	
		if(isset($Item['companycars'])) {
			// kiválasztott céges autók a formból
			foreach($Item['companycars'] as $Car){
			 $this->CarID[] = $Car;
			}			

		}else $this->CarID = array();
		
		// összes céges autó inicializálása
		foreach(CompanyCar::GetFromDB() as $Car){
		 $this->DefCarID[] = $Car['ID'];
		 $this->DefCarName[] = $Car['Brand'].' '.$Car['Type'].' '.$Car['LPNumber'];
		}

		// összes + kiválasztott autó regisztrálása a smarty view-ba		
		if (isset($this->DefCarID)){
			$smarty->assign("cc_option_values", $this->DefCarID);
			$smarty->assign("cc_option_output", $this->DefCarName);	
			$smarty->assign("cc_option_selected", $this->CarID);	
		}
		
	}
	
	public function Get($ID, $smarty = NULL) {
	
		$DBQueryResult = $this->GetFromDB($ID);
		$this->Name = $DBQueryResult[0]['Name'];
		$this->Phone = $DBQueryResult[0]['Phone'];		
		$this->Email = $DBQueryResult[0]['Email'];
		$this->Note = $DBQueryResult[0]['Note'];		
		
		// összes részleg inicializálása
		$this->DefDepID = array();
		$this->DefDepName = array();
		foreach(Department::GetFromDB() as $Department){
			 $this->DefDepID[] = $Department['ID'];
			 $this->DefDepName[] = $Department['Name'];
		}

		// a már kiválasztott inicializálása
		foreach($DBQueryResult as $Department){
		 if(isset($Department['DepID'])) $DepIDSel[] = $Department['DepID'];
		}
		
		$smarty->assign("option_values", $this->DefDepID);
		$smarty->assign("option_output", $this->DefDepName);
		
		if (isset($DepIDSel)) $smarty->assign("option_selected", $DepIDSel);		

		// összes céges autó inicializálása		
		$this->DefCarID = array();
		$this->DefCarName = array();
		foreach(CompanyCar::GetFromDB() as $Car){
		 $this->DefCarID[] = $Car['ID'];
		 $this->DefCarName[] = $Car['Brand'].' '.$Car['Type'].' '.$Car['LPNumber'];
		}
		
		// a már kiválasztott autó inicializálása
		foreach($DBQueryResult as $Car){
		 if(isset($Car['CarID'])) $CarIDSel[] = $Car['CarID'];
		}		

		$smarty->assign("cc_option_values", $this->DefCarID);
		$smarty->assign("cc_option_output", $this->DefCarName);	

		if (isset($CarIDSel)) $smarty->assign("cc_option_selected", $CarIDSel);

	}	
	
	
	public function Set($ID) {
		
		$Validation = new Validation();

		$Validation->ValidateMandatory($this->Name, 'Név');
		$Validation->ValidateStrLen($this->Name, 3, 255, 'Név');

		$Validation->ValidateStrLen($this->Phone, 0, 255, 'Telefonszám');
		
		$Validation->ValidateMandatory($this->Email, 'E-mail');
		$Validation->ValidateEmail($this->Email);
		
		$Validation->ValidateStrLen($this->Note, 0, 1000, 'Megjegyzés');		
		
		$Validation->ValidateMandatory($this->DepID, 'Részleg');	
		
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
	
	public static function GetMulti($sort) {
	
		$DBQueryResult = self::GetFromDB(NULL, $sort);
		return $DBQueryResult;

	}	
	
	public function Delete($ID) {
			$DBQueryResult = $this->DeleteFromDB($ID);
	}		
		
	
	/***********************/
	/* adatbázis műveletek */
	/***********************/
	
	
	public static function GetFromDB($ID = '', $sort = ''){

		if($sort != '') $sortttext = "$sort asc,";
		else $sortttext = '';
	
		$db = ADONewConnection('mysql');
		//$db->debug = true;
		$db->Connect(DBHOST, DBUSER, DBPASS, DBNAME);
		
		$db->SetFetchMode(ADODB_FETCH_ASSOC);
		
		if($ID == '') $DBQueryResult = $db->Execute("SELECT e.*, r.departmentid as DepID, d.name as DepName, rc.CarID as CarID, cc.LPNumber as CarName FROM Employee as e join RelEmpDep as r on e.id = r.employeeid join Department as d on r.departmentid = d.id left join RelEmpCar as rc on e.id = rc.employeeid left join CompanyCar as cc on rc.carid = cc.id order by $sortttext id asc");
		else $DBQueryResult = $db->Execute("SELECT e.*, r.departmentid as DepID, d.name as DepName, rc.CarID as CarID, cc.LPNumber as CarName FROM Employee as e join RelEmpDep as r on e.id = r.employeeid join Department as d on r.departmentid = d.id left join RelEmpCar as rc on e.id = rc.employeeid left join CompanyCar as cc on rc.carid = cc.id WHERE e.ID = $ID");
		
		if (!$DBQueryResult) print $db->ErrorMsg();
		else return $DBQueryResult->GetRows();
		
	}	
	
	public function Save2DB($ID){

		$db = ADONewConnection('mysql');
		//$db->debug = true;
		$db->Connect(DBHOST, DBUSER, DBPASS, DBNAME);
		
		$Name = htmlspecialchars($this->Name, ENT_QUOTES);
		$Phone = htmlspecialchars($this->Phone, ENT_QUOTES);
		$Email = htmlspecialchars($this->Email, ENT_QUOTES);
		$Note = htmlspecialchars($this->Note, ENT_QUOTES);
		
		// update vagy insert?
		if($ID == '') {
			$DBQueryResult = $db->Execute("INSERT INTO Employee (Name, Phone, Email, Note) values ('$Name', '$Phone', '$Email', '$Note')");
			// utolsó beírt ID a frissen létrehozott alkalmazott
			$EmployeeID = $db->Insert_ID();
		}
		else {
			$DBQueryResult = $db->Execute("UPDATE Employee SET Name='$Name', Phone='$Phone', Email='$Email', Note='$Note' WHERE ID='$ID'");
			$EmployeeID = $ID;
		}


		// alkalmazott-részleg kapcsolat DB műveletek
		if($ID != '') {
		
			// 1. csökkenteni a módosítás előtti részlegek alkalmazottjainak számát
			$DBQueryResult1 = $db->Execute("UPDATE Department SET NoOfMembers = NoOfMembers-1 where ID in (SELECT DepartmentID FROM RelEmpDep WHERE EmployeeID = $EmployeeID)");			

			// 2. majd legegyszerűbb törölni az összes kapcsolatot
			$DBQueryResult2 = $db->Execute("DELETE FROM RelEmpDep WHERE EmployeeID='$EmployeeID'");
			
		}

		// 3. az összes új alkalmazott-részleg kapcsolat mentése és a részlegen dolgozók számának növelése
		foreach($this->DepID as $DepartmentID){
			$DBQueryResult3 = $db->Execute("INSERT INTO RelEmpDep (EmployeeID, DepartmentID) values ($EmployeeID, $DepartmentID)");
			$DBQueryResult4 = $db->Execute("UPDATE Department SET NoOfMembers = NoOfMembers+1 where ID = $DepartmentID");
		}	
		
		// alkalmazott-céges autó kapcsolat DB műveletek
		if($ID != '') {
			// legegyszerűbb törölni az összes kapcsolatot
			$DBQueryResult2 = $db->Execute("DELETE FROM RelEmpCar WHERE EmployeeID='$EmployeeID'");
		}		
		
		// majd elmenteni az újakat
		foreach($this->CarID as $CarID){
			$DBQueryResult3 = $db->Execute("INSERT INTO RelEmpCar (EmployeeID, CarID) values ($EmployeeID, $CarID)");
		}	
		
		if (!$DBQueryResult) print $db->ErrorMsg();
		else return $DBQueryResult;
	}	
	
	public function DeleteFromDB($ID){

		$db = ADONewConnection('mysql');
		//$db->debug = true;
		$db->Connect(DBHOST, DBUSER, DBPASS, DBNAME);
		
		// 1. alkalmazott törlése
		$DBQueryResult1 = $db->Execute("DELETE FROM Employee WHERE ID='$ID'");
		
		// 2. részlegeiben az alkalmazottak számának csökkentése eggyel
		$DBQueryResult2 = $db->Execute("UPDATE Department SET NoOfMembers = NoOfMembers-1 where ID in (SELECT DepartmentID FROM RelEmpDep WHERE EmployeeID = $ID)");
		
		// 3. törlés az alkalmazott-részleg kapcsolatból
		$DBQueryResult3 = $db->Execute("DELETE FROM RelEmpDep WHERE EmployeeID='$ID'");		
		
		// 4. törlés az alkalmazott-céges autó kapcsolatból
		$DBQueryResult4 = $db->Execute("DELETE FROM RelEmpCar WHERE EmployeeID='$ID'");		

		if (!$DBQueryResult1) print $db->ErrorMsg();
		else return $DBQueryResult1;
	}	
}
