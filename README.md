# Company HR App

With this application you can manage employee data. You can add new employees, edit and delete them, assign them to  departments, keep a record of their company cars.

Created in 2013, uploaded to github in 2018.

## Install steps

1. Have a *AMP environment with PHP 5+ and MySQL 5+ installed.

2. Setup /inc/config.php for DB connection.

3. Download ADOdb 5.x from http://adodb.org/dokuwiki/doku.php and copy contents to /inc/adodb5.

4. Download Smarty 3.1.x from https://github.com/smarty-php/smarty/releases/tag/v3.1.30 and copy contents to /inc/Smarty-3.1.13.

5. Run index.php.

## Task description

- See headline and short lead.

- Make the app in pure PHP 5+, don't use any framework.

- Use ADOdb as Database Abstraction Layer and Smarty as Template Engine.

- Add basic CSS for usability, no fancy design is necessary.

- Do form validations and company data relations as per below (Hungarian only):

Alkalmazottak (Listázás/Rendezés + Új/Módosítás/Törlés)
	Név (3-255 karakter, kötelezően kitöltendő)
	Telefonszám (0-255 karakter, nem kötelező)
	Email (0-255 karakter, kötelezően kitöltendő, email szintaxis ellenőrzés)
	Megjegyzés (0-1000 karakter, nem kötelező)
	Részleg (több is választható listából, de 1 kötelező)
	Céges autó (több is választható listából, de nem kötelező)

Részleg (Listázás/Rendezés + Új/Módosítás/Törlés (törlés csak ha nincs hozzárendelve egyik Alkalmazotthoz sem))
	Név (3-255 karakter, kötelezően kitöltendő)
	Létszám (aktuális létszám)

Céges autó (Listázás/Rendezés + Új/Módosítás/Törlés (törlés csak ha nincs hozzárendelve egyik Alkalmazotthoz sem))
	Márka (3-255 karakter, kötelezően kitöltendő)
	Típus (3-255 karakter, kötelezően kitöltendő)
	Rendszám (6 karakter: XXX-YYY fromában, ahol X szám lehet csak, Y betű, kötelezően kitöltendő)
