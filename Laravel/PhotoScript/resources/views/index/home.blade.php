@extends('app')

@section('content')
<div class="jumbotron index-header jumbotron_set jumbotron-cover @if( Auth::check() ) session-active-cover @endif">
      <div class="container wrap-jumbotron position-relative">
        <h1 class="title-site vivify driveInTop delay-500" id="titleSite">{{$settings->welcome_text}}</h1>
        <p class="subtitle-site vivify fadeInBottom delay-600"><strong>{{$settings->welcome_subtitle}}</strong></p>

        <form role="search" autocomplete="off" action="{{ url('search') }}" method="get">
			  <div class="input-group input-group-lg searchBar">
                    <input type="text" class="form-control" name="q" id="btnItems" placeholder="{{trans('misc.title_search_bar')}}">
                    <span class="input-group-btn">
                      <button class="btn btn-main btn-flat" type="submit" id="btnSearch">
                      	<i class="glyphicon glyphicon-search"></i>
                      </button>
                    </span>
                  </div>
                  </form>

                  @if($categoryPopular)
                  <div style="text-align:center;color:#FFF;margin-top: 10px;font-size: 16px;">
                    <strong>{{trans('misc.popular_categories')}} {!! $categoryPopular !!}</strong>
                  </div>
                  @endif

      </div><!-- container wrap-jumbotron -->
</div><!-- jumbotron -->


<div class="container-fluid margin-bottom-40">
	<div class="row margin-bottom-20">
		<div class="col-md-9">

		@if( $images->total() != 0 )

      @if($settings->show_images_index == 'featured' || $settings->show_images_index == 'both')
      <div class="col-md-12 btn-block margin-bottom-40">
				<h1 class="btn-block text-center class-montserrat margin-bottom-zero none-overflow highlight-word-color">@lang('misc.featured_photos')</h1>
				<h5 class="btn-block text-center class-montserrat text-uppercase">{{trans('misc.subtitle_featured_home')}}</h5>
			</div>

      <div id="imagesFlexFeatured" class="flex-images btn-block margin-bottom-40">
    	     @include('includes.images', ['images' => $featured])
    	  </div><!-- Image Flex -->

        <div class="col-md-12 text-center margin-bottom-20">
        	<a href="{{ url('featured') }}" class="btn btn-lg btn-main custom-rounded">
        		{{ trans('misc.view_all') }} <i class="fa fa-long-arrow-right"></i>
        		</a>
        </div>
      @endif

      @if($settings->show_images_index == 'latest' || $settings->show_images_index == 'both')
			<div class="col-md-12 btn-block margin-bottom-40">
				<h1 class="btn-block text-center class-montserrat margin-bottom-zero none-overflow highlight-word-color">@lang('misc.recent_photos')</h1>
				<h5 class="btn-block text-center class-montserrat text-uppercase">{{trans('misc.title_2_index')}}</h5>
			</div>

	<div id="imagesFlex" class="flex-images btn-block margin-bottom-40">
	     @include('includes.images')
	  </div><!-- Image Flex -->

	  <div class="col-md-12 text-center margin-bottom-20">
      	<a href="{{ url('latest') }}" class="btn btn-lg btn-main custom-rounded">
      		{{ trans('misc.view_all') }} <i class="fa fa-long-arrow-right"></i>
      		</a>
      </div>
      @endif

	  @else
	  <div class="btn-block text-center">
	    			<i class="icon icon-Picture ico-no-result"></i>
	    		</div>

	    		<h3 class="margin-top-none text-center no-result no-result-mg">
	    		{{ trans('misc.no_images_published') }}
	    	</h3>
	  @endif
		
	  

	  </div>
	  <div class="col-md-3">
		  <style>
			  .ads-wrapper-content {
				margin-bottom: 25px;
			}
		  </style>
		  <div class="row">
	  @foreach( $sidebarAds as $adsdata )
			<div class="col-md-12 col-sm-6">
				<div class="ads-wrapper-content">
					<a href="{{{$adsdata->url}}}">
						<img src="{{ asset('ads-image/'.$adsdata->thumbnail) }}" width="100%" height="auto" alt="{{{$adsdata->name}}}" class="img-responsive" />
					</a>
				</div>
			</div>
	  @endforeach
	  </div>
</pre>
	</div><!-- row -->

	</div><!-- container wrap-ui -->

	<section class="footer-ads-section">
		<div class="container-fluid">
			<div class="row werwer">
			@foreach( $footerSidebarAds as $adsdata )
			<div class="col-md-4 col-sm-6">
				<div class="ads-wrapper-content">
					<a href="{{{$adsdata->url}}}">
						<img src="{{ asset('ads-image/'.$adsdata->thumbnail) }}" width="100%" height="auto" alt="{{{$adsdata->name}}}" class="img-responsive" />
					</a>
				</div>
			</div>
	  @endforeach 
			</div>
		</div>
	</section>



