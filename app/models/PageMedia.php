<?php

	/**
	* 
	*/

	class PageMedia extends Eloquent
	{
		protected $table = "media";

		protected $primaryKey = 'id';

		public function page()
		{
			return $this->belongsTo('Page');
		}

		public function metas()
	    {
	    	return $this->hasMany('PageMeta', 'page_id', 'page_id');
	    }

	    public function meta($name = null)
	    {
	    	return $this->hasOne('PageMeta', 'page_id', 'page_id')->where('name' , '=', $name);
	    }
	}