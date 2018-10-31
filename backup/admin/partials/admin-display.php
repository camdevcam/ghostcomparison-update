<?php
	/**
	 *
	 * This file is used to markup the admin-facing aspects of the plugin.
	 *
	 */

function ghostcomparison_dashboard_html(){

	$states = array(
		'al'=>'Alabama',
		'ak'=>'Alaska',
		'az'=>'Arizona',
		'ar'=>'Arkansas',
		'ca'=>'California',
		'co'=>'Colorado',
		'ct'=>'Connecticut',
		'dc'=>'District of Columbia',
		'de'=>'Deleware',
		'fl'=>'Florida',
		'ga'=>'Georgia',
		'hi'=>'Hawaii',
		'id'=>'Idaho',
		'il'=>'Illinois',
		'in'=>'Indiana',
		'ia'=>'Iowa',
		'ks'=>'Kansas',
		'ky'=>'Kentucky',
		'la'=>'Louisiana',
		'me'=>'Maine',
		'md'=>'Maryland',
		'ma'=>'Massachusetts',
		'mi'=>'Michigan',
		'mn'=>'Minnesota',
		'ms'=>'Mississippi',
		'mo'=>'Missouri',
		'mt'=>'Montana',
		'ne'=>'Nebraska',
		'nv'=>'Nevada',
		'nh'=>'New Hampshire',
		'nj'=>'New Jersey',
		'nm'=>'New Mexico',
		'ny'=>'New York',
		'nc'=>'North Carolina',
		'ok'=>'Oklahoma',
		'or'=>'Oregon',
		'pa'=>'Pennsylvania',
		'ri'=>'Rhode Island',
		'sc'=>'South Carolina',
		'sd'=>'South Dakota',
		'tn'=>'Tennessee',
		'tx'=>'Texas',
		'ut'=>'Utah',
		'vt'=>'Vermont',
		'va'=>'Virginia',
		'wv'=>'West Virginia',
		'wi'=>'Wisconsin',
	);


	?>

	<div class="ghostcomparison">
			<!-- branding -->
			<div id="notice" class="center-text">
				<!-- loading spinner -->
				<div class="loader">Loading...</div>
			</div>

			<?php ghostcomparison_dashboard_notices($_REQUEST);  ?>



  <div class="fade-in">
    <div class="window window-default">
      <div class="window-heading ui-widget-header">
        <h1>
          <span class="dashicons dashicons-admin-generic"></span>
          Ghost Comparison - Plugin Settings & Data Import
        </h1>
      </div>
      <!-- /.window-heading -->
      <div class="window-body">

        <div id="tabs">
          <ul>
            <li><a href="#plugin-settings">Plugin Settings</a></li>

            <?php foreach ($states as $abbrv => $state){ ?>
              <li><a href="#_<?php echo $abbrv; ?>"><?php echo $state; ?></a></li>
            <?php } ?>

          </ul>

            <div id="plugin-settings">
              <h3>Plugin Settings</h3>
              <p>Set ID's for fields used in Gravity Form</p>
              <form method="POST" action="options.php">
		            <?php
			            settings_fields('ghost_options');
			            $ghost_options = get_option('ghost_options');
			            var_dump($ghost_options);
		            ?>
                <p>
                  <label>Ghost Comparison Form ID# </label>
                  <input type="number" min="1" name="ghost_options[form_id]"  value="<?php echo (!empty($ghost_options['form_id'])) ? $ghost_options['form_id'] : ''; ?>">
                </p>
                <p>
                  <label>State Field ID# </label>
                  <input type="number" min="1" name="ghost_options[state]"  value="<?php echo (!empty($ghost_options['state'])) ? $ghost_options['state'] : ''; ?>">
                </p>
                <p>
                  <label>Industry Field ID# </label>
                  <input type="number" min="1" name="ghost_options[industry]"  value="<?php echo (!empty($ghost_options['industry'])) ? $ghost_options['industry'] : ''; ?>">
                </p>
                <p>
                  <label>Class Descriptions Field ID# </label>
                  <input type="number" min="1" name="ghost_options[class_desc]"  value="<?php echo (!empty($ghost_options['class_desc'])) ? $ghost_options['class_desc'] : ''; ?>">
                </p>
                <p>
                  <label>Voluntary1 Field ID# </label>
                  <input type="number" min="1" name="ghost_options[voluntary1]"  value="<?php echo (!empty($ghost_options['voluntary1'])) ? $ghost_options['voluntary1'] : ''; ?>">
                </p>
                <p>
                  <label>Voluntary2 Field ID# </label>
                  <input type="number" min="1" name="ghost_options[voluntary2]"  value="<?php echo (!empty($ghost_options['voluntary2'])) ? $ghost_options['voluntary2'] : ''; ?>">
                </p>
                <p>
                  <label>Voluntary3 Field ID# </label>
                  <input type="number" min="1" name="ghost_options[voluntary3]"  value="<?php echo (!empty($ghost_options['voluntary3'])) ? $ghost_options['voluntary3'] : ''; ?>">
                </p>
                <p>
                  <label>Assigned Risk Field ID# </label>
                  <input type="number" min="1" name="ghost_options[assigned_risk]"  value="<?php echo (!empty($ghost_options['assigned_risk'])) ? $ghost_options['assigned_risk'] : ''; ?>">
                </p>

                <p>
                  <input type="submit" name="submit" id="submit" value="Save Changes">
                </p>
              </form>
            </div>
            <?php foreach ($states as $abbrv => $state){ ?>
              <div id="_<?php echo $abbrv; ?>">
                <?php ghostcomparison_state_import($state); ?>
              </div>
            <?php } ?>
        </div>

      </div>
    </div>
  </div>

  </div>

	<?php
}

function ghostcomparison_dashboard_notices($request){
  if($request['submit'] && strlen($request['import-type']) > 0 && $_REQUEST['rows_inserted']):
      switch ($request['import-type']) {
          case 'class-descriptions':
          ?>
              <div class="alert alert-success">
                <span class="close-btn" onclick="this.parentElement.style.display='none';">×</span>
                <strong>Success!</strong> <?php echo $request['state']; ?> Class descriptions imported. <?php echo ($_REQUEST['rows_inserted']) ? 'Rows inserted: ' . $_REQUEST['rows_inserted'] : ''; ?>
                <?php echo ($_REQUEST['delete_msg']) ? $_REQUEST['delete_msg'] : ''; ?>
              </div>
          <?php
          break;
          case 'rates':
          ?>
          <div class="alert alert-success">
            <span class="close-btn" onclick="this.parentElement.style.display='none';">×</span>
            <strong>Success!</strong> <?php echo $request['state']; ?> Rates imported. <?php echo ($_REQUEST['rows_inserted']) ? 'Rows inserted: ' . $_REQUEST['rows_inserted'] : ''; ?>
            <?php echo ($_REQUEST['delete_msg']) ? $_REQUEST['delete_msg'] : ''; ?>
          </div>
          <?php
          break;
          default:
            // do nothing
          break;
      }
  endif;
  }