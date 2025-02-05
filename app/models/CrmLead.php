<?php
class CrmLead extends Eloquent {

	public $timestamps = false;
	
	public static function getAllOpportunity()
    {
    	$data = array();
    	$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
		$crm_data 		= CrmLead::whereIn("user_id", $groupUserId)->where("leads_type", "=", "O")->where("is_deleted", "=", "N")->where("is_archive", "=", "N")->get();

		if(isset($crm_data) && count($crm_data) >0){
			foreach ($crm_data as $key => $details) {
				$data[$key]['leads_id']       = $details->leads_id;
				$data[$key]['leads_type']     = $details->leads_type;
				$data[$key]['user_id']        = $details->user_id;
				$data[$key]['client_type']    = $details->client_type;
				$data[$key]['date']    		  = date('d-m-Y', strtotime($details->date));
				$data[$key]['deal_certainty'] = $details->deal_certainty;
				$data[$key]['existing_client']= $details->existing_client;
		        $data[$key]['deal_owner']     = User::getStaffNameById($details->deal_owner);
		        $data[$key]['phone']          = $details->phone;
		        $data[$key]['mobile']         = $details->mobile;
		        $data[$key]['email']          = $details->email;
		        $data[$key]['website']        = $details->website;
				$data[$key]['prospect_title'] = $details->prospect_title;
            	$data[$key]['prospect_fname'] = $details->prospect_fname;
            	$data[$key]['prospect_lname'] = $details->prospect_lname;
            	$data[$key]['business_type']  = $details->business_type;
	            $data[$key]['prospect_name']  = $details->prospect_name;
	            $data[$key]['contact_title']  = $details->contact_title;
	            $data[$key]['contact_fname']  = $details->contact_fname;
	            $data[$key]['contact_lname']  = $details->contact_lname;
				$data[$key]['annual_revenue'] = $details->annual_revenue;
		        $data[$key]['quoted_value']   = $details->quoted_value;
		        $data[$key]['lead_source']    = $details->lead_source;
		        $data[$key]['source_name']	  = LeadSource::getLeadSourceName($details->lead_source);
		        $data[$key]['industry']       = $details->industry;
		        $data[$key]['street']         = $details->street;
		        $data[$key]['city']           = $details->city;
		        $data[$key]['county']         = $details->county;
		        $data[$key]['postal_code']    = $details->postal_code;
		        $data[$key]['country_id']     = $details->country_id;
		        $data[$key]['notes']          = $details->notes;
		        $data[$key]['close_date']     = (isset($details->close_date) && $details->close_date != '0000-00-00')?date('d-m-Y', strtotime($details->close_date)):'0000-00-00';
		        $data[$key]['is_invoiced']    = $details->is_invoiced;
		        $data[$key]['is_archive']     = $details->is_archive;
		        $data[$key]['show_archive']   = $details->show_archive;
		        $data[$key]['is_onboarding']  = $details->is_onboarding;
		        $data[$key]['lead_status']    = CrmLeadsStatus::getTabIdByLeadsId( $details->leads_id );
			}
		}
		//echo "<pre>";print_r($data);echo "</pre>";die;
		return $data;
    }

