<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model {

	protected $guarded = ['id'];
	
	public static function filesets() {

		return $this->hasMany(FileSet::class);

	}

}
