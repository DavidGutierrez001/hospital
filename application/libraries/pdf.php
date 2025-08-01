<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Includes autoloader Dompdf
require_once APPPATH . 'libraries/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Pdf extends Dompdf
{
    public function __construct()
    {
        parent::__construct();
    }
}
