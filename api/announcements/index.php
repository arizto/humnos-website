<?php

date_default_timezone_set('Asia/Jakarta');

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

require_once '../vendor/autoload.php';
require_once '../config/server.php';
require_once '../class/database/DB.php';


$app = new Silex\Application();
$app['debug'] = true;


$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});


$app->get('/lists', function(Request $request) use($app)
{
  	$db = DB();
  	$data = array(
	    'status'  	=> false,
        'message'   => '',
	    'records'	=> array()
  	); 
    
    $db->limit(10);

    $db->where('published',1);
    $db->order_by('updated','desc');

    $query = $db->get('announcements');

    if( $query->num_rows() > 0 )
    {
    	$result = $query->result();

    	foreach($result as $r)
    	{
    		$record = array(
    			'announcement_id'    => $r->announcement_id,
    			'content'    => html_entity_decode($r->content, ENT_QUOTES, 'UTF-8'),
    			'excerpt'    => html_entity_decode($r->excerpt, ENT_QUOTES, 'UTF-8')
    		);

    		$data['records'][] = $record;
    	}

    	$data['status'] = true;
    }

  	$dataJson = json_encode($data);
  	return new Response($dataJson, 200, array(
        "Content-Type" => 'application/json'
    ));
});


$app->run();


?>