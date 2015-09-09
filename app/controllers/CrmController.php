<?php
class CrmController extends BaseController{
    public function __construct()
    {
        parent::__construct();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        if (empty($user_id)) {
            Redirect::to('/login');
        }
        if (isset($session['user_type']) && $session['user_type'] == "C") {
            Redirect::to('/client-portal')->send();
        }
    }

    public function index($page_open, $owner_id){
        $data['heading']= "CRM";
        $data['title']  = "Crm";
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        $value          = Session::get('show_archive_leads');
        if(isset($value) && $value == 'Y'){
            $data['archive'] = 'Show Archived';
        }else{
            $data['archive'] = 'Hide Archived';
        }

        $data['page_open']          = base64_decode($page_open);
        $data['encode_page_open']   = $page_open;
        $data['encode_owner_id']    = $owner_id;
        $data['owner_id']           = base64_decode($owner_id);
        $data['goto_url']           = "/crm";
        
        //echo "<pre>";print_r($data);die;
        $data['titles']         = Title::orderBy("title_id")->get();
        $data['countries']      = Country::orderBy('country_name')->get();
        $data['old_org_types']  = OrganisationType::where("client_type", "=", "all")->orderBy("name")->get();
        $data['new_org_types']  = OrganisationType::where("client_type", "=", "org")->whereIn("user_id", $groupUserId)->where("status", "=", "new")->orderBy("name")->get();
        $data['industry_lists'] = IndustryList::getIndustryList();
        $data['staff_details']  = User::getAllStaffDetails();
        $data['old_lead_sources']   = LeadSource::getOldLeadSource();
        $data['new_lead_sources']   = LeadSource::getNewLeadSource();
        $data['leads_tabs']         = CrmLeadsTab::getAllTabDetails();

        $data['invoice_leads_details']  = CrmLead::getInvoiceLeadsDetails();
        $data['leads_details']      = CrmLead::getAllDetails();
        $total    = 0;
        $average  = 0;
        $likely   = 0;
        if(isset($data['leads_details']) && count($data['leads_details']) >0){
            foreach ($data['leads_details'] as $key => $value) {
                $quoted_value = str_replace(",", "", $value['quoted_value']);
                $total += $quoted_value;
                $likely += ($value['deal_certainty']*$quoted_value)/100;
            }
            $average = $total/count($data['leads_details']);
        }
        $data['all_total']     = number_format($total, 2);
        $data['all_average']   = number_format($average, 2);
        $data['all_likely']    = number_format($likely, 2);
        //echo "<pre>";print_r($data['leads_details']);echo "</pre>";die;
        return View::make('crm.index', $data);
    }

    public function save_leads_data()
    {
        $data       = array();
        $session    = Session::get('admin_details'); 
        $user_id    = $session['id'];     

        $details    = Input::get();
        $encode_page_open   = $details['encode_page_open'];
        $encode_owner_id    = $details['encode_owner_id'];
        $type               = $details['type'];
        $leads_id           = $details['leads_id'];

        if($type == "ind"){
            $data['prospect_title'] = $details['prospect_title'];
            $data['prospect_fname'] = $details['prospect_fname'];
            $data['prospect_lname'] = $details['prospect_lname'];
        }else{
            $data['business_type']  = isset($details['business_type'])?$details['business_type']:"0";
            $data['prospect_name']  = $details['prospect_name'];
            $data['contact_title']  = $details['contact_title'];
            $data['contact_fname']  = $details['contact_fname'];
            $data['contact_lname']  = $details['contact_lname'];
        }
        $data['existing_client'] = isset($details['existing_client'])?$details['existing_client']:"0";
        $data['user_id']        = $user_id;
        $data['client_type']    = $details['type'];
        $data['date']           = $details['date'];
        $data['deal_certainty'] = $details['deal_certainty'];
        $data['deal_owner']     = isset($details['deal_owner'])?$details['deal_owner']:"0";
        $data['phone']          = $details['phone'];
        $data['mobile']         = $details['mobile'];
        $data['email']          = $details['email'];
        $data['website']        = $details['website'];
        $data['annual_revenue'] = $details['annual_revenue'];
        $data['quoted_value']   = $details['quoted_value'];
        $data['lead_source']    = isset($details['lead_source'])?$details['lead_source']:"0";
        $data['industry']       = isset($details['industry'])?$details['industry']:"0";
        $data['street']         = $details['street'];
        $data['city']           = $details['city'];
        $data['county']         = $details['county'];
        $data['postal_code']    = $details['postal_code'];
        $data['country_id']     = isset($details['country_id'])?$details['country_id']:"0";
        $data['notes']          = $details['notes'];
        
        if($leads_id == 0){
            $last_id = CrmLead::insertGetId($data);
            $leadstatus['user_id']      = $user_id;
            $leadstatus['leads_id']     = $last_id;
            $leadstatus['leads_tab_id'] = 2;
            $leadstatus['created']      = date("Y-m-d H:i:s");
            CrmLeadsStatus::insert($leadstatus);
        }else{
            CrmLead::where('leads_id', '=', $leads_id)->update($data);
        }
        
        return Redirect::to('/crm/'.$encode_page_open.'/'.$encode_owner_id);
        //print_r($data);die;
    }

