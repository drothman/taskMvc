<?php
/**
 *  Defines autoloading and finding classes for entire TaskMVC framework
 *
 * @ingroup Core
 */

class AutoLoader {

  private static $autoloadClasses;

  static function init () {

    self::$autoloadClasses = array(
      # Controllers
      'IndexController' => ROOT . '/controllers/IndexController.php',
      'PageController' => ROOT . '/controllers/PageController.php',

      # Models
      'PageModel' => ROOT . '/models/PageModel.php',

      # Core classes
      'App' => ROOT . '/core/App.php',
      'Model' => ROOT . '/core/Model.php',
      'View' => ROOT . '/core/View.php',
      'Controller' => ROOT . '/core/Controller.php',
      'Output' => ROOT . '/core/Output.php'
    );
  }


  /**
   * autoload - take a class name and attempt to load it
   *
   * @param string $className name of class we're looking for.
   * @return bool Returning false is important on failure as
   * it allows Zend to try and look in other registered autoloaders
   * as well.
   */
  static function autoload($className) {

    if (isset(self::$autoloadClasses[$className])) {

      $filename = self::$autoloadClasses[$className];

    } else {

      return false;
    }

    require $filename;

    return true;
  }


}

AutoLoader::init();

spl_autoload_register(array('AutoLoader', 'autoload'));
