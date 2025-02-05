@extends('layouts.layout')
@section('mycssfile')
    <link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<script src="{{ URL :: asset('js/org_clients.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/clients.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/relationship.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/jquery.maskedinput.js') }}" type="text/javascript"></script>
<!-- Date picker script -->

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

<!-- Date picker script -->

<!-- page script -->
<script type="text/javascript">
var Table1, Table2, Table3;
$(function() {
    
    
     var staff_id= $("#staff_typeid").val();
    // console.log(staff_typeid);
    // alert(staff_id);
    if(staff_id=="staff"){
    
  Table1 = $('#example1').dataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, 200]],
        "iDisplayLength": 50,
        "language": {
            "lengthMenu": "Show _MENU_ entries",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
        },

      "aoColumns":[
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": true},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}
        ]

    });
  Table1.fnSort( [ [1,'asc'] ] );

  Table2 = $('#example2').dataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, 200]],
        "iDisplayLength": 50,
        "language": {
            "lengthMenu": "Show _MENU_ entries",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
        },

      "aoColumns":[
           {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": true},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}
        ]

    });

   
   Table2.fnSort( [ [1,'asc'] ] );

   Table3 = $('#example3').dataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, 200]],
        "iDisplayLength": 50,
        "language": {
            "lengthMenu": "Show _MENU_ entries",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
        },

      "aoColumns":[
           {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": true},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}
        ]

    });
  Table3.fnSort( [ [1,'asc'] ] );
  }
  else{
    
    Table1 = $('#example1').dataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, 200]],
        "iDisplayLength": 50,
        "language": {
            "lengthMenu": "Show _MENU_ entries",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
        },

      "aoColumns":[
            //{"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": true},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}
        ]

    });
  Table1.fnSort( [ [1,'asc'] ] );

  Table2 = $('#example2').dataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, 200]],
        "iDisplayLength": 50,
        "language": {
            "lengthMenu": "Show _MENU_ entries",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
        },

      "aoColumns":[
          // {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": true},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}
        ]

    });

   
   Table2.fnSort( [ [1,'asc'] ] );

   Table3 = $('#example3').dataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, 200]],
        "iDisplayLength": 50,
        "language": {
            "lengthMenu": "Show _MENU_ entries",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
        },

      "aoColumns":[
          // {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": true},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}
        ]

    });
  Table3.fnSort( [ [1,'asc'] ] );
    
    
    
  }
  
 // $("#stafdpick").datepicker({dateFormat: 'dd-mm-yy'});
  $(".dpick").datepicker({dateFormat: 'dd-mm-yy'});
  
  
$('#snotes').click(function() {
    
   // alert('gigigi');
   // $("#staffcompose-modal").modal("hide");
    
    
    });
    
     //var client_id = $(this).val();
     //alert(client_id);
    $('#staffmDetails').change(function() {
       
        var client_id = $(this).val();
        // alert(client_id);
         console.log(client_id);
         
         if(client_id != "" ){
            //$("#view_edit_company").show();
            
            $.ajax({
                type: "GET",
                //dataType: "json",
                //url: '/client/client-details-by-client_id/'+client_id+"=ajax",
                url: "/staffholidays",
               data: { 'client_id' : client_id },
                beforeSend: function() {
                   // $(".show_client_details").html('<img src="/img/spinner.gif" />');
                    //return false;
                },
                success : function(resp){
                  
                 if(resp!= "") {
                    var res = JSON.parse(resp);
                    var vsl=res.field_value;
                   
                    $("#shentitlement").val(vsl);
                    
                    //alert(vsl);
                  // console.log(resp);
                }
                else{
                    $("#shentitlement").val("");
                }
                
                }
                
                
                
                
            });
        }
        else{
            $("#shentitlement").val("");
            
        }
         
         
         
         
          });
    
});



/*$(function() {
                $("#stafdpick").datepicker({dateFormat: 'dd-mm-yy'});
});

$(function() {
            $(".dpick").datepicker({dateFormat: 'dd-mm-yy'});
			  
});*/