    public static function getAllLeads()
    {
    	$data = array();
    	$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
		$crm_data 		= CrmLead::whereIn("user_id", $groupUserId)->where("leads_type", "=", "L")->where("is_deleted", "=", "N")->where("is_archive", "=", "N")->get();

		if(isset($crm_data) && count($crm_data) >0){
			foreach ($crm_data as $key => $details) {
				$data[$key]['leads_id']       = $details->leads_id;
				$data[$key]['leads_type']     = $details->leads_type;
				$data[$key]['user_id']        = $details->user_id;
				$data[$key]['client_type']    = $details->client_type;
				$data[$key]['date']    		  = date('d-m-Y', strtotime($details->date));
				$data[$key]['deal_certainty'] = $details->deal_certainty;
				$data[$key]['existing_client']= $details->existing_client;
		        $data[$key]['deal_owner']     = User::getStaffNameById($details->deal_owner);
		        $data[$key]['phone']          = $details->phone;
		        $data[$key]['mobile']         = $details->mobile;
		        $data[$key]['email']          = $details->email;
		        $data[$key]['website']        = $details->website;
				$data[$key]['prospect_title'] = $details->prospect_title;
            	$data[$key]['prospect_fname'] = $details->prospect_fname;
            	$data[$key]['prospect_lname'] = $details->prospect_lname;
            	$data[$key]['business_type']  = $details->business_type;
	            $data[$key]['prospect_name']  = $details->prospect_name;
	            $data[$key]['contact_title']  = $details->contact_title;
	            $data[$key]['contact_fname']  = $details->contact_fname;
	            $data[$key]['contact_lname']  = $details->contact_lname;
				$data[$key]['annual_revenue'] = $details->annual_revenue;
		        $data[$key]['quoted_value']   = $details->quoted_value;
		        $data[$key]['lead_source']    = $details->lead_source;
		        $data[$key]['source_name']	  = LeadSource::getLeadSourceName($details->lead_source);
		        $data[$key]['industry']       = $details->industry;
		        $data[$key]['street']         = $details->street;
		        $data[$key]['city']           = $details->city;
		        $data[$key]['county']         = $details->county;
		        $data[$key]['postal_code']    = $details->postal_code;
		        $data[$key]['country_id']     = $details->country_id;
		        $data[$key]['notes']          = $details->notes;
		        $data[$key]['close_date']     = (isset($details->close_date) && $details->close_date != '0000-00-00')?date('d-m-Y', strtotime($details->close_date)):'0000-00-00';
		        $data[$key]['is_invoiced']    = $details->is_invoiced;
		        $data[$key]['is_archive']     = $details->is_archive;
		        $data[$key]['show_archive']   = $details->show_archive;
		        $data[$key]['is_onboarding']  = $details->is_onboarding;
		        $data[$key]['lead_status']    = CrmLeadsStatus::getTabIdByLeadsId( $details->leads_id );
			}
		}
		//echo "<pre>";print_r($data);echo "</pre>";die;
		return $data;
    }

    public static function getInvoiceLeadsDetails()
    {
    	$data = array();
    	$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
		$crm_data = CrmLead::whereIn("user_id", $groupUserId)->where("is_invoiced", "=", "Y")->where("is_archive", "=", "N")->get();
		if(isset($crm_data) && count($crm_data) >0){
			foreach ($crm_data as $key => $details) {
				$data[$key]['leads_id']       = $details->leads_id;
				$data[$key]['leads_type']     = $details->leads_type;
				$data[$key]['user_id']        = $details->user_id;
				$data[$key]['client_type']    = $details->client_type;
				$data[$key]['date']    		  = date('d-m-Y', strtotime($details->date));
				$data[$key]['deal_certainty'] = $details->deal_certainty;
				$data[$key]['existing_client']= $details->existing_client;
		        $data[$key]['deal_owner']     = User::getStaffNameById($details->deal_owner);
		        $data[$key]['phone']          = $details->phone;
		        $data[$key]['mobile']         = $details->mobile;
		        $data[$key]['email']          = $details->email;
		        $data[$key]['website']        = $details->website;
				$data[$key]['prospect_title'] = $details->prospect_title;
            	$data[$key]['prospect_fname'] = $details->prospect_fname;
            	$data[$key]['prospect_lname'] = $details->prospect_lname;
            	$data[$key]['business_type']  = $details->business_type;
	            $data[$key]['prospect_name']  = $details->prospect_name;
	            $data[$key]['contact_title']  = $details->contact_title;
	            $data[$key]['contact_fname']  = $details->contact_fname;
	            $data[$key]['contact_lname']  = $details->contact_lname;
				$data[$key]['annual_revenue'] = $details->annual_revenue;
		        $data[$key]['quoted_value']   = $details->quoted_value;
		        $data[$key]['lead_source']    = $details->lead_source;
		        $data[$key]['source_name']	  = LeadSource::getLeadSourceName($details->lead_source);
		        $data[$key]['industry']       = $details->industry;
		        $data[$key]['street']         = $details->street;
		        $data[$key]['city']           = $details->city;
		        $data[$key]['county']         = $details->county;
		        $data[$key]['postal_code']    = $details->postal_code;
		        $data[$key]['country_id']     = $details->country_id;
		        $data[$key]['notes']          = $details->notes;
		        $data[$key]['close_date']     = (isset($details->close_date) && $details->close_date != '0000-00-00')?date('d-m-Y', strtotime($details->close_date)):'0000-00-00';
		        $data[$key]['is_invoiced']    = $details->is_invoiced;
		        $data[$key]['is_archive']     = $details->is_archive;
		        $data[$key]['show_archive']   = $details->show_archive;
		        $data[$key]['is_onboarding']  = $details->is_onboarding;
		        $data[$key]['lead_status']    = CrmLeadsStatus::getTabIdByLeadsId( $details->leads_id );
			}
		}
		//echo "<pre>";print_r($data);echo "</pre>";die;
		return $data;
    }

