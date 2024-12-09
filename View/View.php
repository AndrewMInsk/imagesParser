<?php

    namespace View;

    class View
    {
        private $model;
        private $controller;
        private $head;
        private $footer;
        private $form;

        // not very smart solution
        public function __construct($controller, $model)
        {
            $this->controller = $controller;
            $this->model = $model;
            $this->head = '<html><head><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"><script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="/script.js" ></script>
</head><body><div class="container">';
            $this->form = '<form method="POST" id="parser">
        <div class="form-group">
          <label for="url">URL</label>
          <input
            type="text"
            class="form-control"
            id="url"
            name="url"
            placeholder="URL"
          />
        </div>
        <div class="form-group">
          <label for="name">TEXT</label>
          <input
            type="text"
            class="form-control"
            id="text"
            name="text"
            placeholder="TEXT"
          />
        </div>
        <div class="form-group">
          <label for="minwidth">MIN WIDTH</label>
          <input
            type="text"
            class="form-control"
            id="minwidth"
            name="minwidth"
            placeholder="MIN WIDTH"
          />
        </div>
        <div class="form-group">
          <label for="minheight">MIN HEIGHT</label>
          <input
            type="text"
            class="form-control"
            id="minheight"
            name="minheight"
            placeholder="MIN HEIGHT"
          />
        </div>
        <button type="submit" class="btn btn-success">
          Submit
        </button>
      </form><div id="results"></div>';
            $this->footer = '</div></body></html>';
        }

        public function allHTML()
        {
            return $this->head . $this->form . $this->model->data . $this->footer;
        }

        public function asJSON()
        {
            return json_encode($this->model->data);
        }
    }