$('.addnew_line').click(function() {
		
			//	alert('AAAAAAAAAAAA');	
                
                $(".dpick").datepicker("destroy");  
                
                	var $newstaffRow = $('#staffholi').clone(true);
                    
                    $newstaffRow.find('#sdate_picker').val('');
                    $newstaffRow.find('.dpick').val('');
                    $newstaffRow.find('#due').val('');
                    $newstaffRow.find('#rtype').val('');
                    $newstaffRow.find('#snotes').val('');
                    
                    var noOfDivs = $('.makeCloneClass').length + 1;
                    
                    $newstaffRow.find('input[type="text"]').attr('id', 'dpick'+ noOfDivs);
                    $('#sBoxTable tr:last').after($newstaffRow);
                    $(".dpick").datepicker({dateFormat: 'dd-mm-yy'}); 
				
			return false;
			
	})
    
    
    $('.sDeleteBoxRow').click(function() {
    
    //find the closest parent row and remove it
	var size = $(".sDeleteBoxRow").size();
		if(size>1){
        	$(this).closest('tr').remove();
		}
    });
    
    function addnotesmodal(){
        
        //alert('dsdsdsd');return false;
        
        $("#addfontnotes-modal").modal("hide");
    
    }
    function staffnotes(){
        
        
        
        var staffnotesval= $("#addfontnotesss").val();
        $('#notesstaff').val(staffnotesval);
        
        $("#addfontnotes-modal").modal("hide");
        //alert('fafafaf');return false;
    }


</script>
@stop

@section('content')
<input type="hidden" id="staff_typeid" name="staff_type" value="{{$staff_type}}" />
 <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas {{ $left_class }}">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    @include('layouts/inner_leftside')

                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side {{ $right_class }}">
                <!-- Content Header (Page header) -->
                @include('layouts.below_header')
    <!-- Main content -->
    <section class="content">
      <div class="practice_mid">
        <form>
        <div class="top_buttons">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="28%">
    <div class="top_bts">
          <ul>
            <li>
            <!--  <button class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Delete</button> -->
            </li>
            <li>
              <button class="btn btn-success"><i class="fa fa-download"></i> Generate PDF</button>
            </li>
            <li>
              <button class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Excel</button>
            </li>
            <div class="clearfix"></div>
          </ul>
        </div></td>
    <td width="6%">
      @if($staff_type == "staff")
        Select Staff
      @endif
    </td>
    <td width="10%">
      @if($staff_type == "staff")
       
      
        <select style="width:120px; height:23px;" id="staffmDetails">
         <option value="">-select staff- </option>
          @if(!empty($staff_details))
                  @foreach($staff_details as $key=>$staff_row)
                  <option value="{{ $staff_row->user_id }}">{{ $staff_row->fname }} {{ $staff_row->lname }}</option>
                  @endforeach
                @endif
        </select>
      @endif
    
    </td>
    <td width="10%">Holidays Entitlement</td>
    <td width="3%"><input type="text" id="shentitlement" style="width:50px;text-align: center;" value="" disabled/></td>
    <td width="8%">Holidays Taken</td>
    <td width="4%"><input type="text"  style="width:50px;text-align: center; " value="18" disabled/></td>
    <td width="10%">Holidays Remaining</td>
    <td width="3%"><input type="text" id="" style="width:50px; text-align: center;" value="10" disabled></td>
  </tr>
</table>

      </div>
          <div class="tabarea">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs nav-tabsbg">
                <li class="active"><a data-toggle="tab" href="#tab_1">AWATING APPROVAL</a></li>
                <li><a data-toggle="tab" href="#tab_2">APPROVED</a></li>
                <li><a data-toggle="tab" href="#tab_3">PREVIOUS REQUEST</a></li>
              </ul>
              <div class="tab-content">
                <div id="tab_1" class="tab-pane active">
                  <!--table area-->
                  <div class="box-body table-responsive" style="position:relative;">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-8"></div>
                        <div class="col-xs-4"></div>
                      </div>
                      <div style="position:absolute; left: 50%; z-index: 10; margin-top: -4px;">
          <button class="btn btn-default" data-toggle="modal" data-target="#staffcompose-modal"><span class="requ_t">New Request</span></button>
          @if($staff_type == "staff")
          <button class="btn btn-default">Approve</button>
          <button class="btn btn-default"><span class="decline_t">Decline</span></button>
          @endif
                      </div>

                      <div class="row">
                        <div class="col-xs-12">
