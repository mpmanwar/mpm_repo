<?php
class CrmLead extends Eloquent {

	public $timestamps = false;
	
	public static function getAllDetails()
    {
    	$data = array();
    	$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
		$crm_data = CrmLead::whereIn("user_id", $groupUserId)->get();
		if(isset($crm_data) && count($crm_data) >0){
			foreach ($crm_data as $key => $details) {
				$data[$key]['prospect_title'] = $details->prospect_title;
            	$data[$key]['prospect_fname'] = $details->prospect_fname;
            	$data[$key]['prospect_lname'] = $details->prospect_lname;
            	$data[$key]['business_type']  = $details->business_type;
	            $data[$key]['prospect_name']  = $details->prospect_name;
	            $data[$key]['contact_title']  = $details->contact_title;
	            $data[$key]['contact_fname']  = $details->contact_fname;
	            $data[$key]['contact_lname']  = $details->contact_lname;
				$data[$key]['user_id']        = $details->user_id;
		        $data[$key]['type']    		= $details->type;
		        $data[$key]['deal_certainty'] = $details->deal_certainty;
		        $data[$key]['deal_owner']     = $details->deal_owner;
		        $data[$key]['phone']          = $details->phone;
		        $data[$key]['mobile']         = $details->mobile;
		        $data[$key]['email']          = $details->email;
		        $data[$key]['website']        = $details->website;
		        $data[$key]['annual_revenue'] = $details->annual_revenue;
		        $data[$key]['quoted_value']   = $details->quoted_value;
		        $data[$key]['lead_source']    = $details->lead_source;
		        $data[$key]['industry']       = $details->industry;
		        $data[$key]['street']         = $details->street;
		        $data[$key]['city']           = $details->city;
		        $data[$key]['province']       = $details->province;
		        $data[$key]['postal_code']    = $details->postal_code;
		        $data[$key]['country_id']     = $details->country_id;
		        $data[$key]['notes']          = $details->notes;
			}
		}
		//print_r($data);die;
		return $data;
    }


}
