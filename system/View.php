<?php defined('__ROOT__') OR exit('No direct script access allowed');

class View
{

	public function render($viewPath, $layout = null,$js1= false,$js2=false,$js3=false,$js4=false,$js5=false,$js6=false,$js7=false,$js8=false,$js9=false)
	{
		if ($layout === null) {
			$this->view = $viewPath;
		}else if ($layout === false) {
			require('Views/' . $viewPath . '.php');			
		}else {
			$this->view = $viewPath;
			if ($js1){
			    $this->js1=$js1;
            }
            if ($js2){
			    $this->js2=$js2;
            }
            if ($js3){
			    $this->js3=$js3;
            }
            if ($js4){
			    $this->js4=$js4;
            }
            if ($js5){
			    $this->js5=$js5;
            }
            if ($js6){
			    $this->js6=$js6;
            }
            if ($js7){
			    $this->js7=$js7;
            }
            if ($js8){
			    $this->js8=$js8;
            }
            if ($js9){
			    $this->js9=$js9;
            }
            require("views/$layout.php");
			//require("Views/$layout.php");
			//require("Views/$layout.php");
		}
	}

}
