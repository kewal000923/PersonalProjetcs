<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\AdminSettings;
use App\Models\Images;
use App\Models\Stock;
use App\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;
use Image;


class bulkUploadController extends Controller {

	use Traits\Upload;

	public function __construct(AdminSettings $settings, Request $request) {
		$this->settings = $settings::first();
		$this->request = $request;
	}

	// START
	public function bulkUpload()
	{
		return view('admin.bulk-upload');

	}//<--- END METHOD

	public function bulkUploadStore()
	{
		return $this->upload('bulk');
	}

}
