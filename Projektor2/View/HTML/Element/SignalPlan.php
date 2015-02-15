<?php
/**
 * Description 
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_SignalPlan extends Framework_View_Abstract {
    public function render() {
        $model = $this->context['model'];
        switch ($model->status) {
            case 'none':
                $class = 'signal signal-none';
                $title = 'není naplánován';
                break;
            case 'plan':
                $class = 'signal signal-plan';
                $title = 'naplánován';
                break;
            case 'uspesneCekaNaCertifikat':
                $class = 'signal signal-dokonceno';
                $title = 'dokončen úspěšně, čeká na certifikát';
                break;
            case 'uspesne':
                $class = 'signal signal-uspesne';
                $title = 'dokončen úspěšně';
                break;
            case 'neuspesne':
                $class = 'signal signal-neuspesne';
                $title = 'dokončen neúspěšně';        
                break;
            case 'uspesneSCertifikatem':
                $class = 'signal signal-certifikat';
                $title = 'dokončen úspěšně, vydán certifikát';
                break;  
            default:
                $class = '';
                $title = '';
                break;
        }
        
        $this->parts[] = '<td title="'.$title.'" class="'.$class.'">'
                .$model->text
                .'</td>';
        return $this;
    }
}
