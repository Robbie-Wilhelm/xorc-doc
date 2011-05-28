## MVC
### Allgemeiner Aufbau
### Namespaces
In vielen komplexeren Anwendungen reicht die Unterteilung der Applikation in die einzelnen Controller und Actions nicht aus.
Will man z. B. für einen abgeschlossenen Adminbereich und einen öffentlichen Publicbereich eine weitere Unterteilung erreichen, kann man das in xorc wie folgt umsetzen.
Es ist jedoch hier etwas manueller Aufwand notwendig.

#### Controller
Als erstes legt man unterhalb von src/controller neue Unterordner an, die dann die Bereiche widerspiegeln. In unserem Beispiel wären das die Unterordner "admin" und "public".

Um jetzt den Adminbereich einzurichten, erstellt man eine neue Datei "admin\_controller.class.php" im Unterverzeichnis "admin" mit folgendem Inhalt:

	<?php 
	
	class Admin_Controller extends Xorc_Controller {
				
	}
	
	?>

Im Admin-Controller kann jetzt auch alles implementiert werden, was spezifisch für genau diesen Bereich ist und was an die Controller in diesem Bereich vererbt werden soll.

Hat man bereits Controller erstellt, die man im Adminbereich verwenden will, so verschiebt man diese aus src/controller nach src/controller/admin und hängt an den Dateinamen ein "admin_" an.
Aus dem Account-Controller account\_c.class.php wird so admin\_account\_c.class.php.

In der Datei selbst ändert man die Ableitung von Xorc\_Controller nach Admin\_Controller:

	<?php
	
	require_once("admin_controller.class.php");
	
	class Admin_Account_C extends Admin_Controller{
	
		function index(){
	
Ein require_once("admin\_controller.class.php"); muss manuell eingefügt werden.

So verfährt man analog mit den anderen Controllern bzw. erstellt gleich die neuen Controller.

Als letztes ist ein Eintrag in die Datei routes.txt (in src) notwendig, damit die Route auch richtig funktioniert:

	admin/$controller/$action/$id      admin/$controller/$action    $id~(\w+)? $id=

Zugegriffen wird dann im Browser auf die Index-Action des neuen Admin-Account-Controllers im Browser über "mydomain/admin/account/index"

Für "public" genauso verfahren.

#### Views
Auch unterhalb des Verzeichnisses src/view werden Unterverzeichnisse angelegt, die zu den Bereichen gehören - also wieder "admin" und "public" für unser Beispiel.

Dort werden die existierenden Views jeweils hineinkopiert bzw. neu angelegt. Hier muss jedoch nichts an den Namen angehängt werden. Die Datei account\_index.html heißt auch im neuen Verzeichnis "admin" genauso wie vorher.

Es ist möglich, in den Unterverzeichnissen auch eigene \_header und \_navigation-Includes zu verwenden.