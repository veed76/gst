<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/phpmailer/PHPMailerAutoload.php';
class Phpmailerlib extends phpmailer
{
    function __construct()
    {
        parent::__construct();
    }
}
/*Author:Tutsway.com */  
/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */
