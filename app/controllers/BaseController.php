<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */

	protected $theme; 

	public function __construct()
	{
		$this->theme = Theme::uses(Helper::optionValue('themes'));
	}

}
