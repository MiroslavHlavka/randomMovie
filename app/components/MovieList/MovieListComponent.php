<?php

namespace App\Components;

use Nette;
use Nette\Application\UI\Control;

class MovieListComponent extends Control
{
    public $enable;
    public $results;

    public function __construct()
    {
        $this->enable = false;
    }

    public function render()
    {
        $this->template->setFile(__DIR__.'/MovieList.latte');
        $this->template->enable = $this->enable;
        $this->template->results = $this->results;
        $this->redrawControl('movieList');
        $this->template->render();


    }

}