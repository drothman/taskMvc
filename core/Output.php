<?php
/**
 *  Enables a controller to output view content, including nested
 *
 *  @ingroup Core
 */

class Output {

  /**
   * Final output string
   * @var	string
   */
  public $finalOutput;

  /**
   * List of server headers
   * @var	array
   */
  public $headers =	array();

  /**
   * Mime-type for the current page
   * @var	string
   */
  protected $mime_type	= 'text/html';

  /**
   * Get Output
   *
   * Returns the current output string.
   *
   * @return	string
   */
  public function getOutput() {
    return $this->finalOutput;
  }


  /**
   * Set Output
   *
   * Sets the output string.
   *
   * @param	string	$output	Output data
   * @return	object	$this
   */
  public function setOutput($output) {
    $this->finalOutput = $output;
    return $this;
  }


  /**
   * Append Output
   *
   * Appends data onto the output string.
   *
   * @param	string	$output	Data to append
   * @return	object	$this
   */
  public function appendOutput($output) {
    if (empty($this->finalOutput)) {
      $this->finalOutput = $output;
    } else {
      $this->finalOutput .= $output;
    }

    return $this;
  }


  /**
   * Set Header
   *
   * Lets you set a server header which will be sent with the final output.
   *
   *
   * @param	string	$header		Header
   * @param	bool	$replace	Whether to replace the old header value, if already set
   * @return	object	$this
   */
  public function setHeader($header, $replace = TRUE) {
    $this->headers[] = array($header, $replace);
    return $this;
  }


  /**
   * Set Content-Type Header
   *
   * @param	string	$mime_type	Extension of the file we're outputting
   * @param	string	$charset	Character set (default: utf-8)
   * @return	object	$this
   */
  public function setContentType($mime_type, $charset = 'utf-8')	{

    $this->mime_type = $mime_type;

    if (empty($charset)) {

      $charset = config_item('charset');

    }

    $header = 'Content-Type: '.$mime_type . '; charset='. strtolower($charset);

    $this->headers[] = array($header, TRUE);

    return $this;
  }


  /**
   * Get Current Content-Type Header
   *
   * @return	string	'text/html', if not already set
   */
  public function getContentType() {

    for ($i = 0, $c = count($this->headers); $i < $c; $i++) {

      if (preg_match('/^Content-Type:\s(.+)$/', $this->headers[$i][0], $matches)) {

        return $matches[1];

      }

    }

    return 'text/html';
  }


  /**
   * Set HTTP Status Header
   *
   *
   * @param	int	$code	Status code (default: 200)
   * @param	string	$text	Optional message
   * @return	object	$this
   */
  public function setStatusHeader($code = 200, $text = '') {

    set_status_header($code, $text);

    return $this;
  }


  /**
   * Display Output
   *
   * Processes sends the sends finalized output data to the client along
   * with any server headers and profile data.
   *
   * Note: All "view" data is automatically put into $this->finalOutput
   *	 by controller class.
   *
   * @param	string	$output	Output data override
   * @return	void
   */
  public function display($output = '')	{
    // Set the output data
    if ($output === '') {

      $output =& $this->finalOutput;
    }

    // Are there any server headers to send?
    if (count($this->headers) > 0) {

      foreach ($this->headers as $header) {

        header($header[0], $header[1]);

      }

    }

    echo $output; // Send it to the client

  }


}
