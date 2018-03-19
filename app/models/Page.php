<?php

	/**
	* 
	*/

	class Page extends Eloquent
	{
		use SoftDeletingTrait;
		
		protected $table = "pages";
		protected $dates = ['deleted_at'];
		protected $softDelete = false;

	    public function translation()
	    {
	    	return $this->belongsTo('PageTranslation','id','page_id');
	    }

	    public function media()
	    {
	    	return $this->hasMany('PageMedia')->orderBy('sorting','ASC');
	    }

	    public function pdfCover()
	    {
	    	return $this->hasOne('PageMedia')->whereType('pdf');
	    }

	    public function cover()
	    {
	    	return $this->hasOne('PageMedia')->whereIsCover(1);
	    }

	    public function metas()
	    {
	    	return $this->hasMany('PageMeta');
	    }

	    public function meta($name = null)
	    {
	    	return $this->hasOne('PageMeta')->whereName($name);
	    }

	    public function firstItem($id = 0)
	    {
	    	return $this->hasOne('PageTranslation','id','page_id')->whereParent($id);
	    }
	    
	}