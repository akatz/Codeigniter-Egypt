<?php 
/** \addtogroup Controllers
 * Remote access controller
 *that controller serves the AJAX purpose
 * , it provide the files , content, directory widgets with
 * the information needed through AJAX
 * 
 * @package	Codeigniter-Egypt
 * @subpackage	Codeigniter-Egypt
 * @category	controller file
 * @author	Emad Elsaid
 * @link	http://github.com/blazeeboy/Codeigniter-Egypt
 */
class Remote extends Application {
	
	/**
	 * that controller serves the AJAX purpose
	 * , it provide the files , content, directory widgets with
	 * the information needed through AJAX
	 * */
	function __construct(){
		parent::__construct();
		$this->perm = 'admin';
		$this->ajax = true;
	}
	
	/**
	 * that function you don't have to use it at all
	 * it's the PHP backend to the file chooser widget of gui class
	 * it returns ist of files within the passed directory via POST
	 * */
	function file()
	{
				
		$this->load->helper('directory');
		
		$root = '';
		$_POST['dir'] = urldecode($_POST['dir']);

		if( file_exists($root . $_POST['dir']) )
		{
			
			$files = directory_map($root . $_POST['dir'], TRUE );
			natcasesort($files);
			
			if( count($files) > 0 )
			{ /* The 2 accounts for . and .. */
				echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
				// All dirs
				foreach( $files as $file )
				{
					if( 	file_exists($root . $_POST['dir'] . $file) 
							&& $file != '.' && $file != '..' 
							&& is_dir($root . $_POST['dir'] . $file)
					) {
						echo "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">" . htmlentities($file) . "</a></li>";
					}
				}
				// All files
				foreach( $files as $file )
				{
					if( 
							file_exists($root . $_POST['dir'] . $file) 
							&& $file != 'index.html' 
							&& !is_dir($root . $_POST['dir'] . $file)
						) {
							$ext = preg_replace('/^.*\./', '', $file);
							echo "<li class=\"file ext_$ext\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "\">" . htmlentities($file) . "</a></li>";
						}
				}
				echo "</ul>";
			}
		}
	}
	
	/**
	 * that function you don't have to use it at all
	 * it's the PHP backend to the directory chooser widget of gui class
	 * it returns ist of directories within the passed directory via POST
	 * */
	function dir()
	{
		if( ! perm_chck( 'edit' ) ) show_error("permission denied");
		$this->load->helper('directory');
		$root = '';
		$_POST['dir'] = urldecode($_POST['dir']);

		if( file_exists($root . $_POST['dir']) )
		{
			$files = directory_map($root . $_POST['dir'], TRUE);
			natcasesort($files);
			if( count($files) > 0 )
			{ /* The 2 accounts for . and .. */
				echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
				// All dirs
				foreach( $files as $file )
				{
					if( 	file_exists($root . $_POST['dir'] . $file) 
							&& is_dir($root . $_POST['dir'] . $file) 
					){
						echo "<li class=\"file ext_file\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">Choose " . htmlentities($file) . "</a></li>";
						echo "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">" . htmlentities($file) . "</a></li>";
					}
				}
				echo "</ul>";
			}
		}
	}
}

