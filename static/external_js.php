<?php
$files = array(
  'google_tag.js' => 'https://www.googletagmanager.com/gtag/js?id=UA-69397952-1',
  'google_analytics.js' => 'https://www.google-analytics.com/analytics.js',
  'google_adsense.js' => 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js',
  'highcharts.js' => 'https://code.highcharts.com/highcharts.js',
  'highcharts_exporting.js' => 'https://code.highcharts.com/modules/exporting.js',
  'fb_api_vi_VN.js' => 'https://connect.facebook.net/vi_VN/sdk.js',
  'fb_api_en_US.js' => 'https://connect.facebook.net/en_US/sdk.js',
);
if(isset($files[$_GET['file']])) {
  $header[] = 'Content-Type: application/javascript';
  $header[] = 'Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + ((60 * 60) * 24 * 7 * 4));
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $files[$_GET['file']]);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
  $output = curl_exec($ch);
  curl_close($ch);
  echo $output;
}
?>