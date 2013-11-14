<?
/**
 *  Handles the Model functionality of MVC framework
 *
 *  @todo break out query timer to another method, maybe a profiler object
 *  @todo move database connection to separate DB object
 *  @ingroup Core
 */
abstract class Model{

  private $username;
  private $password;
  private $hostname;
  private $db_name;
  private $conn;
  private $queriesTotalTime;  // in milliseconds for all queries


  public function __construct() {

    //initialize model db config
    $this->username = DB_USERNAME;
    $this->password = DB_PASSWORD;
    $this->hostname = DB_HOSTNAME;
    $this->db_name =  DB_NAME;

    $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->db_name);

    // check connection
    if ($this->conn->connect_error) {
      trigger_error('Unable to connect to a Database, connection failed: '  . $conn->connect_error);
      
    }
    $this->queriesTotalTime = 0;
  }

  /**
   * Returns array of rows for query
   *
   * @param string $sql
   * @return array - array of db rows
   */
  protected function query($sql) {

    // simple profiling

    $startTime = microtime(true);

    $dbResult = $this->conn->query($sql);

    $endTime = microtime(true);

    $duration = $endTime - $startTime; // total time taken in microsecs

    $this->queriesTotalTime += $duration*1000; // in milliseconds

    $result = array();

    if($dbResult === false) {

      error_log ('Wrong SQL: ' . $sql . ' and/or DB Connect Error: ' . $this->conn->error);

      throw new Exception('Failed to get results from database');

    } else {

      while ($row = $dbResult->fetch_assoc()) {

        $result[] = $row;

      }

    }

    $dbResult->free();

    return $result;
  }


  public function getQueriesTotalTime() {

    return $this->queriesTotalTime;

  }

}
