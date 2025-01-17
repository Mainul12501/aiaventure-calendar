<?php
  /**
   * Sift Class
   *
   * @package Vacation Rentals Booking Calendar (VRBC)
   * @author transinova.com
   * @copyright 2017-2023
   * @version $Id: class.sift.php, v1.2 Feb 2023 transinova $
   */
  
  if (!defined("_EXECPERMIT_WNV"))
      die('Direct access to this location is not allowed.');
  
  final class Sift
  {
	  public static $id = null;
      public static $get = array();
      public static $post = array();
      public static $cookie = array();
      public static $files = array();
      public static $server = array();
      private static $marker = array();
	  public static $msgs = array();
	  public static $showMsg;

	  public static $action = null; 
	  public static $do = null;
      

      /**
       * Sift::__construct()
       * 
       * @return
       */
      public function __construct()
      {
          $_GET = self::clean($_GET);
          $_POST = self::clean($_POST);
          $_COOKIE = self::clean($_COOKIE);
          $_FILES = self::clean($_FILES);
          $_SERVER = self::clean($_SERVER);

          self::$get = $_GET;
          self::$post = $_POST;
          self::$cookie = $_COOKIE;
          self::$files = $_FILES;
          self::$server = $_SERVER;
		  self::$id = self::getId();
      }

	  /**
	   * Sift::getId()
	   * 
	   * @return
	   */
	  private static function getId()
	  {
		  if (isset($_REQUEST['id'])) {
			  self::$id = (is_numeric($_REQUEST['id']) && $_REQUEST['id'] > -1) ? intval($_REQUEST['id']) : false;
			  self::$id = sanitize(self::$id);
			  
			  if (self::$id == false) {
				  DEBUG == true ? self::error("You have selected an Invalid Id", "Sift::getId()") : self::msgfatalerr();
			  } else
				  return self::$id;
		  }
	  }
	  
      /**
       * Sift::clean()
       * 
       * @param mixed $data
       * @return
       */
      public static function clean($data)
      {
          if (is_array($data)) {
              foreach ($data as $key => $value) {
                  unset($data[$key]);

                  $data[self::clean($key)] = self::clean($value);
              }
          } else {
			  if (ini_get('magic_quotes_gpc')) {
				  $data = stripslashes($data);
			  } else {
				  $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
			  }
		  }

          return $data;
      }
	  

	  
      /**
       * Sift::msgWarning()
       * 
       * @param mixed $msg
       * @param bool $fader
       * @param bool $print
       * @param bool $altholder
       * @return
       */
      public static function msgWarning($msg, $print = true, $fader = false, $altholder = false, $closable=false)
      {
if($closable){$opentag='<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';}else{$opentag='<div class="alert alert-warning" role="alert">';}		  
          self::$showMsg = "$opentag <div class=\"content\"><div class=\"header\"> " . Lang::$say->_ALERT . "</div><p>" . $msg . "</p></div></div>";
          if ($fader)
              self::$showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
			setTimeout(function() {       
			  $(\".alert-warning\").fadeOut(\"slow\",    
			  function() {       
				$(\".alert-warning\").remove();  
			  });
			},
			$fader);
		  // ]]>
		  </script>";

          if ($print == true) {
              print ($altholder) ? '<div id="alt-msgholder">' . self::$showMsg . '</div>' : self::$showMsg;
          } else {
              return ($altholder) ? '<div id="alt-msgholder">' . self::$showMsg . '</div>' : self::$showMsg;
          }
      }


      /**
       * Sift::msgSingleAlert()
       * 
       * @param mixed $msg
       * @param bool $print
       * @return
       */
      public static function msgSingleAlert($msg, $print = true)
      {
          self::$showMsg = "<div class=\"wenbs warning message\"><i class=\"attention icon\"></i> " . $msg . "</div>";

          if ($print == true) {
              print self::$showMsg;
          } else {
              return self::$showMsg;
          }
      }

      /**
       * Sift::msgSuccess()
       * 
       * @param mixed $msg
       * @param bool $fader
       * @param bool $print
       * @param bool $altholder
       * @return
       */
      public static function msgSuccess($msg, $print = true, $fader = false, $altholder = false, $closable=false)
      {
		  if($closable){$opentag='<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';}else{$opentag='<div class="alert alert-success" role="alert">';}
          self::$showMsg = "$opentag <div class=\"content\"><div class=\"header\"> " . Lang::$say->_SUCCESS . "</div><p>" . $msg .
              "</p></div></div>";
          if ($fader)
              self::$showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
			setTimeout(function() {       
			  $(\".alert-success\").fadeOut(\"slow\",    
			  function() {       
				$(\".alert-success\").remove();  
			  });
			},
			$fader);
		  // ]]>
		  </script>";
          if ($print == true) {
              print ($altholder) ? '<div id="alt-msgholder">' . self::$showMsg . '</div>' : self::$showMsg;
          } else {
              return ($altholder) ? '<div id="alt-msgholder">' . self::$showMsg . '</div>' : self::$showMsg;
          }
      }

      /**
       * Sift::msgSingleOk()
       * 
       * @param mixed $msg
       * @param bool $print
       * @return
       */
      public static function msgSingleOk($msg, $print = true)
      {
          self::$showMsg = "<div class=\"wenbs success message\"><i class=\"ok sign icon\"></i> " . $msg . "</div>";

          if ($print == true) {
              print self::$showMsg;
          } else {
              return self::$showMsg;
          }
      }
	  
      /**
       * Sift::msgInfo()
       * 
       * @param mixed $msg
       * @param bool $fader
       * @param bool $print
       * @param bool $altholder
       * @return
       */
      public static function msgInfo($msg, $print = true, $fader = false, $altholder = false)
      {
          self::$showMsg = "<div class=\"wenbs icon message info\"><i class=\"flag icon\"></i><i class=\"close icon\"></i><div class=\"content\"><div class=\"header\"> " . Lang::$say->_INFO . "</div><p>" . $msg . "</p></div></div>";
          if ($fader == true)
              self::$showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
			setTimeout(function() {       
			  $(\".msgInfo\").fadeOut(\"slow\",    
			  function() {       
				$(\".msgInfo\").remove();  
			  });
			},
			4000);
		  // ]]>
		  </script>";

          if ($print == true) {
              print ($altholder) ? '<div id="alt-msgholder">' . self::$showMsg . '</div>' : self::$showMsg;
          } else {
              return ($altholder) ? '<div id="alt-msgholder">' . self::$showMsg . '</div>' : self::$showMsg;
          }
      }

      /**
       * Sift::msgSingleOk()
       * 
       * @param mixed $msg
       * @param bool $print
       * @return
       */
      public static function msgSingleInfo($msg, $print = true)
      {
          self::$showMsg = "<div class=\"wenbs info message\"><i class=\"information icon\"></i> " . $msg . "</div>";

          if ($print == true) {
              print self::$showMsg;
          } else {
              return self::$showMsg;
          }
      }
	  
      /**
       * Sift::msgDanger()
       * 
       * @param mixed $msg
       * @param bool $fader
       * @param bool $print
       * @param bool $altholder
       * @return
       */
      public static function msgDanger($msg, $print = true, $fader = false, $altholder = false, $closable=false)
      {
if($closable){$opentag='<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';}else{$opentag='<div class="alert alert-danger" role="alert">';}		  
          self::$showMsg = "$closable <div class=\"content\"><div class=\"header\"> " . Lang::$say->_ERROR . "</div><p>" . $msg .
              "</p></div></div>";
          if ($fader)
              self::$showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
			setTimeout(function() {       
			  $(\".alert-danger\").fadeOut(\"slow\",    
			  function() {       
				$(\".alert-danger\").remove();  
			  });
			},
			$fader);
		  // ]]>
		  </script>";
          if ($print == true) {
              print ($altholder) ? '<div id="alt-msgholder">' . self::$showMsg . '</div>' : self::$showMsg;
          } else {
              return ($altholder) ? '<div id="alt-msgholder">' . self::$showMsg . '</div>' : self::$showMsg;
          }
      }

      /**
       * Sift::msgSingleError()
       * 
       * @param mixed $msg
       * @param bool $print
       * @return
       */
      public static function msgSingleError($msg, $print = true)
      {
          self::$showMsg = '<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' . $msg . '</div>';

          if ($print == true) {
              print self::$showMsg;
          } else {
              return self::$showMsg;
          }
      }
	  
      /**
       * Sift::msgStatus()
       * 
       * @return
       */
      public static function msgStatus()
      {
          self::$showMsg = '<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><div class="header">' . Lang::$say->_SYSTEM_ERR . '</div><div class="content"><ul class="wenbs list">';
          $i = count((is_countable(self::$showMsg)?self::$showMsg:[]));//count(self::$showMsg);
          foreach (self::$msgs as $msg) {
              self::$showMsg .= "<li>" . $msg . "</li>\n";
          }
          self::$showMsg .= "</ul></div></div>";

          return self::$showMsg;
      } 


      /**
       * Sift::error()
       * 
       * @param mixed $msg
       * @param mixed $source
       * @return
       */
      public static function error($msg, $source)
      {
          if (DEBUG == true) {
              $the_error = "<div class=\"wenbs message error\">";
              $the_error .= "<span>System ERROR!</span><br />";
              $the_error .= "DB Error: " . $msg . " <br /> More Information: <br />";
              $the_error .= "<ul class=\"error\">";
              $the_error .= "<li> Date : " . date("F j, Y, g:i a") . "</li>";
              $the_error .= "<li> Function: " . $source . "</li>";
              $the_error .= "<li> Script: " . $_SERVER['REQUEST_URI'] . "</li>";
              $the_error .= "<li>&lsaquo; <a href=\"javascript:history.go(-1)\"><strong>Go Back to previous page</strong></a></li>";
              $the_error .= '</ul>';
              $the_error .= '</div>';
          } else {
              $the_error = "<div class=\"msgDanger\" style=\"color:#444;width:400px;margin-left:auto;margin-right:auto;border:1px solid #C3C3C3;font-family:Arial, Helvetica, sans-serif;font-size:13px;padding:10px;background:#f2f2f2;border-radius:5px;text-shadow:1px 1px 0 #fff\">";
              $the_error .= "<h4 style=\"font-size:18px;margin:0;padding:0\">Oops!!!</h4>";
              $the_error .= "<p>Something went wrong. Looks like the page you're looking for was moved or never existed. Make sure you typed the correct URL or followed a valid link.</p>";
              //$the_error .= "<p>&lsaquo; <a href=\"javascript:history.go(-1)\" style=\"color:#0084FF;\"><strong>Go Back to previous page</strong></a></p>";
              $the_error .= '</div>';
          }
          print $the_error;
          die();
      }

      /**
       * Sift::msgfatalerr()
       * 
       * @return
       */
      public static function msgfatalerr()
      {
          $the_error = "<div class=\"msgDanger\" style=\"color:#444;width:400px;margin-left:auto;margin-right:auto;border:1px solid #C3C3C3;font-family:Arial, Helvetica, sans-serif;font-size:13px;padding:10px;background:#f2f2f2;border-radius:5px;text-shadow:1px 1px 0 #fff\">";
          $the_error .= "<h4 style=\"font-size:18px;margin:0;padding:0\">Error!!!</h4>";
          $the_error .= "<p>Something went wrong. Looks like the page you're looking for was moved or never existed. Make sure you typed the correct URL or followed a valid link.</p>";
          $the_error .= "<p>&lsaquo; <a href=\"javascript:history.go(-1)\" style=\"color:#0084FF;\"><strong>Go Back to previous page</strong></a></p>";
          $the_error .= '</div>';
          print $the_error;
          die();
      }



      /**
       * Sift::getPost()
       * 
       * @param mixed $key
       * @return
       */
      public static function getPost($key)
      {
          return self::arrayKey($key, $_POST);
      }

      /**
       * Sift::arrayKey()
       * 
       * @param mixed $key
       * @param mixed $data
       * @return
       */
      private static function arrayKey($key, $data)
      {
          $array_keys = array();
          if (preg_match('/^([^\[]{1,})\[(.*)\]+$/', $key, $match)) {
              $array_keys[] = $match[1];
              $ns = explode('[', '[' . $match[2] . ']');
              foreach ($ns as $nss) {
                  if ($nss) {
                      $array_keys[] = trim($nss, '][');
                  }
              }

              $buf = $data;
              foreach ($array_keys as $k) {
                  if (isset($buf[$k])) {
                      $buf = $buf[$k];
                  } else 
                      $buf = null;
              }

              return $buf;
          } else {
              return isset($data[$key]) ? $data[$key] : null;
          }
      }

      /**
       * Helper::multi_array_to_single_uniq()
       * 
       * @param mixed $array
       * @param mixed $maxdepth
       * @param integer $depth
       * @return
       */
      public static function multi_array_to_single_uniq($array, $maxdepth = null, $depth = 0)
      {

          $single = array();
          if (!is_array($array)) {
              return $single;
          }

          $depth++;
          foreach ($array as $key => $value) {
              if (($depth <= $maxdepth || is_null($maxdepth)) && is_array($value)) {
                  $single = array_merge($single, self::multi_array_to_single_uniq($value, $maxdepth, $depth));
              } else {
                  array_push($single, $value);
              }
          }
          return array_unique($single);
      }
	   
	  /**
	   * Sift::checkPost()
	   * 
	   * @param mixed $index
	   * @param mixed $msg
	   * @return
	   */  
	  public static function checkPost($index, $msg) {
		  
		if(empty($_POST[$index]))
		   self::$msgs[$index] = $msg;
	  } 

      /**
       * Sift::checkSetPost()
       * 
       * @param mixed $index
       * @param mixed $msg
       * @return
       */
      public static function checkSetPost($index, $msg)
      {

          if (!isset($_POST[$index]))
              self::$msgs[$index] = $msg;
      }
	  

	  
      /**
       * Sift::mark()
       * 
       * @param mixed $name
       * @return
       */
      public static function mark($name)
      {
          self::$marker[$name] = microtime();
      }


      /**
       * Sift::elapsed()
       * 
       * @param string $point1
       * @param string $point2
       * @param integer $decimals
       * @return
       */
      public static function elapsed($point1 = '', $point2 = '', $decimals = 4)
      {

          if (!isset(self::$marker[$point1])) {
              return '';
          }

          if (!isset(self::$marker[$point2])) {
              self::$marker[$point2] = microtime();
          }

          list($sm, $ss) = explode(' ', self::$marker[$point1]);
          list($em, $es) = explode(' ', self::$marker[$point2]);

          return number_format(($em + $es) - ($sm + $ss), $decimals);
      }
  }
?>