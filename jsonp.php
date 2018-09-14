<?php 
/**
* 
*/
class OpsAjaxAction
{
	protected $OpsWebinar;

	public function __construct()
	{
		$this->OpsWebinar = new OpsWebinar;
	}

	static public function init()
	{
		$self = new self();
		add_action( "wp_ajax_webinar_schedules", array($self, 'webinarSchedules') );
		add_action( "wp_ajax_nopriv_webinar_schedules", array($self, 'webinarSchedules') );
	}

	public function webinarSchedules()
	{
		header("content-type: text/javascript; charset=utf-8");
		header("access-control-allow-origin: *");
		

		$webinar_id = esc_sql($_GET['webinar_id']);
		$timezone = esc_sql($_GET['timezone']);
		// echo htmlspecialchars($_GET['callback']) . '(' . json_encode($_GET) . ')';
		// exit;
        $url  = "https://webinarjam.genndi.com/api/everwebinar/webinar";
        $data = [
            'api_key'    => $this->OpsWebinar::API_KEY,
            'webinar_id' => $webinar_id,
            'timezone'   => $timezone,
            'real_dates' => 1,
        ];

        $result = $this->OpsWebinar->post($url, $data);
        $resultArr = json_decode($result);
        $option = "";
        $cnt= 0;
        array_pop($resultArr->webinar->schedules);
        foreach ($resultArr->webinar->schedules as $schedule) {
        	$timezone = $resultArr->webinar->timezone;
        	$date = $schedule->date;
        	if($schedule->schedule == 'ir'){
        		$timezone = "";
        		$date = "Watch Yesterday's Reply Now";
        	}

        	$option .= "<option value='{$schedule->schedule}' data-icon='glyphicon glyphicon-calendar' data-subtext='{$timezone}'>{$date}</option>";
        		$cnt++;
        	
        }
        echo htmlspecialchars($_GET['callback']) . '(' . json_encode($option) . ')';
		exit;
	}
}
 ?>
 
 <script>
 $.ajax({
            type: "GET",
            url: 'https://maxout.com/wp-admin/admin-ajax.php',
            cache: false,
            dataType: "jsonp",              
            crossDomain: true,
            data: {
                action: 'webinar_schedules',
                webinar_id: 'c39ee2c797',
                timezone: timezone
            }
        })
        .done(function(data) {
             $("[name='schedule_id']").append(data);
            console.log(data);
        })
        .fail(function(ts) {
            console.log('error');
        })
        .always(function() {
            console.log("complete");
        });
 </script>
