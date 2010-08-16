<?php

class Book extends Xorcstore_AR{
   
   function validates_presence_of(){
      return array(
         "title",
         "isbn"=>"bitte isbn angeben",
         "year"=>array("name"=>"Erscheinungsjahr")
         );
   }
   
   function validates_uniqueness_of(){
      return array(
         "isbn"=>array("msg"=>"Diese ISBN Nummer ist schon vergeben.")
         );
   }
}

?>