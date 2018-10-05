<?php
namespace app\index\controller;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return 'index Index index';
    }

    public function testBase(){
    	return $this->fetch();
    }

}
