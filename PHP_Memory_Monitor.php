<?php 
/**
 * Plugin by Sanders Web Works
 *
 * @author      Nathan Base
 * @copyright   2018 Sanders Web Works
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: PHP Memory Monitor
 * Plugin URI:  https://sanderswebworks.co.uk
 * Description: Adds an admin bar node to show simple memory usage near end of PHP execution
 * Version:     0.0.1
 * Author:      Nathan Base
 * Author URI:  https://sanderswebworks.co.uk
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: sww
 * Domain Path: /languages
 */

Class PHP_Memory_Monitor {
	public function __construct(){
		add_action( 'admin_bar_menu', array($this, 'modify_admin_bar'), 99999999 );
	}
	public function modify_admin_bar( $wp_admin_bar ){
		// do something with $wp_admin_bar;
		$wp_admin_bar->add_node( array(
			'title' => $this->get_title()
		) );
	}
	public function get_title(){
		ob_start();
		?>
		<a style="color:#f2f2f2;" title="at the point of 'admin_bar_menu' hook. This is close to the end of PHP execution. See https://codex.wordpress.org/Plugin_API/Action_Reference">
			Memory Usage: <?php echo $this->convert_usage(memory_get_peak_usage(false)); ?>
		</a>
		<?php
		$title = ob_get_clean();
		return $title;
	}
	public function convert_usage($size) {
	   $unit=array('b','kb','mb','gb','tb','pb');
	   return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
	}
}

new PHP_Memory_Monitor();