(function($) {

  "use strict";

  $(document).ready(function() {
  console.log(localized);
    var form_id = (localized.ghost_options.form_id) ? localized.ghost_options.form_id : '';
    var state_id = localized.ghost_options.state;
    var industry_id = localized.ghost_options.industry;
    var class_desc_id = localized.ghost_options.class_desc;

    $('#gform_'+form_id+' select[name="input_'+class_desc_id+'"]').select2({width: '300px'});

    $('#gform_'+form_id+' select[name="input_'+state_id+'"]').on('change', function(){
      var state = $(this).val();
      var industry = $('#gform_'+form_id+' input[name="input_'+industry_id+'"]').val();
      query_descriptions(state, industry);
    });

    $('#gform_'+form_id+' select[name="input_'+industry_id+'"]').on('change', function(){
      var state = $('#gform_'+form_id+' input[name="input_'+state_id+'"]').val();
      var industry = $(this).val();
      query_descriptions(state, industry);
    });

    $('#gform_'+form_id+' select[name="input_'+class_desc_id+'"]').on('change', function(){
      var class_id = $(this).val();
      var state = $('#gform_'+form_id+' input[name="input_'+state_id+'"]').val();
      query_rates(class_id, state);
    });

  });

})(jQuery);

function query_rates(class_id, state){
  var form_id = localized.ghost_options.form_id;
  var voluntary1_id = localized.ghost_options.voluntary1;
  var voluntary2_id = localized.ghost_options.voluntary2;
  var voluntary3_id = localized.ghost_options.voluntary3;
  var assigned_risk_id = localized.ghost_options.assigned_risk;
  if(class_id!='' && state != ''){
    var form_data = jQuery('#gform_'+form_id).serializeJSON();
    jQuery.ajax({
      url: localized.ajax_url,
      type: 'post',
      data: {
        action: 'get_ghost_rates',
        form: form_data
      },
      success: function (response) {
        var data = JSON.parse(response);

        jQuery('#gform_'+form_id+' input[name="input_'+voluntary1_id+'"]').val(data[0].voluntary1);
        jQuery('#gform_'+form_id+' input[name="input_'+voluntary2_id+'"]').val(data[0].voluntary1);
        jQuery('#gform_'+form_id+' input[name="input_'+voluntary3_id+'"]').val(data[0].voluntary1);
        jQuery('#gform_'+form_id+' input[name="input_'+assigned_risk_id+'"]').val(data[0].assigned_risk);

        // for debug only
        console.log('voluntary1: '+jQuery('#gform_'+form_id+' input[name="input_'+voluntary1_id+'"]').val());
        console.log('voluntary2: '+jQuery('#gform_'+form_id+' input[name="input_'+voluntary2_id+'"]').val());
        console.log('voluntary3: '+jQuery('#gform_'+form_id+' input[name="input_'+voluntary3_id+'"]').val());
        console.log('assigned_risk: '+jQuery('#gform_'+form_id+' input[name="input_'+assigned_risk_id+'"]').val());
      }
    })
  }
}

function query_descriptions(state, industry){
  var form_id = localized.ghost_options.form_id;
  var class_desc_id = localized.ghost_options.class_desc;
  if(state!='' && industry != ''){
    var form_data = jQuery('#gform_'+form_id).serializeJSON();
    jQuery.ajax({
      url: localized.ajax_url,
      type: 'post',
      data: {
        action: 'get_ghost_class_descriptions',
        form: form_data,
      },
      success: function (response) {
        var data = JSON.parse(response);
        var options = [];
        if(data) {
          jQuery.each(data, function (key, value) {
            options.push('<option value="' + value.id + '">' + value.text + '</option>');
          });
        }
        // setTimeout to prevent browser from freezing, append options
        window.setTimeout(function(){
          // append options
          jQuery('#gform_'+form_id+' select[name="input_'+class_desc_id+'"]').html(options.join(''));
          // reinitialize Select2
          jQuery('#gform_'+form_id+' select[name="input_'+class_desc_id+'"]').select2();
        }, 0);
      }
    }); //end AJAX
  }
}