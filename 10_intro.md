


## eine anwendung anlegen

- datenbank anlegen (z.b. mit phpmyadmin oder bestehende nutzen)
- anwendungsordner anlegen und hineinwechseln (z.b. /home/data/projekte/2009/betatagcloud/)
- terminal öffnen
- das grundgerüst für eine neue anwendung generieren. die datenbank und ein prefix (der allen tabellen dieser anwemdung automatisch vorangestellt wird) müssen angegeben werden.
 
			/home/data/xorclib/xorc/bin/xorc --db=mysql://root:@localhost/betasystems --prefix=tc gen app 
		
- xorc legt automatisch ordner in _/home/data/projekte/2009/betatagcloud/_ an: 

			bin
				betatagcloud
			conf
				betatagcloud_dev.ini
				betatagcloud_dist.ini
			lib
				betatagcloud
					betatagcloud.class.php
			public
				app.css
				index.php
				xorcform.css
			src
				routes.txt
				view
					_layout.bottom.html
					_layout.page.html
					_layout.top.html
			var
		
- das _public_ verzeichnis muß in die htdocs des webservers gelinkt werden 

			ae@monty / $ ln -s /home/data/projekte/2009/betatagcloud/public var/www/localhost/htdocs/betatagcloud
		
- jetzt kann man ein textmateprojekt mit dem anwendungsordner anlegen.
- 'lib/anwendungsname/anwendungsname.class.php' ist der startpunkt der anwendung

				
- zuerst muß die migration initialisiert werden, das erzeugt die versionstabelle für diese anwendung.
		achtung: nicht mehr mit '/home/data/xorclib/xorc/bin/xorc' sondern mit dem bin-verzeichnis der anwendung arbeiten.)

			ae@monty /home/data/projekte/2009/betatagcloud $ ./bin/betatagcloud migrate init
			
- jetzt können die tabellen für die anwendung erzeugt werden
- im ordner 'db' werden die migrationsfiles abgelegt.
	für jede änderung an den tabellen der anwendung wird ein migrationsfile erstellt.

				001_account.php
				002_contact_persons.php
				003_dependendency.php
				004_calendar.php
				005_
				....
				
- eine erste migrationsdatei könnte so aussehen:

			<?
			class Migration_tagcloud extends XorcStore_Migration{
			   function up(){
			      $this->create_table("tags", "
						id I AUTO KEY,
						descr c(255),
						href c(255),
						class c(128),
						title c(255),
						rel c(64),
						style c(255),
						color c(16),
						hicolor c(16),
						target c(16)
						");
			   }		
			   function down(){
			      $this->drop_table("tags");
			   }
			}
			?>
			
- jetzt kann die erste migration abgefahren werden. man sollte vorher mit 'dry' einen testlauf machen:

		$ ./bin/betatagcloud migrate [dry]
		
- xorc erzeugt die tabelle(n), so wie im migrationsfile festgelegt und setzt die entsprechende version (hier version 1).
- nun kann man sich auch noch generische controller und views erzeugen lassen. man sollte die gewünschten tabellen (ohne prefix) als parameter angeben.

		$ ./bin/betatagcloud gen crud tags
		
	erzeugt: 
	
		controller
			tag_c.class.php
			
		und in 'view'
			_tag_form.html
			tag_create.html
			tag_edit.html
			tag_index.html
			
		
 
		




			
		



