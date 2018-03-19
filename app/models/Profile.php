<?php

	/**
	* 
	*/
	class Profile extends Eloquent
	{
		protected $table = "profile";

		protected $primaryKey = 'user_id';

		public function user()
		{
			return $this->belongsTo('User');
		}

	}