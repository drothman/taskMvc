<?php  if ( ! defined('ROOT')) exit('No direct script access allowed');
/**
 *  Handles Page model related functionality - Example model
 *
 *  Name:    PageModel
 *  Author:  David Rothman
 * 		       contact@davidrothman.us
 *  Location: https://github.com/DRothman/taskMvc
 *  Created:  11.14.2013
 *  Description: Gets pages functionality, like get Most Revised Pages For Category
 *
 *  @ingroup Models
 */

class PageModel extends Model {

  public function __construct() {

    parent::__construct();

  }


  /**
   * Returns all unique category names that pages can be associated with
   *
   * @return array - array of category names
   */
  public function get_categories() {

    $sql='SELECT cat_title FROM category';

    $result = $this->query($sql);


    $cat_names = array();

    foreach($result as $cat) {

      $cat_names[] = $cat['cat_title'];
    }

    return $cat_names;
  }

  /**
   * Returns pages sorted by most revisions for a categories during time period
   *
   * @param string $category  to search on for pages (ie. articles)
   * @param int $limit # of pages to get
   * @param string $startTime start of search period ISO 8601 (ie. '2013-10-31')
   * @param string $endTime end of search period ISO 8601 (ie. '2013-10-31')
   *
   * @return array - array of category names
   */
  public function getMostRevisedForCat($category, $limit, $startTime, $endTime) {

    // ORDER BY and LIMIT are commeneted out for added db performance

    $sql = '

    SELECT
      page.page_title,
      COUNT(rev.rev_page) AS rev_count
    FROM categorylinks cl USE INDEX (cl_from)
      JOIN page ON page.page_id = cl.cl_from
      JOIN revision rev ON page.page_id = rev.rev_page
    WHERE cl.cl_to = "'. $category . '"
      AND cl.cl_type = "page"
      AND rev.rev_timestamp BETWEEN ' . $startTime . ' AND ' . $endTime . '
    GROUP BY cl_from
    -- ORDER BY rev_count desc
    -- LIMIT 10';

    $pageCountResults = $this->query($sql);

    // could uncomment sql & skip below $revCounts, multisort, & limit code depending on performance needs
    $revCounts = array();
    $i = 0;
    // create $revCounts array for multisort
    foreach($pageCountResults as $i => $row) {

      $revCounts[$i]  = $row['rev_count'];

    }

    // Sort the $pageCountResults with revCounts descending
    array_multisort($revCounts, SORT_DESC, SORT_NUMERIC,  $pageCountResults);

    // put page counts in nice format for JSON and limit results
    $pageCounts = array();
    foreach ($pageCountResults as $i => $row) {

      $pageCounts[$i]['articleName'] = str_replace( '_', ' ', $row['page_title'] );

      $pageCounts[$i]['editCount'] = $row['rev_count'];

      if ($i == $limit-1) { // limit results

        break;

      }

      $i += 1;
    }
    return $pageCounts;
  }

}
