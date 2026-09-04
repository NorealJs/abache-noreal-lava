<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');


class StudentController extends Controller
{
    
    private $student = [
        'student_id'  => 'MCC2024-00133',
        'name'        => 'Abache, Noreal M.',
        'course'      => 'BSIT',
        'year'        => '3rd Year',
        'section'     => '3-F3',
        'email'       => 'abachenorealm06@gmail.com',
        'address'     => 'Buhuan II',
        'contact'     => '0926-071-1887',
        'skills'      => 'PHP, JavaScript, HTML, CSS, MySQL, Git',
        'bio'         => ' You are my strength. In fear, You are my courage. I will not falter, for You go before me. Thy Kingdom come — through me.',
    ];

  
    public function index()
    {
       
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['profile_access'] = true;

        $data['name'] = $this->student['name'];
        $data['denied'] = isset($_GET['denied']);

        $this->call->view('student_home', $data);
    }

    
    public function profile()
    {
        $this->call->view('student_profile', $this->student);
    }
}
