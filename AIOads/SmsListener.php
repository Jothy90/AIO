<?php

include_once 'lib/sms/SmsReceiver.php';
include_once 'lib/sms/SmsSender.php';
include_once 'log.php';
ini_set('error_log', 'sms-app-error.log');

try {
    $receiver = new SmsReceiver(); // Create the Receiver object

    $content = $receiver->getMessage(); // get the message content
    $address = $receiver->getAddress(); // get the sender's address
    $requestId = $receiver->getRequestID(); // get the request ID
    $applicationId = $receiver->getApplicationId(); // get application ID
    $encoding = $receiver->getEncoding(); // get the encoding value
    $version = $receiver->getVersion(); // get the version

    logFile("[ content=$content, address=$address, requestId=$requestId, applicationId=$applicationId, encoding=$encoding, version=$version ]");
	
	//sendSMS("Test",$address);
    $responseMsg;

    //your logic goes here......
    $split = explode(' ', $content);
    //$responseMsg = bmiLogicHere($split);
	logFile("[response=kk]");

		//$con=mysqli_connect("184.73.170.96","tjeyjenthan","Tj4yJ4N7h@N","eshop");
		//$con=mysqli_connect("localhost","root","","eshop");
		$con=mysqli_connect("localhost","tjeyjenthan","Tj4yJ4N7h@N","eshop");
	logFile("[response1=kkk]");	
		if(!mysqli_fetch_array(mysqli_query($con,"select * from user where mask='$address'"))){
			mysqli_query($con,"INSERT INTO user(mask)VALUES ('$address')");	
		}
		logFile("[response2=kkkk]");		

		// Check connection
		if (mysqli_connect_errno()) {
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

		//$content="dia john Phonef Nokiaj 350 0777771542";
		$split = explode(' ', $content);
		if(strcmp($split[0],"ads")==0){
			$rows=mysqli_query($con,"select * from user where mask='$address'");
			while($rowid = mysqli_fetch_array($rows)) {
				$id=$rowid['id'];
				$maskm=$rowid['mask'];
			}
			
			if(strcmp($split[1],"sell")==0){		
				mysqli_query($con,"INSERT INTO sell_items(name, brand,price,phone_no,user_id)VALUES ('$split[2]','$split[3]','$split[4]','$split[5]','$id')");
				$buyitems=mysqli_query($con,"select * from buy_items where name='".$split[2]."'");
				while($row = mysqli_fetch_array($buyitems)) {
					sendSMS($row['brand']." ".$row['name']." want for ".$row['price']." contact:" .$row['phone_no'],$maskm);
					if($row['user_id']!=null){
						//sendSMS("$split[2] wanted $split[3] $split[4] $split[5]",mysqli_query($con,"select u.mask from buy_items as bi left join user as u on bi.user_id=u.id where bi.id=$row['id']")) ;				
					}
				}
			}
			elseif(strcmp($split[1],"buy")==0){
				mysqli_query($con,"INSERT INTO buy_items(name, brand,price,phone_no,user_id)VALUES ('$split[2]','$split[3]','$split[4]','$split[5]','$id')");
				$sellitems=mysqli_query($con,"select * from sell_items where name='".$split[2]."'");
				while($row = mysqli_fetch_array($sellitems)) {
					sendSMS($row['brand']." ".$row['name']." sale for ".$row['price']." contact:" .$row['phone_no'],$maskm) ;
					if($row['user_id']!=null){
						//sendSMS("$split[2] wanted $split[3] $split[4] $split[5]",mysqli_query($con,"select u.mask from buy_items as bi left join user as u on bi.user_id=u.id where bi.id=$row['id']")) ;				
					}
				}	
			}
		}
		mysqli_close($con);
    

} catch (SmsException $ex) {
    //throws when failed sending or receiving the sms
    error_log("ERROR: {$ex->getStatusCode()} | {$ex->getStatusMessage()}");
}

function bmiLogicHere($split)
{
    if (sizeof($split) < 2) {
        $responseMsg = "Invalid message content";
    } else {
        $weight = (float)$split[0];
        $height = (float)$split[1];
		
        $responseMsg = "kk";
    }
    return $responseMsg;
}

function sendSMS($s1,$s2)
{

    $responseMsg = $s1;

    // Create the sender object server url
    //$sender = new SmsSender("http://api.dialog.lk:8080/sms/send");
	 //$sender = new SmsSender("http://localhost:7000/sms/send");
	 $sender = new SmsSender("https://localhost:7443/sms/send");
    //sending a one message

 	$applicationId = "APP_007544";
 	$encoding = "1";
 	$version =  "1.0";
    $password = "493d1c69ec75b0d6b1bda602e9c31373";
    $sourceAddress = "77200";
    $deliveryStatusRequest = "0";
    $charging_amount = ":15.75";
    //$destinationAddresses = array($s2);
	$destinationAddresses = $s2;
    $binary_header = "";
	//logFile("[ applicationId=$applicationId, password=$password, requestId=$requestId, applicationId=$applicationId, encoding=$encoding, version=$version ]");
    $res = $sender->sms($responseMsg, $destinationAddresses, $password, $applicationId, $sourceAddress, $deliveryStatusRequest, $charging_amount, $encoding, $version, $binary_header);
	//logFile("[res=$res]");

}


?>