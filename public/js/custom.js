$(document).ready(function () {

    $('#explorer-form').validate({
        
        rules: {
            file: {
                required: true,
                extension: "csv"
                }
            },
        messages: {
            file: {
                required: 'The upload Field is required.',
                extension: 'The file must be CSV.'
            }
        },
                    // rules: { file: { required: true, accept: ".csv"  }},
        errorClass:'text-danger',
        errorElement:'span',
    
    }); // initialize the plugin
        


$('#travel-form').validate({
        
        rules: {
            file: {
                required: true,
                extension: "csv"
                }
            },
        messages: {
            file: {
                required: 'The upload Field is required.',
                extension: 'The file must be CSV.'
            }
        },
                    // rules: { file: { required: true, accept: ".csv"  }},
        errorClass:'text-danger',
        errorElement:'span',
    
    }); // initialize the plugin
        
    $( "body" ).on('click',"#nav-travel-tab,#nav-explorer-tab", function(e) {
        $('input[name="file"]').removeClass('text-danger');
        $('#file-error').hide();
    });


});

