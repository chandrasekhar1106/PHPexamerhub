$(document).ready(function(){
    // code to get all records from table via select box
    $("#subject").change(function() {
    var id = $(this).find(":selected").val();
    var dataString = 'subid='+ subid;
    $.ajax({
    url: 'getallsubject.php',
    dataType: "json",
    data: dataString,
    cache: false,
    success: function(subjectData) {
    if(subjectData) {
    $("#heading").show();
    $("#no_records").hide();
    $("#subname").text(subjectData.subname);
    $("#subdesc").text(subjectData.subdesc);
    
    $("#records").show();
    } else {
    $("#heading").hide();
    $("#records").hide();
    $("#no_records").show();
    }
    }
    });
    })
    });