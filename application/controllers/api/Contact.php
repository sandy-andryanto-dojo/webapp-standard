<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CORE_API_Controller {

	public function list_post(){
		$data = $this->db->where("active", 1)->order_by("id", "DESC")->get("ref_contacts")->result();
		$this->output($data, "Daftar Kontak");
	}

	public function create_post(){
		$items = array(
			"name"=>  $this->input->post("name"),
			"phone"=> $this->input->post("phone"),
			"email"=> $this->input->post("email"),
			"website"=> $this->input->post("website"),
			"address"=> $this->input->post("address"),
			"message"=> $this->input->post("message"),
			"created_at"=> date_now(),
			"updated_at"=> date_now(),
			"active"=> 1
		);
		$this->db->insert("ref_contacts", $items);
		$id = $this->db->insert_id();
		$data = $this->common_model->get_data_byid("ref_contacts", $id);
		$this->output($data, "Kontak berhasil dibuat!");
	}

	public function detail_post(){
		if(!$this->input->post("id")){
			$this->output(null, "ID Kontak Kosong");
		}else{
			$id = $this->input->post("id");
			$data = $this->common_model->get_data_byid("ref_contacts", $id);
			if(!is_null($data)){
				$this->output($data, "Kontak berhasil ditemukan!");
			}else{
				$this->output(null, "Kontak tidak ditemukan!");
			}
		}
	}

	public function delete_post(){
		if(!$this->input->post("id")){
			$this->output(null, "ID Kontak Kosong");
		}else{
			$id = $this->input->post("id");
			$data = $this->common_model->get_data_byid("ref_contacts", $id);
			if(!is_null($data)){
				$this->common_model->delete_data($id, "ref_contacts");
				$this->output(true, "Kontak berhasil dihapus!");
			}else{
				$this->output(null, "Kontak tidak ditemukan!");
			}
		}
	}

	public function edit_post(){
		if(!$this->input->post("id")){
			$this->output(null, "ID Kontak Kosong");
		}else{
			$id = $this->input->post("id");
			$data = $this->common_model->get_data_byid("ref_contacts", $id);
			if(!is_null($data)){
				$items = array(
					"name"=>  $this->input->post("name"),
					"phone"=> $this->input->post("phone"),
					"email"=> $this->input->post("email"),
					"website"=> $this->input->post("website"),
					"address"=> $this->input->post("address"),
					"message"=> $this->input->post("message"),
					"updated_at"=> date_now(),
					"active"=> 1
				);
				$this->common_model->update_data($id, "ref_contacts", $items);
				$data = $this->common_model->get_data_byid("ref_contacts", $id);
				$this->output($data, "Kontak berhasil diupdate!");
			}else{
				$this->output(null, "Kontak tidak ditemukan!");
			}
		}
	}

}
