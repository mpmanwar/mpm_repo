@extends('layouts.layout')

@section('myjsfile')
    <script src="{{ URL :: asset('js/sites/practice_details.js') }}" type="text/javascript"></script>
    <script src="{{ URL :: asset('js/upload_script.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        //$(":file").filestyle({input: false});
    </script>
@stop

@section('content')

<div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
           <aside class="left-side sidebar-offcanvas {{ $left_class }}">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    @include('layouts.inner_leftside')
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side {{ $right_class }}">
                <!-- Content Header (Page header) -->
                <!-- <section class="content-header">
                    <h1>
                        MY PRACTICE MANAGER
                        <small>CLIENT NAME Limited</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Practice Details</li>
                    </ol>
                </section> -->
                @include('layouts.below_header')

                <!-- Main content -->

{{ Form::open(array('url' => '/insertPracticeDetails', 'files' => true, 'id' => 'uploadimage')) }}
<input type="hidden" name="practice_id" value="{{ $practice_details->practice_id or ''}}">
<input type="hidden" name="reg_address_id" value="{{ $practice_address['reg_address_id'] or ''}}">
<input type="hidden" name="phy_address_id" value="{{ $practice_address['phy_address_id'] or ''}}">
<input type="hidden" name="hidd_practice_logo" value="{{ $practice_details->practice_logo or ''}}">

<section class="content">

<div class="row">
<div class="top_bts">
<ul>
<!-- <li><button type="button" class="btn btn-info" onClick="window.print()"><i class="fa fa-print"></i> Print</button></li> -->
<li><a class="btn btn-success" href="/download/downloadPdf"><i class="fa fa-download"></i> Generate PDF</a></li><!-- /download/downloadPdf -->




<li><a class="btn btn-primary" href="/downloadExel"><i class="fa fa fa-file-text-o"></i> Excel</a></li>
<!-- <li><a href="javascript:void(0)" id="del_prc_dtls" class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Delete</a></li>

<li><button class="btn btn-warning" type="submit" name="edit" id="edit"><i class="fa fa-edit"></i> Edit</button></li> -->

<div class="clearfix"></div>
</ul>
  
</div>
</div>

<!-- Image upload error show -->
<div id="error_image_type" style="margin-left: 400px;margin-bottom: 10px;color: red;"></div>
<!-- Image upload error show -->

<div class="practice_mid">

<div class="row box_border row_cont">
 <div class="col_left col_left_new">
<div class="col-xs-12">
 <div class="col-lg-6">   
 <!-- <h2 class="res_t p_details">Practice Details</h2> -->
 </div>
  <div class="col-lg-6">  
<div class="browse_cont">
 <span class="btn btn-default btn-file p_details">
    Browse <input type="file" name="practice_logo" id="practice_logo">
</span>
@if(isset($practice_details->practice_logo) && $practice_details->practice_logo != "")
    @if(file_exists("practice_logo/".$practice_details->practice_logo))
      <img src="practice_logo/{{ $practice_details->practice_logo }}" class="browse_img" alt="" width="30" />
      <button class="btn btn-danger" data-practice_id="{{ $practice_details->practice_id }}" data-logo_name="{{ $practice_details->practice_logo }}" title="Delete Logo?" type="button" id="delete_practice_logo">Delete</button>
    @endif
@endif
</div>
</div>
<div class="clearfix"></div>
<!--<input type="file" name="practice_logo" id="practice_logo">-->
</div>
 </div>


<div class="col_right">
 <div class="setting_con">
    <a href="/settings-dashboard" class="btn btn-success btn-lg"><i class="fa fa-cog fa-fw"></i>Settings</a>

</div>

<div class="save_con">

<button class="btn btn-primary" type="submit" name="save" id="save">Save</button>

<button class="btn btn-info" type="reset" name="cancel" id="cancel">Cancel</button>
</div>

 </div>
 <div class="clearfix"></div>
</div>

<div class="row b_gap">
<div class="col-lg-3 col-xs-12">
<div class="form-group">
<label for="display_name">Display Name</label>
<input type="text" placeholder="Display Name" value="{{ $practice_details->display_name or '' }}" id="display_name" name="display_name" class="form-control">
</div>
</div>
<div class="col-lg-3 col-xs-12">
<div class="form-group">
<label for="legal_name">Legal/Trading Name</label>
<input type="text" placeholder="Legal/Trading Name" value="{{ $practice_details->legal_name or '' }}" id="legal_name" name="legal_name" class="form-control">
</div>
</div>
<div class="col-lg-3 col-xs-12">
<div class="form-group">
<label for="registration_no">Registration Number</label>
<input type="text" placeholder="Registration Number" value="{{ (isset($practice_details->registration_no) && $practice_details->registration_no != 0)?$practice_details->registration_no:'' }}" id="registration_no" name="registration_no" class="form-control">
</div>
</div>
<div class="col-lg-3 col-xs-12">
<div class="form-group">
<label>Organisation Type</label>
<select class="form-control" name="organisation_type_id" id="organisation_type_id">
    <option value="">--Select Organization Type--</option>
