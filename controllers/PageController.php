<?php
/**
 *  Handles controller related functionality for Pages - Example controller
 *
 *  @todo better way for ISO 8601 date validation
 *  @ingroup Controllers
 */

class PageController extends Controller {
  /**
   * Default Model used by controller
   * @var PageModel $PageModel
   */
  protected $PageModel;

  public function __construct() {

    parent::__construct();
    $this->PageModel = new PageModel();

  }

  /**
   * Returns limited # of most revised pages in a category during a time period
   * @param string $category
   * @param int $limit # of pages to get
   * @param string $start in ISO 8601 format (for example '2011-07-31')
   * @param string $end in ISO 8601 format (for example '2013-10-31')
   *
   * @return JSON - "mostEditedArticlesForCat" names/edit counts for cat
   */
  public function mostRevisedForCat($category, $limit, $start, $end) {

    // init json return fields
    $status = $message = $data = null;

    // validate params
    $validation = $this->validateMostRevisedForCat($category, $limit, $start, $end);

    if ($validation === true) {

      $startDate = date("YmdHis", strtotime($start));

      $endDate = date("YmdHis", strtotime($end));

      try {
        $pageCounts = $this->PageModel->getMostRevisedForCat($category, $limit, $startDate, $endDate);

      } catch (Exception $e) {

        $status = "fail";
        $message = $e->getMessage();
        $data =  null;

        $this->loadView('mostRevisedForCat', array('status' => $status, 'data' => $data,'message' => $message ) );
        die();
      }
      // set the data upon success
      $status = "success";
      $message = "In the category: $category, here are the $limit most-edited articles between the " .
        "days $start and $end with the # of times each were edited during that period.";

      $queryTotalTime = number_format($this->PageModel->getQueriesTotalTime(), 4);

      $data =  array('mostEditedArticlesForCat' => $pageCounts, 'queryTotalTimeInMs' => $queryTotalTime);

    } else { // return errors
        $status = "error";
        $message = $validation;
        $data =  null;
    }

    $this->data['status'] = $status;
    $this->data['message'] = $message;
    $this->data['data'] = $data;

    /** this works also but let's stick to rendering from the viiew for now
     * $this->Output->set_content_type('application/json');
     *              ->set_output(json_encode( array('status' => $status, 'data' => $data,'message' => $message ) ));
     */

    $this->loadView('mostRevisedForCat', $this->data);

  }

  protected function validateMostRevisedForCat($category, $limit, $start, $end) {

    $errors = array();

    // get category list
    try {
      $catNames = $this->PageModel->get_categories();

    } catch (Exception $e) {

      echo 'Error: ' . $e->getMessage();
      die();
    }

    // validate category
    if (!in_array($category, $catNames)) {

      $errors[] = 'Error: the category must be in the list. Please recheck ' .

        'spelling. Try running taskMvc.php -h or --help to see list of categories.';
    }
    // validate limit
    if (empty($limit) || !is_numeric($limit) || (int)$limit <= 0) {

      $errors[] = 'Error: The limit must be an integer and greater than zero' ;
    }

    /**  validate start date /end date
     *
     */
    if (empty($start) || empty($end) ||

      ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $start) ||

      ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $end)) {

        $errors[] = 'Error: One of the dates is missing or not in the right format of 2011-07-31';

    }

    if (!empty($errors)) {

      return $errors;
    }
    return true;
  }


  public function mostRevisedForCatHelp() {

    try {
      $catNames = $this->PageModel->get_categories();

    } catch (Exception $e) {

      echo 'Error: ' . $e->getMessage();
      die();
    }

    $this->data['catNames'] = $catNames;

    $this->loadView('mostRevisedForCatHelp', $this->data);
    $this->loadView('indexHelp');

  }


}

