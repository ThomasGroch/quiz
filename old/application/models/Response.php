<?php

class Response extends DataMapperExt {

    var $table = 'responses';

    // Optionally, don't include a constructor if you don't need one.
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }

    // Optionally, you can add post model initialisation code
    function post_model_init($from_cache = FALSE)
    {
    }
}

/* End of file name.php */
/* Location: ./application/models/question.php */
