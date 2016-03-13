<?php

namespace App\Components;

use Nette;
use Nette\Application\UI\Control;

class MovieListComponent extends Control
{
    public $enable;
    public $results;
    public $page = 1;
    public $totalPages;

    public $searched;

    public $genres;
    public $year;
    public $sort;

    public function __construct()
    {
        $this->enable = false;
    }

    public function render()
    {
        $this->template->setFile(__DIR__.'/MovieList.latte');
        $this->template->enable = $this->enable;
        $this->template->page = $this->page;
        $this->template->totalPages = $this->totalPages;
        $this->template->results = $this->results;

        $this->template->searched = $this->searched;

        $this->template->genres = $this->genres;
        $this->template->year = $this->year;
        $this->template->sort = $this->sort;
        $this->redrawControl('movieList');
        $this->template->render();


    }


}