    public static function getDataWithDateRange($from_date, $to_date)
    {
    	$data = array();
    	$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
		$crm_data = CrmLead::whereIn("user_id", $groupUserId)->whereBetween('date', array($from_date, $to_date))->where("is_deleted", "=", "N")->where("close_date", "!=", "0000-00-00")->where("is_archive", "=", "N")->get();
		//Common::last_query();
		if(isset($crm_data) && count($crm_data) >0){
			foreach ($crm_data as $key => $details) {
				$data[$key]['leads_id']       = $details->leads_id;
				$data[$key]['leads_type']     = $details->leads_type;
				$data[$key]['user_id']        = $details->user_id;
				$data[$key]['client_type']    = $details->client_type;
				$data[$key]['date']    		  = date('d-m-Y', strtotime($details->date));
				$data[$key]['deal_certainty'] = $details->deal_certainty;
				$data[$key]['existing_client']	  = $details->existing_client;
		        $data[$key]['deal_owner']     = User::getStaffNameById($details->deal_owner);
		        $data[$key]['deal_owner_id']  = $details->deal_owner;
		        $data[$key]['phone']          = $details->phone;
		        $data[$key]['mobile']         = $details->mobile;
		        $data[$key]['email']          = $details->email;
		        $data[$key]['website']        = $details->website;
				$data[$key]['prospect_title'] = $details->prospect_title;
            	$data[$key]['prospect_fname'] = $details->prospect_fname;
            	$data[$key]['prospect_lname'] = $details->prospect_lname;
            	$data[$key]['business_type']  = $details->business_type;
	            $data[$key]['prospect_name']  = $details->prospect_name;
	            $data[$key]['contact_title']  = $details->contact_title;
	            $data[$key]['contact_fname']  = $details->contact_fname;
	            $data[$key]['contact_lname']  = $details->contact_lname;
				$data[$key]['annual_revenue'] = $details->annual_revenue;
		        $data[$key]['quoted_value']   = $details->quoted_value;
		        $data[$key]['lead_source']    = $details->lead_source;
		        $data[$key]['source_name']	  = LeadSource::getLeadSourceName($details->lead_source);
		        $data[$key]['industry']       = $details->industry;
		        $data[$key]['street']         = $details->street;
		        $data[$key]['city']           = $details->city;
		        $data[$key]['county']         = $details->county;
		        $data[$key]['postal_code']    = $details->postal_code;
		        $data[$key]['country_id']     = $details->country_id;
		        $data[$key]['notes']          = $details->notes;
		        $data[$key]['close_date']     = (isset($details->close_date) && $details->close_date != '0000-00-00')?date('d-m-Y', strtotime($details->close_date)):'0000-00-00';
		        $data[$key]['is_invoiced']    = $details->is_invoiced;
		        $data[$key]['is_archive']     = $details->is_archive;
		        $data[$key]['show_archive']   = $details->show_archive;
		        $data[$key]['is_onboarding']  = $details->is_onboarding;
		        $data[$key]['lead_status']    = CrmLeadsStatus::getTabIdByLeadsId( $details->leads_id );
			}
		}
		//echo "<pre>";print_r($data);echo "</pre>";die;
		return $data;
    }

