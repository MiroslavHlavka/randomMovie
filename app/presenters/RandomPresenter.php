<?php

namespace App\Presenters;

use Nette;
use app\model\DataModel;
use Nette\Application\UI;
use App\Components\MovieListComponent;


/**
 * Homepage presenter.
 */
class RandomPresenter extends BasePresenter
{
	/** @var  DataModel inject */
	private $DataModel;

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}

	public function renderLucky(){
		$data = new DataModel();
		$this->template->result = $data->lucky();

	}

	public function createComponentFilters()
	{
		$years = array();

		for($i=intval(date("Y")); $i> 1960; $i--){
			$years[$i]=$i;
		}

		$form = new UI\Form;
		$form->addCheckboxList('genres', 'Genres:', array(
			'35' => 'Comedy',
			'18' => 'Drama',
			'10749' => 'Romance',
			'28' => 'Action',
			'10751' => 'Family',
			'10402' => 'Music',
			'99' => 'Documentary',
			'80' => 'Crime',
			'53' => 'Thriller',
			'10752' => 'War',
			'27' => 'Horror',
			'37' => 'Western',
			'12' => 'Adventure',
			'14' => 'Fantasy',
			'878' => 'Sci-Fi',
		));

		$form->addSelect('year', 'Year:', $years)->setPrompt('None');

		$form->addSelect('sort', 'Sort by:', array(
			'original_title.asc' => 'Name ▲',
			'original_title.desc' => 'Name ▼',
			'vote_average.asc' => 'Rating ▲',
			'vote_average.desc' => 'Rating ▼',
			'primary_release_date.asc' => 'Release date ▲',
			'primary_release_date.desc' => 'Release date ▼',

		));

		$form->addSubmit('submit', 'Filter');
		$form->onSuccess[] = array($this, 'filterFormSucceeded');



		return $form;
	}

	public function filterFormSucceeded(UI\Form $form, $values){
		$data = new DataModel();
		$results = $data->discover($values['genres'], $values['year'], $values['sort']);
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
