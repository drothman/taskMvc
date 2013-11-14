<?php 
/**
 *  Renders JSON Most Revised Pages For Category data - Example JSON View 
 *  
 *  @file 
 *  @ingroup Views
 *  @defgroup Views Views
 */
  header('Content-Type: application/json');
  echo json_encode( array('status' => $status, 'data' => $data,'message' => $message ) );

