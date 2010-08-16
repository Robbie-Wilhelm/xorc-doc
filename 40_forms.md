



## Formulare

### Funktionen

#### check_box_tag

    string check_box_tag(_$name, $value, $checked=false, $opts=array()_)

beispielcode:    
                
            <?=check_box_tag("clown_cb", 0, false, array("label"=>"Krusty", "id"=>"clown_cb", "class"=>"mycb"))?>
erzeugt:

            <label for="clown_cb"><input type="checkbox" name="clown_cb" value="0" id="clown_cb">Krusty</label>
            
sieht so aus: 

<label for="clown_cb"><input type="checkbox" name="clown_cb" value="0" id="clown_cb">Krusty</label>


#### file_field_tag

    file_field_tag(_$name, $opts=array()_)

beispielcode:    
                
            <?=file_field_tag("bowl-o-rama-timetable")?>
erzeugt:

            <input type="file" name="bowl-o-rama-timetable">
            
sieht so aus:

<input type="file" name="bowl-o-rama-timetable">


#### form_tag

    form_tag($name, $url, $opts=array())
    
beispielcode:    
                
            <?=form_tag("krusty-burger-order-form", "/frontdesk/order", array("class"=>"mass-select", "id"=>"kbof", "replace"=>"#linked-articles"))?>
            
oder 'url' mit ID als array:    

            <?=form_tag("krusty-burger-order-form", array("/frontdesk/order", 3046), array("replace"=>"#weightwatcher_ad", "id"=>"kbof"))?>

erzeugt:

            <form action="/frontdesk/order/3046" id="krusty-burger-order-form" replace="#weightwatcher_ad" method="post">

- 'url' kann weggelassen werden, dann bekommt das formular die aktuelle url (selfurl())  
- wenn 'opts' 'multipart' enthält, wird enctype="multipart/form-data" gesetzt (sollte bei formularen mit dateiuploads benutzt werden)

sieht so aus:

--


#### end_form_tag

    end_form_tag(_$opts=array()_)
    
beispielcode:    
                
            <?=end_form_tag()?>
erzeugt:

            </form>
            
sieht so aus:

--


#### hidden_field_tag

    hidden_field_tag(_$name, $value, $opts=array()_)

beispielcode:    
                
            <?=hidden_field_tag("malloys-money", 0, array("id"=>"malloys-money"))?>
erzeugt:

            <input type="hidden" name="malloys-money" value="1" id="malloys-money" />
            
sieht so aus:

--


#### image_submit_tag(_$name, $src, $opts=array()_)

beispielcode:    
                
            <?=image_submit_tag("save", "gfx/homers-butt.jpg", array('class'=>'ibutton'))?>
erzeugt:

            <input type="image" value="save" name="save" src="/gfx/homers-butt.jpg" class="ibutton">
            
sieht so aus:

<input type="image" value="save" name="save" src="gfx/homers-butt.jpg" class="ibutton">


#### password_field_tag(_$name, $value, $opts=array()_)

beispielcode:    
                
            <?=password_field_tag("sfpssk", "ge.h.eim", array("class"=>"passwort"));?>
erzeugt:

            <input type="password" name="sfpssk" value="ge.h.eim" class="passwort">
            
sieht so aus:

<input type="password" name="sfpssk" value="ge.h.eim" class="passwort">

- 'sfpssk' = springfield power station secret key   ;) 


#### radio_button_tag(_$name, $value, $checked=false, $opts=array()_)

beispielcode:    
                
            <?=radio_button_tag("more-donuts", 2, true, array("class"=>"radio", "label"=>"maybe"))?>
erzeugt:

            <label class="radio">
               <input type="radio" name="more-donuts" value="2" class="radio" checked="checked">maybe
            </label>
            
sieht so aus:

<label class="radio">
   <input type="radio" name="more-donuts" value="2" class="radio" checked="checked">maybe
</label>


- wenn 'label' nicht angegeben wird, wird ein input ohne label drumherum erzeugt 


#### select_box_tag(_$name, $value, $items, $opts=array()_)

beispielcode:    
                
            <?=select_box_tag("marge[hair]", null, array("lilac", "blue", "lavender"), array("nullentry"=>"bitte auswählen"))?>
erzeugt:

            <select name="marge[hair]">
               <option value="">bitte auswählen</option>
               <option value="0">lilac</option>
               <option value="1">blue</option>
               <option value="2">lavender</option>
            </select>
            
sieht so aus:

<select name="marge[hair]">
   <option value="">bitte auswählen</option>
   <option value="0">lilac</option>
   <option value="1">blue</option>
   <option value="2">lavender</option>
</select>

beispiel 2:    
                
            <?=select_box_tag("marge[hair]", 2, array("lilac", "blue", "lavender"), array("multiple", "nohash"=>1))?>
erzeugt:

            <select name="marge[hair]" multiple>
               <option>lilac</option>
               <option>blue</option>
               <option selected="selected">lavender</option>
            </select>
            
sieht so aus: 

<select name="marge[hair]" multiple>
   <option>lilac</option>
   <option>blue</option>
   <option selected="selected">lavender</option>
</select>

- gibt man unter opts <code>"nohash"=>1</code> an, werden die value="index" parameter der options weggelassen (beispiel 2)
- gibt man unter opts "multiple" an, wird ein multiauswahlfeld erzeugt (beispiel 2) 
- gibt man unter opts "nullentry"=>"bitte auswählen" an, wird als erste option <code>&lt;option value=""&gt;bitte auswählen&lt;/option&gt;</code> erzeugt, für den fall, daß keine option vorausgewählt ist/wird  (beispiel 1)


#### submit_tag(_$name, $value=null, $opts=array()_)

beispielcode:    
                
            <?=submit_tag("eat-donuts", "eat donuts", array("class"=>"button"))?>
erzeugt:

            <input type="submit" name="eat-donuts" value="eat donuts" class="button">
            
sieht so aus:

<input type="submit" name="eat-donuts" value="eat donuts" class="button">



#### text_area_tag(_$name, $value, $opts=array()_)

beispielcode:    
            
            <?$text="Lisa Marie Simpson, voiced by  ..."?>
            <?=text_area_tag("simpsons[lisa]", $text, array("id"=>"lisa_simpson", "size"=>"72x5"))?>
erzeugt:

            <textarea name="simpsons[lisa]" rows="5" cols="72">
               Lisa Marie Simpson, voiced by  ...
            </textarea>
            
sieht so aus:

<textarea name="simpsons[lisa]" rows="5" cols="72">
   Lisa Marie Simpson, voiced by Yeardley Smith, is the eldest daughter and middle child of the family. She is an extremely intelligent eight year old girl, one of the most intelligent characters on the show. Lisa's political convictions are generally socially liberal. She is a vegetarian, and a supporter of the Free Tibet movement, and while still supportive of the Christian church in which she was raised, Lisa became a practicing Buddhist following her decision to follow the Noble Eightfold Path.
</textarea>

- "size" kann auch weggelassen werden



#### text_field_tag(_$name, $value, $opts=array()_)

beispielcode:    
                
            <?=text_field_tag("simpsons[Maggie]", "summand", array("size"=>"40", "id"=>"tf5"))?>
erzeugt:

            <input type="text" name="simpsons[Maggie]" value="baby" size="40" id="tf5">
            
sieht so aus:

<input type="text" name="simpsons[Maggie]" value="baby" size="40" id="tf5">


