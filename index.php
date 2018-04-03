<?php

// entitásnak nevezem: alkalmazott, részleg, céges autó

// utf-8 karakterek mindenhol
header('Content-Type: text/html; charset=utf-8');

// include-ok és osztályok betöltése
require_once('inc/adodb5/adodb.inc.php');
require_once('inc/Smarty-3.1.13/libs/Smarty.class.php');
require_once('inc/config.php');
require_once('class/class.form.php');
require_once('class/class.validation.php');
require_once('class/class.employee.php');
require_once('class/class.department.php');
require_once('class/class.companycar.php');

// smarty inicializálása
$smarty = new Smarty;

// a html form elemek megjelenítéséhez szükséges osztály regisztrálása a smarty view-ba
$Form = new Form();
$smarty->assign("form", $Form);

// melyik oldalról érkeztünk?
if (isset($_GET['p'])) $page=$_GET['p'];
elseif (isset($_POST['p'])) $page=$_POST['p'];
else $page='get';

// melyik entitásssal akarunk dolgozni?
if (isset($_GET['entity'])) $entity=$_GET['entity'];
elseif (isset($_POST['entity'])) $entity=$_POST['entity'];
else $entity='employee';

// jött ID az entitáshoz?
if (isset($_GET['id'])) $id=$_GET['id'];
else $id='';

// jött rendezési kérés?
if (isset($_GET['sort'])) $sort=$_GET['sort'];
else $sort='';

if (isset($_POST['submit'])) {
	// adatokat küldött a form
	$EntityObj = new $entity($_POST, $smarty); // entitás létrehozása és változóinak feltöltése
	$Result = $EntityObj->Set($id); // adatok mentése
	$smarty->assign("result", $Result); // eredmény regisztrálása a smarty view-ba
}else {
	// nem érkeztek adatok a formból
	$smarty->assign("result", 'no'); // NULL eredmény regisztrálása a smarty view-ba
	$EntityObj = new $entity(NULL, $smarty); // entitás létrehozása és változóinak inicializálása
}

if (isset($_POST['submit']) && $Result[0] == 'ok') {
	// már feldolgoztuk a formot, ezért a listázó oldalra küldjük a felhasználót
	$smarty->assign("data", $EntityObj->GetMulti($sort));
	$page = 'get';
} else
	switch($page){
			// még nem dolgoztuk fel a formot -> a kérésnek megfelelő oldal lehívása
			case 'get': 
				$smarty->assign("data", $EntityObj->GetMulti($sort)); // lista adatok regisztrálása a smarty view-ba
				break;
			case 'create': 
				$smarty->assign("data", $EntityObj); // NULL adatok regisztrálása a smarty view-ba
				$title = "létrehozása";
				break;
			case 'edit': 
				$EntityObj->Get($id, $smarty); // módosítás az ID alapján
				$smarty->assign("data", $EntityObj); // módosítandó adatok regisztrálása a smarty view-ba
				$title = "módosítása";				
				break;
			case 'delete': 
				$Result = $EntityObj->Delete($id);	// törlés
				$smarty->assign("result", $Result); // törlés eredményének regisztrálása a smarty view-ba
				// majd a listázó oldalra küldjük a felhasználót
				$smarty->assign("data", $EntityObj->GetMulti($sort));
				$page = 'get'; 
				break;
	}

// ugyanazt a view-t használjuk létrehozáshoz és módosításhoz
$page == 'create' ? $view = 'edit' : $view = $page;

// oldal címének regisztrálása a smarty view-ba
if(!isset($title)) $title = '';
$smarty->assign("title", $title);

// view generálása smarty-val
$smarty->display('view/'.$view.'-header.tpl');
$smarty->display('view/'.$view.'-'.$entity.'.tpl');
$smarty->display('view/'.$view.'-footer.tpl');

?>

