<?php
class ChdataController extends BaseController {
	
	/*public function index()
	{
		$data 			= array();
		$details_data 	= array();
		$data['heading'] 	= "CH DATA";
		$data['title'] 		= "Ch Data";
		
		$numbers = CompanyNumber::orderBy("cn_id", "DESC")->get();
		if(isset($numbers) && count($numbers) >0 ){
			foreach ($numbers as $key => $row) {
				$details = Common::getCompanyDetails($row->number);
				if(isset($details) && count($details) >0 ){
					$details_data[$key]['company_number'] 		= $details->primaryTopic->CompanyNumber;
					$details_data[$key]['company_name'] 		= $details->primaryTopic->CompanyName;
					$details_data[$key]['incorporation_date'] 	= $details->primaryTopic->IncorporationDate;
					$details_data[$key]['acc_ref_date'] 		= $details->primaryTopic->Accounts->AccountRefDay."/".$details->primaryTopic->Accounts->AccountRefMonth;
					$details_data[$key]['auth_code'] 			= "";
					$details_data[$key]['last_ret_made_date'] 	= $details->primaryTopic->Returns->LastMadeUpDate;
					$details_data[$key]['next_due_date'] 		= $details->primaryTopic->Returns->NextDueDate;
					$details_data[$key]['count_down'] 			= Common::getDayCount($details->primaryTopic->Returns->NextDueDate);

				}
			}
		}
		$data['company_details']	= $details_data;
		//print_r($details);die;
		return View::make('ch_data.chdata_list', $data);
		

	}*/

	public function index()
	{
		$data 			= array();
		$client_data 	= array();
		$data['heading'] 	= "CH DATA";
		$data['title'] 		= "Ch Data";
		
		$admin_s 			= Session::get('admin_details'); // session
		$user_id 			= $admin_s['id']; //session user id
		$groupUserId 		= Common::getUserIdByGroupId($admin_s['group_id']);

		if (empty($user_id)) {
			return Redirect::to('/');
		}
		
		$client_ids = Client::where("type", "=", "org")->where("is_archive", "=", "N")->whereIn("user_id", $groupUserId)->select("client_id", "show_archive")->orderBy("client_id", "DESC")->get();
		//echo $this->last_query();die;

		$i = 0;
		if (isset($client_ids) && count($client_ids) > 0) {
			foreach ($client_ids as $client_id) {
				$client_details = StepsFieldsClient::where('client_id', '=', $client_id->client_id)->select("field_id", "field_name", "field_value")->get();
				$client_data[$i]['client_id'] = $client_id->client_id;
				
				if (isset($client_details) && count($client_details) > 0) {
					foreach ($client_details as $client_row) {
						if (isset($client_row['field_name']) && $client_row['field_name'] == "next_acc_due"){
							$client_data[$i]['deadacc_count'] = App::make('HomeController')->getDayCount($client_row->field_value);
						}
						if (isset($client_row['field_name']) && $client_row['field_name'] == "next_ret_due"){
							$client_data[$i]['count_down'] = App::make('HomeController')->getDayCount($client_row->field_value);
						}

						$client_data[$i][$client_row['field_name']] = $client_row->field_value;
					}
					$details_data[$i]['auth_code'] 			= "";
					$i++;
				}

				//echo $this->last_query();die;
			}
		}

		$data['company_details']	= $client_data;
		//print_r($data['company_details']);die;
		return View::make('ch_data.chdata_list', $data);
		

	}

	public function chdata_details($number)
	{
		$data = array();
		$data['heading'] 	= "COMPANY DETAILS";
		$data['title'] 		= "Company Details";
		$details 			= Common::getCompanyDetails($number);
		$registered_office 	= Common::getRegisteredOffice($number);
		$officers 			= Common::getOfficerDetails($number);
		$filling_history 	= Common::getFillingHistory($number);
		//$insolvency 		= Common::getInsolvency($number);

		$data['details']			= $details->primaryTopic;
		$data['officers']			= $officers->items;
		$data['filling_history']	= $filling_history->items;
		$data['registered_office']	= $registered_office;

		$data['nature_of_business']	= $this->getSicDescription($details->primaryTopic->SICCodes->SicText);
		$data['client_data']		= $this->getRegisteredIn($details->primaryTopic->CompanyNumber);
		$data['insolvency']			= Common::getInsolvency($number);
		$data['charges']			= Common::getCharges($number);

		//print_r($data['officers']);die;
		return View::make("ch_data.chdata_details", $data);
	}

