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

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
		$this->template->test = 15;
	}

	public function createComponentSearchForm(){
		$form = new UI\Form;
		$form->addText('searchMovie', 'search');
		$form->addSubmit('submit', 'Search');
		$form->onSuccess[] = array($this, 'searchFormSucceeded');



		return $form;
	}

	public function searchFormSucceeded(UI\Form $form, $values){

		$data = new DataModel();
		$results = $data->search($values['searchMovie']);
		$component = $this->getComponent('movieList');
		$component->enable = true;
		$component->results = $results;
		$component->redrawControl();

	}


	public function createComponentMovieList()
	{
		return new MovieListComponent();
	}


}
