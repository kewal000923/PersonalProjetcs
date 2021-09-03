<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AdminSettings;
use App\Models\UsersReported;
use App\Models\ImagesReported;
use App\Models\Images;
use App\Models\Like;
use App\Models\ImagesViews;
use App\Models\Notifications;
use App\Models\Messages;
use App\Models\Stock;
use App\Models\Query;
use App\Models\Followers;
use App\Models\Comments;
use App\Helper;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Image;

class AjaxController extends Controller {

	public function __construct( AdminSettings $settings) {
		$this->settings = $settings::first();
	}
	
	public function imageview(Request $request){
		$ip = ip2long($request->ip());
		$like = ImagesViews::firstOrNew(['user_ip' => $ip, 'images_id' => $request->id]);
		$imagesData = Images::firstOrNew(['id' => $request->id]);
		
		if(!$like->exists){
			$like->user_ip  = $ip;
			$like->view = 1;
			$like->save();
		}
		$imageView = ImagesViews::where('images_id' ,'=' ,$request->id)->pluck('images_id')->all(); ;
		$viewCount = count($imageView);
		$imagesData->total_views = $viewCount;
		$imagesData->save();
		
		return response()->json([
			'status' => 200,
			'totalview'=> $viewCount,
			'message' => "Success!"
		]);
	}
	public function like( Request $request ){

		$ip = ip2long($request->ip());
		$like = Like::firstOrNew(['user_ip' => $ip, 'images_id' => $request->id]);
		$imagesData = Images::firstOrNew(['id' => $request->id]);
		$user = Images::find($request->id);
		if( $like->exists ) {

			if($like->status == '0'){
				$like->status = '1';
				$like->user_ip  = $ip;
				$like->save();
			}
			else{
				return response()->json([
					'status' => false,
					'message' => "Already Liked it!"
				]);
			}
			
		}
		else{
			$like->status = '1';
			$like->user_ip  = $ip;
			$like->save();
		} 

		
		$totalLike = Helper::formatNumber( $user->likes()->count() );
		$totaldisLike = Helper::formatNumber( $user->dislikes()->count() );
		$imagesData->total_like = $totalLike;
		$imagesData->total_dislike = $totaldisLike;
		$imagesData->save();
		return response()->json([
			'status' => 200,
			'countLike' => $totalLike,
			'countdisLike' => $totaldisLike,
			'message' => "successfuly Like!"
		]);
				
	}//<---- End Method


	public function dislike( Request $request ){

		$ip = ip2long($request->ip());
		$like = Like::firstOrNew(['user_ip' => $ip, 'images_id' => $request->id]);
		$imagesData = Images::firstOrNew(['id' => $request->id]);
		$user = Images::find($request->id);

		$like->status = '0';
		$like->user_ip  = $ip;
		$like->save();

		$totalLike = Helper::formatNumber( $user->likes()->count() );
		$totaldisLike = Helper::formatNumber( $user->dislikes()->count() );
		$imagesData->total_like = $totalLike;
		$imagesData->total_dislike = $totaldisLike;
		$imagesData->save();
		return response()->json([
			'status' => 200,
			'countLike' => $totalLike,
			'countdisLike' => $totaldisLike,
			'message' => "successfuly Dislike!"
		]);
				
	}//<---- End Method