    public static function getDataWithDateRangeAndLeadsId($from_date, $to_date, $leads_id)
    {
    	$data = array();
    	$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
		$crm_data = CrmLead::whereIn("user_id", $groupUserId)->whereBetween('date', array($from_date, $to_date))->where("is_deleted", "=", "N")->where("is_archive", "=", "N")->where("leads_id", "=", $leads_id)->get();
		//Common::last_query();
		if(isset($crm_data) && count($crm_data) >0){
			foreach ($crm_data as $key => $details) {
				$data[$key]['leads_id']       = $details->leads_id;
				$data[$key]['leads_type']     = $details->leads_type;
				$data[$key]['user_id']        = $details->user_id;
				$data[$key]['client_type']    = $details->client_type;
				$data[$key]['date']    		  = date('d-m-Y', strtotime($details->date));
				$data[$key]['deal_certainty'] = $details->deal_certainty;
				$data[$key]['existing_client']	  = $details->existing_client;
		        $data[$key]['deal_owner']     = User::getStaffNameById($details->deal_owner);
		        $data[$key]['phone']          = $details->phone;
		        $data[$key]['mobile']         = $details->mobile;
		        $data[$key]['email']          = $details->email;
		        $data[$key]['website']        = $details->website;
				$data[$key]['prospect_title'] = $details->prospect_title;
            	$data[$key]['prospect_fname'] = $details->prospect_fname;
            	$data[$key]['prospect_lname'] = $details->prospect_lname;
            	$data[$key]['business_type']  = $details->business_type;
	            $data[$key]['prospect_name']  = $details->prospect_name;
	            $data[$key]['contact_title']  = $details->contact_title;
	            $data[$key]['contact_fname']  = $details->contact_fname;
	            $data[$key]['contact_lname']  = $details->contact_lname;
				$data[$key]['annual_revenue'] = $details->annual_revenue;
		        $data[$key]['quoted_value']   = $details->quoted_value;
		        $data[$key]['lead_source']    = $details->lead_source;
		        $data[$key]['source_name']	  = LeadSource::getLeadSourceName($details->lead_source);
		        $data[$key]['industry']       = $details->industry;
		        $data[$key]['street']         = $details->street;
		        $data[$key]['city']           = $details->city;
		        $data[$key]['county']         = $details->county;
		        $data[$key]['postal_code']    = $details->postal_code;
		        $data[$key]['country_id']     = $details->country_id;
		        $data[$key]['notes']          = $details->notes;
		        $data[$key]['close_date']     = (isset($details->close_date) && $details->close_date != '0000-00-00')?date('d-m-Y', strtotime($details->close_date)):'0000-00-00';
		        $data[$key]['is_invoiced']    = $details->is_invoiced;
		        $data[$key]['is_archive']     = $details->is_archive;
		        $data[$key]['show_archive']   = $details->show_archive;
		        $data[$key]['is_onboarding']  = $details->is_onboarding;
		        $data[$key]['lead_status']    = CrmLeadsStatus::getTabIdByLeadsId( $details->leads_id );
			}
		}
		//echo "<pre>";print_r($data);echo "</pre>";die;
		return $data;
    }

