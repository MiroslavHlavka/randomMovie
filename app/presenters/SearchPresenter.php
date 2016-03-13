<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI;
use Nette\Forms\Controls;
use App\Components\MovieListComponent;
use app\model\DataModel;


/**
 * Homepage presenter.
 */
class SearchPresenter extends BasePresenter
{

	/** @var  DataModel inject */
	private $DataModel;

	public function renderDefault($page=1, $value)
	{
		if($value != null){

			$data = new DataModel();
			$results = $data->search($value, $page);
			$component = $this->getComponent('movieList');
			$component->enable = true;
			$component->results = $results->results;
			$component->page = $page;
			$component->totalPages = $results->total_pages;
			$component->searched = $value;
			$component->redrawControl();
		}

	}

	public function createComponentSearchForm(){
		$form = new UI\Form;
		$form->addText('searchMovie', 'search');
		$form->addSubmit('submit', 'Search');
		$form->onSuccess[] = array($this, 'searchFormSucceeded');



		return $form;
	}

	public function searchFormSucceeded(UI\Form $form, $values){

		$this->redirect('Search:default',null, $values["searchMovie"]);
	}


	public function createComponentMovieList()
	{
		return new MovieListComponent();
	}


}
