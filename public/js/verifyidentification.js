$(document).ready(function() {
        
    $("#div-off").hide();

    
    $("select[name='tipid']").change(function() {
       if ($(this).val() == "J") {
          
          $("#div-off").show();
       } else {
         
          $("#div-off").hide();
       }
    });
 });