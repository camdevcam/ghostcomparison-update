<?php

	class GhostComparisonActivation {

		public function __construct() {

			register_activation_hook( __FILE__, array( $this, 'activate' ) );

		}

		public function activate() {
			global $wpdb;
			$charset_collate = $wpdb->get_charset_collate();
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

			$tables_used = array(
				"ghostcomparison_class_descriptions",
				"ghostcomparison_rates",
			);

			foreach ($tables_used as $table_name) { // for each table used in plugin, create if not already added

				if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
					if( $table_name == 'ghostcomparison_class_descriptions' ){ // if premiums table, use premiums table format
						$table_name = $wpdb->prefix.$table_name;
						$sql = "CREATE TABLE $table_name (
																		id mediumint(9) NOT NULL AUTO_INCREMENT,
																		class_id varchar(12) NOT NULL,
																		industry varchar(255) NOT NULL,
																		description varchar(255) NOT NULL,
																		state varchar(50) NOT NULL,
																		UNIQUE KEY id (id)
													      ) $charset_collate;";
						dbDelta( $sql );
					} elseif( $table_name == "ghostcomparison_rates" ){
						$table_name = $wpdb->prefix.$table_name;
						$sql = "CREATE TABLE $table_name (
															id mediumint(9) NOT NULL AUTO_INCREMENT,
															class_id mediumint(9) NOT NULL,
	                            voluntary1 mediumint(9) NOT NULL,
	                            voluntary2 mediumint(9) NOT NULL,
	                            voluntary3 mediumint(9) NOT NULL,
	                            assigned_risk mediumint(9) NOT NULL,
	                            state varchar(50) NOT NULL,
															UNIQUE KEY id (id)
												) $charset_collate;";
						dbDelta( $sql );
					}

				} // end if table doesn't exist
			} // end foreach

		}

	}