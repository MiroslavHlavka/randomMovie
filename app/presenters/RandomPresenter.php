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


	public function renderLucky(){
		$data = new DataModel();
		$this->template->result = $data->lucky();

	}

	public function renderFilters($page = 1, $genres = array(), $year, $sort ){

		if($genres != array()){$genres = $genres[0];}

		$data = new DataModel();
		$results = $data->discover($genres, $year, $sort, $page);

		$component = $this->getComponent('movieList');
		$component->enable = true;
		$component->results = $results->results;
		$component->page = $page;
		$component->totalPages = $results->total_pages;

		$component->genres = $genres;
		$component->year = $year;
		$component->sort = $sort;

		$component->redrawControl();

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

		$this->redirect('Random:filters',null, array($values['genres']), $values['year'], $values['sort']);

	}

	public function createComponentMovieList()
	{
		return new MovieListComponent();
	}

}
