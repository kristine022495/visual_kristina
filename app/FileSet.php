<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileSet extends Model
{
    //

    protected $guarded = ['id'];

    public function files() {

      return $this->hasMany(File::class);

    }

    public function user() {

      return $this->belongsTo(User::class);

    }

    public function folder() {

    	return $this->belongsTo(Folder::class);

    }

}
