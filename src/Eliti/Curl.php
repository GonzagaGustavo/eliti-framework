
<?php

class Eliti_Curl
{

  public static function POST($url)
  {
    $ch = curl_init();

    // curl_setopt($ch, CURLOPT_URL, "http://localhost/events");
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    // curl_setopt(
    //   $ch,
    //   CURLOPT_POSTFIELDS,
    //   "postvar1=value1&postvar2=value2&postvar3=value3"
    // );

    // In real life you should use something like:
    // curl_setopt($ch, CURLOPT_POSTFIELDS, 
    //          http_build_query(array('postvar1' => 'value1')));

    // Receive server response ...
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);

    curl_close($ch);

    return $server_output;
  }
}