@if(!empty($org_types))
    @foreach($org_types as $key=>$org_row)
    <option value="{{ $org_row->organisation_id }}" {{ (isset($practice_details->organisation_type_id) && ($practice_details->organisation_type_id == $org_row->organisation_id))?'selected':'' }}>{{ $org_row->name }}</option>
    @endforeach
@endif
</select>
</div>
</div>
<div class="clearfix"></div>
</div>

</div>

<div class="practice_mid2">
<div class="row row_cont">

<div class="col-xs-12 col-xs-4">
    <div class="col_m2">
<button class="btn btn-success">Companies’ House login</button>
<h3 class="box-title"><!-- Sign in details--></h3> 
    <div class="form-group">
        <label for="exampleInputEmail1">User Name</label>
        <input type="text" placeholder="User Name" id="exampleInputEmail1" class="form-control">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="text" placeholder="Password" id="exampleInputPassword1" class="form-control">
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Presenter ID</label>
        <input type="text" placeholder="Enter Presenter ID" id="exampleInputEmail1" class="form-control">
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Presenter Authentication codes</label>
        <input type="text" placeholder="Enter Presenter Authentication codes" id="exampleInputEmail1" class="form-control">
    </div>

    </div>
</div>
 
<div class="col-xs-12 col-xs-4">
 <div class="col_m2">
<button class="btn btn-primary">HMRC Log In</button>
<h3 class="box-title"><!-- Sign in details --></h3>
<div class="form-group">
<label for="exampleInputEmail1">User Name</label>
<input type="text" placeholder="User Name" id="exampleInputEmail1" class="form-control">
</div>
<div class="form-group">
<label for="exampleInputPassword1">Password</label>
<input type="text" placeholder="Password" id="exampleInputPassword1" class="form-control">
</div>

<div class="form-group">
<label for="exampleInputEmail1">Gateway Agent Identifier</label>
<input type="text" placeholder="Gateway Agent Identifier" id="exampleInputEmail1" class="form-control">
</div>

</div>
 </div>
 
 <div class="col-xs-12 col-xs-4">
  <div class="col_m2">
<button class="btn btn-warning">Agent IDS</button>
<h3 class="box-title"><!-- Sign in details --></h3>
<div class="agent_left">
<div class="form-group">
<label for="exampleInputEmail1">Paye</label>
<input type="text" placeholder="Paye" id="exampleInputEmail1" class="form-control">
</div>
<div class="form-group">
<label for="exampleInputPassword1">VAT</label>
<input type="text" placeholder="Vat" id="exampleInputPassword1" class="form-control">
</div>
 </div>
 
 <div class="agent_right">
<div class="form-group">
<label for="exampleInputEmail1">CT</label>
<input type="text" placeholder="CT" id="exampleInputEmail1" class="form-control">
</div>
<div class="form-group">
<label for="exampleInputPassword1">SA</label>
<input type="text" placeholder="SA" id="exampleInputPassword1" class="form-control">
</div>
 </div>
 
 <div class="clearfix"></div>
 </div>
 </div>
 
 </div>

</div>

<div class="practice_mid2">
<div class="row row_cont">

 <h2>Contact Details</h2>
<div class="col-xs-12 col-xs-4">
 <div class="col_m1">
<h3 class="box-title">Registered Address</h3>
<div class="form-group">
<label for="reg_attention">Attention</label>
<input type="text" placeholder="Attention" value="{{ $practice_address['reg_attention'] or '' }}" id="reg_attention" name="reg_attention" class="form-control">
</div>
<div class="form-group">
<label for="reg_street_address">Street Address or PO Box</label>
<textarea placeholder="Street Address or PO Box" id="reg_street_address" name="reg_street_address" rows="3" class="form-control">{{ $practice_address['reg_street_address'] or ''}}</textarea>
</div>
<div class="form-group">
<label for="reg_city_id">Town/City</label>
<!-- <input type="text" placeholder="Town/City" value="{{ $practice_address['reg_city_name'] or '' }}" onKeyUp="ajaxSearchByCity(this.value, 'reg_city_id')" id="reg_city_id" name="reg_city_id" class="form-control"> 
<input type="hidden" name="hid_reg_city_id" id="hid_reg_city_id" value="{{ $practice_address['reg_city_id'] or '' }}">
<div class="drop_down_city" id="reg_city_id_div" style="display:none;">
    <ul id="reg_city_id_result"></ul>
