<?php
class ContactsLettersEmailsController extends BaseController {
	public function __construct()
	{
		parent::__construct();
	    $session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		if (empty($user_id)) {
			Redirect::to('/login');
		}
		if (isset($session['user_type']) && $session['user_type'] == "C") {
			Redirect::to('/client-portal')->send();
		}
	}
	
	public function index($step_id, $address_type)
	{ 
		$data = array();
		$org_data 		= array();
		$data['title'] 		= 'Contacts Letters & Emails';
	$data['step_id'] 	= $step_id;
		$data['address_type'] 	= base64_decode($address_type);
		$data['encoded_type'] 	= $address_type; 
		$data['heading'] 		= "CONTACTS, LETTERS & EMAILS";
		$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId 	= $session['group_users'];

		if (empty($user_id)) {
			return Redirect::to('/');
		}
		$org_count 		= 0;
		$ind_count 		= 0;
		$staff_count 	= 0;
		$other_count 	= 0;

		if($step_id == 1){
			$org_details = Client::getAllOrgClientDetails();
			if(isset($org_details) && count($org_details) >0){
				foreach ($org_details as $key => $client_row) {
					//$org_details[$key]['contact_name'] 	= $this->getContactNameDropdown($client_row);
					$org_details[$key]['other_details'] = ContactAddress::getContactAddressByType($client_row['client_id'], $data['address_type']);
					$org_details[$key]['notes']	= ContactsNote::getNotes($client_row['client_id'], 'org');

					$org_count++;
				}
				$data['org_details'] = $org_details;
			}
		}else if($step_id == 2){
			$ind_details = Client::getAllIndClientDetails();
			if(isset($ind_details) && count($ind_details) >0){
				foreach ($ind_details as $key => $client_row) {
					$ind_details[$key]['notes']	= ContactsNote::getNotes($client_row['client_id'], 'ind');

					$ind_count++;
				}
				$data['ind_details'] = $ind_details;
			}
		}else if($step_id == 3){
			$data['staff_details'] = User::getAllStaffDetails();
		}else if($step_id == 4){
			$data['contact_details'] = ContactAddress::getAllContactDetails();
		}else{
			$data['group_details'] 	= ContactAddress::getGroupContactDetails($step_id);
		}
		

		$data['steps'] = ContactsStep::getAllSteps($org_count, $ind_count, $staff_count, $other_count);
		$data['countries'] 	= Country::orderBy('country_name')->get();
		$data['address_types'] 	= AddressType::getAllAddressDetails();
		$data['all_address'] 	= ContactAddress::getAllContactAddress();


		//echo "<pre>";print_r($data['group_details']);echo "</pre>";die;
		return View::make('contacts_letters.index', $data);
	}

	public function getContactNameDropdown($details)
	{
		$data = array();
		if(isset($details) && count($details) >0)
		{
			$i = 0;
			if(isset($details['trad_cont_name']) && $details['trad_cont_name'] != ""){
				$data[$i]['name'] = $details['trad_cont_name'];
				$i++;
			}
			if(isset($details['reg_cont_name']) && $details['reg_cont_name']!= ""){
				$data[$i]['name'] = $details['reg_cont_name'];
				$i++;
			}
			if(isset($details['corres_cont_name']) && $details['corres_cont_name']!= ""){
				$data[$i]['name'] = $details['corres_cont_name'];
				$i++;
			}
			if(isset($details['banker_cont_name']) && $details['banker_cont_name']!= ""){
				$data[$i]['name'] = $details['banker_cont_name'];
				$i++;
			}
			if(isset($details['oldacc_cont_name']) && $details['oldacc_cont_name']!= ""){
				$data[$i]['name'] = $details['oldacc_cont_name'];
				$i++;
			}
			if(isset($details['auditors_cont_name']) && $details['auditors_cont_name']!= ""){
				$data[$i]['name'] = $details['auditors_cont_name'];
				$i++;
			}
			if(isset($details['solicitors_cont_name']) && $details['solicitors_cont_name']!= ""){
				$data[$i]['name'] = $details['solicitors_cont_name'];
				$i++;
			}

			$rel_data = Common::get_relationship_client($details['client_id']);
			if(isset($rel_data) && count($rel_data) >0 ){
				foreach ($rel_data as $key => $value) {
					$data[$i]['name'] = $value['name'];
					$i++;
				}
			}
		}

		return $data;
	}

	public function show_contacts_notes()
    {
        $data = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $client_id  	= Input::get("client_id");
        $contact_type   = Input::get("contact_type");

        $notes = ContactsNote::whereIn("user_id", $groupUserId)->where("client_id", "=", $client_id)->where("contact_type", "=", $contact_type)->first();

        if(isset($notes) && count($notes) >0){
            $data['notes'] = $notes['notes'];
        }
        echo json_encode($data);
    }

