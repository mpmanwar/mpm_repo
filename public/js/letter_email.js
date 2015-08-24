$(document).ready(function (e) {
  $(document).click(function() {
    $(".address_type_down").hide();
  });
  $(".down_arrow").click(function(event) {
      $(".address_type_down").toggle();
      event.stopPropagation();
  });

  $('.allCheckSelect').on('ifChecked', function(event){
        $(".email_letter input[class='ads_Checkbox']").iCheck('check');
    });

    $('.allCheckSelect').on('ifUnchecked', function(event){
        $(".email_letter input[class='ads_Checkbox']").iCheck('uncheck');
    });

  	$("body").on("click", ".more_address", function(){
        var client_id   = $(this).data('client_id');
        var client_type   = $(this).data('client_type');
        if(client_type == "org"){
            var address = $("#corres_add_"+client_id).val();
        }else if(client_type == "ind"){
            var address_type   = $(this).data('address_type');
            if(address_type == "reg"){
              var address = $("#reg_add_"+client_id).val();
            }else{
              var address = $("#serv_add_"+client_id).val();
            }
        }else if(client_type == "staff"){

        }else if(client_type == "other"){
          var contact_id   = $(this).data('contact_id');
          var address = $("#other_address_"+contact_id).val();
        }
        

        $("#show_full_address").html(address);
        $("#full_address-modal").modal("show");
    });

  /* ################# Open Notes Popup Start ################### */
    $(".open_notes_popup").click(function(){
      var client_id     = $(this).data("client_id");
      var contact_type  = $(this).data("contact_type");
      $.ajax({
          type: "POST",
          dataType : "json",
          url: "/contacts/show-contacts-notes",
          data: { 'client_id': client_id, 'contact_type' : contact_type },
          success: function (resp) {
            $("#notes_client_id").val(client_id);
            $("#contact_type").val(contact_type);
            $("#notes").val(resp['notes']);
            $("#notes-modal").modal("show");             
          }
      });
        
    });
/* ################# Save Notes Popup End ################### */
	
/* ################# Save Notes Start ################### */
    $(".save_notes").click(function(){
      var client_id     = $("#notes_client_id").val();
      var contact_type  = $("#contact_type").val();
      var notes         = $("#notes").val();
      var step_id       = $("#step_id").val();

      $.ajax({
          type: "POST",
          //dataType : "json",
          url: "/contacts/save-contacts-notes",
          data: { 'client_id': client_id, 'contact_type' : contact_type, 'notes' : notes },
          success: function (resp) {
            //$("#notes-modal").modal("hide");  
            window.location = '/contacts-letters-emails/'+step_id;           
          }
      });
        
    });
/* ################# Save Notes End ################### */

/* ################# Create Group Start ################### */
    $(".create_groups").click(function(){
      var step_id       = $("#create_group_step_id").val();
      var tab_id        = $("#tab_id").val();
      var group_name    = $("#group_name").val();
      $.ajax({
          type: "POST",
          dataType : "json",
          url: "/contacts/save-contacts-group",
          beforeSend : function(){
            $(".loader_class").html('<img src="/img/spinner.gif" />');
          },
          data: { 'step_id': step_id, 'group_name' : group_name },
          success: function (resp) {
            if(resp > 0){
              window.location = '/contacts-letters-emails/'+tab_id;            
            }else{
              $(".loader_class").html('');
              alert("There are some error..., Please try again.");
              return false;
            }
          }
      });
        
    });
/* ################# Create Group End ################### */

/* ################# Open Add To Group Popup Start ################### */
    $(".open_addto_group").click(function(){
      //var step_id     = $(this).data("step_id");
      //var contact_type  = $(this).data("contact_type");
      $("#addto_group-modal").modal("show");
      /*$.ajax({
          type: "POST",
          dataType : "json",
          url: "/contacts/show-contacts-notes",
          data: { 'client_id': client_id, 'contact_type' : contact_type },
          success: function (resp) {
            $("#notes_client_id").val(client_id);
            $("#contact_type").val(contact_type);
            $("#notes").val(resp['notes']);
            $("#notes-modal").modal("show");             
          }
      });*/
        
    });
/* ################# Open Add To Group Popup End ################### */

/* ################# Search Client By Address Type Start ################### */
    $(".address_type").change(function(){
      var address_type  = $(this).val();
      var client_id = $(this).data('client_id');
      var key = $(this).data('key');
      $.ajax({
          type: "POST",
          dataType : "json",
          url: "/contacts/search-address",
          data: { 'address_type' : address_type, 'client_id' : client_id },
          success: function (resp) {
            if(resp['address'].length > '48'){
              var small_addr = resp['address'].substring(0,45)
              var address = small_addr+"...<a href='javascript:void(0)' class='more_address' data-client_id='"+client_id+"' data-client_type='org'>more</a>"
            }else{
              var address = resp['address'];
            }
            $("#corres_add_"+client_id).val(resp['address']);
            $(".tr_no_"+key+" td:nth-child(5)").html(resp['contact_person']);   
            $(".tr_no_"+key+" td:nth-child(6)").html(resp['telephone']);
            $(".tr_no_"+key+" td:nth-child(7)").html(resp['mobile']);   
            $(".tr_no_"+key+" td:nth-child(8)").html(resp['email']);
            $(".tr_no_"+key+" td:nth-child(9)").html(address);       
          }
      });
        
    });
/* ################# Search Client By Address Type End ################### */

    
    
    
	
});
