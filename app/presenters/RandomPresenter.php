<?php

namespace App\Presenters;

use Nette;
use app\model\DataModel;


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

}
