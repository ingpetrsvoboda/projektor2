<?php
/**
 * Třída Projektor2_View_HTML_HeSmlouva zabaluje původní PHP4 kód do objektu. Funkčně se jedná o konponentu View, 
 * na základě dat předaných konstruktoru a šablony obsažené v metodě display() generuje HTML výstup
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Head extends Framework_View_Abstract {

    public function render() {
        $this->parts[] = '<head>
                <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
                <meta content="IE=edge" http-equiv="X-UA-Compatible">
                <title>Grafia.cz | Projektor | '.$this->context['projektText'].' | '.$this->context['kancelarText'].'</title>
                <link rel="stylesheet" type="text/css" href="css/styles.css">
                <link rel="stylesheet" type="text/css" href="css/zaznamy.css">
                <link rel="stylesheet" type="text/css" href="css/form.css">
                <link rel="stylesheet" type="text/css" href="css/test.css">
                <link rel="stylesheet" type="text/css" href="css/highlight.css" />
                <script src="js/vendor/modernizr.custom.77712.js"></script>
                <script src="js/projektor/myDatepicker.js"></script>
                <script src="js/projektor/fieldset.js"></script>
                <script src="js/projektor/projektor.js"></script>';
                
        $this->parts[] = "<script>
                Modernizr.load(
                    {
                        test: Modernizr.inputtypes.date,
                        nope: ['js/vendor/jquery-1.11.0.js', 'js/vendor/jquery-ui.min.js', 'css/jquery-ui.css'],
                        complete: function () {
                                    myDatepicker();
                                  }
                    }
                );
                </script>";

        $this->parts[] = '</head>';
//                <link rel='stylesheet' type='text/css' href='css/fixed_menu.css'>
        return $this;
        }

}

?>
