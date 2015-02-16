<?php
class Projektor2_View_HTML_VyberKontext extends Framework_View_Abstract {

    public function render() {
        $kancelare = $this->context['kancelare'];
        $behy = $this->context['behy'];
        
        $this->parts[] = '<div id="vyberkontext">';
        $this->parts[] = '<form name="Kancelar" id="Kancelar" action="index.php" method="post">';
            $this->parts[] = '<fieldset id="select_beh">';
                $this->parts[] = '<legend>Výběr kanceláře</legend>';
                $this->parts[] = '<label for="kancelar" >Vyberte kancelář:</label>';
                $this->parts[] = '<select id="kancelar" size="1" name="id_kancelar">';
                    $this->parts[] = "<option value=\"ß\"> </option>\n";                    
                    $this->parts[] = "<option value=\"*\">všechny</option>\n";            
                    foreach ($kancelare as $kancelar) {
                        $option = "<option ";
                        if (isset($this->context['id_kancelar']) AND $kancelar->id==$this->context['id_kancelar']) {
                            $option .= 'selected="selected" ';
                        }
                        $option .= "value=\"".$kancelar->id."\">".$kancelar->text."</option>\n";
                        $this->parts[] = $option;
                    }
                $this->parts[] = '</select>';
            $this->parts[] = '</fieldset>';

            $this->parts[] = '<fieldset id="select_beh">';
                $this->parts[] = '<legend>Výběr běhu</legend>';
                $this->parts[] = '<label for="beh" >Vyberte běh:</label>';
                $this->parts[] = '<select id="beh" size="1" name="id_beh">';
                    $this->parts[] = "<option value=\"ß\"> </option>\n";            
                    $this->parts[] = "<option value=\"*\">všechny</option>\n";            
                    foreach ($behy as $beh) {
                        $option = "<option ";
                        if (isset($this->context['id_beh']) AND $beh->id==$this->context['id_beh']) {
                            $option .= 'selected="selected" ';
                        }
                        $option .= "value=\"".$beh->id."\">".$beh->text."</option>\n";
                        $this->parts[] = $option;            
                    }
                $this->parts[] = '</select>';
            $this->parts[] = '</fieldset>';
            $this->parts[] = '<input type="submit" value="Vyber">';
        $this->parts[] = '</form>';
        $this->parts[] = '</div>';  

        $this->parts[] = '</div>';        
        
        return $this;
    }
}

?>
