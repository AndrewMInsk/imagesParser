<?php

    namespace Controller;

    use phpQuery;

    class Controller
    {
        private $model;

        public function __construct($model)
        {
            $this->model = $model;
        }

        public function parseIt($data)
        {
            $this->model->downloadData($data);
        }
        public function getCatalog()
        {
            $this->model->getData();
        }
    }