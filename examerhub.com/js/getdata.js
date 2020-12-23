$(document).ready(function(){
    $("#btb5").click(function(){
        $.ajax({type: 'post', url: "search_testname.php",data: {reg: $("#txt1").val()}, success: function(result)
{
            $("#div1").html(result);
document.getElementById("txt1").value = "";
        }});
    });
});

