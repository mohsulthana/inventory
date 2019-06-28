<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Model extends CI_Model
{
	protected $data = [];

	public function __construct()
	{
		parent::__construct();
	}

	public function affected_rows()
	{
		return $this->db->affected_rows();
	}

	public function get($cond = '')
	{
		if (is_array($cond))
			$this->db->where($cond);
		if (is_string($cond) && strlen($cond) > 3)
			$this->db->where($cond);

		$query = $this->db->get($this->data['table_name']);

		return $query->result();
	}
	public function getarray($cond = '')
	{
		if (is_array($cond))
			$this->db->where($cond);
		if (is_string($cond) && strlen($cond) > 3)
			$this->db->where($cond);

		$query = $this->db->get($this->data['table_name']);

		return $query->result_array();
	}

	public function get_by_order($ref, $order, $cond = '')
	{
		if (is_array($cond))
			$this->db->where($cond);
		if (is_string($cond) && strlen($cond) > 3)
			$this->db->where($cond);

		$this->db->order_by($ref, $order);
		$query = $this->db->get($this->data['table_name']);

		return $query->result();
	}

	public function get_last_row($cond = '', $order_by = null)
	{
		if (is_array($cond))
			$this->db->where($cond);
		if (is_string($cond) && strlen($cond) > 3)
			$this->db->where($cond);
		if ($order_by != null)
			$this->db->order_by($order_by, 'DESC');
		$this->db->order_by($this->data['primary_key'], 'DESC');
		$this->db->limit(1);
		$query = $this->db->get($this->data['table_name']);

		return $query->row();
	}	

	public function get_by_order_limit($ref, $order, $cond = '')
	{
		if (is_array($cond))
			$this->db->where($cond);

		$this->db->order_by($ref, $order);
		$this->db->limit(1);
		$query = $this->db->get($this->data['table_name']);

		return $query->row();
	}

	public function get_by_order_any_limit($ref, $order, $number, $cond = '')
	{
		if (is_array($cond))
			$this->db->where($cond);

		$this->db->order_by($ref, $order);
		$this->db->limit($number);
		$query = $this->db->get($this->data['table_name']);

		return $query->result();
	}

	public function get_row($cond)
	{
		$this->db->where($cond);
		$query = $this->db->get($this->data['table_name']);

		return $query->row();
	}
	public function get_row_array($cond)
	{
		$this->db->where($cond);
		$query = $this->db->get($this->data['table_name']);

		return $query->row_array();
	}

	public function insert($data)
	{
		return $this->db->insert($this->data['table_name'], $data);
	}
	public function store($data)
	{
		$this->db->insert($this->data['table_name'], $data);
		return $this->db->insert_id();
	}

	public function update($pk, $data)
	{
		$this->db->where($this->data['primary_key'], $pk);
		return $this->db->update($this->data['table_name'], $data);
	}

	public function update_where($cond, $data)
	{
		$this->db->where($cond);
		return $this->db->update($this->data['table_name'], $data);
	}

	public function delete($pk)
	{
		$this->db->where($this->data['primary_key'], $pk);
		return $this->db->delete($this->data['table_name']);
	}
	public function delete2($pk)
	{
		$data = [ 'status' => 0 ];
		$this->db->where($this->data['primary_key'], $pk);
		return $this->db->update($this->data['table_name'], $data);
	}
	public function delete_by($cond)
	{
		$this->db->where($cond);
		return $this->db->delete($this->data['table_name']);
	}

	public function getOrdered($order = 'ASC')
	{
		$query = $this->db->query('SELECT * FROM ' . $this->data['table_name'] . ' ORDER BY ' . $this->data['primary_key'] . ' ' . $order);
		return $query->result();
	}

	public function getDataLike($like)
	{
		$this->db->select('*');
		$this->db->like($like);
		$query = $this->db->get($this->data['table_name']);
		return $query->result();
	}

	public function getDataJoin($tables, $jcond)
	{
		$this->db->select('*');
		for ($i = 0; $i < count($tables); $i++)
			$this->db->join($tables[$i], $jcond[$i]);
		return $this->db->get($this->data['table_name'])->result();
	}

	public function getdanpembimbing($id)
	{
		/*$this->db->select('*');
		$this->db->join($tables, $jcond,'left');
		$this->db->where($cond);
		return $this->db->get_compiled_select();
		// return $this->db->get('pengajuan_proposal')->row();*/

		$sql = "
		select * from ".$this->data['table_name']." 
		left join membimbing 
		on ".$this->data['table_name'].".id_mahasiswa=membimbing.id_mahasiswa
		where id_".$this->data['table_name']." = ".$id."";
		return $this->db->query($sql)->row();
	}
	public function getJSON($url)
	{
		$content = file_get_contents($url);
		$data = json_decode($content);
		return $data;
	}

	public function validate($conf)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules($conf);
		return $this->form_validation->run();
	}

	public function required_input($input_names)
	{
		$rules = [];
		foreach ($input_names as $input)
		{
			$rules []= [
				'field'		=> $input,
				'label'		=> ucfirst($input),
				'rules'		=> 'required'
			];
		}

		return $this->validate($rules);
	}

	public function flashmsg($msg, $type = 'success')
	{
		return $this->session->set_flashdata('msg', '<div class="alert alert-'.$type.'">'.$msg.'</div>');
	}

	public function get_col($col)
	{
		$query = $this->db->query('SELECT '.$col.' FROM ' . $this->data['table_name']);
		return $query->result();
	}

}
