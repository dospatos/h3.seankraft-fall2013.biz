<?php

class index_controller extends base_controller {
	
	/*-------------------------------------------------------------------------------------------------

	-------------------------------------------------------------------------------------------------*/
	public function __construct() {
		parent::__construct();
	} 
		
	/*-------------------------------------------------------------------------------------------------
	Accessed via http://localhost/index/index/
	-------------------------------------------------------------------------------------------------*/
	public function increment($counter_id = null) {
		

        # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);




        //if there is no counter ID we'll create a new one
        if ($counter_id == null) {
            $_POST['created'] = Time::now();
            $_POST['client_ip'] =$_SERVER['REMOTE_ADDR'];
            $_POST['elapsed_seconds'] = 0;
            $_POST['start'] = Time::now();
            $_POST['last_updated'] = Time::now();

            $counter_id = DB::instance(DB_NAME)->insert('timers', $_POST);
        } else {
            $q = "SELECT elapsed_seconds FROM timers WHERE timer_id = ".$counter_id;
            $existing_elapsed_seconds = DB::instance(DB_NAME)->select_field($q);

            $new_elapsed_seconds = $existing_elapsed_seconds + 1;

            $_POST['elapsed_seconds'] = $new_elapsed_seconds;
            $_POST['last_updated'] = Time::now();

            $returned_id = DB::instance(DB_NAME)->update('timers', $_POST, "WHERE timer_id = ".$counter_id." AND stop IS NULL");
        }

        //otherwise increment the counter by one

        echo json_encode(array($counter_id));

	} # End of method

    public function stop($counter_id) {
        # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);

        //stop the counter
        $_POST['stop'] = Time::now();
        $_POST['last_updated'] = Time::now();
        $counter_id = DB::instance(DB_NAME)->update('timers', $_POST, "WHERE timer_id = ".$counter_id." AND stop IS NULL");

        echo json_encode(array($counter_id));

    } # End of method
	
} # End of class
