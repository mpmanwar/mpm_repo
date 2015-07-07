$(document).ready(function (e) {

	// Get all the officers in the relationship section start //
	$(".imported_officers").click(function(){
	    var company_number = $(this).data("company_number");
	    $.ajax({
	        type: "POST",
	        url: "/client/get-officers-client",
	        dataType: "json",
	        data: { 'company_number': company_number },
	        beforeSend: function() {
	            $("#officers_details-modal").modal('show');
	            $("#officers_details-modal .officer_table").last().append('<tr><td colspan="3" align="center"><img src="/img/spinner.gif" /></td></tr>');
	        	//return false;
	        },
	        success: function (resp) {//console.log(resp['link']);return false;
	            var content = "";
	            $.each(resp, function(key){
		            content += '<tr><td width="40%">'+resp[key].client_name+'</td>';
	                content += '<td width="40%" align="center">'+resp[key].officer_role+'</td>';
	                content += '<td width="20%" align="center" id="goto'+key+'"><div class="officer_selectbox"><span>+ Add</span><div class="small_icon" data-id="'+key+'"></div><div class="clr"></div>';
	                content += '<div class="select_toggle" id="status'+key+'" style="display: none;"><ul>';
	                content += '<li data-value="org"><a href="javascript:void(0)" data-company_number="'+company_number+'" data-key="'+key+'" class="add_client_officers">NEW CLIENT</a></li>';
	                content += '<li data-value="non"><a href="javascript:void(0)" data-company_number="'+company_number+'" data-key="'+key+'" class="officer_addto_relation">NON - CLIENT</a></li>';
	                content += '</ul></div></div></td></tr>';
                });
	            $('#officers_details-modal .officer_table tr:last').remove();
                $("#officers_details-modal .officer_table").last().append(content);
	        }
	        
	    });

	});
	// Get all the officers in the relationship section End //


// ################Officers dropdown toggle in relationship section start ################### //
	$(document).click(function() {
	    $(".select_toggle").hide();
	});
	//$(".small_icon").click(function(event) {
	$("#officers_details-modal").on("click", ".small_icon", function(event){
		var visable = 0;
		event.stopPropagation();
		var id = $(this).data("id");
		if($(".select_toggle").is(':visible')){
			visable = 1;
		}
		$(".select_toggle").hide();

		if(visable == 1){
			$("#status"+id).hide();
		}else{
			$("#status"+id).show();
		}    
	    
	});
// ################Officers dropdown toggle in relationship section end ################### //


$("#officers_details-modal").on("click", ".officer_addto_relation", function(){
	var key = $(this).data("key");
    var company_number = $(this).data("company_number");

	$.ajax({
        type: "POST",
        url: "/client/save-officers-into-relation",
        dataType: "json",
        data: { 'company_number': company_number, 'key': key },
        
        success: function (resp) {//console.log(resp['relation_type_id']);return false;
            $('#rel_type_id').val(resp['relation_type_id']);
    		$('#rel_client_id').val(resp['client_id']);
    		saveRelationship('add_org');
        }
        
    });
});


$("#officers_details-modal").on("click", ".add_client_officers", function(){
    var key = $(this).data("key");
    var company_number = $(this).data("company_number");
    var client_id = $("#client_id").val();

    $.ajax({
            type: "POST",
            url: "/goto-edit-client",
            dataType: "json",
            data: { 'company_number': company_number, 'key' : key, 'client_id' : client_id },
            beforeSend: function() {
                $("#goto"+key).html('<img src="/img/spinner.gif" />');
            },
            success: function (resp) {//console.log(resp['link']);return false;
            	var content = "";
	            content += '<div class="officer_selectbox"><span>+ Add</span><div class="small_icon" data-id="'+key+'"></div><div class="clr"></div>';
	            content += '<div class="select_toggle" id="status'+key+'" style="display: none;"><ul>';
	            content += '<li data-value="org"><a href="javascript:void(0)" data-company_number="'+company_number+'" data-key="'+key+'" class="add_client_officers">NEW CLIENT</a></li>';
	            content += '<li data-value="non"><a href="javascript:void(0)" data-company_number="'+company_number+'" data-key="'+key+'" class="officer_addto_relation">NON - CLIENT</a></li>';
	            content += '</ul></div></div>';
            	$("#goto"+key).html(content);
                if(resp['link'] == 'org'){
                    var url = resp['base_url']+'/client/edit-org-client/'+resp['client_id'];
                    var myWindow = window.open(url , '_blank');
                    myWindow.focus();
                }
                if(resp['link'] == 'ind'){
                    var url = resp['base_url']+'/client/edit-ind-client/'+resp['client_id'];
                    var myWindow = window.open(url, '_blank');
                    myWindow.focus();
                }
            }
        });

});



});