    public function add_new_source()
    {
        $session             = Session::get('admin_details');
        $user_id             = $session['id'];
        $data['user_id']     = $user_id;
        $data['status']      = "new";
        $data['is_show']     = Input::get("modal_type");
        $data['source_name'] = Input::get("source_name");
        $last_id = LeadSource::insertGetId($data);
        echo $last_id;
    }

    public function delete_source_name()
    {
        $source_id = Input::get("field_id");
        LeadSource::where("source_id", "=", $source_id)->delete();
        echo $source_id;
    }

    public function get_form_dropdown()
    {
        $data = array();
        $client_data    = array();
        $leads_details  = array();
        $leads_details['date'] = date("d-m-Y");
        $type       = Input::get("type");
        $leads_id   = Input::get("leads_id");

        //======== Client Details ========//
        if($type == "ind"){
            $existing_clients  = Client::getAllIndClientDetails();
            if(isset($existing_clients) && count($existing_clients) >0){
                foreach ($existing_clients as $key => $value) {
                    $client_data[$key]['client_id']    = $value['client_id'];
                    $client_data[$key]['client_name']  = $value['client_name'];
                }
            }
        }else{
            $existing_clients  = Client::getAllOrgClientDetails();
            if(isset($existing_clients) && count($existing_clients) >0){
                foreach ($existing_clients as $key => $value) {
                    $client_data[$key]['client_id']    = $value['client_id'];
                    $client_data[$key]['client_name']  = $value['business_name'];
                }
            }
        }

        if(isset($client_data) && count($client_data) >0){
            foreach ($client_data as $value){
            $client_name[]  = strtolower($value['client_name']);
            } 
            array_multisort($client_name, SORT_ASC, $client_data);
        }
        //======== Client Details ========//
        

        if($leads_id != '0'){
            $leads_details = CrmLead::getLeadsByLeadsId($leads_id);
        }else{
            $leads_details['deal_certainty'] = 100;
        }
        
        $data['leads_details']      = $leads_details;
        $data['existing_clients']   = $client_data;

        echo json_encode($data);
    }

    public function save_edit_status()
    {
        $data = array();
        $step_id        = Input::get('step_id');
        $type           = Input::get('type');
        if(isset($type) && $type == "title"){
            $data['tab_name'] = Input::get("status_name");
            $title = $data['tab_name'];
        }else{
            $value = CrmLeadsTab::where("tab_id", "=", $step_id)->first();
            if($value['status'] == "S"){
                $data['status'] = "H";
            }else{
                $data['status'] = "S";
            }
            $title = $value['tab_name'];
        }
        $sql = CrmLeadsTab::where("tab_id", "=", $step_id)->update($data);
        
        echo $title;
        exit;
    }

    public function delete_leads_details()
    {
        $leads_ids  = Input::get('leads_delete_id');
        foreach ($leads_ids as $leads_id) {
            CrmLead::where('leads_id', '=', $leads_id)->update(array('is_deleted'=>'Y'));
            CrmLeadsStatus::where('leads_id', '=', $leads_id)->delete();
        }
    }
    