<table class="table table-bordered table-hover dataTable" id="example1" aria-describedby="example1_info">
  @if($staff_type == "staff")
    <thead>
      <tr role="row">
        <th align="left"><input type="checkbox" id="allCheckSelect"/></th>
        <th align="center">Staff Name</th>
        <th align="center">Time Off Type</th>
        <th align="center">Date</th>
        <th align="center" width="10%">Status</th>
        <th align="center" style="padding: 6px 4px; width: 10%;" >Requester Notes</th>
        <th align="center" style="padding: 9px 4px; width: 10%;">Approver Notes</th>
        <th align="center">Action</th>
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      <tr>
        <td align="left"><input type="checkbox" /></td>
        <th align="center"><a href="#">Anwar</a></th>
        <td align="center">No</td>
        <td align="center">20-07-2015</td>
        <td align="center">
         <input type="button" value="AWATING APPROVAL" class="awating_btn">
        </td>
        <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td>
        
        <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td>
        <td align="center"><a href="#"><img src="/img/edit_icon.png" width="15"></a>
        <a href="#" ><img src="/img/cross.png" width="15" ></a>
        
        
        </td>
      </tr>
      
    </tbody>
          
  @else
    <thead>
      <tr role="row">
       <!-- <th align="left"><input type="checkbox" id="allCheckSelect"/></th> -->
        <th align="center">Staff Name</th>
        <th align="center">Time Off Type</th>
        <th align="center">Date</th>
        <th align="center" width="10%">Status</th>
        <th align="center" style="padding: 6px 4px; width: 10%;" >Requester Notes</th>
        <th align="center" style="padding: 9px 4px; width: 10%;">Approver Notes</th>
        <th align="center">Action</th>
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      <tr>
        <!-- <td align="left"><input type="checkbox" /></td> -->
        <th align="center"><a href="#">Anwar</a></th>
        <td align="center">No</td>
        <td align="center">20-07-2015</td>
        <td align="center">
         <input type="button" value="AWATING APPROVAL" class="awating_btn">
        </td>
        <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td>
        
        <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td>
        <td align="center"><a href="#"><img src="/img/edit_icon.png" width="15"></a>
        <a href="#" ><img src="/img/cross.png" width="15" ></a>
        
        
        </td>
      </tr>
      
    </tbody>
  @endif                
</table>
  </div>
                      </div>
                    </div>
                  </div>
                  <!--end table-->
                </div>
                <!-- /.tab-pane -->
                <div id="tab_2" class="tab-pane">
                  <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      <div class="row">
                         <div class="col-xs-12">
<table class="table table-bordered table-hover dataTable" id="example2" aria-describedby="example2_info">
  @if($staff_type == "staff")
    <thead>
      <tr role="row">
        <th align="left"><input type="checkbox" id="allCheckSelect"/></th>
        <th align="center">Staff Name</th>
        <th align="center">Time Off Type</th>
        <th align="center">Date</th>
        <th align="center" width="10%">Status</th>
        <th align="center" style="padding: 6px 4px; width: 10%;" >Requester Notes</th>
        <th align="center" style="padding: 9px 4px; width: 10%;">Approver Notes</th>
        <th align="center">Action</th>
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      <tr>
        <td align="left"><input type="checkbox" /></td>
        <th align="center"><a href="#">Anwar</a></th>
        <td align="center">No</td>
        <td align="center">20-07-2015</td>
        <td align="center">
        <input type="button" value="APPROVED!" class="approved_btn">
        <!-- <input type="button" value="AWATING APPROVAL" class="awating_btn"> -->
        </td>
        <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td>
        
        <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td>
        <td align="center"><a href="#"><img src="/img/edit_icon.png" width="15"></a>
        <a href="#" ><img src="/img/cross.png" width="15" ></a>
        
        
        </td>
      </tr>
      
    </tbody>
          
  @else
    <thead>
      <tr role="row">
      <!--  <th align="left"><input type="checkbox" id="allCheckSelect"/></th> -->
        <th align="center">Staff Name</th>
        <th align="center">Time Off Type</th>
        <th align="center">Date</th>
        <th align="center" width="10%">Status</th>
        <th align="center" style="padding: 6px 4px; width: 10%;" >Requester Notes</th>
        <th align="center" style="padding: 9px 4px; width: 10%;">Approver Notes</th>
        <th align="center">Action</th>
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      <tr>
      <!--  <td align="left"><input type="checkbox" /></td> -->
        <th align="center"><a href="#">Anwar</a></th>
        <td align="center">No</td>
        <td align="center">20-07-2015</td>
        <td align="center">
        
         <input type="button" value="AWATING APPROVAL" class="awating_btn">
        </td>
        <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td>
        
        <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td>
        <td align="center"><a href="#"><img src="/img/edit_icon.png" width="15"></a>
        <a href="#" ><img src="/img/cross.png" width="15" ></a>
        
        
        </td>
      </tr>
      
    </tbody>
  @endif                
