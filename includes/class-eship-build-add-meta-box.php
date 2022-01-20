<?php

class ESHIP_Build_Add_Meta_Box {
    protected $add_meta;

    public function __construct($data)
    {
        $this->add_meta = $data;
    }

    public function run()
    {
        $data = $this->add_meta;
        add_meta_box(
            $data['id'],
            __($data['title']),
            $data['callback'],
            $data['view'],
            $data['context'],
            $data['priority']
        );
    }
}