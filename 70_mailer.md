## Mails versenden mit xorc

### Die Basis
Xorc stellt für das Versenden von Mails die Klasse Xorc_Mailer bereit. Diese Klasse implementiert alle notwendigen Funktionen und dient als Basis für die eigene Mail-Klasse. In der eigenen Mail-Klasse wird für jede Mailaktion eine Mthode implementiert. Für jede implementierte Mailaktion wird von xorc eine Deliver-Methode bereitgestellt, die dann die Mail verschickt.
Auch für Mails gibt es analog zu den Views Templates in Form von Text-Dateien. In diesen kann mittels PHP-Code auf alle zum Zeitpunkt der Ausführung bekannten Variablen des Mailer-Objekts zugegriffen werden. 

### Eine neue Notifier Klasse
Die eigene Klasse, wie hier im Beispiel ein Notifier, wird von Xorc_Mailer abgeleitet.

	class Register_Notifier extends Xorc_Mailer{
		var $return_path="mail@yourdomain.com";
		var $reply_to='"yourdomain" <mail@yourdomain.com>';
 
		var $from='"yourdomain" <mail@yourdomain.com>';
		var $sitename="yourdomain";
	}
	
Die Klasse wird in einer eigenen Datei (im Beispiel register_notifier.class.php) im Unterverzeichnis der Applikation im lib-Verzeichnis abgelegt.
	
### Die Mail-Aktion
Die gewünschte Mailaktion wird als Methode der eigenen Mailer-Klasse erstellt. Dieser Methode können beim Aufruf die benötigten Datenobjekte übergeben werden.

Im Beispiel eine Funktion für eine Passwort-Erinnerung:

	class Register_Notifier extends Xorc_Mailer{
		/* Mail Parameter siehe oben */
		
		function password_reminder($account){
	    	$this->account = $account;

	    	$this->to($account->email);
	   		$this->subject("[yourdomain.com] Password Request");
	   }
	}

### Das Mail-Template	
Für die Mail-Templates gibt es ein eigenes Verzeichnis "mail" unterhalb des Verzeichnisses "src". In diesem Verzeichnis erwartet xorc alle Mail-Templates als Text-Datei. Die Templates müssen nach einem definierten Schema beannt werden, damit sie der xorc-Mailer findet. Der Name besteht aus den beiden Teilen "Name der Mailer_Klasse" und "Name der die Mailaktion implementierenden Methode" und endet immer auf ".txt", in unserem Beispiel also "register_notifier_password_reminder.txt".

In diesem Template wird nun der Mailtext geschrieben, die Daten werden aus den Variablen übernommen, die in der Funktion mit $this-><variable> gesetzt wurden:
	
	Hallo <?=$account->uname ?>,
	
	Ihr Passwort wurde auf "1234" zurückgesetzt.
	
	-=-=-
	Diese E-Mail wurde automatisch versendet. Bitte nicht antworten.
	-=-=-
	
### Auslösen der Mail
Um die Mail dann auch zu versenden, muss nur in der gewünschten Aktion im Controller ein neues Mail-Objekt erzeugt und die zur Mailaktion gehörende Deliver-Methode aufgerufen werden. In unserem Beispiel heißt diese Methode dann "deliver_password_reminder()":

	function password_reminder_save(){
		$u = User::i()->find_by_email($this->r['user']['email']);
		if(!$u) throw new XorcRuntimeException("Nicht gefunden.", array("header"=>404));
		$mail = new Register_notifier;
		$mail->deliver_password_reminder($u);
	}