</table>
  </div>
                        
                        
                        
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.tab-pane -->
                  <div id="tab_3" class="tab-pane">
                  <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-12">
<table class="table table-bordered table-hover dataTable" id="example3" aria-describedby="example3_info">
  @if($staff_type == "staff")
    
    <thead>
      <tr role="row">
        <th align="center"><input type="checkbox" id="allCheckSelect"/></th>
        <th align="center">Staff Name</th>
        <th align="center">Time Off Type</th>
        <th align="center">Date</th>
        <th align="center" width="10%">Status</th>
        <th align="center" style="padding: 6px 4px; width: 10%;" >Requester Notes</th>
        <th align="center" style="padding: 9px 4px; width: 10%;">Approver Notes</th>
        <th align="center">Action</th>
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      <tr>
        <td align="left"><input type="checkbox" /></td>
        <th align="center"><a href="#">Anwar</a></th>
        <td align="center">No</td>
        <td align="center">20-07-2015</td>
        <td align="center">
         <input type="button" value="AWATING APPROVAL" class="awating_btn">
        </td>
        <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td>
        
        <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td>
        <td align="center"><a href="#"><img src="/img/edit_icon.png" width="15"></a>
        <a href="#" ><img src="/img/cross.png" width="15" ></a>
        
        
        </td>
      </tr>
      
    </tbody>
          
  @else
   <thead>
      <tr role="row">
       <!-- <th align="center"><input type="checkbox" id="allCheckSelect"/></th> -->
        <th align="center">Staff Name</th>
        <th align="center">Time Off Type</th>
        <th align="center">Date</th>
        <th align="center" width="10%">Status</th>
        <th align="center" style="padding: 6px 4px; width: 10%;" >Requester Notes</th>
        <th align="center" style="padding: 9px 4px; width: 10%;">Approver Notes</th>
        <th align="center">Action</th>
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      <tr>
       <!--  <td align="left"><input type="checkbox" /></td> -->
        <th align="center"><a href="#">Anwar</a></th>
        <td align="center">No</td>
        <td align="center">20-07-2015</td>
        <td align="center">
         <input type="button" value="AWATING APPROVAL" class="awating_btn">
        </td>
        <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td>
        
        <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td>
        <td align="center"><a href="#"><img src="/img/edit_icon.png" width="15"></a>
        <a href="#" ><img src="/img/cross.png" width="15" ></a>
        
        
        </td>
      </tr>
      
    </tbody>
  @endif                
</table>
  </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.tab-pane -->
                
              </div>
            </div>
          </div>
        </form>
      </div>
    </section>
    <!-- /.content -->
  </aside>
  <!-- /.right-side -->
</div>

