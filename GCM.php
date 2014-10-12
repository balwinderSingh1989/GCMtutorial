<?php
	//generic php function to send GCM push notification
   function sendPushNotificationToGCM($registatoin_ids, $message) {
		//Google cloud messaging GCM-API url
        $url = 'https://android.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
        );
		// Google Cloud Messaging GCM API Key
		define("GOOGLE_API_KEY", "AIzaSyBEd09MHLeUu7Mwn3tHlcIjojHGt3c1py8"); 		
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);	
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);				
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
?>
<?php
	
	//this block is to post message to GCM on-click
	$pushStatus = "";	
	if(!empty($_GET["push"])) {	
		$gcmRegID  = 'APA91bF12Dzp3TQ6DNMzAQMTaqbRzXYvd6l7sWhSQSsK3Wrq8wSOdLKxnTpk0UfUJbJJ50fYcM_JVw0_87DYDwjQp83sln5JQgE54ZG8pEAkQHtUHsUGproh0EqPeQDGrmo0KBQC-GlzbevineEZwkhaah0qlJga2r3a_exoDbbC8w0gh7lCCOM';


		$pushMessage = $_POST["message"];	
		if (isset($gcmRegID) && isset($pushMessage)) {		
			$gcmRegIds = array($gcmRegID);
			$message = array("m" => $pushMessage);	
			$pushStatus = sendPushNotificationToGCM($gcmRegIds, $message);
		}		
	}
	
		
?>
<html>
    <head>
        <title>Welcome To Google Cloud Messaging (GCM) Server</title>
    </head>
	<body>
		<h1>Google Cloud Messaging(Tech-Papers)</h1>	
		<form method="post" action="gcm.php/?push=1">					                             
			<div>                                
				<textarea rows="2" name="message" cols="23" placeholder="Your Message"></textarea>
			</div>
			<div><input type="submit"  value="Send Push Notification via GCM" /></div>
		</form>
		<p><h3><?php echo $pushStatus; ?></h3></p>        
    </body>
</html>
