<?php
class JobsController extends BaseController {
	
	public function dashboard(){
		$data['title'] = 'Jobs';
		//$data['previous_page'] = '<a href="/dashboard">Dashboard</a>';
		$data['heading'] = "JOBS";
		$session = Session::get('admin_details');
		$user_id = $session['id'];
		$groupUserId = $session['group_users'];

		if (empty($user_id)) {
			return Redirect::to('/');
		}

		//echo "<prev>".print_r($data);die;
		return View::make('jobs.dashboard', $data);
	}

	public function send_manage_task(){
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

    	$service_id        = Input::get("service_id");
    	$client_id         = Input::get("client_id");
    	$jobs = JobsManage::whereIn("user_id", $groupUserId)->where("client_id", "=", $client_id)->where("service_id", "=", $service_id)->first();

        $data["status"]    = "Y";
        if(isset($jobs) && count($jobs) >0){
    		JobsManage::where("job_manage_id", "=", $jobs['job_manage_id'])->update($data);
    		$last_id = $jobs['job_manage_id'];
    	}else{
            $data["user_id"]    = $user_id;
    		$data["service_id"] = $service_id;
    		$data["client_id"] 	= $client_id;
    		$last_id = JobsManage::insertGetId($data);
    	}

    	echo $last_id;
    }

    public function update_staff_filter()
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

