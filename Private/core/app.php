<?php

class App 

{

	protected $controller = "home.php";
	protected $method = "index";
	protected $parameters = array();

 // part two
	public function __construct()
	{
		$URL = $this->getURL();

		// checking if file exist ion controller folder before assigning to variable URL but by default in case it doesnt exist $url [0] ="home".

		if(file_exists("../private/controllers/".$URL[0] .".php"))
		{

			$this->controller = ucfirst($URL[0]);
			// since we checked and saw it was working we remove from the array with unset
			unset($URL[0]);
		}
		// even if file is not present we need to load a controller

		require "../private/controllers/".$this->controller.".php" ;

		$this->controller = new $this->controller();

	// part three 

	// here we want to make sur every controller has an index method which will be call when calling a controller 
		if(isset($URL[1]))
		{

			if (method_exists($this->controller, $URL[1]))
			{
				$this->method =ucfirst($URL[1]);
				unset($URL[1]);
			}
		}

		// here we want to set the index of our url array to zero ie our paramter no matter what will start form index 0

		$URL = array_values($URL);
		$this->parameters = $URL ;
		call_user_func_array([$this->controller, $this->method], $this->parameters);
	}
	// part three handling parameters if its not an url nor a method it is treated a parameter
	
// part one 

	private function getURL()
	{
		$url = isset ($_GET['url']) ? $_GET['url'] : "home";
		return explode("/", filter_var(trim($url,"/")),FILTER_SANITIZE_URL);
	}

} 

// we all set lets go to the views functions 