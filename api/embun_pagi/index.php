<?php

date_default_timezone_set('Asia/Jakarta');

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

require_once '../vendor/autoload.php';
require_once '../config/server.php';
require_once '../class/database/DB.php';
require_once '../class/functions.php';


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
	    'records'	=> array(),
	    'next'		=> 0
  	);

  	$date_next = ( !empty( $request->get('date_next') ) ? $request->get('date_next') : '' );
    $limit = ( !empty( $request->get('limit') ) ? $request->get('limit') : 6 );
    //$offset = ($page - 1) * $limit;
    
    $db->select('*, Date(date) as tanggal',false);
    $db->limit($limit+1);

    $db->where('published',1);
    if( !empty($date_next) )
    {
        $db->where('date <=',date('Y-m-d H:i:s',strtotime($date_next)));        
    }
    $db->order_by('date','desc');

    $query = $db->get('embun_pagi');

    if( $query->num_rows() > 0 )
    {
    	$result = $query->result();

    	if( !empty( $result[$limit] ) )
		{
			$data['next'] = date('Y-m-d',strtotime($result[$limit]->date));
			array_pop($result);
		}

    	foreach($result as $r)
    	{
    		$record = array(
    			'ep_id'		=> $r->ep_id,
    			'title'		=> $r->title,
    			'content'   => html_entity_decode($r->content, ENT_QUOTES, 'UTF-8'),
    			'excerpt'	=> html_entity_decode($r->excerpt, ENT_QUOTES, 'UTF-8'),
    			'verse'     => ( !empty($r->verse) && !ctype_space($r->verse) ) ? html_entity_decode($r->verse, ENT_QUOTES, 'UTF-8') : '',
                'date'      => date('Y-m-d',strtotime($r->date)),
    			'tanggal'   => generateTanggal($r->tanggal, true)
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

$app->get('/lists_update', function(Request $request) use($app)
{
    $db = DB();
    $data = array(
        'status'    => false,
        'message'   => '',
        'records'   => array()
    );

    $date = ( !empty( $request->get('date') ) ? $request->get('date') : date('Y-m-d') );
    $limit = ( !empty( $request->get('limit') ) ? $request->get('limit') : 6 );
    
    $db->select('*, Date(date) as tanggal',false);
    $db->limit($limit);

    $db->where('published',1);
    $db->where('date >',date('Y-m-d H:i:s',strtotime($date)));
    $db->order_by('date','asc');

    $query = $db->get('embun_pagi');

    if( $query->num_rows() > 0 )
    {
        $result = $query->result();

        foreach($result as $r)
        {
            $record = array(
                'gk_id'     => $r->ep_id,
                'title'     => $r->title,
                'content'   => html_entity_decode($r->content, ENT_QUOTES, 'UTF-8'),
                'excerpt'   => html_entity_decode($r->excerpt, ENT_QUOTES, 'UTF-8'),
                'verse'     => ( !empty($r->verse) && !ctype_space($r->verse) ) ? html_entity_decode($r->verse, ENT_QUOTES, 'UTF-8') : '',
                'date'      => $r->date,
                'tanggal'   => generateTanggal($r->tanggal, true)
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