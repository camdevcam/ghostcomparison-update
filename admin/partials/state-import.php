<?php

// Dynamic Import Form for State
function ghostcomparison_state_import($state){
	?>
  <!-- HEADING -->
  <h3>
    <img class="csv-import-icon" src="<?php echo plugins_url( '../images/ExportCsv.png', __DIR__ ); ?>"/>
    <?php echo $state; ?> Data Import
  </h3>
  <p>Use the forms below to import data into the tables used in this plugin.</p>

  <div class="alert alert-warning">
    <span title="Close" class="close-btn" onclick="this.parentElement.style.display='none';">×</span>
    <strong>Warning!</strong> Make sure you are uploading a properly formatted CSV file or else it may not work as expected.
  </div>

	<hr>

	<!-- CSV IMPORTS -->

  <h4>Class Descriptions Import</h4>

  <form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="import-type" value="class-descriptions"/>
    <input type="hidden" name="state" value="<?php echo $state; ?>"/>

    <p>
      <span class="dashicons dashicons-upload"></span>
      <label for="class-desc-file">Select a file</label>
      <input id="class-desc-file" type="file" name="file">
    </p>

    <p><span class="dashicons dashicons-trash"></span>
    <label>Delete previously imported class descriptions?</label>
    <input type="checkbox" name="delete-records" value="delete"> Yes
    </p>

    <p>
      <input type="submit" name="submit" value="Import"/>
    </p>

  </form>
  <p>Class Descriptions import file: <a class="example-link" href="<?= plugins_url('../csv/class_descriptions.csv', __DIR__) ?>">class_descriptions.csv</a></p>
  <hr>

  <h4>Rates Import</h4>

  <form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="import-type" value="rates"/>
    <input type="hidden" name="state" value="<?php echo $state; ?>"/>

    <p>
      <span class="dashicons dashicons-upload"></span>
      <label for="rates-file">Select a file</label>
      <input id="rates-file" type="file" name="file">
    </p>

    <p>
      <span class="dashicons dashicons-trash"></span>
      <label>Delete previously imported rates?</label>
      <input type="checkbox" name="delete-records" value="delete"> Yes
    </p>

    <p>
      <input type="submit" name="submit" value="Import"/>
    </p>

  </form>
  <p>Rates import file: <a class="example-link" href="<?= plugins_url('../csv/rates.csv', __DIR__) ?>">rates.csv</a></p>

<?php } ?>
