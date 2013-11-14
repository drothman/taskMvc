<?php
/**
 *  Config info for the entire MVC framework
 *
 *  @file
 *  @ingroup Config
 */

  // in standard operation this would be set to index
  define ('DEFAULT_CONTROLLER', "index");

  // in standard operation this would be set to index
  define ('DEFAULT_ACTION', "index");

  /** MySQL DB Config **/
  define ('DB_USERNAME', "");
  define ('DB_PASSWORD', "");
  define ('DB_HOSTNAME', "");
  define ('DB_NAME', "");


  // list Module groupings for documentation
  /**
   *   Group of config files across app
   *
   *   @defgroup Config Config
   */

  /**
   *  Group of Models that provide biz logic/data store access across different across functional domains
   *
   *  @defgroup Models Models
   */

  /**
   *  Group of Controllers Models that provide access to Models and Views across functional domains
   *
   *  @defgroup Controllers Controllers
   */
