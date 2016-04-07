//Tooltips
$(function() {
	$('.tooltip-test').tooltip();
});

//Select2
$(function() {
	$('select:not(".special")').select2();
});

//Selectclient
$(function() {
	$(':input.selectclient').change(function() { 
		var $id = $(this).val();
		var $url = Routing.generate('tg_client_view', { id: $id });
       	window.location= $url;
       });
});

//Selectcontact
$(function() {
	$(':input.selectcontact').change(function() { 
		var $id = $(this).val();
		var $url = Routing.generate('tg_client_view', { id: $id });
       	window.location= $url;
	});
});

//chat
$(function() {
	$('#chat-titre').on('click', function() {
		if($('#chat-div').css('height') == '300px') {
		$('#chat-div').css('height', '20px');
		$('#chat-contenu').hide(); }
		else {
		$('#chat-div').css('height', '300px');
		$('#chat-contenu').show(); }
	});
});

//submit désactivé
$(function() {
	$('form').on('submit', function() {
		$('form :submit:not("#special")').attr("disabled", "disabled");
	});
});

//stocks
$(function() {
	$('#tg_comptabundle_besoin_stock').on('change', function() {
	var id_select = $('#tg_comptabundle_besoin_stock').val();
  $.ajax({
    url: Routing.generate('set_dimensions'),
    type: 'POST',
    data: {'id': id_select},
    dataType: 'json',
    success: function(json){ // quand la réponse de la requete arrive
      $('#tg_comptabundle_besoin_dimension').html(''); // tu vides le select2
      $.each(json, function(index, value) { // et tu boucle sur la réponse contenu dans la variable passé à la function du success "json"
    $('#tg_comptabundle_besoin_dimension').append('<option value="'+ value.idD +'">'+ value.nameD +'</option>');
      });
    }
  });
});
});
