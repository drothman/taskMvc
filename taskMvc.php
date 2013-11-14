<?php
/**
 *  Entry point bootstraps, loads classes, config, starts entire Task MVC framework
 *  
 *  @file 
 *  @ingroup Core
 */
  define('ROOT', __DIR__ );
  ini_set( 'error_log', ROOT . '/tmp/logs/error.log' );

  require_once (ROOT . '/core/AutoLoader.php');

  require_once (ROOT . '/config/config.php');

  /*
   * ------------------------------------------------------
   *  Load the app controller and local controller
   * ------------------------------------------------------
   *
   */

  $App = new App();

  /** Main Call Function **/
  $App->run();