</div>-->

<input type="text" placeholder="Town/City" name="reg_city" id="reg_city" value="{{ $practice_address['reg_city'] or '' }}" class="form-control">

</div>

<div class="form-group">
<label for="reg_state_id">State/Region</label>
<!-- <input type="text" placeholder="State/Region" value="{{ $practice_address['reg_state_name'] or '' }}" id="reg_state_id" name="reg_state_id" class="form-control">
<input type="hidden" name="hid_reg_state_id" id="hid_reg_state_id" value="{{ $practice_address['reg_state_id'] or '' }}"> -->
<input type="text" placeholder="State/Region" value="{{ $practice_address['reg_state'] or '' }}" id="reg_state" name="reg_state" class="form-control">
</div>

<div class="form-group">
<label for="reg_zip">Postal/Zip Code</label>
<input type="text" placeholder="Postal/Zip Code" value="{{ $practice_address['reg_zip'] or '' }}" id="reg_zip" name="reg_zip" class="form-control">
</div>

<div class="form-group">
<label for="reg_country_id">Country</label>
<!-- <input type="text" id="reg_country_id" value="United Kingdom" name="reg_country_id" class="form-control" disabled>
<input type="hidden" name="hid_reg_country_id" id="hid_reg_country_id" value="1"> -->
<select class="form-control" name="reg_country_id" id="reg_country_id">
    @if(!empty($countries))
      @foreach($countries as $key=>$country_row)
      @if(!empty($country_row->country_code) && $country_row->country_code == "GB")
        <option value="{{ $country_row->country_id }}">{{ $country_row->country_name }}</option>
      @endif
      @endforeach
    @endif
    @if(!empty($countries))
      @foreach($countries as $key=>$country_row)
      @if(!empty($country_row->country_code) && $country_row->country_code != "GB")
        <option value="{{ $country_row->country_id }}" {{ (isset($practice_address['phy_country_id']) && $country_row->country_id == $practice_address['reg_country_id'])?"selected":"" }}>{{ $country_row->country_name }}</option>
      @endif
      @endforeach
    @endif
  </select>
</div>
</div>
 </div>
 
 <div class="col-xs-12 col-xs-4">
 <div class="col_m1">
<h3 class="box-title t1_left">Physical Address</h3>
<p class="t1_right"><a href="javascript:void(0)" onClick="copyPostal()">Copy Postal</a></p>
<div class="clearfix"></div>
<div class="form-group">
<label for="phy_attention">Attention</label>
<input type="text" placeholder="Attention" value="{{ $practice_address['phy_attention'] or '' }}" id="phy_attention" name="phy_attention" class="form-control">
</div>
<div class="form-group">
<label for="phy_street_address">Street Address or PO Box</label>
<textarea placeholder="Street Address or PO Box" name="phy_street_address" id="phy_street_address" rows="3" class="form-control">{{ $practice_address['phy_street_address'] or ''}}</textarea>
</div>

<!-- <div class="form-group">
<label for="phy_city_id">Town/City</label>
<input type="text" placeholder="Town/City" value="{{ $practice_address['phy_city_name'] or '' }}" onKeyUp="ajaxSearchByCity(this.value, 'phy_city_id')" id="phy_city_id" name="phy_city_id" class="form-control">
<input type="hidden" name="hid_phy_city_id" id="hid_phy_city_id" value="{{ $practice_address['phy_city_id'] or '' }}">
<div class="drop_down_city" id="phy_city_id_div" style="display:none;">
    <ul id="phy_city_id_result"></ul>
</div>

</div> -->

<div class="form-group">
<label for="phy_city_id">Town/City</label>
<input type="text" placeholder="Town/City" value="{{ $practice_address['phy_city'] or '' }}" id="phy_city" name="phy_city" class="form-control">
</div>

<!-- <div class="form-group">
<label for="phy_state_id">State/Region</label>
<input type="text" placeholder="State/Region" value="{{ $practice_address['phy_state_name'] or ''}}" id="phy_state_id" name="phy_state_id" class="form-control">
<input type="hidden" name="hid_phy_state_id" id="hid_phy_state_id" value="{{ $practice_address['phy_state_id'] or '' }}">
</div> -->

<div class="form-group">
<label for="phy_state_id">State/Region</label>
<input type="text" placeholder="State/Region" value="{{ $practice_address['phy_state'] or ''}}" id="phy_state" name="phy_state" class="form-control">
</div>

