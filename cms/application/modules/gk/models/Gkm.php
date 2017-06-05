<?php
class Gkm extends CI_Model {

	function __construct()
    {
        parent::__construct();

    }

    function gets($param = array())
    {
    	if(!empty($param['where']))
        {
            $this->db->where($param['where']);
        }

    	if( !empty($param['order']) )
        {
            $this->db->order_by($param['order']['column'].' '.$param['order']['dir']);
        }
        else
        {
    	   $this->db->order_by('date');
        }
        

        if(!empty($param['length']))
        {
            $this->db->limit($param['length'],$param['start']);
        }

        $query = $this->db->get('garam_keluarga');

        if($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }

    function get($id = null)
    {
    	if( !empty($id) )
    	{
    		$this->db->where('gk_id',$id);
		 	$query = $this->db->get('garam_keluarga');

	        if($query->num_rows() > 0)
	    	{
	    		return $query->row();
	    	}
    	}

    }

    function get_count($where = array())
    {
    	$this->db->select('COUNT(*) as total',false);

    	if(!empty($where))
        {
            $this->db->where($where);
        }

    	$query = $this->db->get('garam_keluarga');

    	if($query->num_rows() > 0)
    	{
    		return $query->row();
    	}
    }

    function add($data = array())
    {
    	$result = array(
    		'status' 	=> false,
    		'message'	=> array(
    			'type' 	=> 'danger',
    			'text'	=> 'simpan data error'
    		)
    	);

    	if( !empty($data) )
    	{
    		$query = $this->db->insert('garam_keluarga',$data);
    		if( $query )
    		{
    			$result = array(
		    		'status' 	=> false,
		    		'message'	=> array(
		    			'type' 	=> 'success',
		    			'text'	=> 'simpan data sukses'
		    		)
		    	);
    		}
    	}

    	return $result;

    }

    function edit($data = array(), $id = null)
    {
    	$result = array(
    		'status' 	=> false,
    		'message'	=> array(
    			'type' 	=> 'danger',
    			'text'	=> 'simpan data error'
    		)
    	);

    	if( !empty($data) && !empty($id) )
    	{
    		$this->db->where('gk_id',$id);
    		$query = $this->db->update('garam_keluarga',$data);
    		if( $query )
    		{
    			$result = array(
		    		'status' 	=> false,
		    		'message'	=> array(
		    			'type' 	=> 'success',
		    			'text'	=> 'simpan data sukses'
		    		)
		    	);
    		}
    	}

    	return $result;

    }

    function delete($id = null)
    {
    	$result = array(
    		'status' 	=> false,
    		'message'	=> array(
    			'type' 	=> 'danger',
    			'text'	=> 'hapus data error'
    		)
    	);

    	if( !empty($id) )
    	{
    		$this->db->where('gk_id',$id);
    		$query = $this->db->delete('garam_keluarga');
    		if( $query )
    		{
    			$result = array(
		    		'status' 	=> false,
		    		'message'	=> array(
		    			'type' 	=> 'success',
		    			'text'	=> 'hapus data sukses'
		    		)
		    	);
    		}
    	}

    	return $result;

    }

    function bulk_delete($ids = array())
    {
    	$result = array(
    		'status' 	=> false,
    		'message'	=> array(
    			'type' 	=> 'danger',
    			'text'	=> 'hapus data error'
    		)
    	);

    	if( !empty($ids) )
    	{
    		$this->db->where_in('gk_id',$ids);
    		$query = $this->db->delete('garam_keluarga');
    		if( $query )
    		{
    			$result = array(
		    		'status' 	=> false,
		    		'message'	=> array(
		    			'type' 	=> 'success',
		    			'text'	=> 'hapus data sukses'
		    		)
		    	);
    		}
    	}

    	return $result;

    }



}