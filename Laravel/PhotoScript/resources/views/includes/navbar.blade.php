<?php
$userAuth = Auth::user();
if ( Auth::check() ) {
	// Notifications
	$notifications_count = App\Models\Notifications::where('destination',Auth::user()->id)->where('status','0')->count();
}
?>

<div class="btn-block text-center class-montserrat showBanner padding-top-10 padding-bottom-10" style="display:none;">{{trans('misc.cookies_text')}} <button class="btn btn-sm btn-success" id="close-banner">{{trans('misc.go_it')}}</button></div>

<div class="navbar navbar-inverse navBar">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">

          	 <?php if ( isset( $totalNotify ) ) : ?>
        	<span class="notify notifyResponsive"><?php echo $totalNotify; ?></span>
        	<?php endif; ?>

            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{ url('/') }}">
          	<img src="{{ url('img', $settings->logo) }}" class="logo" />
          	</a>
        </div><!-- navbar-header -->



        <div class="navbar-collapse collapse">

        	<ul class="nav navbar-nav navbar-right margin-bottom-zero">

						@if (!Request::is('/') && !Request::is('search/*'))

							 <li id="li-search">
							<a class="color-default font-default text-uppercase" id="btnExpand" data-toggle="collapse" href="#formShow" aria-expanded="false" aria-controls="form_Show">
								<i class="icon-search"></i> <span class="title-dropdown">{{trans('misc.search')}}</span>
								</a>
						</li>
						 @endif


							<li>
						 <a href="{{url('/')}}" class="font-default text-uppercase">
							 {{trans('misc.home')}}
							 </a>
					 </li>




        		<li class="dropdown">
        			<a href="javascript:void(0);" class="font-default text-uppercase" data-toggle="dropdown">{{trans('misc.categories')}}
        				<i class="ion-chevron-down margin-lft5"></i>
        				</a>

        				<!-- DROPDOWN MENU -->
        				<ul class="dropdown-menu arrow-up nav-session" role="menu" aria-labelledby="dropdownMenu2">
        				@foreach(  App\Models\Categories::where('mode','on')->orderBy('name')->take(9)->get() as $category )
        					<li>
        						<a href="{{ url('category') }}/{{ $category->slug }}" class="text-overflow">
											@if (Lang::has('categories.'.$category->slug, config('app.locale')))
        								@lang('misc.'.$category->slug)
											@else
												{{$category->name}}
											@endif
        							</a>
        					</li>
        					@endforeach

        					@if ( App\Models\Categories::count() > 9 )
			        		<li><a href="{{ url('categories') }}">
			        			<strong>{{ trans('misc.view_all') }} <i class="fa fa-long-arrow-right"></i></strong>
			        		</a></li>
			        		@endif
        				</ul><!-- DROPDOWN MENU -->
        			</li>

        		@if ( Auth::check() )

        			<li class="dropdown">
			          <a href="javascript:void(0);" data-toggle="dropdown" class="userAvatar myprofile dropdown-toggle font-default text-uppercase">
			          		<img src="{{asset(config('path.avatar').Auth::user()->avatar)}}" alt="User" class="img-circle avatarUser" width="21" height="21">
			          		<span class="title-dropdown">{{ trans('users.my_profile') }}</span>
			          		<i class="ion-chevron-down margin-lft5"></i>
			          	</a>

			          <!-- DROPDOWN MENU -->
			          <ul class="dropdown-menu dd-close arrow-up nav-session" role="menu" aria-labelledby="dropdownMenu4">


	          		 @if ($userAuth->role == 'admin' )
	          		 	<li>
	          		 		<a href="{{ url('panel/admin') }}" class="text-overflow">
	          		 			<i class="icon icon-Speedometter myicon-right"></i> {{ trans('admin.admin') }}</a>
	          		 			</li>
	          		 			<li role="separator" class="divider"></li>
	          		 	@endif


											<!-- <li>
			          		 		<a href="{{ url($userAuth->username) }}" class="myprofile text-overflow">
			          		 			<i class="icon icon-User myicon-right"></i> {{ trans('users.my_profile') }}
			          		 		</a>
			          		 		</li> -->



	          		 		<li>
	          		 			<a href="{{ url('account') }}" class="text-overflow">
	          		 				<i class="icon icon-Settings myicon-right"></i> {{ trans('users.account_settings') }}
	          		 				</a>
	          		 			</li>
	          		 		<li>
	          		 			<a href="{{ url('logout') }}" class="logout text-overflow">
	          		 				<i class="icon icon-Exit myicon-right"></i> {{ trans('users.logout') }}
	          		 			</a>
	          		 		</li>

	          		 	</ul><!-- DROPDOWN MENU -->

	          		</li>
						@else

        		@if ( $settings->registration_active == '1' )
        			<li>
        				<a class="log-in font-default text-uppercase" href="{{ url('register') }}">
        					<i class="glyphicon glyphicon-user"></i> {{ trans('auth.sign_up') }}
        					</a>
        			</li>
        			@endif

        			<li>
        				<a class="font-default text-uppercase @if ( $settings->registration_active == 0 ) log-in @endif" href="{{ url('login') }}">
        					{{ trans('auth.login') }}
        					</a>
        			</li>
        	  @endif
          </ul>



</div><!--/.navbar-collapse -->
      </div>
    </div>
		<div class="cm-bottom-bar">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<div class="btn-bar-text text-center">
							You can view <span>Newly added Images</span> <a href="#">click here</a>
						</div>
					</div>
					<div class="col-md-4">
						<div class="btn-social-liks">
							<ul class="list-inline">

						 @if( $settings->twitter != '' )
							<li><a href="{{$settings->twitter}}" target="_blank" class="ico-social"><i class="fa fa-twitter"></i></a></li>
							@endif

						@if( $settings->facebook != '' )
							<li><a href="{{$settings->facebook}}" target="_blank" class="ico-social"><i class="fa fa-facebook"></i></a></li>
						@endif

						@if( $settings->instagram != '' )
							<li><a href="{{$settings->instagram}}" target="_blank" class="ico-social"><i class="fa fa-instagram"></i></a></li>
						@endif

						@if( $settings->linkedin != '' )
							<li><a href="{{$settings->linkedin}}" target="_blank" class="ico-social"><i class="fa fa-linkedin"></i></a></li>
							@endif

						@if( $settings->youtube != '' )
							<li><a href="{{$settings->youtube}}" target="_blank" class="ico-social"><i class="fa fa-youtube-play"></i></a></li>
							@endif

						@if( $settings->pinterest != '' )
							<li><a href="{{$settings->pinterest}}" target="_blank" class="ico-social"><i class="fa fa-pinterest"></i></a></li>
							@endif
						</ul ></div>
					</div>
				</div>
			</div>
		</div>