<div class="form-group">
<label for="phy_zip">Postal/Zip Code</label>
<input type="text" placeholder="Postal/Zip Code" value="{{ $practice_address['phy_zip'] or '' }}" id="phy_zip" name="phy_zip" class="form-control">
</div>

<div class="form-group">
<label for="phy_country_id">Country</label>
<!-- <input type="text" value="United Kingdom" id="phy_country_id" name="phy_country_id" class="form-control" disabled>
<input type="hidden" name="hid_phy_country_id" id="hid_phy_country_id" value="1"> -->
<select class="form-control" name="phy_country_id" id="phy_country_id">
    @if(!empty($countries))
      @foreach($countries as $key=>$country_row)
      @if(!empty($country_row->country_code) && $country_row->country_code == "GB")
        <option value="{{ $country_row->country_id }}">{{ $country_row->country_name }}</option>
      @endif
      @endforeach
    @endif
    @if(!empty($countries))
      @foreach($countries as $key=>$country_row)
      @if(!empty($country_row->country_code) && $country_row->country_code != "GB")
        <option value="{{ $country_row->country_id }}"{{ (isset($practice_address['phy_country_id']) && $country_row->country_id == $practice_address['phy_country_id'])?"selected":"" }}>{{ $country_row->country_name }}</option>
      @endif
      @endforeach
    @endif
  </select>
</div>
</div>
 </div>


 
 <div class="col-xs-12 col-xs-4">
  <div class="col_m1">
 <div class="tel_cont">
<h3 class="box-title">Telephone</h3>
<div class="country_con">
<div class="form-group">
<label for="tel_country_code">Country</label>
<input type="text" placeholder="Country" value="{{ $practice_details['telephone_no'][0] or '' }}" id="tel_country_code" name="tel_country_code" class="form-control">
</div>
</div>
<div class="country_con">
<div class="form-group">
<label for="tel_area_code">Area</label>
<input type="text" placeholder="Area" value="{{ $practice_details['telephone_no'][1] or '' }}" id="tel_area_code" name="tel_area_code" class="form-control">
</div>
</div>
<div class="no_con">
<div class="form-group">
<label for="tel_number">Number</label>
<input type="text" placeholder="Number" value="{{ $practice_details['telephone_no'][2] or '' }}" id="tel_number" name="tel_number" class="form-control">
</div>
</div>
</div>
<div class="clearfix"></div> 
 <div class="tel_cont">
<h3 class="box-title">Fax</h3>
<div class="country_con">
<div class="form-group">
<label for="fax_country_code">Country</label>
<input type="text" placeholder="Country" value="{{ $practice_details['fax_no'][0] or '' }}" id="fax_country_code" name="fax_country_code" class="form-control">
</div>
</div>
<div class="country_con">
<div class="form-group">
<label for="fax_area_code">Area</label>
<input type="text" placeholder="Area" value="{{ $practice_details['fax_no'][1] or '' }}" id="fax_area_code" name="fax_area_code" class="form-control">
</div>
</div>
<div class="no_con">
<div class="form-group">
<label for="fax_number">Number</label>
<input type="text" placeholder="Number" value="{{ $practice_details['fax_no'][2] or '' }}" id="fax_number" name="fax_number" class="form-control">
</div>
</div>
</div>
<div class="clearfix"></div> 
 <div class="tel_cont">
<h3 class="box-title">Mobile</h3>
<div class="country_con">
<div class="form-group">
<label for="mob_country_code">Country</label>
<input type="text" placeholder="Country" value="{{ $practice_details['mobile_no'][0] or '' }}" id="mob_country_code" name="mob_country_code" class="form-control">
</div>
</div>
<div class="country_con">
<div class="form-group">
<label for="mob_area_code">Area</label>
<input type="text" placeholder="Area" value="{{ $practice_details['mobile_no'][1] or '' }}" id="mob_area_code" name="mob_area_code" class="form-control">
</div>
</div>
<div class="no_con">
<div class="form-group">
<label for="mob_number">Number</label>
<input type="text" placeholder="Number" value="{{ $practice_details['mobile_no'][2] or '' }}" id="mob_number" name="mob_number" class="form-control">
</div>
</div>
</div>

 <div class="clearfix"></div> 
 </div>
 <div class="save_con">
<!-- <button class="btn btn-warning" type="submit" name="save" id="save">Edit Physical Address</button> 
<button class="btn btn-primary" type="submit" name="save" id="save">Save</button>
<button class="btn btn-danger" type="reset" name="cancel" id="cancel">Cancel</button>-->
</div>
 </div>
 


 </div> 
 <div class="clearfix"></div> 
 </div>
 


                </section><!-- /.content -->
{{ Form::close() }}
            </aside><!-- /.right-side -->
        
  </div>

        <!-- ./wrapper -->     
@stop