	private function getSicDescription($sic_codes)
	{
		$text = "";
		if(isset($sic_codes) && count($sic_codes) >0 ){
			$text = implode(",", $sic_codes);
		}
		return $text;
	}

	private function getRegisteredIn($company_no)
	{
		$array = array();
		$details = StepsFieldsClient::where("field_value", "=", $company_no)->where("step_id", "=", 1)->where("field_name", "=", "registration_number")->first();
		//print_r($details);echo $this->last_query();die;
		if( isset($details) && count($details) >0 ){
			$all_details = StepsFieldsClient::where("client_id", "=", $details['client_id'])->where("step_id", "=", 1)->get();
			foreach ($all_details as $key => $value) {
				if(isset($value->field_name) && $value->field_name == "registered_in"){
					$reg_in = RegisteredAddress::where("reg_id", "=", $value->field_value)->first();
					$array['registered_in'] = $reg_in['reg_name'];
				}
				if(isset($value->field_name) && $value->field_name == "ch_auth_code"){
					$array['ch_auth_code'] = $value->field_value;
				}
			}

		}
		//print_r($array);die;
		//echo $this->last_query();die;
		return $array;
	}

	public function officers_details()
	{
		$number = Input::get("number");
		$key 	= Input::get("key");
		$data 		= array();
		$off_data 	= array();

		$officers 			= Common::getOfficerDetails($number);
		
		$off_data['date_of_birth'] 			= isset($officers->items[$key]->date_of_birth)?$officers->items[$key]->date_of_birth:"";
		$off_data['nationality'] 			= isset($officers->items[$key]->nationality)?$officers->items[$key]->nationality:"";
		$off_data['officer_role'] 			= isset($officers->items[$key]->officer_role)?$officers->items[$key]->officer_role:"";
		$off_data['name'] 					= isset($officers->items[$key]->name)?$officers->items[$key]->name:"";
		$off_data['occupation'] 			= isset($officers->items[$key]->occupation)?$officers->items[$key]->occupation:"";
		$off_data['appointed_on'] 			= isset($officers->items[$key]->appointed_on)?$officers->items[$key]->appointed_on:"";
		$off_data['resigned_on'] 			= isset($officers->items[$key]->resigned_on)?$officers->items[$key]->resigned_on:"";
		$off_data['country_of_residence'] 	= isset($officers->items[$key]->country_of_residence)?$officers->items[$key]->country_of_residence:"";
		$off_data['address'] 				= isset($officers->items[$key]->address)?$officers->items[$key]->address:"";
		$off_data['links'] 					= isset($officers->items[$key]->links)?$officers->items[$key]->links:"";

		$data['officers'] = $off_data;

		echo View::make("ch_data.ajax_officer_details", $data);
		
	}

	public function import_from_ch($back_url)
	{
		$data['title'] = "Import from CH";
		$data['heading'] = "";
		$data['back_url'] = base64_decode($back_url);
		//echo $data['back_url'];die;
		return View::make("ch_data.import_from_ch", $data);
	}

	public function search_company()
	{
		$company = array();
		$value = str_replace(" ", "+", Input::get("value"));
		//$value = "Alexander+Rosse";
		$compamy_details	= Common::getSearchCompany($value);
		if(isset($compamy_details->items) && count($compamy_details->items) >0 )
		{
			foreach ($compamy_details->items as $key => $value) {
				$company[$key]['company_name'] 		= $value->title;
				$company[$key]['company_number'] 	= $value->description_values->company_number;
			}
		}
		$data['company_details'] 	= $company;
		//print_r($data);die;

		echo View::make("ch_data.ajax_company_search_result", $data);
	}

