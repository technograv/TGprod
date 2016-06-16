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
	$('#tg_comptabundle_besoin_stock').change(function() {
	var id_select = $(this).val();
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

//trier contact par client
$(function() {
  $('#tg_prodbundle_projet_client').change(function() {
  var id_select = $(this).val();
  $.ajax({
    url: Routing.generate('set_contacts'),
    type: 'POST',
    data: {'id': id_select},
    dataType: 'json',
    success: function(json){ // quand la réponse de la requete arrive
      $('#tg_prodbundle_projet_contact').html(''); // tu vides le select2
      $.each(json, function(index, value) { // et tu boucle sur la réponse contenu dans la variable passé à la function du success "json"
      $('#tg_prodbundle_projet_contact').append('<option value="'+ value.idC +'">'+ value.nameC +'</option>');
      });
    }
  });
});
});

//trier projets par contact
$(function() {
	$(':input.triparcontact').change(function() { 
		var $id = $(this).val();
		 $.ajax({
			url: Routing.generate('set_projets'),
    		type: 'POST',
    		data: {'id': $id},
    		dataType: 'json',
    		success: function(json){ // quand la réponse de la requete arrive
      			$('tbody#triparcontact').html(''); // tu vides le tableau des projets
      			$.each(json, function(index, value) { // et tu boucle sur la réponse contenu dans la variable passé à la function du success "json"
    			var $url = Routing.generate('tg_prod_view', { id: value.idP });
          $('tbody#triparcontact').append('<tr><td width="6%">'+ value.idP +'</td><td width="14%"><a href="' + $url +'">' + value.titreP +'</a></td><td width="12%" align="center">'+ value.typeP +'</td><td width="10%" align="center">'+ value.userP +'</td><td width="10%" align="center">'+ value.assignP +'</td><td width="14%" align="center">'+ value.etapeP +'</td><td width="10%" align="center">'+ value.delaiP +'</td></tr>');
       //var obj = JSON.stringify(json);
       //console.log(obj);
      });
    }
  });
});
});

