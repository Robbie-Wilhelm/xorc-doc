## Authentifizierung
### Ein Wort vorab
Da xorc das aktuelle Benutzerobjekt in der Variable $this->user im Controller (bzw. $user dann im View) verwaltet, ist es sinnvoll, für die eigentliche Userverwaltung gleich einen anderen Namen zuverwenden, z. B. Account. 
Somit kann man sich mit dem Benutzerobjekt nicht "in die Quere" kommen und vermeidet gleich von Anfang an eine mühselige Fehlersuche, wenn man sich das Benutzerobjekt $user ausversehen überschrieben hat.
### Userverwaltung
#### Eine Tabelle für die Benutzer
Um die Benutzer authentifizieren zu können, müssen wir sie erstmal auch selbst verwalten. Dazu wird eine Tabelle angelegt, diese könnte z. B. wie folgt aussehen:

	function up(){
		$this->create_table("accounts", "
			id I AUTO KEY,
			email c(64) NOTNULL,
			password c(64),
			uname c(32),
			firstname c(32),
			lastname c(32),
			login_count I,
			failed_login_count I,
			current_login_at T,
			last_login_at T,
			current_login_ip c(32),
			last_login_ip c(32),
			perm c(10),
			status I,
			old_id c(32),
			created_at T NOTNULL,
			modified_at T
		");
	}   

#### Eine erste Verwaltung
Nach erfolgter Migration und kann auch hier wieder mit "gen crud" die zur Tabelle accounts dazugehörende Verwaltung generiert werden.

Dabei wird auch die Datei für das Model account.class.php generiert.

Jetzt können noch die Views angepasst werden und die Felder, die nicht benötigt entfernt bzw. zwei Felder in einer Spalte angeordnet werden.
### Die Konfiguration

	[auth]
	controller=blogger_auth
	allow_rememberme=false
	layout=
	redirect=1
	
	mvc=auth
	mvcplus=1

### Der Auth-Controller
Im Verzeichnis src/controller muss nun eine neue Datei auth_c.class.php erstellt werden, welche den Auth-Controller enthält.

Der Auth-Controller erbt von der Klasse Xorc\_Auth\_Controller implementiert die folgenden Funktionen:

 * login()
 * logout() 
 * relogin()
 * before_logout()
 * restricted()
 * _init()
 * _fetch_user()
 * _fetch_auth_id_from_login()  	
 * _check_login()

### Die Views
Im Verzeichnis src/view sind die folgenden Views notwendig:

 * auth_login.html
 * auth_logout.html
 * auth_relogin.html

Beispiel auth_login.html


	<div id="login">
		<div id="welcome">
			<h1>Willkommen zu Blogger</h1>
		</div>

		<div id="form">
			<form action="<?=url("user/index")?>" method="post">
    		<div id="msg"><?=$msg?></div>

			<fieldset>
				<label for="xorcuser">E-Mail</label><br>
				<input type="Text" id="xorcuser" name="username" size="15" maxlength="24" value="" ><br><br>
				
				<label for="xorcpass">Passwort</label><br>
				<input type="password" id="xorcpass" name="password" size="15" maxlength="16" value=""><br><br>
				
			</fieldset>
			
			<fieldset>
				<div class="xf">
					<button type="Submit" name="post" value="Login" class="btn green">Anmelden</button><br><br>
				</div>
			</fieldset>

			<fieldset>
				<?=link_to("register/reminder", "Ich habe mein Passwort vergessen.")?>
			</fieldset>
			</form>
		</div>
	</div>

Wichtig sind die beiden Input-Felder "xorcuser" und "xorcpass", da über diese die Login-Daten übergeben werden. Diese können auch nach eigenem Geschmack angepasst werden.
### Ein geschützter Bereich
Damit die Authentifizierung ausgelöst wird, muss der gewünschte Controller gekennzeichnet werden. 

Das erfolgt durch die Zeile

	public $require_auth=true;

im Controller, also in unserem Beispiel im User-Controller in der Datei user_c.class.php.

Ruft man nun eine Action des so markierten Controllers auf, wird man auf die Login-Seite weitergeleitet.
### Anpassungen am Auth-Controller
Die Implementierung des Login-Prozesses erfolgt, in dem zuerst die Funktion \_check\_login() im Auth-Controller überschrieben wird.

	function _check_login(){

		$xorcuser = $this->r['username'];
		$xorcpass = $this->r['password'];
		
		if ($xorcuser && $xorcpass) {
         
			// implement login check here
			$account = Account::i()->find_by_email($this->r['username']); 
		
			if($u->password == $xorcpass) {
				return true;
			} else {
				return false;
			}
		}
		return false;
	}

In dieser Funktion wird dann auch die eigene Passwort-Check Funktion aufgerufen. Im Beispiel ist (denkbar schlecht, nur zur Demonstartion) das Passwort als Klartext abgelegt und wird mit dem übergebenen Passwort verglichen.

In der Funktion \_fetch\_auth\_id\_from\_login() wird implementiert, wie aus den übergebenen Login-Daten die Id extrahiert wird. 
 
	function _fetch_auth_id_from_login(){
	// store unique id in session
		$account = Account::i()->find_by_email($this->r['username']); 	   	
		return $account->id;
	}

Diese Id wird in der Session gespeichert und dient bei nachfolgenden Seitenaufrufen dazu, das Benutzerobjekt wieder zu selektieren.
Das erfolgt mit der Funktion \_fetch\_user(), in der dann dieser Prozess implementiert wird: 

	function _fetch_user(){
		$account = Account::i()->find($this->sess->id); 	   
		return $account;
	}
  	
Das Benutzerobjekt steht global in jedem Controller als $this->user zur Verfügung, in den Views kann es direkt über $user angesprochen werden.

Achtung: Aus diesem Grund darf es in keinem Controller $this->user als eigene Variable geben. Dadurch wird das Benutzerobjekt überschrieben und die Authentifizierung funktioniert nicht.
### Ein besserer Passwort-Check
Besser ist es natürlich, wenn das Passwort in der Datenbank verschlüsselt abgelegt ist.

Dafür verlagern wir als erstes die Check-Funktion in das Model. 

Die Passwort-Check-Funktion im Model könnte wie folgt aussehen:

	function check_password($pass) {
		if(md5($pass) == $this->password) {
			return true;
		} else {
			return false;
		}
	}

In auth_c.class.php sieht das dann wie folgt aus:

	function _check_login(){

		$xorcuser = $this->r['username'];
		$xorcpass = $this->r['password'];
		
		if ($xorcuser && $xorcpass) {
         
			// implement login check here
			$account = Account::i()->find_by_email($this->r['username']); 
		
			if($account->check_password($xorcpass)) {
				return true;
			} else {
				return false;
			}
		}
		return false;
	}

### Logout
Abmelden kann man sich über die Logout-Action im Auth-Controller. Der Link kann z. B. im View-Part _header.html eingebaut werden.

	<?=link_to("auth/logout", "Abmelden")?>  	
### Weitere Aktionen nach dem Login
Möchte man weitere Aktionen am Benutzerobjekt ausführen, also z. B. die Anzahl der Logins speichern oder die aktuelle IP, dann kann man das in der Funktion _check_login() im Auth-Controller implementieren.
Man ruft dort einfach die gewünschte Funktion am $account-Objekt auf, z. B. $account->after_login();
### Beispiel

::include book_auth.php

### Änderung des Passworts
Wenn das Passwort verschlüsselt gespeichert wird, darf es nur über eine spezielle Controller-Action geändert werden. 
Dafür fügen wir im Account-Controller zwei neue Actions ein: change_password() zur Anzeige der View und save_password() zum Speichern.


### Registrierung
### Anbindung an externe Benutzerverwaltungen