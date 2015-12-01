<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

$document = &JFactory::getDocument();


/**
 * AJAX Component Controller
 */
class AjaxController extends JController {
	
    function display() {
    	
        parent::display();
    }

    function getStandartSeviye(){
  		$model = $this->getModel('Ajax');
		$model->getStandartSeviye();

    }
    function getStandart(){
  		$model = $this->getModel('Ajax');
		$model->getStandart();

    }
    function getTerim(){
  		$model = $this->getModel('Ajax');
		$model->getTerim();

    }
    function getTerimAra(){
  		$model = $this->getModel('Ajax');
		$model->getTerimAra();

    }

    function uyariTekrarGosterme(){
  		$model = $this->getModel('Ajax');
		$model->uyariTekrarGosterme();

    }

    function uyariTumunuTemizle(){
  		$model = $this->getModel('Ajax');
		$model->uyariTumunuTemizle();

    }

}
?>