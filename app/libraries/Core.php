<?php 
class Core {
    protected $currentController = "Pages";
    protected $currentMethod = "index";
    protected $params = [];

public function __construct() {
    //print_r ($this->getCurrentUrl());

    $uri = $this->getCurrentUrl();
  
    if(file_exists("../app/controllers/" . ucwords($uri[0]) . ".php")) {
        $this->currentController = ucwords($uri[0]);
        unset($uri[0]);
        }
        else {
            echo  ucwords($uri[0]) . " controller doesn't exist";
            exit();
        }

        
    require_once "../app/controllers/" . $this->currentController . ".php";
    $this->currentController = new $this->currentController;

    if(isset($uri[1])) {
        if(method_exists($this->currentController, $uri[1])) {
            $this->currentMethod = $uri[1];
        }
        
    }
    unset($uri[1]);
    
    $this->params = $uri ? array_values($uri) : [];

    call_user_func_array([$this->currentController, $this->currentMethod], $this->params);

}
public function getCurrentUrl() {
    if(isset($_GET['url'])) {
        $url = rtrim($_GET['url'], '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode("/", $url);
        return $url;
    }
}

}
?>