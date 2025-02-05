<?php
class JobStatus extends Eloquent {

	public $timestamps = false;

	public static function getAllJobStatus()
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$status_data = array();
		$JobStatus	= JobStatus::whereIn("user_id", $groupUserId)->where("is_completed","=", "N")->get();
		if(isset($JobStatus) && count($JobStatus) >0){
			foreach ($JobStatus as $key => $row) {
				$status_data[$key]['job_status_id'] = $row['job_status_id'];
				$status_data[$key]['client_id'] = $row['client_id'];
				$status_data[$key]['service_id'] = $row['service_id'];
				$status_data[$key]['status_id'] = $row['status_id'];
			}
		}
		return $status_data;
	}

	public static function getJobStatusByServiceId($service_id, $clientId)
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$status_data = array();
		$JobStatus	= JobStatus::whereIn("user_id", $groupUserId)->whereIn("client_id", $clientId)->where("service_id", "=", $service_id)->where("is_completed","=", "N")->get();
		if(isset($JobStatus) && count($JobStatus) >0){
			foreach ($JobStatus as $key => $row) {
				$status_data[$key]['job_status_id'] = $row['job_status_id'];
				$status_data[$key]['client_id'] = $row['client_id'];
				$status_data[$key]['service_id'] = $row['service_id'];
				$status_data[$key]['status_id'] = $row['status_id'];
			}
		}
		return $status_data;
	}

	public static function getCompletedJobStatusByClientId($service_id, $client_id)
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$status_data = array();
		$JobStatus	= JobStatus::whereIn("user_id", $groupUserId)->where("client_id", $client_id)->where("service_id", "=", $service_id)->where("is_completed","=", "Y")->first();
		if(isset($JobStatus) && count($JobStatus) >0){
			$status_data['job_status_id'] 	= $JobStatus['job_status_id'];
			$status_data['client_id'] 		= $JobStatus['client_id'];
			$status_data['service_id'] 		= $JobStatus['service_id'];
			$status_data['status_id'] 		= $JobStatus['status_id'];
			$status_data['created'] 		= $JobStatus['created'];
		}
		return $status_data;
	}

	public static function getJobStatusByStatusId($service_id, $status_id, $clientId)
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$status_data = array();
		$JobStatus	= JobStatus::whereIn("user_id", $groupUserId)->whereIn("client_id", $clientId)->where("service_id","=",$service_id)->where("is_completed","=", "N")->where("status_id","=",$status_id)->get();
		//Common::last_query();die;
		if(isset($JobStatus) && count($JobStatus) >0){
			foreach ($JobStatus as $key => $row) {
				$status_data[$key]['job_status_id'] = $row['job_status_id'];
				$status_data[$key]['client_id'] 	= $row['client_id'];
				$status_data[$key]['service_id'] 	= $row['service_id'];
				$status_data[$key]['status_id'] 	= $row['status_id'];
			}
		}
		return $status_data;
	}

	public static function getCompletedTaskByServiceId( $service_id, $status_id, $clientId )
	{
		$clients 		= array();
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$client_data = array();
		$JobStatus	= JobsCompletedTask::whereIn("user_id", $groupUserId)->where("service_id","=",$service_id)->get();
		//Common::last_query();
		if(isset($JobStatus) && count($JobStatus) >0){
			foreach ($JobStatus as $key => $row) {
				$client_data[$key] = Common::clientDetailsById( $row->client_id );
				//$client_data[$key]['completed_tasks'] = JobsCompletedTask::getTaskByClientAndServiceId($row['client_id'], $service_id);
				//$client_data[$key]['job_status'][$service_id] = JobStatus::getCompletedJobStatusByClientId($service_id, $row['client_id']);
				$client_data[$key]['jobs_notes']['notes'] = $row->notes;
				$client_data[$key]['completed_tasks']['date'] = $row->date;
				$client_data[$key]['job_status'][$service_id]['filling_date'] = $row->filling_date;
			}
		}

		
		//$clients = array_merge($client_array, $client_data);

		//echo "<pre>";print_r($client_data);echo "</pre>";die;
		return array_values($client_data);
	}

	/*public static function getCompletedTaskByServiceId( $service_id, $status_id, $clientId )
	{
		$clients 		= array();
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$client_array = array();
		$client_details = Client::getClientByServiceId( $service_id );
		if(isset($client_details) && count($client_details) >0){
			foreach ($client_details as $key => $details) {
				
				if(isset($details['ch_manage_task']) && $details['ch_manage_task'] == "Y"){
        			if(isset($details['job_status'][$service_id]['status_id']) && $details['job_status'][$service_id]['status_id'] == 10){
        				//echo $details['job_status'][$service_id]['status_id'];
						$client_array[$key] = $client_details[$key];
						$client_array[$key]['completed_tasks'] = JobsCompletedTask::getTaskByClientAndServiceId($details['client_id'], $service_id);
						$client_array[$key]['jobs_notes'] = JobsNote::getNotesByClientAndServiceId($details['client_id'], $service_id);
					}
				}
				
			}
		}

		$client_data = array();
		$JobStatus	= JobStatus::whereIn("user_id", $groupUserId)->where("service_id","=",$service_id)->where("is_completed","=", "Y")->where("status_id","=",$status_id)->get();
		//Common::last_query();
		if(isset($JobStatus) && count($JobStatus) >0){
			foreach ($JobStatus as $key => $row) {
				$client_data[$key] = Common::clientDetailsById( $row['client_id'] );
				$client_data[$key]['completed_tasks'] = JobsCompletedTask::getTaskByClientAndServiceId($row['client_id'], $service_id);
				$client_data[$key]['job_status'][$service_id] = JobStatus::getCompletedJobStatusByClientId($service_id, $row['client_id']);
				$client_data[$key]['jobs_notes'] = JobsNote::getCompletedTaskNotes($row['client_id'], $service_id);
			}
		}

		
		$clients = array_merge($client_array, $client_data);

		//echo "<pre>";print_r($clients);echo "</pre>";die;
		return array_values($clients);
	}*/

	
	

	
}
