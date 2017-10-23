<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "/third_party/phpword/PHPWord.php";

class Php_word extends PHPWord
{

    public function __construct()
    {
        parent::__construct();
    }

}