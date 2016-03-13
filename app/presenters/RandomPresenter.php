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
		// getSession values
		//->setDefaultValue($year)

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
		))->setDefaultValue($this->getSession('filters')->genres);

		$form->addSelect('year', 'Year:', $years)->setPrompt('None')->setDefaultValue($this->getSession('filters')->year);

		$form->addSelect('sort', 'Sort by:', array(
			'original_title.asc' => 'Name ▲',
			'original_title.desc' => 'Name ▼',
			'vote_average.asc' => 'Rating ▲',
			'vote_average.desc' => 'Rating ▼',
			'primary_release_date.asc' => 'Release date ▲',
			'primary_release_date.desc' => 'Release date ▼',

		))->setDefaultValue($this->getSession('filters')->sort);

		$form->addSubmit('submit', 'Filter');
		$form->onSuccess[] = array($this, 'filterFormSucceeded');



		return $form;
	}

	public function filterFormSucceeded(UI\Form $form, $values){
		$filters = $this->getSession('filters');
		$filters->genres = $values['genres'];
		$filters->year = $values['year'];
		$filters->sort = $values['sort'];



		//ulozit do sessionu values
		$this->redirect('Random:filters',null, array($values['genres']), $values['year'], $values['sort']);

	}

	public function renderSearch($page=1, $value)
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

		$this->redirect('Random:search',null, $values["searchMovie"]);
	}


	public function createComponentMovieList()
	{
		return new MovieListComponent();
	}

}
