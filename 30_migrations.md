## Migrationen

### Kommandozeile

Alle Migrationskommandos werden auf der Datenbank ausgeführt, die mit `--db=DSN --prefix=PREFIX`    
spezifiziert ist. Beim Aufruf über die Applicationskommandozeile, wird die Datenbank so angesteuert, wie es in der ini Datei spezifiziert ist.

    migrate [version=VERSION_NUMBER] [dry] 
        up/ downgrade to highest version or VERSION_NUMBER 
        dry means all ddl is printed but not executed 
        all migrations are in db/VERSION_NUMBER_description.php

    migrate new description 
        generate new migrationfile in db/ directory

    migrate init 
        generating versiontable for database/ prefix

    migrate dump 
        prints schema migration to screen 
        use dump > db/schemafilename.php for further use with load

    migrate load migrationfile [down] 
        load migrationfile to create a schema option down reverses the ddl

    migrate dumpdata migrationdatafile 
        creates a database dump

    migrate loaddata migrationdatafile 
        loads a database dump

### Methoden

#### create_table

    void create_table($tab, $cols)

#### drop_table

    void drop_table($tab)

#### rename_table

    void rename_table($old, $new)

#### unrename_table

    void unrename_table($old, $new)

#### alter_table

    void alter_table($tab, $cols)

#### add_column
    
    void add_column($tab, $col)

#### drop_column

    void drop_column($tab, $col)

#### alter_column

    void alter_column($tab, $col)

#### rename_column

    void rename_column($tab, $old, $new)

#### unrename_column

    void unrename_column($tab, $old, $new)

#### create_index
   
    void create_index($tab, $cols, $extra=null, $idxname=null)
    
Beispiele:
    
    $this->create_index("books", "author_id");
    $this->create_index("books", "isbn", "UNIQUE");
    $this->create_index("books", "isbn", "UNIQUE", "isbn_idx");
    $this->create_index("books", "year,country");
    
#### drop_index

    void drop_index($tab, $idxname)
    
Beispiele:

    $this->drop_index("books", "author_id");
    $this->drop_index("books", "isbn");
    $this->drop_index("books", "isbn_idx");
    $this->drop_index("books", "year,country");

#### ddl

    void ddl($table, $ddl)
    