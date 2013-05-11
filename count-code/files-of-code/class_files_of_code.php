<?php
 
	//
	//  Counts the files in root folder and in all sub folders. 
	//  Original file by Hamid Alipour, http://blog.code-head.com/
	//  Extended version for Panic's Status Board by Krisztian Tabori @ktabori, http://ktabori.me/
	//  You may not sell this script or remove these header comments
	//  Count Code 1.1 for Panic's Status Board
	//
 
	class Folder {
 
		var $name;
		var $path;
		var $folders;
		var $files;
		var $exclude_extensions;
		var $exclude_files;
		var $exclude_folders;
 
 
		function Folder($path) {
			$this -> path 		= $path;
			$this -> name		= array_pop( array_filter( explode(DIRECTORY_SEPARATOR, $path) ) );
			$this -> folders 	= array();
			$this -> files		= array();
			$this -> exclude_extensions = array( 'gif', 'jpg', 'jpeg', 'png', 'tft', 'bmp' );
			$this -> exclude_files 	    = array( 'class_chars_of_code.php', 'class_lines_of_code.php', 'class_words_of_code.php', 'class_files_of_code.php', '/chars-of-code/index.php', '/lines-of-code/index.php', '/words-of-code/index.php', '/files-of-code/index.php' );
			$this -> exclude_folders 	 = array( '_private', '_vti_bin', '_vti_cnf', '_vti_log', '_vti_pvt', '_vti_txt' );
		}
 
		function count_files() {
			$total_lines = 0;
			$this -> get_contents();
			$total_lines = 0;
			foreach($this -> files as $file) {
				if( in_array($file -> ext, $this -> exclude_extensions) || in_array($file -> name, $this -> exclude_files) ) {
					continue;
				}
				$total_lines += $file -> get_num_lines();
			}
			foreach($this -> folders as $folder) {
				if( in_array($folder -> name, $this -> exclude_folders) ) {
					continue;
				}
				$total_lines += $folder -> count_files();
			}
			return $total_lines;
		}
 
		function get_contents() {
			$contents = $this -> _get_contents();
			foreach($contents as $key => $value) {
				if( $value['type'] == 'Folder' ) {
					$this -> folders[] = new Folder($value['item']);
				} else {
					$this -> files[]   = new File  ($value['item']);
				}
			}
		}
 
		function _get_contents() {
			$folder = $this -> path;
			if( !is_dir($folder) ) {
				return array();
			}
			$return_array = array();
			$count		  = 0;
			if( $dh = opendir($folder) ) {
				while( ($file = readdir($dh)) !== false ) {
					if( $file == '.' || $file == '..' ) continue;
					$return_array[$count]['item']	= $folder .$file .(is_dir($folder .$file) ? DIRECTORY_SEPARATOR : '');
					$return_array[$count]['type']	= is_dir($folder .$file) ? 'Folder' : 'File';
					$count++;
				}
				closedir($dh);
			}
			return $return_array;
		}
 
	} // Class
 
	class File {
 
		var $name;
		var $path;
		var $ext;
 
 
		function File($path) {
			$this -> path = $path;
			$this -> name = basename($path);
			$this -> ext  = array_pop( explode('.', $this -> name) );
		}
 
		function get_num_lines() {
			return 1;
		}
 
	} // Class
 
	$path_to_here = dirname(dirname(dirname(__FILE__))) .DIRECTORY_SEPARATOR;
	$folder 	  = new Folder($path_to_here);
    $result = $folder -> count_files();
    header("Content-Type: text/plain");
    echo json_encode($result);
?>