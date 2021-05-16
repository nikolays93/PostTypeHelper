<?php
/**
 * Plugin Name: Post type registration helper
 * Plugin URI: https://github.com/nikolays93
 * Description:
 * Version: 0.1.0
 * Author: NikolayS93
 * Author URI: https://vk.com/nikolays_93
 * Author EMAIL: NikolayS93@ya.ru
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: _plugin
 * Domain Path: /languages/
 *
 * @package NikolayS93.PostType
 */

namespace NikolayS93\PostTypeHelper;

spl_autoload_register(
	function ( $class_name ) {
		// If the specified $class_name does not include our namespace, duck out.
		if ( false === strpos( $class_name, __NAMESPACE__ ) ) {
			return;
		}

		// Path to classes directory.
		$class_dir = __DIR__ . DIRECTORY_SEPARATOR . 'post-type' . DIRECTORY_SEPARATOR;
		// Lower class name without namespace.
		$class_path = strtolower( str_replace( __NAMESPACE__, '', $class_name ) );
		// Split the class name into an array to read the namespace and class.
		$class_parts = array_filter( explode( '\\', $class_path ) );

		$class_basename = &$class_parts[ count( $class_parts ) ];
		$class_basename = 'class-' . str_ireplace( '_', '-', $class_basename ) . '.php';

		require_once $class_dir . implode( DIRECTORY_SEPARATOR, $class_parts );
	}
);