	public function company_details()
	{
		$number = Input::get("number");
		$data 		= array();
		$data['officers']	= array();
		
		$details 			= Common::getCompanyDetails($number);
		$registered_office 	= Common::getRegisteredOffice($number);
		$officers 			= Common::getOfficerDetails($number);
		if(isset($officers->items) && count($officers->items) > 0){
			$data['officers']	= $officers->items;
		}
//print_r($data['officers']);die;
		$data['details']			= $details->primaryTopic;
		
		$data['registered_office']	= $registered_office;
		$data['nature_of_business']	= $this->getSicDescription($details->primaryTopic->SICCodes->SicText);

		echo View::make("ch_data.ajax_company_details", $data);
		
	}

	public function import_company_details($number)
	{
		//$number = Input::get("number");
		//$number = "05244480";
		$data = array();
		//$details 			= Common::getCompanyDetails($number);
		$details 			= Common::getCompanyData($number);
		//print_r($details);die;
		$admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];

		//################# If company number exists Start ##################//
		$client_data = StepsFieldsClient::where("field_name", "=", "registration_number")->where("field_value", "=", $details->company_number)->first();
		//echo $this->last_query();die;
		if(isset($client_data) && count($client_data) >0 ){
			$client_id = $client_data['client_id'];
			StepsFieldsClient::where("client_id", "=", $client_id)->delete();
			ClientRelationship::where("client_id", "=", $client_id)->delete();
		}else{
			$client_id = Client::insertGetId(array("user_id" => $user_id, 'type' => 'org'));
		}
		//################# If company number exists End ##################//
		
		

