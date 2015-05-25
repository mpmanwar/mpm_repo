@extends('layouts.layout')

@section('mycssfile')
    <link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/clients.js') }}" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
$(function() {
  $('#example2').dataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,


        //"iDisplayLength": -1,
        //"aaSorting": [[ 5, "desc" ]],
        "aoColumns":[
            {"bSortable": false},
            
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}
        ]

        //"aoColumnDefs": [{ "bVisible": false, "aTargets": [2] }]

    });

  $("#example2_filter").hide();


});



</script>
@stop

@section('content')
<div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="{{ URL :: asset('img/user3.jpg') }}" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, Jane</p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="/dashboard">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        CLIENT LIST - INDIVIDUALS
                        <!-- <small>CLIENT NAME  Limited</small> -->
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Individual Clients</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
      <div class="row">
        <div class="top_bts">
          <ul>
            <!-- <li>
              <button class="btn btn-info"><i class="fa fa-print"></i> Print</button>
            </li> -->
            <li>
              <button class="btn btn-success"><i class="fa fa-download"></i> Generate PDF</button>
            </li>
            <li>
              <button class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Excel</button>
            </li>
            
            <!-- <li>
            
              <button class="btn btn-warning" type="button" id="edit_but"><i class="fa fa-edit"></i> Edit</button>
              <button class="btn btn-success" type="button" style="display:none;" id="save_but">Save</button>
            
            </li> -->

            

            <div class="clearfix"></div>
          </ul>
        </div>

        <div style="float: right; margin-right: 43px;"><a href="javascript:void(0)" id="archive_div">Show Archived</a></div>
      </div>
      <div class="practice_mid">
        <form>
          
          <div class="tabarea">
            <div class="tab_topcon">
              <div class="top_bts">
                <ul style="padding:0;">
                  <li>
                    <a href="/individual/add-client" class="btn btn-info">ADD CLIENT</a>
                  </li>
                  <li>
                    <button class="btn btn-success">BULK CSV IMPORT</button>
                  </li>
                  <li>
              <button type="button" id="deleteClients" class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Delete</button>
            </li>
                  <li>
              <button type="button" id="archivedButton" style="display:none;" class="btn btn-warning">Archive</button>
            </li>
                  <div class="clearfix"></div>
                </ul>
              </div>
              <div class="top_search_con">
               <div class="top_bts">
                <ul style="padding:0;">
                  <li>
                    <button class="btn btn-info">ON-BOARD NEW CLIENT</button>
                  </li>
                  <li>
                    <button type="button" id="show_search" class="btn btn-success">Search</button>
                  </li>
                  <div class="clearfix"></div>
                </ul>
              </div>
              </div>
              <div class="clearfix"></div>
            </div>
            
            <div class="table_top_box" id="table_top_box">
              <ul>
                <li style="width:auto;"><input type="reset" value="Clear"></li>
                <li><input type="text" name="search_client_text" id="search_client_text" placeholder="Search..." class="search_box"></li>
              
              </ul>
              
              <div class="clearfix"></div>
          
            </div>
            
            <div class="box-body table-responsive">
              <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                <div class="row">
                  <div class="col-xs-6"></div>
                  <div class="col-xs-6"></div>
                </div>
          <table class="table table-bordered table-hover dataTable" id="example2" aria-describedby="example2_info">
                        
            <thead>
              <tr role="row">
                <th><input type="checkbox" id="allCheckSelect"/></th>
                <!-- <th>#</th> -->
                <th>STAFF</th>
                <th><span id="dob_text">DOB</span>
                  <span id="dob_select" style="display:none;">
                    <select id="four" style="width:100px;">
                      @if(!empty($client_fields))
                        @foreach($client_fields as $key=>$field_row)
                        <option value="{{ $field_row->field_name }}-{{ $field_row->field_label }}" {{ ($field_row->field_name == 'dob') ? 'selected':"" }} >{{ $field_row->field_label }}</option>
                        @endforeach
                      @endif
                    </select>
                  </span>
                </th>
                <th>CLIENT NAME</th>
                <th><span id="business_name_text">BUSINESS NAME</span>
                  <span id="business_name_select" style="display:none;">
                    <select id="six" style="width:100px;">
                      @if(!empty($client_fields))
                        @foreach($client_fields as $key=>$field_row)
                        <option value="{{ $field_row->field_name }}-{{ $field_row->field_label }}" {{ ($field_row->field_name == 'business_name') ? 'selected':"" }} >{{ $field_row->field_label }}</option>
                        @endforeach
                      @endif
                    </select>
                  </span>
                </th>
                
                <th><span id="ni_number_text">NI NUMBER</span>
                  <span id="ni_number_select" style="display:none;">
                    <select id="seven" name="first" style="width:100px;">
                      @if(!empty($client_fields))
                        @foreach($client_fields as $key=>$field_row)
                        <option value="{{ $field_row->field_name }}-{{ $field_row->field_label }}" {{ ($field_row->field_name == 'ni_number') ? 'selected':'' }} >{{ $field_row->field_label }}</option>
                        @endforeach
                      @endif
                    </select>
                  </span>
                </th>
                <th><span id="tax_reference_text">TAX REFERENCE</span>
                  <span id="tax_reference_select" style="display:none;">
                    <select id="eight" style="width:100px;">
                      @if(!empty($client_fields))
                        @foreach($client_fields as $key=>$field_row)
                        <option value="{{ $field_row->field_name }}-{{ $field_row->field_label }}" {{ ($field_row->field_name == 'tax_reference') ? 'selected':"" }} >{{ $field_row->field_label }}</option>
                        @endforeach
                      @endif
                    </select>
                  </span>
                </th>
                <th><span id="acting_text">ACTING</span>
                  <span id="acting_select" style="display:none;">
                    <select id="nine" style="width:100px;">
                      @if(!empty($client_fields))
                        @foreach($client_fields as $key=>$field_row)
                        <option value="{{ $field_row->field_name }}-{{ $field_row->field_label }}" {{ ($field_row->field_name == 'acting') ? 'selected':"" }} >{{ $field_row->field_label }}</option>
                        @endforeach
                      @endif
                    </select>
                  </span>
                </th>
                <th><span id="res_address_text">RESIDENTIAL ADDRESS</span>
                  <span id="res_address_select" style="display:none;">
                    <select id="ten" style="width:100px;">
                      @if(!empty($client_fields))
                        @foreach($client_fields as $key=>$field_row)
                        <option value="{{ $field_row->field_name }}-{{ $field_row->field_label }}" {{ ($field_row->field_name == 'res_address') ? 'selected':"" }} >{{ $field_row->field_label }}</option>
                        @endforeach
                      @endif
                    </select>
                  </span>
                </th>
              
              </tr>
            </thead>

            <tbody role="alert" aria-live="polite" aria-relevant="all">
              @if(!empty($client_details))
              <?php $i=1; ?>
              @foreach($client_details as $key=>$client_row)
                <tr class="all_check">
                  <td align="center">
                    <input type="checkbox" class="ads_Checkbox" name="client_delete_id[]" value="1" id="client_delete_id"/>
                  </td>
                  <!-- <td>{{ $i }}</td> -->
                  <td>{{ $client_row['staff_name'] or "" }}</td>
                  <td>{{ (!empty($client_row['dob']))? $client_row['dob']: '' }}</td>
                  <td><a href="#">{{ (!empty($client_row['name']))? $client_row['name']: '' }}</a></td>
                  <td>{{ (!empty($client_row['business_name']))? $client_row['business_name']: '' }}</td>
                  <td>{{ (!empty($client_row['ni_number']))? $client_row['ni_number']: '' }}</td>
                  <td>{{ (!empty($client_row['tax_reference']))? $client_row['tax_reference']: '' }}</td>
                  <td>{{ (!empty($client_row['acting'])) ? 'Yes': 'No' }}</td>
                  <td>{{ (!empty($client_row['res_address'])) ? $client_row['res_address'] : '' }}, {{ (!empty($client_row['res_city'])) ? $client_row['res_city'] : '' }}, {{ (!empty($client_row['res_zipcode'])) ? $client_row['res_zipcode'] : '' }}</td>
                </tr>
                <?php $i++; ?>
                @endforeach
                
              @endif
              
              
              
            </tbody>
          </table>
                         </div>
        </div>
            
            
            

            
                      
                      
          </div>
        </form>
      </div>
    </section>
                <!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

@stop