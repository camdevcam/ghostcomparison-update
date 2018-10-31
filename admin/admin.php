<?php
	// Include partials file for rendering HTML (in an effort to keep the code organized)
	include  plugin_dir_path(__FILE__) . '/partials/admin-display.php';
	include  plugin_dir_path(__FILE__) . '/partials/state-import.php';

	class GhostComparisonAdmin {

		public function __construct( ) {

			add_action( 'admin_enqueue_scripts', array($this, 'enqueue_styles' )  );
			add_action( 'admin_enqueue_scripts', array($this, 'enqueue_scripts' )  );
			add_action( 'admin_menu', array($this, 'register_menu_page')  );
			add_action( 'admin_init', array($this, 'register_settings')  );

		}

		public function enqueue_styles() {
			wp_enqueue_style('ghostcomparison-jquery-ui-css', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', array(), null, 'all');
			wp_enqueue_style( 'ghostcomparison-admin-css', plugin_dir_url( __FILE__ ) . 'css/admin.css', array(), null, 'all' );
		}

		public function enqueue_scripts() {
			wp_enqueue_script( 'jquery-ui', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', array( 'jquery' ), null, true );
			wp_enqueue_script( 'ghostcomparison-admin-js', plugin_dir_url( __FILE__ ) . 'js/admin.js', array( 'jquery' ), null, true );
		}

		public function register_menu_page(){
			add_menu_page( 'Ghost Comparison Dashboard', 'Ghost Comparison', 'activate_plugins', 'ghostcomparison-plugin-dashboard',	array( $this, 'submenu_page' ),	'dashicons-admin-generic',	101);
		}

		/* Register Settings */
		public function register_settings(){
			register_setting( 'ghost_options', 'ghost_options' );
		}

		public function submenu_page() {

			echo '<div class="ghostcomparison-wrapper">';

			if ( $_REQUEST['submit'] && strlen($_REQUEST['import-type']) > 0 )
				$this->process_csv();

			ghostcomparison_dashboard_html();

			echo '</div>';

		}

		public function process_csv(){

			if ( $_FILES["file"]['size'] > 0 ) {
				switch ($_REQUEST['import-type']) {
					case "class-descriptions":
						// Class Description Import
						$this->class_descriptions_import($_REQUEST);
						break;
					case "rates":
						// Class Data Import
						$this->rates_import($_REQUEST);
						break;
					default:
						// do nothing
						echo "There was an error!";
				}
			} else {
				// do nothing
				echo '<div class="alert alert-info">
        <span title="Close" class="close-btn" onclick="this.parentElement.style.display=\'none\';">×</span>
        <strong>Error!</strong> There was an error, please try again.
      </div>';

			}

		}

		public function prepare_mysql_import($Str) {
			$StrArr = str_split($Str); $NewStr = '';
			foreach ($StrArr as $Char) {
				$CharNo = ord($Char);
				if ($CharNo == 163) { $NewStr .= $Char; continue; } // keep £
				if ($CharNo > 31 && $CharNo < 127) {
					$NewStr .= $Char;
				}
			}
			return stripslashes($NewStr);
		}

		public function class_descriptions_import($request){
			global $wpdb;
			$wpdb->show_errors();
			$table_name = $wpdb->prefix . "ghostcomparison_class_descriptions";
			// if user select to delete all, then clear existing records
			if($request['delete-records']=="delete"){
				$delete = $wpdb->delete( $table_name, array( 'state' => $request['state'] ) );
				if($delete > 0){
					$_REQUEST['delete_msg'] = "<p>".$request['state']." Class descriptions deleted. Rows removed:  " . $delete . "</p>";
				}
			}

			$csvAsArray = array_map('str_getcsv', file($_FILES["file"]["tmp_name"]));
			$values = '';
			for($i=0; $i < count($csvAsArray); $i++) {
				if($i<>0){ // skip the first row, that's just the column headers
					if ( $i == (count($csvAsArray)-1) ) { // do not include a comma at the end of the last set of values
						$values .= "('".$this->prepare_mysql_import($csvAsArray[$i][0])."','".$this->prepare_mysql_import($csvAsArray[$i][1])."','".$this->prepare_mysql_import($csvAsArray[$i][2])."','".$request['state']."')";
					} else { // create row with values
						$values .= "('".$this->prepare_mysql_import($csvAsArray[$i][0])."','".$this->prepare_mysql_import($csvAsArray[$i][1])."','".$this->prepare_mysql_import($csvAsArray[$i][2])."','".$request['state']."'),";
					}
				}
			}
			// build SQL query
			$sql = "INSERT INTO ".$table_name." (`class_id`,`industry`,`description`,`state`) VALUES ";
			$sql .= $values;
			$insert = $wpdb->query($sql);
			$_REQUEST['rows_inserted'] = $insert;


		}

		public function rates_import($request){
			global $wpdb;
			$wpdb->show_errors();
			$table_name = $wpdb->prefix . "ghostcomparison_rates";
			// if user select to delete all, then clear existing records
			if($request['delete-records']=="delete"){
				$delete = $wpdb->delete( $table_name, array( 'state' => $request['state'] ) );
				if($delete > 0){
					$_REQUEST['delete_msg'] = "<p>" . $request['state'] . " Class data deleted. Rows removed:  " . $delete . "</p>";
				}
			}

			$csvAsArray = array_map('str_getcsv', file($_FILES["file"]["tmp_name"]));
			$values = '';
			for($i=0; $i < count($csvAsArray); $i++) {
				if($i<>0){ // skip the first row, that's just the column headers
					if ( $i == (count($csvAsArray)-1) ) { // do not include a comma at the end of the last set of values
						$values .= "('".addslashes($csvAsArray[$i][0])."','".addslashes($csvAsArray[$i][1])."','".addslashes($csvAsArray[$i][2])."','".addslashes($csvAsArray[$i][3])."','".addslashes($csvAsArray[$i][4])."','".$request['state']."')";
					} else { // create row with values
						$values .= "('".addslashes($csvAsArray[$i][0])."','".addslashes($csvAsArray[$i][1])."','".addslashes($csvAsArray[$i][2])."','".addslashes($csvAsArray[$i][3])."','".addslashes($csvAsArray[$i][4])."','".$request['state']."'),";
					}
				}
			}
			// build SQL query
			$sql = "INSERT INTO ".$table_name." (`class_id`, `voluntary1`, `voluntary2`, `voluntary3`, `assigned_risk`, `state`) VALUES ";
			$sql .= $values;
			$insert = $wpdb->query($sql);
			$_REQUEST['rows_inserted'] = $insert;

		}



	}



?>
