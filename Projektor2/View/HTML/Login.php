<?php
/**
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Login extends Framework_View_Abstract {
    public function render() {
        $projekty = $this->context['projekty'];
        if(isset($this->context['warning'])) {
            $this->parts[] = '<p class="login warning">'.$this->context['warning'].'</p>';
        }
        $this->parts[] = '<h1>Přihlášení do systému projektor</h1>';
        $this->parts[] = '<form name="Login" id="Login" action="index.php?akce=login" method="post">';
//	    $this->parts[] = '<input type="hidden" name="sent" value="1">';
	    $this->parts[] = '<label for="name" >Uživatelské jméno:</label>';
		    $this->parts[] = '<input id="name" type ="text" name="name">';
            $this->parts[] = '<label for="password" >Heslo:</label></td>';
		    $this->parts[] = '<input id="password" type="password" name="password">';
            $this->parts[] = '<label for="projekt" >Projekt</label>';
                $this->parts[] = '<select id="projekt" size="1" name="id_projekt">';
                    $this->parts[] = "<option value=\"ß\"> </option>\n";                    
//                    $this->parts[] = "<option value=\"*\">všechny</option>\n";            
                foreach ($projekty as $projekt) {
                    $option = "<option ";
                    if (isset($this->context['id_projekt']) AND $projekt->id==$this->context['id_projekt']) {
                        $option .= 'selected="selected" ';
                    }
                    $option .= "value=\"".$projekt->id."\">".$projekt->text."</option>\n";
                    $this->parts[] = $option;  
                }
            $this->parts[] = '</select>';
            $this->parts[] = '<input type="submit" value="Přihlásit" id="Submit2" name="submit">';
        $this->parts[] = '</form>';        
        return $this;
    }
}

?>
