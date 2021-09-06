<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Traits\Search;
class ImagesViews extends Model {

	protected $guarded = array();
	public $timestamps = false;
	use Search;
    protected $fillable = [
        'images_id', 'view', 'user_ip'
        ];
	public function user() {
        return $this->belongsTo('App\Models\User')->first();
    }

	public function images() {
        return $this->belongsTo('App\Models\Images');
    }

}