<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="staffcompose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <!--<div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD COURSE</h4>
        <div class="clearfix"></div>
      </div>-->
      <form action="#" method="post">
        <div class="modal-body">
          <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
          <table width="100%" border="0" class="staff_holidays">
            <tr>
              <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="20%"><strong>HOLIDAY/TIME OFF REQUEST</strong></td>
                    
                    <td width="14%">
                      @if($staff_type != "staff")
                      <strong>Total Days Requested</strong> <input type="text" style="width:60px;">
                      @endif
                    </td>
                    <td width="12%">
                      @if($staff_type != "staff")
                      <strong>Days Remaining</strong> <input type="text" style="width:60px;">
                      @else
                      <strong>Staff Name </strong></td>
                      <td width="15%"><select class="form-control">
                      
                      @if(!empty($staff_details))
                  @foreach($staff_details as $key=>$staff_row)
                  <option value="{{ $staff_row->user_id }}">{{ $staff_row->fname }} {{ $staff_row->lname }}</option>
                  @endforeach
                @endif
                      
                      </select>
                      @endif
                    </td>
                    
                    
                  </tr>
                </table>

              </td>
            </tr>
            <tr>
              <td valign="top">
              <table width="100%" class="table table-bordered" id="sBoxTable" >
                  <tbody>
                   <tr>
                   
                     <td align="center">&nbsp;</td>
                      <td align="center"><strong>Date</strong></td>
                      <td align="center"><strong>Duration</strong></td>
                      <td align="center"><strong>Request type</strong></td>
                      <td align="center"><strong>Notes</strong></td>
                    </tr>
                   
                    <tr id="staffholi" class="makeCloneClass">
                    
                        <td><a href="#"><img src="/img/cross_icon.png" id="sdate_picker"  class="sDeleteBoxRow" /></a></td>
                      
                     <td> <input type="text" class="dpick" id="stafdpick" name="date[]" style="width:86%; height: 33px;">
                      </td>
                      <td align="center">
                             
                                                          
                              <select class="form-control" id="due">
                                <option value="fullfday">Full Day</option>
                                <option value="am">AM-Half Day </option>
                                <option value="ph">PM-Half Day </option>
                                
                              </select>
                            </td>
                      <td align="center">
                      <select class="form-control" id="rtype">
                        <option value="annual">Annual Leave</option>
                        <option value="paternity">Paternity/Maternity Leave </option>
                        <option value="sickness">Sickness</option>
                       
                        </select></td>
                      <td align="center" style="padding: 9px 0; width: 14%;" ><button class="btn btn-default note_t" id="snotes" data-toggle="modal" data-target="#addfontnotes-modal" id="notesaddfont">Notes</button>
                      
                      
                      <input type="hidden" name="notes[]" id="notesstaff" value="">
                      </td>
                    </tr>
                    
                 
                     
                  </tbody>
                </table>
              </td>
            </tr>
          </table>
          <div class="save_btncon">
         <div class="left_side"><button class="addnew_line"><i class="add_icon_img"><img src="/img/add_icon.png"></i><p class="add_line_t">Add new</p></button>
         
         
         </div>
         <div class="right_side"> <button class="btn btn-success">Submit for Approval</button></div>
         <div class="clearfix"></div>
         </div>
         
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>






<!-- addfontnotes-modal-->
<div>
<div class="modal fade" id="addfontnotes-modal" tabindex="1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:36%;">
    
    <div class="modal-content">
     
      
      <div class="modal-body">
      <button class="close save_btn" aria-hidden="true" data-dismiss="modal" type="button">x</button>
     
      <div style="width:100%;">
             <label for="f_name" style="font-size: 18px;">Notes</label>
             
          <textarea rows="4" cols="60"  name="notes1[]" id="addfontnotesss" value="" ></textarea>
         
         
     <!--     <button class="btn btn-primary" onclick="return fetchnotes()" id="fetchsave_notes" style=" padding:4px 20px; text-align: center; margin-top: 15px; float: right; margin-right: 6%; ">Save</button> -->  
          <div class="clr"></div> 
        
        
        
        <button class="btn btn-primary" onclick="return staffnotes()" id="save_staffnotes" style=" padding:4px 20px; text-align: center; margin-top: 15px; float: right; margin-right: 6%; ">Save</button>
        
       <!--   <button class="btn btn-primary"   style="padding:4px 20px; text-align: center; margin-top: 15px; float: right; margin-right: 6%;">Save</button>  -->
               
         </div>
         <div class="clr"></div> 
        </div>
        
       
      <!--</form>-->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

</div>
<!-- addfontnotes-modal -->
@stop
<!-- staff-->