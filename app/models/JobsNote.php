<?php
class JobsNote extends Eloquent {

	public $timestamps = false;
	public static function getNotesByClientAndServiceId($client_id, $service_id)
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$status_data = array();
		$JobStatus	= JobsNote::whereIn("user_id", $groupUserId)->where("client_id","=", $client_id)->where("service_id","=", $service_id)->first();
		if(isset($JobStatus) && count($JobStatus) >0){
			$status_data['jobs_notes_id'] 	= $JobStatus['jobs_notes_id'];
			$status_data['client_id'] 		= $JobStatus['client_id'];
			$status_data['service_id'] 		= $JobStatus['service_id'];
			$status_data['user_id'] 		= $JobStatus['user_id'];
			$status_data['notes'] 			= $JobStatus['notes'];
			$status_data['job_start_date']	= $JobStatus['job_start_date'];
			$status_data['created'] 		= $JobStatus['created'];
		}
		return $status_data;
	}

	public static function getCompletedTaskNotes($client_id, $service_id)
	{
		$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

		$status_data = array();
		$JobStatus	= JobStatus::whereIn("user_id", $groupUserId)->where("client_id","=", $client_id)->where("service_id","=", $service_id)->where("is_completed","=", "Y")->where("status_id","=", 10)->first();
		if(isset($JobStatus) && count($JobStatus) >0){
			$status_data['job_status_id'] 	= $JobStatus['job_status_id'];
			$status_data['client_id'] 		= $JobStatus['client_id'];
			$status_data['service_id'] 		= $JobStatus['service_id'];
			$status_data['user_id'] 		= $JobStatus['user_id'];
			$status_data['notes'] 			= $JobStatus['notes'];
			$status_data['status_id']		= $JobStatus['status_id'];
			$status_data['is_completed']	= $JobStatus['is_completed'];
			$status_data['created'] 		= $JobStatus['created'];
		}
		return $status_data;
	}

}
