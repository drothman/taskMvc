<?php
/**
 * Handles the Controller functionality of MVC framework
 *
 *  @ingroup Core
 */
class Controller {

  /**
   * Default $data array used by subclasses to pass data to views 
   * @var array $data
   */
  protected $data = array();

  /**
   * Output class used by controller to store and modify rendered view content
   * @var Output $Output
   */
  protected $Output;

  public function __construct() {

    $this->Output = new Output();

  }


  /**
   * Used to load view and assign $data to it, and assigns outpput to $assignee
   *
   * @param	string	$viewName
   * @param	array 	$data optional associative array of data available to view
   * @param	bool	$return	the view output to caller or add to Output class
   *
   * @return	void|string of view content if $return is true
   */
  public function loadView($viewName, $data = array(), $return = FALSE) {

    $view = new View($viewName, $data);

    if ($return) {

      return $view->render($return);

    } else {

      $this->Output->appendOutput($view->Render());

    }

  }


  /**
   * Standard default action - change as you like
   *
   */
  public function index(){
    $this->indexHelp();
  }


  /**
   * Standard default help
   *
   */
  public function indexHelp() {
  
    $this->loadView('indexHelp');
  
  }


  public function __destruct() {

    // return accumulated output

    $this->Output->display();

  }


}

