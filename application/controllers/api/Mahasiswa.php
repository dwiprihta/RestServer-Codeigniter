<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends CI_Controller{

    use REST_Controller {
    REST_Controller::__construct as private __resTraitConstruct;}


public function __construct(){
    parent::__construct();
    $this->__resTraitConstruct();
    $this->load->model('Mahasiswa_model','mhs');
    $this->methods['index_get']['limit'] =2;
   
}

 //GET DATA
    public function index_GET(){
       
        $id = $this->get('id');

        // If the id parameter doesn't exist return all the users

        if ($id === null)
        {
            $mahasiswa=$this->mhs->getMahasiswa();
        }else{
            $mahasiswa=$this->mhs->getMahasiswa($id);
        }
            
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($mahasiswa)
            {
                // Set the response and exit
                $this->response([
                    'status'=>true,
                    'data'=>$mahasiswa], 200); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => false,
                    'message' => 'No users were found'
                ], 404); // NOT_FOUND (404) being the HTTP response code
            }
        }

    //DELETE DATA
    public function index_delete(){
        $id = $this->delete('id');

        if ($id === null){
            $this->response([
                'status' => false,
                'message' => 'provide an id'
            ], 400); // BAD_REQUEST (400) being the HTTP response code

        }else{
            if($this->mhs->delete_mahasiswa($id) > 0){
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'Deleted the resource.'
                ]);// NO_CONTENT (204) being the HTTP response code
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'id not found'
                ], 400); // BAD_REQUEST (400) being the HTTP response code
                }
            }   
    }

    //POST DATA
    public function index_post(){
        $data=[
            'nrp'=>$this->post('nrp'),
            'nama'=>$this->post('nama'),
            'email'=>$this->post('email'),
            'jurusan'=>$this->post('jurusan')
        ];

        if ($this->mhs->createMahasiswa($data) > 0){
            $this->response([
                'status' => true,
                'message' => 'New mahasiswa has been create.'
            ], 201);// NO_CONTENT (201) being the HTTP response code
        }else{
            $this->response([
                'status' => false,
                'message' => 'faild create mahasiswa'
            ], 400); // BAD_REQUEST (400) being the HTTP response code
            }
        }
  

    //  PUT DATA
    public function index_put(){
        $id = $this->put('id');
        $data=[
            'nrp'=>$this->put('nrp'),
            'nama'=>$this->put('nama'),
            'email'=>$this->put('email'),
            'jurusan'=>$this->put('jurusan')
        ];

        if ($this->mhs->updateMahasiswa($data, $id) > 0){
            $this->response([
                'status' => true,
                'message' => 'mahasiswa has been updated.'
            ], 201);// NO_CONTENT (201) being the HTTP response code
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed update mahasiswa'
            ], 400); // BAD_REQUEST (400) being the HTTP response code
            }
    }
}