    	$staff_id      = Input::get("staff_id");	
    	$service_id    = Input::get("service_id");
    	if($staff_id != "all" && $staff_id != "none"){
    		$staff_id = base64_decode($staff_id);
    	}
    	AutosendTask::whereIn("user_id", $groupUserId)->where('service_id','=',$service_id)->update(array('staff_filter'=>$staff_id));
    	echo 1;
    }

    public function send_global_task()
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $client_array   = array();
        $update_data    = array();
        $dead_line      = Input::get("dead_line");
        $service_id     = Input::get("service_id");
        $data['company_details'] = Client::getClientByServiceId( $service_id );
        //print_r($data['company_details']);
        $all_count = 0;
        $i = 0;
        if(isset($data['company_details']) && count($data['company_details']) >0){
            foreach ($data['company_details'] as $key => $details) {
                if(isset($details['deadret_count']) && $details['deadret_count'] <= $dead_line){

                    $jobs = JobsManage::whereIn("user_id", $groupUserId)->where("client_id", "=", $details['client_id'])->where("service_id", "=", $service_id)->first();
                    $job_data["status"]    = "Y";
                    $job_data["user_id"]    = $user_id;
                    $job_data["service_id"] = $service_id;
                    $job_data["client_id"]  = $details['client_id'];
                    if(isset($jobs) && count($jobs) >0){
                        JobsManage::where("job_manage_id", "=", $jobs['job_manage_id'])->update($job_data);
                        $last_id = $jobs['job_manage_id'];
                    }else{
                        $last_id = JobsManage::insertGetId($job_data);
                    }
//echo $this->last_query();die;
                    $client_array[$i]['client_id'] = $details['client_id'];
                    $i++;
                }
            }
        }

        $autosend=AutosendTask::whereIn("user_id", $groupUserId)->where('service_id','=',$service_id)->first();
        $autoData["user_id"]      = $user_id;
        $autoData['days']         = $dead_line;
        $autoData['service_id']   = $service_id;
        if(isset($autosend) && count($autosend) >0 ){
            AutosendTask::where('autosend_id', '=', $autosend['autosend_id'])->update($autoData);
        }else{
            AutosendTask::insert($autoData);
        }
        
        echo json_encode($client_array);
    }

    public function delete_single_task()
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $client_id  = Input::get("client_id");
        $service_id = Input::get("service_id");
        $tab        = Input::get("tab");


        $jobs = JobsManage::whereIn("user_id", $groupUserId)->where("service_id", "=", $service_id)->where("client_id", "=", $client_id)->first();
        if(isset($jobs) && count($jobs) >0){
            $del_data['status'] = "N";
            JobsManage::where("job_manage_id", "=", $jobs['job_manage_id'])->update($del_data);
        }

        $job_status = JobStatus::whereIn("user_id", $groupUserId)->where("client_id", "=", $client_id)->where("service_id", "=", $service_id)->where("status_id", "=", 10)->first();
        if( isset($job_status) && count($job_status) >0){
            if($tab == 3){
                JobStatus::where("job_status_id", "=", $job_status['job_status_id'])->delete();
            }else{
                $update_data['is_completed'] =  'Y';
                JobStatus::where("job_status_id", "=", $job_status['job_status_id'])->update($update_data);
            }
            
        }else{
            JobStatus::whereIn("user_id", $groupUserId)->where("client_id", "=", $client_id)->where("is_completed", "=", "N")->where("service_id", "=", $service_id)->delete();
        }

        echo 1;
    }

    public function change_job_status()
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $client_id  = Input::get("client_id");
        $service_id = Input::get("service_id");
        $status_id  = Input::get("status_id");

        JobsCompletedTask::putCompletedTaskDate($client_id, $service_id, $status_id);

        $qry = JobStatus::whereIn("user_id", $groupUserId)->where("is_completed", "=", "N")->where("client_id", "=", $client_id)->where("service_id", "=", $service_id)->first();
        
        if(isset($qry) && count($qry) >0){
            $updateData['status_id']    = $status_id;
            JobStatus::where("job_status_id", "=", $qry["job_status_id"])->update($updateData);
            $last_id = $qry["job_status_id"];
        }else{
            $data['user_id']    = $user_id;
            $data['client_id']  = $client_id;
            $data['service_id'] = $service_id;
            $data['status_id']  = $status_id;
            $last_id = JobStatus::insertGetId($data);
        }
        
        echo $last_id;
    }

    public function show_jobs_notes()
    {
        $data = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $client_id  = Input::get("client_id");
        $service_id = Input::get("service_id");

        $notes = JobsNote::whereIn("user_id", $groupUserId)->where("client_id", "=", $client_id)->where("service_id", "=", $service_id)->first();

        if(isset($notes) && count($notes) >0){
            $data['notes'] = $notes['notes'];
        }
        echo json_encode($data);
    }

    public function save_jobs_notes()
    {
        $data = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $client_id  = Input::get("client_id");
        $service_id = Input::get("service_id");

        $notes = JobsNote::whereIn("user_id", $groupUserId)->where("client_id", "=", $client_id)->where("service_id", "=", $service_id)->first();

        $data['notes']      = Input::get("notes");
        if(isset($notes) && count($notes) >0){
            JobsNote::where("jobs_notes_id", "=", $notes['jobs_notes_id'])->update($data);
            $last_id = $notes['jobs_notes_id'];
        }else{
            $data['client_id']  = $client_id;
            $data['service_id'] = $service_id;
            $data['user_id']    = $user_id;
            $last_id = JobsNote::insertGetId($data);
        }

        echo $last_id;exit;
    }

    public function save_made_up_date()
    {
        $data = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $client_id  = Input::get("client_id");
        $service_id = Input::get("service_id");

        $client_details = StepsFieldsClient::where('client_id', '=', $client_id)->where('field_name', '=', "made_up_date")->select("field_value")->first();

        $data['field_value']   = Input::get("date");
        if(isset($client_details["field_value"]) && $client_details["field_value"] != ""){
            StepsFieldsClient::where('client_id', '=', $client_id)->where('field_name', '=', "made_up_date")->update($data);
        }else{
            $data['user_id']        = $user_id;
            $data['client_id']      = $client_id;
            $data['step_id']        = 1;
            $data['field_name']     = "made_up_date";
            
            StepsFieldsClient::insertGetId($data);
        }

        echo $client_id;exit;
    }

    public function sync_jobs_clients()
    {
        $data = array();
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $client_ids  = Input::get("client_ids");
        $service_id = Input::get("service_id");

        if(isset($client_ids) && count($client_ids) > 0){
            foreach ($client_ids as $key => $client_id) {
                $company_number = Client::getCompanyNumberByClientId($client_id);
                $value = $company_number."=function";
                $client_id = App::make("ChdataController")->import_company_details($value);
            }
        }
        return $client_id;
    }



    

}
