<?php
    abstract class con_controller{

        protected $config;
        public $error;

        public function __construct($config,$POST=array(),$GET=array()){
            $this->config = $config;
            $this->loader($config);
            $this->requestHandler($POST,$GET);
            $this->lateLoader($config);
        }

        protected function loader($config){}
        protected function lateLoader($config){}
        protected function requestHandler($POST,$GET){}

    }
?>