@if ($settings->show_categories_index == 'on')
<div class="wrapper">
<div class="container">
	<div class="row margin-bottom-40">
				<div class="col-md-12 btn-block margin-bottom-40">
					<h1 class="btn-block text-center class-montserrat margin-bottom-zero none-overflow color-white">{{trans('misc.categories')}}</h1>
					<h5 class="btn-block text-center class-montserrat text-uppercase color-gray">{{trans('misc.browse_by_category')}}</h5>
				</div>

	    	@foreach($categories->chunk(3) as $column)

	    		<div class="col-md-3 col-center">
	    			<ul class="list-unstyled imagesCategory">
	    		@foreach ($column as $category)

	        				<li>
	        					<a class="link-category" href="{{ url('category') }}/{{ $category->slug }}">{{ $category->name }} ({{$category->images()->count()}}) </a>
	        					</li>

	        			@endforeach

	        				</ul>
	        			</div>
	        	@endforeach

	        	@if( $categories->total() > 11 )
	        		<div class="col-md-12 text-center margin-top-40">
                  	<a href="{{ url('categories') }}" class="btn btn-lg btn-main custom-rounded">
                  		{{ trans('misc.view_all') }} <i class="fa fa-long-arrow-right"></i>
                  		</a>
                  </div>
	        	@endif

			</div><!-- col-md-9 -->
			</div><!-- row -->
	</div><!-- container -->
</div><!-- wrapper -->
@endif
@endsection

@section('javascript')
	<script src="{{ asset('plugins/jquery.counterup/jquery.counterup.min.js') }}"></script>
	<script src="{{ asset('plugins/jquery.counterup/waypoints.min.js') }}"></script>

		<script type="text/javascript">
		jQuery(document).ready(function(){

			// open Image Viewer
			jQuery("a.ImagePlating.openImageViewer").on('click', function(e){
				e.preventDefault();
				var imgId = jQuery(this).attr('data-id');
				jQuery("#cmImageValueField").val(imgId);
				var Like =jQuery(this).find('.total_like').text();
				var DisLike = jQuery(this).find('.total_dislike').text();
				var Views = jQuery(this).find('.total_views').text();
				jQuery("#like-count").text(Like);
				jQuery("#dislike-count").text(DisLike);
				jQuery('#views').text(Views);
				var formData = {
					id: imgId
				};
				var type = "POST";
				var ajaxurl = 'ajax/imageview';
				$.ajax({
					type: type,
					url: ajaxurl,
					data: formData,
					dataType: 'json',
					success: function (datas) {
						if(datas.status == 200){
							jQuery("#views").text(datas.totalview);
						}
						
					},
					error: function (data) {
			
					}
				});

			})

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			//Image Dislike
			$(".dislike-btn").click(function(e){
				var myImgId = jQuery('#cmImageValueField').val();
				e.preventDefault();
				$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
				}
			});
			e.preventDefault();
			var formData = {
				id: myImgId
			};
			var type = "POST";
			var ajaxurl = 'ajax/dislike';
				$.ajax({
					type: type,
					url: ajaxurl,
					data: formData,
					dataType: 'json',
					success: function (datas) {
						if(datas.status == 200){
							swal(datas.message, "","success");
							jQuery("#dislike-count").text(datas.countdisLike);
							jQuery("#like-count").text(datas.countLike);
						}
						else if(datas.status == false){
							swal(datas.message, "","info");
						}
					},
					error: function (data) {
						console.log(data);
					}
				});
			});
			//Image Like Func
			$(".like-btn").click(function(e){
				var myImgId = jQuery('#cmImageValueField').val();
				e.preventDefault();
				$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
				}
			});
			e.preventDefault();
			var formData = {
				id: myImgId
			};
			var type = "POST";
			var ajaxurl = 'ajax/like';
				$.ajax({
					type: type,
					url: ajaxurl,
					data: formData,
					dataType: 'json',
					success: function (datas) {
						if(datas.status == 200){
							swal(datas.message, "","success");
							jQuery("#like-count").text(datas.countLike);
							jQuery("#dislike-count").text(datas.countdisLike);
						}
						else if(datas.status == false){
							swal(datas.message, "","info");
						}
					},
					error: function (data) {
						console.log(data);
					}
				});
			});
		})
		 $('#imagesFlex').flexImages({ rowHeight: 320, maxRows: 8, truncate: true });

     $('#imagesFlexFeatured').flexImages({ rowHeight: 320, maxRows: 8, truncate: true });


		jQuery(document).ready(function( $ ) {
			$('.counter').counterUp({
			delay: 10, // the delay time in ms
			time: 1000 // the speed time in ms
			});
		});

		 @if (session('success_verify'))
    		swal({
    			title: "{{ trans('misc.welcome') }}",
    			text: "{{ trans('users.account_validated') }}",
    			type: "success",
    			confirmButtonText: "{{ trans('users.ok') }}"
    			});
   		 @endif

   		 @if (session('error_verify'))
    		swal({
    			title: "{{ trans('misc.error_oops') }}",
    			text: "{{ trans('users.code_not_valid') }}",
    			type: "error",
    			confirmButtonText: "{{ trans('users.ok') }}"
    			});
   		 @endif

       // GET country
       /*$.get("https://ipinfo.io", function (response) {
   		     console.log(response.country);

   		 }, "jsonp");*/


		</script>

@endsection
