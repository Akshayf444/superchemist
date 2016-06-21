<?php

echo $this->session->userdata('message') ? $this->session->userdata('message') : '';
$this->session->unset_userdata('message');
$this->load->view($content, $view_data);
