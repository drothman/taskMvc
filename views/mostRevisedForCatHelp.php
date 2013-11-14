<?php 
/**
 *  Renders Help info for Most Revised Pages For Category data - Example Simple "HTML" View (w/ no HTML in it Ha!)
 *  - output is meant for command line console, but it's still an HTML content type - check out the header
 *  
 *  @file 
 *  @ingroup Views
 */
/**
 *  @defgroup Views Views
 */

?>

    Welcome to the Most Edited Articles in a Category Searcher! aka TaskMvc

    Which category below would you like to search on? (See instructions at bottom)

<?php 
    foreach ($catNames as $cat) :
      echo "           $cat  \n";
    endforeach;
?>

    Please choose a category from the list above:

