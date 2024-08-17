<?php
class P_Principal extends Controller
{

    public function index()
    {
        $this->views->getView($this, "index");
    }
}