    public static function getLeadsByLeadsId( $leads_id )
    {
    	$data = array();
    	$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
		$details = CrmLead::where("leads_id", "=", $leads_id)->where("is_deleted", "=", "N")->where("is_archive", "=", "N")->first();
		if(isset($details) && count($details) >0){
			$data['leads_id']       = $details->leads_id;
			$data['leads_type']     = $details->leads_type;
			$data['user_id']        = $details->user_id;
			$data['existing_client']= $details->existing_client;
			$data['client_type']    = $details->client_type;
			$data['date'] 			= date('d-m-Y', strtotime($details->date));
			$data['deal_certainty'] = $details->deal_certainty;
			$data['deal_owner']     = $details->deal_owner;
	        $data['phone']          = $details->phone;
	        $data['mobile']         = $details->mobile;
	        $data['email']          = $details->email;
	        $data['website']        = $details->website;
			$data['prospect_title'] = $details->prospect_title;
        	$data['prospect_fname'] = $details->prospect_fname;
        	$data['prospect_lname'] = $details->prospect_lname;
        	$data['business_type']  = $details->business_type;
            $data['prospect_name']  = $details->prospect_name;
            $data['contact_title']  = $details->contact_title;
            $data['contact_fname']  = $details->contact_fname;
            $data['contact_lname']  = $details->contact_lname;
			$data['annual_revenue'] = $details->annual_revenue;
	        $data['quoted_value']   = $details->quoted_value;
	        $data['lead_source']    = $details->lead_source;
	        $data['source_name']	  = LeadSource::getLeadSourceName($details->lead_source);
	        $data['industry']       = $details->industry;
	        $data['street']         = $details->street;
	        $data['city']           = $details->city;
	        $data['county']         = $details->county;
	        $data['postal_code']    = $details->postal_code;
	        $data['country_id']     = $details->country_id;
	        $data['notes']          = $details->notes;
	        $data['close_date']     = (isset($details->close_date) && $details->close_date != '0000-00-00')?date('d-m-Y', strtotime($details->close_date)):'0000-00-00';
	        $data['is_invoiced']    = $details->is_invoiced;
	        $data['is_archive']     = $details->is_archive;
		    $data['show_archive']   = $details->show_archive;
		    $data['is_onboarding']  = $details->is_onboarding;
		}
		//echo "<pre>";print_r($data);echo "</pre>";die;
		return $data;
    }

    public static function getLeadsCount()
    {
    	$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
		$crm_count = CrmLead::whereIn("user_id", $groupUserId)->where("is_deleted", "=", "N")->where("is_archive", "=", "N")->get()->count();
		return $crm_count;
    }

    public static function getTotalQuotedValue( $leads_tab_id )
    {
    	$data = array();
    	$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
		$status_details = CrmLeadsStatus::leadsStatusByTabId($leads_tab_id);

		if(isset($status_details) && count($status_details) >0){
			$total    = 0;
	        $average  = 0;
	        $likely   = 0;
			foreach ($status_details as $key => $value) {
				$crn_lead = CrmLead::where("leads_id", "=", $value['leads_id'])->where("is_deleted", "=", "N")->where("is_archive", "=", "N")->first();
				if(isset($crn_lead->quoted_value) && $crn_lead->quoted_value != ""){
					$quoted_value = str_replace(",", "", $crn_lead->quoted_value);
					$total += $quoted_value;
					$likely += ($crn_lead->deal_certainty*$quoted_value)/100;
				}
				$average = $total/count($status_details);
			}
			/*$data['total']     = number_format($total, 2, '.', '');
	        $data['average']   = number_format($average, 2, '.', '');
	        $data['likely']    = number_format($likely, 2, '.', '');*/
	        $data['total']     	= number_format($total, 2);
	        $data['average']   	= number_format($average, 2);
	        $data['likely']    	= number_format($likely, 2);
	    }

		return $data;
    }

    public static function getLeadsTypeByLeadsId($leads_id)
    {
    	$leads_type = CrmLead::where("leads_id", "=", $leads_id)->select('leads_type')->first();
		return $leads_type['leads_type'];
    }

    public static function getCompanyNumber($company_name)
	{
		$company_number = 0;
        $value = str_replace(" ", "+", $company_name);
        $compamy_details    = Common::getSearchCompany($value);
        if(isset($compamy_details->items) && count($compamy_details->items) >0 )
        {
            foreach ($compamy_details->items as $key => $value) {//return $company_name;die;
                //$company[$key]['company_name']      = $value->title;
                //$company[$key]['company_number']    = $value->company_number;
                $comp_name = str_replace("+", " ", $company_name);
                if(strtolower($company_name) == strtolower($value->title)){
                	$company_number = $value->company_number;
                }
            }
        }

        return $company_number;
	}

	public static function updateCrmLeadsStatus($client_id, $data)
	{
		$crm_leads = Client::where('client_id', '=', $client_id)->select('crm_leads_id')->first();
		if(isset($crm_leads['crm_leads_id']) && $crm_leads['crm_leads_id'] != 0){
			CrmLead::where('leads_id', '=', $crm_leads['crm_leads_id'])->update($data);
		}
	}



}
