<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('sendmail')) {
   function sendmail($data)
   {
      $ci = &get_instance();
      $ci->load->library('email');
      $config = array();
      $config['protocol']       = getenv('mail.Protocol');
      $config['smtp_host']      = getenv('mail.Host');
      $config['smtp_user']      = getenv('mail.User');
      $config['smtp_pass']      = getenv('mail.Password');
      $config['smtp_port']      = getenv('mail.Port');
      $config['mailtype']       = 'html';
      $config['charset']        = 'utf-8';
      $ci->email->initialize($config);
      $ci->email->set_newline("\r\n");
      $ci->email->from(getenv('mail.User'), getenv('mail.Profile'));
      $ci->email->to($data['to']);
      $ci->email->subject($data['subject']);
      $ci->email->message($data['message']);

      if ($ci->email->send()) {
         return true;
      } else {
         return false;
      }
   }
}
