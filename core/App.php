<?php
/**
 *  Group of Core classes that provide critical plumbing
 *
 *  @todo move help option checking to separate helper method
 *  @todo add more help/overview documentation re. 'controller' and 'method' query parameters
 *  @todo add support for actions with default parameters 
 *  @todo add app level loader to store modelsels/libraries, etc to increase performance
 *  @defgroup Core Core
 */

/**
 *  Super controller / router / dispatcher for entire MVC framework
 *
 *  @ingroup Core
 */
class App {

    public function run() {

        if (empty($_GET) || empty($_GET['controller'])) {

            $controllerName = ''; //will use default Controller

            $action = DEFAULT_ACTION;

        } else {

            $controllerName = $_GET['controller'];

            $action = !empty($_GET['action']) ? $_GET['action'] : 'index';
        }

        // modify controller name to fit naming convention
        $class = ucfirst($controllerName).'Controller';  // will default to base Controller if no name specified

        // instantiate the appropriate class
        if (class_exists($class) && (int)method_exists($class, $action)) {

            $controller = new $class($this);

            // provide help option if user used -h or --help

            $getHelp = false;

            $opt = getopt ('h', array ('help') );

            if (!empty($opt)) {

                if (array_key_exists('h', $opt) || array_key_exists('help', $opt)) {

                  $getHelp = true;

                }

            }

            if ($getHelp || array_key_exists('-h', $_GET) || array_key_exists('--help', $_GET)) {

                $actionHelp = $action . 'Help';

                $controller->$actionHelp();
                die();
            }

            $actionToCall = new ReflectionMethod($controller, $action);

            

            
            $actionParamsToPass = array();  //will be passed to our action
            
            $actionParams = $actionToCall->getParameters(); // params to find

            foreach ($actionParams as  $i => $actionParam) {

                // query string parameter names must match action's parameter names
                if (isset($_GET[$actionParam->name])) {

                  $actionParamsToPass[$i] = $_GET[$actionParam->name];

                } elseif ($actionParam::isDefaultValueAvailable()) {
                  $actionParamsToPass[$i] = $actionParam::getDefaultValue();
                }

            }

            $actionToCall->invokeArgs($controller, $actionParamsToPass);

        } else {

            // Error: Controller Class not found
            die("1. File " . $controllerName ."Controller.php containing class $class might be missing.\n" .
                "or\n" .
                "2. Method $action is missing in " . $controllerName ."Controller.php");
        }

    }


}
