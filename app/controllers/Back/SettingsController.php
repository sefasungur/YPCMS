<?php namespace Back;

	/**
	* 
	*/

	class SettingsController extends \BaseController
	{
		
		public function getIndex()
		{
			$type = \Input::get('type');
			if ($type) {
				$detail = "widgets.settings.{$type}";
				if (\View::exists($detail)) {
					return \View::make('views.settings.main')
							->withType($detail);
				}
			}
			return \App::abort(404);
		}
	}
	