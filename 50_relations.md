## Relationen
### Beispiel Artikel / Kategorien
Ein Artikel (Article) hat genau eine Kategorie (Category).
### Erweiterung Datenbank 
Über Migration Datenbank anpassen, neue Tabelle für die Kategorien:

	class Migration_categories extends XorcStore_Migration{

 		function up(){
			$this->create_table("categories", "
         		id I AUTO KEY,
         		name c(64) NOTNULL,
         		created_at T NOTNULL
			");
		}
   
		function down(){
			$this->drop_table("categories");
		}
	}

Erweiterung der Artikel-Tabelle um das Feld für den Fremdschlüssel:

	class Migration_add_category_to_articles extends XorcStore_Migration{
	
		function up(){
			$this->add_column("articles", "
				category_id I
			");
		}

		function down(){
			$this->drop_column("articles", "category_id");
		}
	}

?>

Migration ablaufen lassen.

Wichtig: Das Feld für den Fremdschlüssel heißt immer \[Objektname\_id\].

### Model / Controller / Views 

Als nächster Schritt kann mit "gen crud" das Gerüst und die Verwaltung für die Kategorien erzeugt werden.
Braucht man keine komplette Verwaltung, sollte zumindest ein Model für category angelegt werden.
### Erweiterung Model
Im Model Article wird nun eine neue Funktion für die Beziehung zu den Kategorien hinzugefügt:

	class Article extends XorcStore_AR {
	// gehört zu (n:1)
		function belongs_to() {		
			return array('category'=>array('class'=>'Category', 'fkey'=>'category_id'));
		}
		/* Weitere Möglichkeiten
	
	// hat mehrere (1:n)
		function has_many() {
			return array('attachments'=>array('class'=>'Attachment', 'fkey'=>'article_id'));		
		}
	
	// hat mehrere, gehört zu (n:m)
		function has_many_belongs_to_many() {
			return array('tags'=>array(
				'join_table'=>'article_tag',
				'class'=>'Tag',
				'dependent'=>'none', //(or dependents will be deleted!)
				'fkey'=>'tag_id',
				'myfkey'=>'article_id'));
		}*/
	// hat eins (1:1)	
		function has_one() {
			return array('address'=>array('class'=>'Address', 'fkey'=>'article_id'));		
		}
	}
	
### Zugriff auf Objekt

	<? if($article->category) { ?>Eingeordnet unter "<?=$article->category->name?>"<? } ?>


	$article->category // enthält das Objekt
	$article->category->name // Zugriff auf die einzelnen Felder (Eigenschaften) des Objekts

### Liste für Selectbox erzeugen
Im Verzeichnis lib/\[projekt\] legt man eine Datei \[projekt\]\_helper.php ab. Diese Datei muss noch per include\_once() in \[projekt\].class.php geladen werden. Funktionen in dieser Datei sind global verfügbar. Hier kann man dann auch die Funktion zum Selektieren der Kategorien einfügen:

	function category_list() {
		static $load = NULL;
	
		if(!$load) {
			$load = Category::i()->map("name");
		}
		return $load;
	}
### Selectbox im View

	<?=label_tag('Kategorie', 'category_id')?>
	<?=$f->select_box("category_id", category_list(), array("nullentry"=>"Bitte auswählen"))?><br />
