<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P extends CI_Controller {
	public function __construct()
    {
    	parent::__construct();
    	$this->load->model('Kas_model');
    }
	
	public function index()
	{
		if ($this->session->userdata('username')) {
			redirect(base_url('p/beranda'));
		}else{
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('login');
			$this->load->view('template/footer');
		}
	}

	function login()
	{
		if ($this->session->userdata('username')) {
			redirect(base_url('p/beranda'));
		}else{
			$username 	= $this->input->post('username');
			$password 	= md5($this->input->post('password'));
			$result 	= $this->Kas_model->login($username,$password);
			if ($result){
				$sess = array(
				    'username'  => $result[0]['username'],
				    'name'  	=> $result[0]['name'],
				    'logged_in' => TRUE
				);
				$this->session->set_userdata($sess);
				redirect(base_url('p/beranda'));
			}else{
				$this->session->set_flashdata('message', 'Username atau password salah');
				redirect(base_url());
			}
		}
	}

	function beranda()
	{
		if ($this->session->userdata('username')) {
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('beranda');
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function masuk()
	{
		if ($this->session->userdata('username')) {
			$total = $this->Kas_model->row_masuk();
			$config['base_url'] 		= base_url().'p/masuk';
			$config['total_rows'] 		= $total;
			$config['per_page'] 		= 5;
	        $config['full_tag_open']    = '<div><ul class="pagination">';
	        $config['full_tag_close']   = '</ul></div>';
        	$config['first_link']       = '<li class="page-item page-link">Awal</li>';
        	$config['last_link']        = '<li class="page-item page-link">Akhir</li>';
	        $config['prev_link']        = '&laquo';
	        $config['prev_tag_open']    = '<li class="page-item page-link">';
	        $config['prev_tag_close']   = '</li>';
	        $config['next_link']        = '&raquo';
	        $config['next_tag_open']    = '<li class="page-item page-link">';
	        $config['next_tag_close']   = '</li>';
	        $config['cur_tag_open']     = '<li class="page-item page-link">';
	        $config['cur_tag_close']    = '</li>';
	        $config['num_tag_open']     = '<li class="page-item page-link">';
	        $config['num_tag_close']    = '</li>';
			$this->pagination->initialize($config);
			$from = $this->uri->segment(3);
			$data = array(
				'halaman' 	=> $this->pagination->create_links(), 
				'result' 	=> $this->Kas_model->masuk($config['per_page'], $from),
				'ttl' 		=> $this->Kas_model->total_masuk()
			);
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('masuk',$data);
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function pemasukan()
	{
		if ($this->session->userdata('username')) {
			$result = $this->Kas_model->nomor();
			if (empty($result[0]['nomor'])){ 
				$no = date('Ymd')."000001"; 
			} else { 
				$no = $result[0]['nomor']+1; 
			}
			$data['nomor'] = $no;
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('pemasukan',$data);
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function tambah_pemasukan()
	{
		if ($this->session->userdata('username')) {
			$data = array(
				'nomor'			=> $this->input->post('nomor'),
				'keterangan'	=> $this->input->post('keterangan'),
				'tanggal' 		=> $this->input->post('tanggal'),
				'jumlah' 		=> $this->input->post('jumlah'),
				'jenis' 		=> 'masuk'
			);
			$input = $this->Kas_model->tambah_pemasukan($data);
			if ($input){
				$this->session->set_flashdata('message', 'Data pemasukkan berhasil ditambahkan');
				redirect(base_url('p/masuk'));
			}else{
				$this->session->set_flashdata('message', 'Data pemasukan gagal ditambahkan');
				redirect(base_url('p/tambah_pemasukan'));
			}
		}else{
			redirect(base_url());
		}
	}

	function ubah_pemasukan($nomor)
	{
		if ($this->session->userdata('username')) {
			$result = $this->Kas_model->ambil_data($nomor);
			$data = array(
				'nomor'			=> $result[0]['nomor'],
				'keterangan'	=> $result[0]['keterangan'],
				'tanggal'		=> $result[0]['tanggal'],
				'jumlah'		=> $result[0]['jumlah']
			);
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('ubah_pemasukan', $data);
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function update_pemasukan()
	{
		if ($this->session->userdata('username')) {
			$data = array(
				'nomor'			=> $this->input->post('nomor'),
				'keterangan'	=> $this->input->post('keterangan'),
				'tanggal' 		=> $this->input->post('tanggal'),
				'jumlah' 		=> $this->input->post('jumlah'),
				'jenis' 		=> 'masuk'
			);
			$input = $this->Kas_model->ubah($this->input->post('nomor'),$data);
			if ($input){
				$this->session->set_flashdata('message', 'Data pemasukkan berhasil diubah');
				redirect(base_url('p/masuk'));
			}else{
				$this->session->set_flashdata('message', 'Data pemasukan gagal diubah');
				redirect(base_url('p/ubah_pemasukan/'.$this->input->post('nomor')));
			}
		}else{
			redirect(base_url());
		}
	}

	function hapus_pemasukan($nomor)
	{
		if ($this->session->userdata('username')) {
			$hapus = $this->Kas_model->hapus($nomor);
			if ($hapus){
				$this->session->set_flashdata('message', 'Data barhasil dihapus');
				redirect(base_url('p/masuk'));
			}else{
				$this->session->set_flashdata('message', 'Data gagal dihapus');
				redirect(base_url('p/masuk'));
			}
		}else{
			redirect(base_url());
		}
	}

	function keluar()
	{
		if ($this->session->userdata('username')) {
			$total = $this->Kas_model->row_keluar();
			$config['base_url'] 		= base_url().'p/keluar';
			$config['total_rows'] 		= $total;
			$config['per_page'] 		= 5;
	        $config['full_tag_open']    = '<div><ul class="pagination">';
	        $config['full_tag_close']   = '</ul></div>';
        	$config['first_link']       = '<li class="page-item page-link">Awal</li>';
        	$config['last_link']        = '<li class="page-item page-link">Akhir</li>';
	        $config['prev_link']        = '&laquo';
	        $config['prev_tag_open']    = '<li class="page-item page-link">';
	        $config['prev_tag_close']   = '</li>';
	        $config['next_link']        = '&raquo';
	        $config['next_tag_open']    = '<li class="page-item page-link">';
	        $config['next_tag_close']   = '</li>';
	        $config['cur_tag_open']     = '<li class="page-item page-link">';
	        $config['cur_tag_close']    = '</li>';
	        $config['num_tag_open']     = '<li class="page-item page-link">';
	        $config['num_tag_close']    = '</li>';
			$this->pagination->initialize($config);
			$from = $this->uri->segment(3);
			$data = array(
				'halaman' 	=> $this->pagination->create_links(),
				'result' 	=> $this->Kas_model->keluar($config['per_page'], $from),
				'ttl' 		=> $this->Kas_model->total_keluar() 
			);
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('keluar',$data);
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function pengeluaran()
	{
		if ($this->session->userdata('username')) {
			$result = $this->Kas_model->nomor();
			if (empty($result[0]['nomor'])){ 
				$no = date('Ymd')."000001"; 
			} else { 
				$no = $result[0]['nomor']+1; 
			}
			$data['nomor'] = $no;
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('pengeluaran',$data);
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function tambah_pengeluaran()
	{
		if ($this->session->userdata('username')) {
			$data = array(
				'nomor'			=> $this->input->post('nomor'),
				'keterangan'	=> $this->input->post('keterangan'),
				'tanggal' 		=> $this->input->post('tanggal'),
				'jumlah' 		=> $this->input->post('jumlah'),
				'jenis' 		=> 'keluar'
			);
			$input = $this->Kas_model->tambah_pengeluaran($data);
			if ($input){
				$this->session->set_flashdata('message', 'Data pengeluaran berhasil ditambahkan');
				redirect(base_url('p/keluar'));
			}else{
				$this->session->set_flashdata('message', 'Data pengeluaran gagal ditambahkan');
				redirect(base_url('p/tambah_pengeluaran'));
			}
		}else{
			redirect(base_url());
		}
	}

	function ubah_pengeluaran($nomor)
	{
		if ($this->session->userdata('username')) {
			$result = $this->Kas_model->ambil_data($nomor);
			$data = array(
				'nomor'			=> $result[0]['nomor'],
				'keterangan'	=> $result[0]['keterangan'],
				'tanggal'		=> $result[0]['tanggal'],
				'jumlah'		=> $result[0]['jumlah']
			);
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('ubah_pengeluaran', $data);
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function update_pengeluaran()
	{
		if ($this->session->userdata('username')) {
			$data = array(
				'nomor'			=> $this->input->post('nomor'),
				'keterangan'	=> $this->input->post('keterangan'),
				'tanggal' 		=> $this->input->post('tanggal'),
				'jumlah' 		=> $this->input->post('jumlah'),
				'jenis' 		=> 'keluar'
			);
			$input = $this->Kas_model->ubah($this->input->post('nomor'),$data);
			if ($input){
				$this->session->set_flashdata('message', 'Data pengeluaran berhasil diubah');
				redirect(base_url('p/keluar'));
			}else{
				$this->session->set_flashdata('message', 'Data pengeluaran gagal diubah');
				redirect(base_url('p/ubah_pengeluaran/'.$this->input->post('nomor')));
			}
		}else{
			redirect(base_url());
		}
	}

	function hapus_pengeluaran($nomor)
	{
		if ($this->session->userdata('username')) {
			$hapus = $this->Kas_model->hapus($nomor);
			if ($hapus){
				$this->session->set_flashdata('message', 'Data barhasil dihapus');
				redirect(base_url('p/keluar'));
			}else{
				$this->session->set_flashdata('message', 'Data gagal dihapus');
				redirect(base_url('p/keluar'));
			}
		}else{
			redirect(base_url());
		}
	}

	function laporan()
	{
		if ($this->session->userdata('username')) {
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('laporan');
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function laporan_harian()
	{
		if ($this->session->userdata('username')) {	
			if (!$this->uri->segment(3)){
				$cek = $this->input->post('tanggal');
			}else{
				$cek = $this->uri->segment(3);
			}
			$tgl_uri = str_replace('/','-',$cek);
			$tgldb = str_replace('-', '/', $cek);
			$total = $this->Kas_model->row_harian($tgldb);
			$config['base_url'] 		= base_url().'p/laporan_harian/'.$tgl_uri;
			$config['total_rows'] 		= $total;
			$config['per_page'] 		= 5;
	        $config['full_tag_open']    = '<div><ul class="pagination">';
	        $config['full_tag_close']   = '</ul></div>';
        	$config['first_link']       = '<li class="page-item page-link">Awal</li>';
        	$config['last_link']        = '<li class="page-item page-link">Akhir</li>';
	        $config['prev_link']        = '&laquo';
	        $config['prev_tag_open']    = '<li class="page-item page-link">';
	        $config['prev_tag_close']   = '</li>';
	        $config['next_link']        = '&raquo';
	        $config['next_tag_open']    = '<li class="page-item page-link">';
	        $config['next_tag_close']   = '</li>';
	        $config['cur_tag_open']     = '<li class="page-item page-link">';
	        $config['cur_tag_close']    = '</li>';
	        $config['num_tag_open']     = '<li class="page-item page-link">';
	        $config['num_tag_close']    = '</li>';
			$this->pagination->initialize($config);
			$from = $this->uri->segment(4);
			$data = array(
				'tanggal' 		=> $tgldb,
				'ttl_masuk'		=> $this->Kas_model->total_harian_masuk($tgldb),
				'ttl_keluar'	=> $this->Kas_model->total_harian_keluar($tgldb),
				'halaman' 		=> $this->pagination->create_links(),
				'result' 		=> $this->Kas_model->laporan_harian($tgldb,$config['per_page'], $from)
			);
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('laporan_harian',$data);
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function laporan_periode()
	{
		if ($this->session->userdata('username')) {
			if (!$this->uri->segment(3) && !$this->uri->segment(4)){
				$tgl_mulai = str_replace('/','-',$this->input->post('tgl_mulai'));
				$tgl_sampai = str_replace('/','-',$this->input->post('tgl_sampai'));
			}else{
				$tgl_mulai = $this->uri->segment(3);
				$tgl_sampai = $this->uri->segment(4);
			}
			$tgl_mulai_db = str_replace('-','/',$tgl_mulai);
			$tgl_sampai_db = str_replace('-','/',$tgl_sampai);
			$total = $this->Kas_model->row_periode($tgl_mulai_db, $tgl_sampai_db);
			$config['base_url'] 		= base_url().'p/laporan_periode/'.$tgl_mulai.'/'.$tgl_sampai;
			$config['total_rows'] 		= $total;
			$config['per_page'] 		= 5;
	        $config['full_tag_open']    = '<div><ul class="pagination">';
	        $config['full_tag_close']   = '</ul></div>';
        	$config['first_link']       = '<li class="page-item page-link">Awal</li>';
        	$config['last_link']        = '<li class="page-item page-link">Akhir</li>';
	        $config['prev_link']        = '&laquo';
	        $config['prev_tag_open']    = '<li class="page-item page-link">';
	        $config['prev_tag_close']   = '</li>';
	        $config['next_link']        = '&raquo';
	        $config['next_tag_open']    = '<li class="page-item page-link">';
	        $config['next_tag_close']   = '</li>';
	        $config['cur_tag_open']     = '<li class="page-item page-link">';
	        $config['cur_tag_close']    = '</li>';
	        $config['num_tag_open']     = '<li class="page-item page-link">';
	        $config['num_tag_close']    = '</li>';
			$this->pagination->initialize($config);
			$from = $this->uri->segment(5);
			$data = array(
				'tgl_mulai' 	=> $tgl_mulai_db,
				'tgl_sampai'	=> $tgl_sampai_db,
				'ttl_masuk'		=> $this->Kas_model->total_periode_masuk($tgl_mulai,$tgl_sampai),
				'ttl_keluar'	=> $this->Kas_model->total_periode_keluar($tgl_mulai,$tgl_sampai),
				'halaman' 		=> $this->pagination->create_links(),
				'result' 		=> $this->Kas_model->laporan_periode($tgl_mulai_db, $tgl_sampai_db, $config['per_page'], $from)
			);
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('laporan_periode',$data);
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function cari()
	{
		if ($this->session->userdata('username')) {
			$key= $this->input->get('s'); 
	        $page=$this->input->get('per_page');  
	        $cari=array(
	            'nomor' => $key,
	            'keterangan' => $key,
	            'tanggal' => $key,
	            'jumlah' => $key,
	            'jenis' => $key,
	        );
	        $batas = 5;
	 		if(!$page){
				$offset = 0;
			}else{
				$offset = $page;
			}
			$this->load->model('Kas_model');
			$total = $this->Kas_model->row_cari($cari);
			$config['page_query_string'] = TRUE;
			$config['base_url'] = base_url().'p/cari?s='.$key;
			$config['total_rows'] = $total;
			$config['per_page'] = $batas;
			$config['uri_segment'] = $page;
	        $config['full_tag_open']    = '<div><ul class="pagination">';
	        $config['full_tag_close']   = '</ul></div>';
        	$config['first_link']       = '<li class="page-item page-link">Awal</li>';
        	$config['last_link']        = '<li class="page-item page-link">Akhir</li>';
	        $config['prev_link']        = '&laquo';
	        $config['prev_tag_open']    = '<li class="page-item page-link">';
	        $config['prev_tag_close']   = '</li>';
	        $config['next_link']        = '&raquo';
	        $config['next_tag_open']    = '<li class="page-item page-link">';
	        $config['next_tag_close']   = '</li>';
	        $config['cur_tag_open']     = '<li class="page-item page-link">';
	        $config['cur_tag_close']    = '</li>';
	        $config['num_tag_open']     = '<li class="page-item page-link">';
	        $config['num_tag_close']    = '</li>';
			$this->pagination->initialize($config);
			$data['cari'] = $key;
			$data['halaman'] = $this->pagination->create_links();
			$data['result'] = $this->Kas_model->cari($batas, $offset, $cari);
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('cari',$data);
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function bersihkan()
	{
		if ($this->session->userdata('username')) {
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('konfirmasi');
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function clean()
	{
		if ($this->session->userdata('username')) {
			$exec = $this->Kas_model->clean();
			if ($exec){
				$this->session->set_flashdata('message', 'Semua data berhasil dihapus');
				redirect(base_url('p/beranda'));
			}else{
				$this->session->set_flashdata('message', 'Semua data gagal dihapus');
				redirect(base_url('p/bersihkan'));
			}
		}else{
			redirect(base_url());
		}
	}

	function logout()
	{
		session_destroy();
		redirect(base_url());
	}
}
