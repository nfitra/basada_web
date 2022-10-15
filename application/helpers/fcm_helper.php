<?php

function sendFCM($title, $body, $registrationIds, $imageUrl = null)
{
  // FCM API Url
  $url = 'https://fcm.googleapis.com/fcm/send';

  // Put your Server Key here
  $apiKey = "AAAAPNnOx1w:APA91bHuxcXKHaC2RWW2vdfvTxbryp9v4S8HEfqu5PH5SS-W-gE0MEmXhFyyCf_4krou0s4O_2U1nYITRM0AFCP0ZZSR94xrq2qK-_Ik4XuRlofklMIVF09THzqrdYI_ZQXaGBCO2w1R";

  // Compile headers in one variable
  $headers = array(
    'Authorization:key=' . $apiKey,
    'Content-Type:application/json'
  );

  if ($imageUrl != null) {
    $notifData = [
      'title' => $title,
      'body' => $body,
      'image' => $imageUrl
    ];
  } else {
    $notifData = [
      'title' => $title,
      'body' => $body
    ];
  }

  // $dataPayload = ['to'=> 'My name', 
  // 'points'=>80, 
  // 'other_data' => 'This is extra payload'
  // ];

  // Create the api body
  $apiBody = [
    'notification' => $notifData,
    //'data' => $dataPayload, //Optional
    //'time_to_live' => 600, // optional - In Seconds
    //'to' => '/topics/mytargettopic'
    'registration_ids' => $registrationIds,
    // 'to' => 'cc3y906oCS0:APA91bHhifJikCe-6q_5EXTdkAu57Oy1bqkSExZYkBvL6iKCq2hq3nrqKWymoxfTJRnzMSqiUkrWh4uuzzEt3yF5KZTV6tLQPOe9MCepimPDGTkrO8lyDy79O5sv046-etzqCGmKsKT4'
  ];

  // Initialize curl with the prepared headers and body
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($apiBody));

  // Execute call and save result
  $result = json_decode(curl_exec($ch));
  // Close curl after call
  curl_close($ch);

  return $result;
}

function testHTTPRequest()
{
  // FCM API Url
  $url = 'https://api.agify.io/?name=bella';

  // Compile headers in one variable
  $headers = array(
    'Content-Type:application/json'
  );

  // Initialize curl with the prepared headers and body
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($apiBody));

  // Execute call and save result
  $result = json_decode(curl_exec($ch));
  // Close curl after call
  curl_close($ch);

  return $result;
}