    public function sendto_another_tab()
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];

        $data['leads_tab_id']   = Input::get('tab_id');
        $data['leads_id']       = Input::get('leads_id');
        $data['user_id']        = $user_id;

        if($data['leads_tab_id'] == 12){
            CrmLead::where('leads_id', '=', $data['leads_id'])->update(array('is_invoiced'=>'Y'));
            $last_id = $data['leads_id'];
        }else{
            $leads_status = CrmLeadsStatus::getDetailsByLeadsId( $data['leads_id'] );
            if(isset($leads_status) && count($leads_status) >0){
                CrmLeadsStatus::where("leads_status_id", "=", $leads_status['leads_status_id'])->update($data);
                $last_id = $leads_status['leads_status_id'];
            }else{
                $data['created'] = date("Y-m-d H:i:s");
                $last_id = CrmLeadsStatus::insertGetId($data);
            }
        }
        echo $last_id;
    }

    public function get_client_address()
    {
        $data = array();
        $client_id      = Input::get('client_id');
        $client_type    = Input::get('client_type');
        $details = Common::clientDetailsById($client_id);
        if($client_type == "org"){
            $type = "corres";
            $data['address'] = ContactAddress::getClientContactAddress($client_id, $type);
            if(isset($details['business_name'])){
                $data['address']['business_name'] = $details['business_name'];
            }
            if(isset($details['business_type'])){
                if(strtolower($details['business_type']) == "llp"){
                    $business_type = 1;
                }
                if(strtolower($details['business_type']) == "company"){
                    $business_type = 2;
                }
                if(strtolower($details['business_type']) == "partnership"){
                    $business_type = 3;
                }
                if(strtolower($details['business_type']) == "sole trader"){
                    $business_type = 4;
                }
                $data['address']['business_type'] = $business_type;
            }
            if(isset($details['corres_cont_name'])){
                $name = explode(" ", $details['corres_cont_name']);
                $data['address']['contact_fname'] = isset($name[0])?$name[0]:"";
                $data['address']['contact_lname'] = isset($name[1])?$name[1]:"";
            }
        }else{
            $type = "res";
            $data['address'] = ContactAddress::getClientContactAddress($client_id, $type);
            if(isset($details['title'])){
                $data['address']['prospect_title'] = $details['title'];
            }
            if(isset($details['fname'])){
                $data['address']['prospect_fname'] = $details['fname'];
            }
            if(isset($details['lname'])){
                $data['address']['prospect_lname'] = $details['lname'];
            }
            
        }
        //print_r($data);
        
        echo json_encode($data);
        exit;
    }

    public function show_graph()
    {
        $data = array();
        $from_date  = Input::get('from_date');
        $to_date    = Input::get('to_date');
        $divided_by = 10000;

        $details = CrmLead::getDataWithDateRange($from_date, $to_date);
        $jan_total = $feb_total = $mar_total = $apr_total = $may_total = $jun_total = $jul_total = $aug_total = $sep_total = $oct_total = $nov_total = $dec_total = 0;
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $date = explode("-", $value['date']);
                $month = $date[1];
                if($month == "01"){
                    $jan_total += $value['quoted_value'];
                    //$jan_won += $value['quoted_value'];
                }
                if($month == "02"){
                    $feb_total += $value['quoted_value'];
                }
                if($month == "03"){
                    $mar_total += $value['quoted_value'];
                }
                if($month == "04"){
                    $apr_total += $value['quoted_value'];
                }
                if($month == "05"){
                    $may_total += $value['quoted_value'];
                }
                if($month == "06"){
                    $jun_total += $value['quoted_value'];
                }
                if($month == "07"){
                    $jul_total += $value['quoted_value'];
                }
                if($month == "08"){
                    $aug_total += $value['quoted_value'];
                }
                if($month == "09"){
                    $sep_total += $value['quoted_value'];
                }
                if($month == "10"){
                    $oct_total += $value['quoted_value'];
                }
                if($month == "11"){
                    $nov_total += $value['quoted_value'];
                }
                if($month == "12"){
                    $dec_total += $value['quoted_value'];
                }
            }
        }
        $data['jan_total'] = $jan_total/$divided_by;
        $data['feb_total'] = $feb_total/$divided_by;
        $data['mar_total'] = $mar_total/$divided_by;
        $data['apr_total'] = $apr_total/$divided_by;
        $data['may_total'] = $may_total/$divided_by;
        $data['jun_total'] = $jun_total/$divided_by;
        $data['jul_total'] = $jul_total/$divided_by;
        $data['aug_total'] = $aug_total/$divided_by;
        $data['sep_total'] = $sep_total/$divided_by;
        $data['oct_total'] = $oct_total/$divided_by;
        $data['nov_total'] = $nov_total/$divided_by;
        $data['dec_total'] = $dec_total/$divided_by;
        //print_r($data);
        //Common::last_query();
        echo view::make("crm/ajax.graph", $data);
    }

    public function archive_leads() {
        Session::put('show_archive_leads', 'Y');

        $leads_ids = Input::get("leads_ids");
        $status     = Input::get("status");
        //print_r($clients_id);die;
        foreach ($leads_ids as $leads_id) {
            if($status == "Archive"){
                $up_data['is_archive']      = 'Y';
                $up_data['show_archive']    = 'Y';
            }else{
                $up_data['is_archive']      = 'N';
                $up_data['show_archive']    = 'N';
            }
            CrmLead::where('leads_id', '=', $leads_id)->update($up_data);
        }
    }

    public function show_archive_leads() {
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        $groupUserId = $session['group_users'];
        
        $is_archive = Input::get("is_archive");
        if($is_archive == "Y"){
            Session::put('show_archive_leads', 'Y');
        }else{
            Session::put('show_archive_leads', 'N');
        }

        $affected = CrmLead::whereIn("user_id", $groupUserId)->where("show_archive", "=", "Y")->update(array("is_archive"=>$is_archive));
        //echo $this->last_query();die;
    }
    
    
    

}
