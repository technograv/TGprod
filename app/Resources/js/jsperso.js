//test
//$(function() {
	//$('#texteJQ').html('Hello world. Ce texte est affiché par jQuery.');
//});

//Tooltips
$(function() {
	$('.tooltip-test').tooltip();
});

//Select2
$(function() {
	$('select').select2();
});

//Selectclient
$(function() {
	$(':input.selectclient').change(function() { 
		var $id = $(':input.selectclient option:selected').val();
		var baseUrl = document.location.origin;
       	window.location=baseUrl + "/technograv/web/commercial/client/" + $id; // dev
       	// prod : window.location=baseUrl + "/commercial/client/" + $id;
       });
})

//Selectcontact
$(function() {
	$(':input.selectcontact').change(function() { 
		var $id = $(':input.selectcontact option:selected').val();
		var baseUrl = document.location.origin;
       	window.location=baseUrl + "/technograv/web/commercial/client/" + $id; // dev
       	// prod : window.location=baseUrl + "/commercial/client/" + $id;
	});
})