		$ret_check = 0;
		$acc_check = 0;
		if (isset($details->company_name)) {
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'business_name', $details->company_name);
		}
		if (isset($details->company_number)) {
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'registration_number', $details->company_number);
		}
		if (isset($details->date_of_creation)) {
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'incorporation_date', $details->date_of_creation);
		}
		if (isset($details->type)) {
			if($details->type == "ltd" || $details->type == "limited"){
				$type = 2;
			}else if($details->type == "llp"){
				$type = 1;
			}else{
				$type = "";
			}
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'business_type', $type);
		}
		if (isset($details->jurisdiction)) {
			//$reg_in = RegisteredAddress::where("reg_name", "=", ucwords(str_replace("-", " ", $details->jurisdiction)))->select("reg_id")->first();
			$reg_in = RegisteredAddress::where("reg_name", "=", ucwords($details->jurisdiction))->select("reg_id")->first();
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'registered_in', $reg_in['reg_id']);
		}
		if (isset($details->sic_codes) && count($details->sic_codes) >0 ) {
			$codes_data = "";
			foreach ($details->sic_codes as $key => $value) {
				$sic_codes = SicCodesDescription::where("sic_codes", "=", $value)->first();
				$codes_data .= $sic_codes['description'].", ";
			}
			$codes_data = substr($codes_data, 0, -2);
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'business_desc', $codes_data);
		}
		if (isset($details->annual_return->next_due)) {
			$ret_check = 1;
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'next_ret_due', str_replace("/", "-", $details->annual_return->next_due));
		}
		if (isset($details->annual_return->last_made_up_to)) {
			$ret_check = 1;
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'made_up_date', $details->annual_return->last_made_up_to);
		}
		if (isset($details->accounts->last_accounts->made_up_to)) {
			$acc_check = 1;
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'last_acc_madeup_date', $details->accounts->last_accounts->made_up_to);
		}
		if (isset($details->accounts->next_due)) {
			$acc_check = 1;
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'next_acc_due', $details->accounts->next_due);
		}
		if (isset($details->accounts->accounting_reference_date->day)) {
			$acc_check = 1;
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'acc_ref_day', $details->accounts->accounting_reference_date->day);
		}
		if (isset($details->accounts->accounting_reference_date->month)) {
			$acc_check = 1;
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'acc_ref_month', $details->accounts->accounting_reference_date->month);
		}
		if($ret_check == 1){
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'ann_ret_check', 1);
		}
		if($acc_check == 1){
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'yearend_acc_check', 1);
		}

		//$registered_office 				= Common::getRegisteredOffice($number);
		$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 3,'cont_reg_addr', 'reg');
		if (isset($details->registered_office_address->address_line_1)) {
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 3, 'reg_cont_addr_line1', $details->registered_office_address->address_line_1);
		}
		if (isset($details->registered_office_address->address_line_2)) {
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 3, 'reg_cont_addr_line2', $details->registered_office_address->address_line_2);
		}
		if (isset($details->registered_office_address->locality)) {
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 3, 'reg_cont_city', $details->registered_office_address->locality);
		}
		if (isset($details->registered_office_address->postal_code)) {
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 3, 'reg_cont_postcode', $details->registered_office_address->postal_code);
		}
		if (isset($details->registered_office_address->country)) {
			$country = Country::where("country_name", "=", $details->registered_office_address->country)->select("country_id")->first();
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 3, 'reg_cont_country', $country['country_id']);
		}
		//print_r($arrData);die;
		$inserted = StepsFieldsClient::insert($arrData);

		$officers 			= Common::getOfficerDetails($number);
		if(isset($officers->items) && count($officers->items) > 0){
			foreach ($officers->items as $key => $row) {
				$app_client_id = Client::insertGetId(array("user_id" => $user_id, 'type' => 'chd'));
				if (isset($row->officer_role) && $row->officer_role != "") {

					$relationship_type = RelationshipType::where("relation_type", "=", ucwords($row->officer_role))->first();
					$relData[] = array(
						'client_id' => $client_id,
						'appointment_with' => $app_client_id,
						'appointment_date' => str_replace("/", "-", $row->appointed_on),
						'relationship_type_id' => isset($relationship_type['relation_type_id'])?$relationship_type['relation_type_id']:"0",
					);
					ClientRelationship::insert($relData);
				}
				$insert_client = $this->insertClientDetails($row, $app_client_id);
			}
			
		}

		
		

		if($inserted){
			echo $client_id;
		}else{
			echo 0;
		}
		exit;
	}

	public function insertClientDetails($row, $app_client_id)
	{
		$admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];

		if(strpos($row->officer_role, 'corporate') !== false){
			$name = str_replace(" ", "+", $row->name);
			$details = Common::getSearchCompany($name);
			$company_number = $details->items[0]->description_values->company_number;
			//echo $company_number;die;
			if(isset($company_number) && $company_number != ""){
				$this->insert_corporate_company($company_number);
			}
			
		}else{

			$arrData[] = App::make('HomeController')->save_client($user_id, $app_client_id, 1, 'client_name', $row->name);

			$full_name = explode(" ", $row->name);
			if (isset($full_name[0]) && $full_name[0] != "") {
				$arrData[] = App::make('HomeController')->save_client($user_id, $app_client_id, 1, 'fname', $full_name[0]);
			}
			if (isset($full_name[1]) && $full_name[1] != "") {
				$arrData[] = App::make('HomeController')->save_client($user_id, $app_client_id, 1, 'mname', $full_name[0]);
			}
			if (isset($full_name[2]) && $full_name[2] != "") {
				$arrData[] = App::make('HomeController')->save_client($user_id, $app_client_id, 1, 'lname', $full_name[0]);
			}
			if (isset($row->date_of_birth) && $row->date_of_birth != "") {
				$arrData[] = App::make('HomeController')->save_client($user_id, $app_client_id, 1, 'dob', $row->date_of_birth);
			}

			$inserted = StepsFieldsClient::insert($arrData);

		}
		
	}

	public function insert_corporate_company($number)
	{
		$data = array();
		//$details 			= Common::getCompanyDetails($number);
		$details 			= Common::getCompanyData($number);
		//print_r($details);die;
		$admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];

		//################# If company number exists Start ##################//
		$client_data = StepsFieldsClient::where("field_name", "=", "registration_number")->where("field_value", "=", $details->company_number)->first();
		//echo $this->last_query();die;
		if(isset($client_data) && count($client_data) >0 ){
			$client_id = $client_data['client_id'];
			StepsFieldsClient::where("client_id", "=", $client_id)->delete();
			ClientRelationship::where("client_id", "=", $client_id)->delete();
		}else{
			$client_id = Client::insertGetId(array("user_id" => $user_id, 'type' => 'org'));
		}
		//################# If company number exists End ##################//
		
		

		$ret_check = 0;
		$acc_check = 0;
		if (isset($details->company_name)) {
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'business_name', $details->company_name);
		}
		if (isset($details->company_number)) {
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'registration_number', $details->company_number);
		}
		if (isset($details->date_of_creation)) {
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'incorporation_date', $details->date_of_creation);
		}
		if (isset($details->type)) {
			if($details->type == "ltd" || $details->type == "limited"){
				$type = 2;
			}else if($details->type == "llp"){
				$type = 1;
			}else{
				$type = "";
			}
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'business_type', $type);
		}
		if (isset($details->jurisdiction)) {
			$reg_in = RegisteredAddress::where("reg_name", "=", ucwords(str_replace("-", " ", $details->jurisdiction)))->select("reg_id")->first();
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'registered_in', $reg_in['reg_id']);
		}
		if (isset($details->sic_codes) && count($details->sic_codes) >0 ) {
			$codes_data = "";
			foreach ($details->sic_codes as $key => $value) {
				$sic_codes = SicCodesDescription::where("sic_codes", "=", $value)->first();
				$codes_data .= $sic_codes['description'].", ";
			}
			$codes_data = substr($codes_data, 0, -2);
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'business_desc', $codes_data);
		}
		if (isset($details->annual_return->next_due)) {
			$ret_check = 1;
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'next_ret_due', str_replace("/", "-", $details->annual_return->next_due));
		}
		if (isset($details->annual_return->last_made_up_to)) {
			$ret_check = 1;
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'made_up_date', $details->annual_return->last_made_up_to);
		}
		if (isset($details->accounts->last_accounts->made_up_to)) {
			$acc_check = 1;
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'last_acc_madeup_date', $details->accounts->last_accounts->made_up_to);
		}
		if (isset($details->accounts->next_due)) {
			$acc_check = 1;
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'next_acc_due', $details->accounts->next_due);
		}
		if (isset($details->accounts->accounting_reference_date->day)) {
			$acc_check = 1;
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'acc_ref_day', $details->accounts->accounting_reference_date->day);
		}
		if (isset($details->accounts->accounting_reference_date->month)) {
			$acc_check = 1;
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'acc_ref_month', $details->accounts->accounting_reference_date->month);
		}
		if($ret_check == 1){
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'ann_ret_check', 1);
		}
		if($acc_check == 1){
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 1, 'yearend_acc_check', 1);
		}

		//$registered_office 				= Common::getRegisteredOffice($number);
		$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 3,'cont_reg_addr', 'reg');
		if (isset($details->registered_office_address->address_line_1)) {
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 3, 'reg_cont_addr_line1', $details->registered_office_address->address_line_1);
		}
		if (isset($details->registered_office_address->address_line_2)) {
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 3, 'reg_cont_addr_line2', $details->registered_office_address->address_line_2);
		}
		if (isset($details->registered_office_address->locality)) {
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 3, 'reg_cont_city', $details->registered_office_address->locality);
		}
		if (isset($details->registered_office_address->postal_code)) {
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 3, 'reg_cont_postcode', $details->registered_office_address->postal_code);
		}
		if (isset($details->registered_office_address->country)) {
			$country = Country::where("country_name", "=", $details->registered_office_address->country)->select("country_id")->first();
			$arrData[] = App::make('HomeController')->save_client($user_id, $client_id, 3, 'reg_cont_country', $country['country_id']);
		}
		//print_r($arrData);die;
		$inserted = StepsFieldsClient::insert($arrData);

		$officers 			= Common::getOfficerDetails($number);
		if(isset($officers->items) && count($officers->items) > 0){
			foreach ($officers->items as $key => $row) {
				$app_client_id = Client::insertGetId(array("user_id" => $user_id, 'type' => 'chd'));
				if (isset($row->officer_role) && $row->officer_role != "") {

					$relationship_type = RelationshipType::where("relation_type", "=", ucwords($row->officer_role))->first();
					$relData[] = array(
						'client_id' => $client_id,
						'appointment_with' => $app_client_id,
						'appointment_date' => str_replace("/", "-", $row->appointed_on),
						'relationship_type_id' => isset($relationship_type['relation_type_id'])?$relationship_type['relation_type_id']:"0",
					);
					ClientRelationship::insert($relData);
				}
				$insert_client = $this->insertClientDetails($row, $app_client_id);
			}
			
		}

		
		

		if($inserted){
			echo $client_id;
		}else{
			echo 0;
		}
		exit;
	}

}