    public function save_contacts_notes()
    {
        $data = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $contact_type   = Input::get("contact_type");
		$client_id  	= Input::get("client_id");

        $notes 		= ContactsNote::whereIn("user_id", $groupUserId)->where("client_id", "=", $client_id)->where("contact_type", "=", $contact_type)->first(); 
        $data['notes'] = Input::get("notes");
		if(isset($notes) && count($notes) >0){
            ContactsNote::where("notes_id", "=", $notes['notes_id'])->update($data);
            $last_id = $notes['notes_id'];
        }else{
            $data['client_id']  	= $client_id;
            $data['contact_type']  	= $contact_type;
            $data['user_id']    	= $user_id;
            $last_id = ContactsNote::insertGetId($data);
        }

        echo $last_id;exit;
    }

	public function send_letteremail()
	{
		$data['title'] = 'Emails/Letters';
		$data['previous_page'] = '<a href="/contacts-letters-emails">Contacts Letters & Emails</a>';
		$data['heading'] = "EMAILS/LETTERS";
		$admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];
		$groupUserId = $admin_s['group_users'];

		if (empty($user_id)) {
			return Redirect::to('/');
		}


		return View::make('contacts_letters.send_letteremail', $data);
	}

	public function save_contacts_group()
	{
		$session = Session::get('admin_details');
		$user_id = $session['id'];
		$groupUserId = $session['group_users'];

		$data['user_id']  		= $user_id;
		$data['title'] 			= strtoupper(Input::get("group_name"));
		$data['short_code'] 	= strtolower(str_replace(" ", "_", $data['title']));
		$data['status']  		= "S";
		$data['step_type']  	= "new";
		$data['parent_step_id'] = Input::get("step_id");

		$last_id = ContactsStep::insertGetId($data);
		echo $last_id;exit;
	}

	public function insert_contact_details()
    {
    	$data = array();
    	$session = Session::get('admin_details');
		$user_id = $session['id'];
		$groupUserId 	= $session['group_users'];
		$contact_id		= Input::get("contact_id");

    	$tab_id 				= Input::get("tab_index");
    	$address_type 			= Input::get("encoded_type");
    	$data['contact_type'] 	= Input::get("contact_type");
    	$data['contact_name'] 	= Input::get("contact_name");
    	$data['telephone_code'] = Input::get("telephone_code");
    	$data['telephone'] 		= Input::get("telephone");
    	$data['mobile_code'] 	= Input::get("mobile_code");
    	$data['mobile'] 		= Input::get("mobile");
    	$data['email'] 			= Input::get("email");
    	$data['website'] 		= Input::get("website");
    	$data['company_name'] 	= Input::get("company_name");
		$data['addr_line1'] 	= Input::get("addr_line1");
    	$data['addr_line2'] 	= Input::get("addr_line2");
    	$data['city'] 			= Input::get("city");
    	$data['county'] 		= Input::get("county");
    	$data['postcode'] 		= Input::get("postcode");
    	$data['country'] 		= Input::get("country");

    	if($contact_id >0){
    		ContactAddress::where("contact_id", "=", $contact_id)->update($data);
    	}else{
    		$data['user_id'] 	= $user_id;
    		ContactAddress::insert($data);
    	}
    	
    	return Redirect::to('/contacts-letters-emails/'.$tab_id.'/'.$address_type);
    }

    public function search_address()
    {
    	$data = array();
    	$address_type 	= Input::get("address_type");
    	$client_id 		= Input::get("client_id");
    	$address = ContactAddress::getContactAddressByType($client_id, $address_type);

		echo json_encode($address);
    }

    public function save_edit_group()
    {
    	$data = array();
    	$step_id 			= Input::get('step_id');
    	$data['short_code'] = strtolower(Input::get("group_name"));
    	$data['title'] 		= Input::get("group_name");
    	
    	$sql = ContactsStep::where("step_id", "=", $step_id)->update($data);
    	
    	echo $sql;
    	exit;
    }

    public function copy_to_group()
    {
    	$step = array();
    	$data = array();

    	$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId 	= $session['group_users'];

    	$group_id 		= Input::get('group_id');
    	$tab_id 		= Input::get('tab_id');
    	$group_name 	= Input::get('group_name');
    	$client_ids 	= explode(",", Input::get('client_ids'));
    	$contact_type 	= ContactsGroup::getContacttype($tab_id);

    	if(isset($group_name) && $group_name != ""){
    		$step['user_id'] 		= $user_id;
    		$step['parent_step_id'] = $tab_id;
    		$step['short_code'] 	= str_replace(" ", "_", strtolower($group_name));
    		$step['title'] 			= $group_name;
    		$step['status'] 		= "S";
    		$step['step_type'] 		= "new";
    		$group_id = ContactsStep::insertGetId($step);
    	}

    	if(isset($group_id) && $group_id != ""){
    		if(isset($client_ids) && count($client_ids) >0){
    			foreach ($client_ids as $key => $client_id) {
    				$details = ContactsGroup::whereIn("user_id", $groupUserId)->where("client_id", "=", $client_id)->where("group_id", "=", $group_id)->where("contact_type", "=", $contact_type)->select("groups_contact_id")->first();
    				if($details['groups_contact_id'] == ""){
    					$data['user_id'] 		= $user_id;
	    				$data['client_id'] 		= $client_id;
			    		$data['group_id'] 		= $group_id;
			    		$data['contact_type'] 	= $contact_type;
			    		ContactsGroup::insert($data);
    				}
    				
    			}
	    	}
    	}
    	//ContactsGroup
    	//print_r($client_ids);
    	echo 1;die;
    }

    public function delete_group()
    {
    	$step_id = Input::get('step_id');
    	$query = ContactsStep::where("step_id", "=", $step_id)->delete();
    	if($query){
    		echo 1;die;
    	}else{
    		echo 0;die;
    	}
    }

    public function delete_from_group()
    {
    	$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId 	= $session['group_users'];

    	$client_id 		= Input::get('client_id');
    	$group_id 		= Input::get('tab_id');
    	$contact_type 	= Input::get('contact_type');

    	$query = ContactsGroup::whereIn("user_id", $groupUserId)->where("client_id", "=", $client_id)->where("group_id", "=", $group_id)->where("contact_type", "=", $contact_type)->delete();
    	if($query){
    		echo 1;die;
    	}else{
    		echo 0;die;
    	}
    }

    public function show_contact_group() {
		$data = array();
		$contact_type = Input::get('contact_type');
		$contact = explode("_", $contact_type);
		if($contact[0] == "other"){
			$address = ContactAddress::getContactDetailsById($contact[1]);
			if(isset($address) && count($address) >0){
				$data['address1'] 	= $address['addr_line1'];
				$data['address2'] 	= $address['addr_line2'];
				$data['city'] 		= $address['city'];
				$data['county'] 	= $address['county'];
				$data['postcode'] 	= $address['postcode'];
				$data['country'] 	= $address['country'];
			}

		}else{
			$data = ContactAddress::getClientContactAddress($contact[1], $contact[0]);
		}
		//print_r($data);die;
		echo json_encode($data);
		exit;

	}

	public function get_contact_details() {
		$address = array();
		$contact_type 	= Input::get('contact_type');
		$contact_id 	= Input::get('contact_id');
		$address = ContactAddress::getContactDetailsById($contact_id);
		//print_r($data);die;
		echo json_encode($address);
		exit;

	}

	public function delete_contact_address()
    {
    	$contact_id = Input::get('contact_id');
    	$query = ContactAddress::where("contact_id", "=", $contact_id)->delete();
    	if($query){
    		echo 1;die;
    	}else{
    		echo 0;die;
    	}
    }
    
    
    public function cletab1pdf(){
         $step_id ="1";
         $address_type="corres";
		$data = array();
		$org_data 		= array();
		$data['title'] 		= 'Contacts Letters & Emails';
		$data['step_id'] 	= $step_id;
		$data['address_type'] 	= base64_decode($address_type);
	 	$data['encoded_type'] 	= $address_type;
		$data['heading'] 		= "CONTACTS, LETTERS & EMAILS";
		$session 		= Session::get('admin_details');
		$user_id 		= $session['id'];
		$groupUserId 	= $session['group_users'];

		if (empty($user_id)) {
			return Redirect::to('/');
		}
		$org_count 		= 0;
		$ind_count 		= 0;
		$staff_count 	= 0;
		$other_count 	= 0;

		if($step_id == 1){
			$org_details = Client::getAllOrgClientDetails();
			if(isset($org_details) && count($org_details) >0){
				foreach ($org_details as $key => $client_row) {
					//$org_details[$key]['contact_name'] 	= $this->getContactNameDropdown($client_row);
					$org_details[$key]['other_details'] = ContactAddress::getContactAddressByType($client_row['client_id'], $data['address_type']);
					$org_details[$key]['notes']	= ContactsNote::getNotes($client_row['client_id'], 'org');

					$org_count++;
				}
				$data['org_details'] = $org_details;
			}
		}else if($step_id == 2){
			$ind_details = Client::getAllIndClientDetails();
			if(isset($ind_details) && count($ind_details) >0){
				foreach ($ind_details as $key => $client_row) {
					$ind_details[$key]['notes']	= ContactsNote::getNotes($client_row['client_id'], 'ind');

					$ind_count++;
				}
				$data['ind_details'] = $ind_details;
			}
		}else if($step_id == 3){
			$data['staff_details'] = User::getAllStaffDetails();
		}else if($step_id == 4){
			$data['contact_details'] = ContactAddress::getAllContactDetails();
		}else{
			$data['group_details'] 	= ContactAddress::getGroupContactDetails($step_id);
		}
		

		$data['steps'] = ContactsStep::getAllSteps($org_count, $ind_count, $staff_count, $other_count);
		$data['countries'] 	= Country::orderBy('country_name')->get();
		$data['address_types'] 	= AddressType::getAllAddressDetails();
		$data['all_address'] 	= ContactAddress::getAllContactAddress();


		//echo "<pre>";print_r($data['group_details']);echo "</pre>";die;
	//	return View::make('contacts_letters.index', $data);
        
        $pdf = PDF::loadView('contacts_letters.tab1clelistpdf', $data);
        
		return $pdf->download('ContactsLetters_Emails.pdf');
	
        
        
        
    }

    

}
