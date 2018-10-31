(function($) {

  "use strict";

  $(document).ready(function() {

    var form_id = gco.ghost_options.form_id,
        state_id = gco.ghost_options.state,
        industry_id = gco.ghost_options['industry'],
        class_desc_id = gco.ghost_options['class_desc'];

    // $(`#gform_${form_id} select[name=input_${class_desc_id}]`).select2({width: '300px'});
    $(`#gform_${form_id} select[name=input_${class_desc_id}]`).chosen();


    $(`#gform_${form_id} select[name=input_${state_id}]`).on('change', function(){
      console.log('STATE CHANGE');
      var state = $(this).val();
      var industry = $(`#gform_${form_id} input[name=input_${industry_id}]`).val();
      query_descriptions(state, industry);
    });


    $(`#gform_${form_id} select[name=input_${industry_id}]`).on('change', function(){
      console.log('INDUSTRY CHANGE');
      var state = $(`#gform_${form_id} select[name=input_${state_id}]`).val();
      var industry = $(this).val();
      query_descriptions(state, industry);
    });

    $(`#gform_${form_id} select[name=input_${class_desc_id}]`).on('change', function(){
      console.log('CLASS CHANGE');
      var class_id = $(this).val();
      var state = $(`#gform_${form_id} input[name=input_${state_id}]`).val();
      query_rates(class_id, state);
    });

  });

})(jQuery);

function query_rates(class_id, state){
  var form_id = gco.ghost_options.form_id;
  var voluntary1_id = gco.ghost_options.voluntary1;
  var voluntary2_id = gco.ghost_options.voluntary2;
  var voluntary3_id = gco.ghost_options.voluntary3;
  var assigned_risk_id = gco.ghost_options.assigned_risk;
  if(class_id!='' && state != ''){
    var form_data = jQuery(`#gform_${form_id}`).serializeJSON();
    jQuery.ajax({
      url: gco.ajax_url,
      type: 'post',
      data: {
        action: 'get_ghost_rates',
        form: form_data
      },
      success: function (response) {
        console.table({response});
        var data = JSON.parse(response);
        console.table({data});
        
        if(data[0]){
          jQuery(`#gform_${form_id} input[name=input_${voluntary1_id}]`).val(data[0].voluntary1);
          jQuery(`#gform_${form_id} input[name=input_${voluntary2_id}]`).val(data[0].voluntary2);
          jQuery(`#gform_${form_id} input[name=input_${voluntary3_id}]`).val(data[0].voluntary3);
          jQuery(`#gform_${form_id} input[name=input_${assigned_risk_id}]`).val(data[0].assigned_risk);
        }
      }
    })
  }
}

function query_descriptions(state, industry){
  var form_id = gco.ghost_options.form_id;
  // console.table({form_id});
  var class_desc_id = gco.ghost_options.class_desc;
  // console.table({class_desc_id});

  if(state!='' && industry != ''){
    var form_data = jQuery(`#gform_${form_id}`).serializeJSON();
    jQuery.ajax({
      url: gco.ajax_url,
      type: 'post',
      data: {
        action: 'get_ghost_class_descriptions',
        form: form_data,
      },
      success: function (response) {
        console.log(response);
        var data = JSON.parse(response);
        // console.table({data})
        var options = [];
        if(data) {
          ;
          jQuery.each(data, function (key, value) {
            options.push(`<option value='${value.id}'>${value.text}</option>`);
          });
        }
        console.log(options);
        // setTimeout to prevent browser from freezing, append options
        window.setTimeout(function(){
          // append options
          jQuery(`#gform_${form_id} select[name=input_${class_desc_id}]`).html(options.join(''));
          // reinitialize Select2
          // jQuery(`#gform_${form_id} select[name=input_${class_desc_id}]`).select2();
          jQuery(`#gform_${form_id} select[name=input_${class_desc_id}]`).trigger("chosen:updated");
        }, 0);
      }
    }); //end AJAX
  }
}