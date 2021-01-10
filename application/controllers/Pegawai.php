<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->web = $this->db->get('web')->row();
		if ($this->session->userdata('level') != 'pegawai') {
			$this->session->set_flashdata('message', 'swal("Ops!", "Anda haru login sebagai pegawai", "error");');
			redirect('auth');
		}
		date_default_timezone_set ( 'asia/jakarta' );
	}
	
	public function index()
	{
		$tahun 			= date('Y');
		$bulan 			= date('m');
		$hari 			= date('d');
		$absen			= $this->M_data->absendaily($this->session->userdata('nip'),$tahun,$bulan,$hari); 
		if ($absen->num_rows() == 0) { $data['waktu'] = 'masuk'; }
		else { $data['waktu'] = 'dilarang'; }
		$data['web']	= $this->web;
		$data['title']	= 'Dashboard';
		$data['body']	= 'pegawai/home';
		$this->load->view('template',$data);
	}
	//proses absen
	public function proses_absen()
	{
		$id = $this->session->userdata('nip');
		$p = $this->input->post();
		$data = [
			'nip'	=> $id
		];
		$this->db->insert('absen',$data);
		$this->session->set_flashdata('message', 'swal("Berhasil!", "Melakukan absen", "success");');
		redirect('pegawai');
	}
	//data absen
	public function absensi()
	{
		$data['web']	= $this->web;
		$data['data']	= $this->M_data->absensi_pegawai($this->session->userdata('nip'))->result();
		$data['title']	= 'Data Absen';
		$data['body']	= 'pegawai/absen';
		$this->load->view('template',$data);
	}
	//CURD data cuti
	public function cuti()
	{
		$data['web']	= $this->web;
		$data['data']	= $this->M_data->cuti_pegawai($this->session->userdata('nip'))->result();
		$pegawai = $this->M_data->pegawaiid($this->session->userdata('nip'))->row();
		$dt1 = new DateTime($pegawai->waktu_masuk);
		$dt2 = new DateTime(date('Y-m-d'));
		$d = $dt2->diff($dt1)->days + 1;
		$data['bakti']	= $d;
		$data['title']	= 'Data Cuti';
		$data['body']	= 'pegawai/cuti';
		$this->load->view('template',$data);
	}
	public function cuti_add()
	{
		$data['web']	= $this->web;
		$data['title']	= 'Tambah Data Cuti';
		$data['body']	= 'pegawai/cuti_add';
		$this->load->view('template',$data);
	}
	public function cuti_simpan()
	{
		$data = array(
			'nip'	=> $this->session->userdata('nip'),
			'mulai'	=> $this->input->post('mulai'),
			'akhir'	=> $this->input->post('akhir'),
			'alasan'=> $this->input->post('alasan'),
			'status'=> 'diajukan'
		);
		$this->db->insert('cuti',$data);
		$this->session->set_flashdata('message', 'swal("Berhasil!", "Pengajuan cuti", "success");');
		redirect('pegawai/cuti');
	}
	public function cuti_update($id)
	{
		$data = array(
			'nip'	=> $this->session->userdata('nip'),
			'mulai'	=> $this->input->post('mulai'),
			'akhir'	=> $this->input->post('akhir'),
			'alasan'=> $this->input->post('alasan')
		);
		$this->db->update('cuti',$data,['id_cuti'=>$id]);
		$this->session->set_flashdata('message', 'swal("Berhasil!", "Update pengajuan cuti", "success");');
		redirect('pegawai/cuti');
	}
	public function cuti_edit($id)
	{
		$data['web']	= $this->web;
		$data['title']	= 'Update Data Cuti';
		$data['data']	= $this->db->get_where('cuti',['id_cuti'=>$id])->row();
		$data['body']	= 'pegawai/cuti_edit';
		$this->load->view('template',$data);
	}
	public function cuti_delete($id)
	{
		$this->db->delete('cuti',['id_cuti'=>$id]);
		$this->session->set_flashdata('message', 'swal("Berhasil!", "Delete pengajuan cuti", "success");');
		redirect('pegawai/cuti');
	}
	//update profile
	public function profile()
	{
		$data['web']	= $this->web;
		$data['data']	= $this->M_data->pegawaiid($this->session->userdata('nip'))->row();
		$data['title']	= 'Profile Pengguna';
		$data['body']	= 'pegawai/profile';
		$this->load->view('template',$data);
	}
	public function profile_update($id)
	{
		$usr = [
			'nama'	=> $this->input->post('nama'),
			'email'	=> $this->input->post('email'),
		];
		$this->db->trans_start();
		$this->db->update('user',$usr,['nip'=>$id]);
		$this->db->update('pegawai',['jenis_kelamin'=>$this->input->post('jenis_kelamin')],['nip'=>$id]);
		$this->db->trans_complete();
		$this->session->set_flashdata('message', 'swal("Berhasil!", "Update profile", "success");');
		redirect('pegawai/profile');
	}
	public function ganti_password()
	{
		$data['web']	= $this->web;
		$data['title']	= 'Ganti Password';
		$data['body']	= 'pegawai/ganti password';
		$this->load->view('template',$data);
	}
	public function password_update($id)
	{
		$p = $this->input->post();
		$cek = $this->db->get_where('user',['nip'=>$id]);
		if ($cek->num_rows() > 0) {
			$a = $cek->row();
			if (md5($p['pw_lama']) == $a->password) {
				$this->db->update('user',['password'=>md5($p['pw_baru'])],['nip'=>$id]);
				$this->session->set_flashdata('message', 'swal("Berhasil!", "Update password", "success");');
				redirect('pegawai/ganti_password');
			}
			else
			{
				$this->session->set_flashdata('message', 'swal("Ops!", "Password lama yang anda masukan salah", "error");');
				redirect('pegawai/ganti_password');
			}
		}
		else
		{
			$this->session->set_flashdata('message', 'swal("Ops!", "Anda harus login", "error");');
				redirect('auth');
		}
	}
	public function slip()
	{
		$tahun 			= date('Y');
		$bulan 			= date('m');
		$data['data']	= $this->M_data->pegawaiid($this->session->userdata('nip'))->row();
		$data['absen']	= $this->M_data->absenbulan($this->session->userdata('nip'),$tahun,$bulan)->num_rows(); 
		$cuti 			= $this->M_data->cutibulan($this->session->userdata('nip'),$tahun,$bulan)->result(); 
		$jumlah = 0;
		foreach ($cuti as $c) {
			$dt1 = new DateTime($c->mulai);
			$dt2 = new DateTime($c->akhir);
			$d = $dt2->diff($dt1)->days + 1;
			$jumlah += $d;
		}
		$data['jumlah'] = $jumlah;
		$data['web']	= $this->web;
		$data['title']	= 'Slip Gaji';
		$data['body']	= 'pegawai/slip';
		$this->load->view('template',$data);
	}
	public function print_slip()
	{
		$tahun 			= date('Y');
		$bulan 			= date('m');
		$data['data']	= $this->M_data->pegawaiid($this->session->userdata('nip'))->row();
		$data['absen']	= $this->M_data->absenbulan($this->session->userdata('nip'),$tahun,$bulan)->num_rows(); 
		$cuti 			= $this->M_data->cutibulan($this->session->userdata('nip'),$tahun,$bulan)->result(); 
		$jumlah = 0;
		foreach ($cuti as $c) {
			$dt1 = new DateTime($c->mulai);
			$dt2 = new DateTime($c->akhir);
			$d = $dt2->diff($dt1)->days + 1;
			$jumlah += $d;
		}
		$data['jumlah'] = $jumlah;
		$data['web']	= $this->web;
		$data['title']	= 'Slip Gaji '.$this->session->userdata('nama');
		$this->load->view('pegawai/slip_print',$data);
	}
}