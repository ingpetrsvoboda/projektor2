<?php
/**
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Logout extends Framework_View_Abstract {
    public function render() {

    if($warning=="name") {
            $this->parts[] = '<p class="login message">Přihlášení se nezdařilo</p>';
    }
    if($warning=="projekt") {
            $this->parts[] = '<p class="login message>Prosím vyberte projekt ke kterému se chcete přihlásit a přihlašte se znovu !</p>';
    }
    $this->parts[] = '<h1>Přihlášení do systému projektor</h1>';
	$this->parts[] = '<form name="Login" ID="Login" action="login.php" method="post">';
	    $this->parts[] = '<input type="hidden" name="sent" value="1">';
	    $this->parts[] = '<label for="text2" >Uživatelské jméno:</label>';
		    $this->parts[] = '<input  type ="text" name="name" ID="Text2" value="'.$lastname.'">';
            $this->parts[] = '<label for="Password2" >Heslo:</label></td>';
		    $this->parts[] = '<input type="password" name="password" ID="Password2>';
		$this->parts[] = '<label for="Projekt" >Projekt</label>';
		    $this->parts[] = '<select ID="Projekt" size="1" name="projekt">';
//                    $this->parts[] = "<option value=\" \"> </option>\n";                    
//                    $this->parts[] = "<option value=\"*\">všechny</option>\n";            
                    foreach ($projekty as $projekt) {
                        $option = "<option ";
                        if (isset($this->context['id_projekt']) AND $projekt->id=$this->context['id_projekt']) {
                            $option .= 'selected="selected" ';
                        }
                        $option .= "value=\"".$projekt->id."\">".$projekt->text."</option>\n";
                        $this->parts[] = $option;  
                    }
                $this->parts[] = '</select>';

                $this->parts[] = '<input type="submit" value="Přihlásit" ID="Submit2" NAME="Submit1">';
            $this->parts[] = '</form>';        
        return $this;
    }
}

?>
