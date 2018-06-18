$(function () {
$(".menu-toggle").click(function(e) {
        $("#wrapper").toggleClass("active");
        if (!$('#black-overlay').is(':visible')) {
                $('#black-overlay').css('display','block');
            }else{
                $('#black-overlay').css('display','none');
            }
});
$(".phmenu-toggle").click(function(e) {
	$("#navbar-data1").toggle("fast");
})
$("#mmicon").click(function(e) {
	$("#navbar-data1").toggle("slow");
})

});  