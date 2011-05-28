<?php

include_once("xorc/mvc/xorc_auth.class.php");

class Book_auth extends Xorc_Auth{

   public $name;
   public $id;
   
   public $msg_logout="Vielen Dank, dass sie vorbeigeschaut haben. Sie sind jetzt ausgeloggt.";

	function chekk_login(){
		$xorcuser=$_REQUEST['xorcuser'];
		$xorcpass=$_REQUEST['xorcpass'];

		if($xorcuser && $xorcpass){
			$user=User::i()->find_by_email($xorcuser);
			if($user && $user->check_password($xorcpass)){
			   if($user->check_status()){
				   $this->name=$user->fname." ".$user->lname;
				   $this->id=$user->id;
				   $user->after_login();
				   return array(true, "OK");
				}else{
				   return array(false, 
				      "Ihre E-Mail-Adresse ist noch nicht bestätigt. Bitte klicken Sie auf den Link, den wir Ihnen zugesendet haben.");
				}
			}else{
				return array(false, 
				   "Die E-Mail-Adresse und / oder das Passwort sind nicht korrekt! ".
				   "Bitte überprüfen sie auch die Groß oder Kleinschreibung des Passworts.");
			}
		}else{
			return array(false, "Bitte geben sie ihre E-Mail-Adresse und ihr Passwort ein.");
		}
	}
	
	function get_userobject(){
		return User::i()->find($this->id);
	}
}
?>