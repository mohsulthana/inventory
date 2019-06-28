<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends CI_Controller
{
	public $title = ' | SITA';
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
		ini_set("allow_url_fopen", 1);
	}

	public function template($data)
	{
		return $this->load->view('template/layout', $data);
	}
	public function POST($name)
	{
		return $this->input->post($name);
	}

	public function flashmsg($msg, $type = 'success',$name='msg')
	{
		return $this->session->set_flashdata($name, '<div class="alert alert-'.$type.' alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$msg.'</div>');
	}

	public function upload($id, $directory, $tag_name = 'userfile')
	{
		if ($_FILES[$tag_name])
		{
			$upload_path = realpath(APPPATH . '../assets/img/' . $directory . '/');
			@unlink($upload_path . '/' . $id . '.jpg');
			$config = [
				// 'file_name' 		=> $id . '.jpg',
				'file_name' 		=> $id,
				'allowed_types'		=> 'jpg|png|bmp|jpeg',
				'upload_path'		=> $upload_path
			];
			$this->load->library('upload');
			$this->upload->initialize($config);
			return $this->upload->do_upload($tag_name);
		}
		return FALSE;
	}
	public function upload_proposal($id, $directory, $tag_name = 'userfile')
	{
		if ($_FILES[$tag_name])
		{
			$upload_path = "./assets/proposal/";
			// $upload_path = realpath(FCPATH . '../' . $directory . '/');
			@unlink($upload_path . '/' . $id . '.jpg');
			$config = [
				// 'file_name' 		=> $id . '.jpg',
				'file_name' 		=> $id,
				'allowed_types'		=> 'doc|docx|pdf',
				'upload_path'		=> $upload_path
			];
			// print_r($config);
			// print_r($tag_name);
			$this->load->library('upload');
			$this->upload->initialize($config);
			if (!$this->upload->do_upload($tag_name)) {
				print_r($this->upload->display_errors());
			};
		}
		return FALSE;
	}
	public function upload_semhas($id, $directory, $tag_name = 'userfile')
	{
		if ($_FILES[$tag_name])
		{
			$upload_path = "./assets/semhas/";
			// $upload_path = realpath(FCPATH . '../' . $directory . '/');
			@unlink($upload_path . '/' . $id . '.jpg');
			$config = [
				// 'file_name' 		=> $id . '.jpg',
				'file_name' 		=> $id,
				'allowed_types'		=> 'doc|docx|pdf',
				'upload_path'		=> $upload_path
			];
			// print_r($config);
			// print_r($tag_name);
			$this->load->library('upload');
			$this->upload->initialize($config);
			if (!$this->upload->do_upload($tag_name)) {
				print_r($this->upload->display_errors());
			};
		}
		return FALSE;
	}
	public function upload_pendadaran($id, $directory, $tag_name = 'userfile')
	{
		if ($_FILES[$tag_name])
		{
			$upload_path = "./assets/pendadaran/";
			// $upload_path = realpath(FCPATH . '../' . $directory . '/');
			@unlink($upload_path . '/' . $id . '.jpg');
			$config = [
				// 'file_name' 		=> $id . '.jpg',
				'file_name' 		=> $id,
				'allowed_types'		=> 'doc|docx|pdf',
				'upload_path'		=> $upload_path
			];
			// print_r($config);
			// print_r($tag_name);
			$this->load->library('upload');
			$this->upload->initialize($config);
			if (!$this->upload->do_upload($tag_name)) {
				print_r($this->upload->display_errors());
			};
		}
		return FALSE;
	}
	public function upload_arsip($id, $directory, $tag_name = 'userfile')
	{
		if ($_FILES[$tag_name])
		{
			$upload_path = "./assets/arsip/";
			// $upload_path = realpath(FCPATH . '../' . $directory . '/');
			@unlink($upload_path . '/' . $id . '.jpg');
			$config = [
				// 'file_name' 		=> $id . '.jpg',
				'file_name' 		=> $id,
				'allowed_types'		=> 'doc|docx|pdf|zip|rar',
				'upload_path'		=> $upload_path
			];
			// print_r($config);
			// print_r($tag_name);
			$this->load->library('upload');
			$this->upload->initialize($config);
			if (!$this->upload->do_upload($tag_name)) {
				print_r($this->upload->display_errors());
			};
		}
		return FALSE;
	}
	public function upload_berkas($id, $directory, $tag_name = 'userfile')
	{
		if ($_FILES[$tag_name])
		{
			$upload_path = "./assets/berkas/";
			// $upload_path = realpath(FCPATH . '../' . $directory . '/');
			@unlink($upload_path . '/' . $id . '.jpg');
			$config = [
				// 'file_name' 		=> $id . '.jpg',
				'file_name' 		=> $id,
				'allowed_types'		=> 'doc|docx|pdf|zip|rar',
				'upload_path'		=> $upload_path
			];
			// print_r($config);
			// print_r($tag_name);
			$this->load->library('upload');
			$this->upload->initialize($config);
			if (!$this->upload->do_upload($tag_name)) {
				print_r($this->upload->display_errors());
			};
		}
		return FALSE;
	}

	public function dump($var)
	{
		echo '<pre>';
		var_dump($var);
		echo '</pre>';
	}

	public function import($tag_name = 'userfile')
	{
		$config = [
			'file_name'		=> 'temp.xlsx',
			'allowed_types' => 'xls|xlsx',
			'upload_path'	=> realpath(APPPATH . '../assets/excel/')
		];
		$this->load->library('upload', $config);
		$this->upload->do_upload($tag_name);
	}
	public function downloadberkas()
	{
		ob_start();
		$this->load->helper('download');
		$path2  = $this->uri->segment(3, 0);
		// // force_download('assets/berkas/'.$path.'', NULL);
		ini_set("allow_url_fopen", 1);
		 $pth    =   file_get_contents(base_url()."assets/berkas/".$path2);
		 $nme    =   $path2;
		 force_download($pth,NULL);
		//echo $path2;
		 ob_end_flush();

	}
	public function downloadarsip()
	{
		$this->load->helper('download');
		$path2  = $this->uri->segment(3, 0);
		// force_download('assets/berkas/'.$path.'', NULL);
		$pth    =   file_get_contents(base_url()."assets/arsip/".$path2);
		$nme    =   $path2;
		force_download($nme, $pth);
		// echo "a";
		// echo $pth;
	}
	public function downloadproposal()
	{
		$this->load->helper('download');
		$path2  = $this->uri->segment(3, 0);
		// force_download('assets/berkas/'.$path.'', NULL);
		// $pth    =   file_get_contents(base_url()."assets/proposal/".$path2);
		$pth    =   file_get_contents(base_url()."assets/proposal/".$path2);
		$nme    =   $path2;
		force_download($nme, $pth);
	}
	public function downloadsemhas()
	{
		$this->load->helper('download');
		$path2  = $this->uri->segment(3, 0);
		// force_download('assets/berkas/'.$path.'', NULL);
		$pth    =   file_get_contents(base_url()."assets/semhas/".$path2);
		$nme    =   $path2;
		force_download($nme, $pth);
	}
	public function downloadpendadaran()
	{
		$this->load->helper('download');
		$path2  = $this->uri->segment(3, 0);
		// force_download('assets/berkas/'.$path.'', NULL);
		$pth    =   file_get_contents(base_url()."assets/pendadaran/".$path2);
		$nme    =   $path2;
		force_download($nme, $pth);
	}
	// public function downloadberkas()
	// {
	// 	$path2  = $this->uri->segment(3, 0);
	// 	$a = urlencode($path2);
	// 	$b = urldecode($path2);
	// 	$c = $path2;
	// 	$d = htmlentities($path2);
	// 	$e = htmlspecialchars($path2);
	// 	echo $a."<br>";
	// 	echo $b."<br>";
	// 	echo $c."<br>";
	// 	echo $d."<br>";
	// 	echo $e."<br>";
	// 	// header('Content-Transfer-Encoding: binary');  // For Gecko browsers mainly
	// 	// header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($path)) . ' GMT');
	// 	// header('Accept-Ranges: bytes');  // Allow support for download resume
	// 	// header('Content-Length: ' . filesize($path));  // File size
	// 	// header('Content-Encoding: none');
	// 	// header('Content-Type: application/pdf');  // Change the mime type if the file is not PDF
	// 	// header('Content-Disposition: attachment; filename=' . $filename);  // Make the browser display the Save As dialog
	// 	// readfile($path);
	// }



}
