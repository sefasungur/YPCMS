<?php

	/**
	* 
	*/

	use Cviebrock\EloquentSluggable\SluggableInterface;
	use Cviebrock\EloquentSluggable\SluggableTrait;
	
	class PageTranslation extends Eloquent implements SluggableInterface
	{

		use SluggableTrait;

	    protected $sluggable = array(
	        'build_from' => 'title',
	        'save_to'    => 'slug',
	    );

		public $timestamps = false;

		public function page()
		{
			return $this->hasOne('Page','id', 'page_id');
		}

		public function pdf()
		{
			return $this->hasOne('PageMedia', 'page_id', 'page_id')->whereType('pdf');
		}
	}