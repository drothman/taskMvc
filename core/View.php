<?php
/**
 *  Handles the View functionality of MVC framework
 *
 *  @ingroup Core
 */
class View {
    /**
     * Name of template file that will be loaded for rendering
     * @var	string
     */
    private $viewName = '';
    /**
     * Holds associate array assigned to view from controller
     * @var	array
     */
    private $data = array();

    /**
     * Output buffering's nesting level
     * @var	int
     */
    private $obLevel;

    /**
     * Creates a View, defining name of template to include, and data to populate it when rendered
     *
     * @param string $viewName of "template" file name to load
     * @param array $data  to populate view when loaded
     *
     */
    public function __construct($viewName, $data = array()) {

      $this->viewName = $viewName;
      $this->data = $data;
      $this->obLevel  = ob_get_level();

    }

    /**
     * Render for output allowing nesting, or optionally return output to caller direct
     * Used to load view and assign $data to it
     *
     * @param	bool	$return	the view output or leave it for Output class
     * @return string of view output
     */
    public function render($return = FALSE) {

      // compose file name
      $file = ROOT . '/views/' . $this->viewName . '.php';

      if (!file_exists($file)) {

        error_log ("Unable to load the requested file: $file");
      }

      // Extract data variables from array to be available in view
      if (is_array($this->data)) {

        extract($this->data);

      }

      /*
      * Two reasons to turn output buffering on, capturing all output:
      *  - Performance gain
      *  - Allows for additional post render processing in Output class
      */
      ob_start();

      // Get template $data will be accessible to it
      include($file);

      // Return the file data if requested
      if ($return === TRUE) {

        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
      }

      /*
       * Flush the buffer
      *
      * In order to permit views to be nested within
      * other views, we need to flush the content back out whenever
      * we are beyond the first level of output buffering so that
      * it can be seen and included properly by the first included
      * template and any subsequent ones.
      */
      if (ob_get_level() > $this->obLevel + 1) {

        ob_end_flush();

      } else {

        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
      }

    }

}
