<?php
namespace madxartwork\Modules\WpCli;

use madxartwork\Core\Logger\Loggers\Db;
use madxartwork\Core\Logger\Items\Log_Item_Interface as Log_Item_Interface;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Cli_Logger extends Db {

	public function save_log( Log_Item_Interface $item ) {
		$message = $item->format( 'raw' );
		switch ( $item->type ) {
			case self::LEVEL_WARNING:
				\WP_CLI::warning( $message );
				break;
			case self::LEVEL_ERROR:
				\WP_CLI::error( $message, false );
				break;
			default:
				\WP_CLI::log( $message );
				break;
		}

		parent::save_log( $item );
	}
}