	public function follow(Request $request)
	{
		$findUser = User::whereId($request->id)
				->where('id', '<>', Auth::user()->id)
				->whereStatus('active')
				->first();

		if (!$findUser) {
			return response()->json([
				'status' => false,
			]);
		}

		 $user = Followers::firstOrNew(['follower' => Auth::user()->id, 'following' => $request->id]);

		if($user->exists) {

			   $notifications = Notifications::where('destination',$request->id)
			   ->where('author',Auth::user()->id)
			   ->where('target',Auth::user()->id)
			   ->where('type','1')
			   ->first();

				// IF ACTIVE DELETE FOLLOW
				if ($user->status == '1') {
					$user->status = '0';
					$user->update();

				if (isset($notifications)) {
					// DELETE NOTIFICATION
					$notifications->status = '1';
					$notifications->update();
				}

				// ELSE ACTIVE AGAIN
				} else {
					$user->status = '1';
					$user->update();

					if (isset($notifications)) {
					// ACTIVE NOTIFICATION
					$notifications->status = '0';
					$notifications->update();
					}
				}

		} else {

			// INSERT
			$user->save();

			// Send Notification //destination, author, type, target
			if ($request->id != Auth::user()->id) {
				Notifications::send( $request->id, Auth::user()->id, '1', Auth::user()->id );
			}

		}
			return response()->json([
				        'status' => true,
				    ]);
	}//<---- End Method

	public function notifications() {

		if( Auth::check() ) {

		   if(request()->ajax()) {
			// Notifications
			$notifications_count = Notifications::where('destination',Auth::user()->id)->where('status','0')->count();

			if( $notifications_count == 0 ){
				$notifications_count = '0';
			}

			return response()->json( array ( 'notifications' => $notifications_count ) );

		   } else {
				return response()->json( array ( 'error' => 1 ) );
			}
	  }//Auth
	  else {
				return response()->json( array ( 'error' => 1 ) );
			}

   }//<---- * End Method

   public function users() {

	 $data = Query::users();

	 return view('ajax.users-ajax')->with($data)->render();

	}//<---- End Method

	public function search() {

	 $images = Query::searchImages();

	 return view('ajax.images-ajax')->with($images)->render();

	}//<---- End Method

	public function latest() {

	 $images = Query::latestImages();

	 return view('ajax.images-ajax',['images' => $images])->render();

	}//<---- End Method

	public function featured() {

	 $images = Query::featuredImages();

	 return view('ajax.images-ajax',['images' => $images])->render();

	}//<---- End Method

	public function popular() {

	 $images = Query::popularImages();

	 return view('ajax.images-ajax',['images' => $images])->render();

	}//<---- End Method

	public function commented() {

	 $images = Query::commentedImages();

	 return view('ajax.images-ajax',['images' => $images])->render();

	}//<---- End Method

	public function viewed() {

	 $images = Query::viewedImages();

	 return view('ajax.images-ajax',['images' => $images])->render();

	}//<---- End Method

	public function downloads() {

	 $images = Query::downloadsImages();

	 return view('ajax.images-ajax',['images' => $images])->render();

	}//<---- End Method

	public function category( Request $request ) {

	 $slug = trim($request->slug);

	 $images = Query::categoryImages($slug);

	 return view('ajax.images-ajax')->with($images)->render();

	}//<---- End Method

	public function tags( Request $request ) {

		 $slug = trim($request->q);

		 $images = Query::tagsImages($slug);

		 return view('ajax.images-ajax')->with($images)->render();

	}//<---- End Method

	public function camera( Request $request ) {

		 $slug = trim($request->q);

		 $images = Query::camerasImages($slug);

		 return view('ajax.images-ajax')->with($images)->render();

	}//<---- End Method

	public function colors( Request $request ) {

		 $slug = trim($request->q);

		 $images = Query::colorsImages($slug);

		 return view('ajax.images-ajax')->with($images)->render();

	}//<---- End Method

	public function userImages( Request $request ) {

		 $id = $request->id;

		 $images = Query::userImages($id);

		 return view('ajax.images-ajax',['images' => $images])->render();

	}//<---- End Method

	public function comments( Request $request ) {

		 $id = $request->photo;

		 $comments_sql = Comments::where('images_id', $id)->where('status','1')->orderBy('date', 'desc')->paginate(10);

		 return view('includes.comments',['comments_sql' => $comments_sql])->render();

	}//<---- End Method

	public function premium() {

	 $images = Query::premiumImages();

	 return view('ajax.images-ajax',['images' => $images])->render();

	}//<---- End Method

}
