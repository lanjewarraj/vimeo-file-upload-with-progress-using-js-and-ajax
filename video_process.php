
<?php
//allow script execution time upto 5 minutes
//ini_set('max_execution_time', 300); 
require('vendor/autoload.php');
require_once('config/config.php');
use Vimeo\Vimeo;


if(!empty($_FILES['file1'])){
    //vimeo configuration file
    $client = new Vimeo($Client_id,$Client_secrets,$Access_token);
    $response = $client->request('/tutorial', array(), 'GET');
    
    //get file name
    $video_name = $_FILES['file1']['name'];
   
    
    $file_tmp = $_FILES['file1']['tmp_name'];
    
    $file_name = "$file_tmp";
    
	$uri = $client->upload($file_name, array(
		"name" => "vid name",
		"description" => "desc",
        'privacy' => array(
            'view' => 'disable',
            'embed' => 'whitelist'
        ),
    ));

    $response = $client->request($uri . '?fields=transcode.status');
    if ($response['body']['transcode']['status'] === 'complete') {
        print 'Your video finished transcoding.';
    } 
    elseif ($response['body']['transcode']['status'] === 'in_progress') {
        print 'Video Uploading Done. (your video is still processing..please try to access your video after few minutes)';
    }
    else {
	   print 'Your video encountered an error during transcoding.';
    }
    
    
    $response = $client->request($uri . '?fields=link');
    $video_link = $response['body']['link'];
    
    $get_vid_id = explode("/",$video_link);
    
    //echo $get_vid_id = $get_vid_id['3'];
    
    //below is uploaded video Id
    echo $get_vid_id = $get_vid_id['3'];
}
