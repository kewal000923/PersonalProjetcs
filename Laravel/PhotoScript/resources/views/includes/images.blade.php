@foreach( $images as $image )

@php
  

  // echo "<pre>";
  // print_r($image);
  // echo "</pre>";


	$colors = explode(",", $image->colors);
	$color = $colors[0];

	if($image->extension == 'png' ) {
		$background = 'background: url('.url('public/img/pixel.gif').') repeat center center #e4e4e4;';
	}  else {
		$background = 'background-color: #'.$color.'';
	}

@endphp
<!-- Start Item -->


<div class="col-md-4">
<style type="text/css">
.like-btn,
.dislike-btn {
    float: left;
    padding-top: 15px;
    padding-bottom: 15px;
}
.dislike-btn {
    margin-top: 10px;
    margin-left: 15px;
}
#like-count {
    font-size: 15px;
    font-weight: bold;
    color: #05ba4c;
    top: 8px;
    position: relative;
    margin-left: 10px;
}
#dislike-count {
    font-size: 15px;
    font-weight: bold;
    color: #f02a27;
    top: 8px;
    position: relative;
    margin-left: 10px;
}
.like-dislike-btn {
    float: left;
    display: block;
    width: 100%;
}
#dislike-count {
    top: 0px !important;
}
.color-red{color: #F00 !important;font-weight: bold;}
.color-red span {
    color: #000;
}
#popbg {
    width: 100%;
    height: 400px;
    object-fit: contain;
    object-position: top;
}
.ImagePlating img {
    width: 100%;
    height: 350px;
    object-fit: cover;
    object-position: center;
    margin-bottom: 30px;
}
</style>
	<a href="#" class="ImagePlating openImageViewer" data-toggle="modal" data-target="#product_view" data-id="{{ $image->id}}">
    <img class="img-responsive" src="{{ asset('storage/uploads/small/'.$image->small) }}" />
    <div class="image-info d-none">
      <div id="tags">{{ $image->tags}}</div>
      <div id="largeimg">{{ $image->large}}</div>
      <div id="category">{{ $image->category->name}}</div>
      <div id="title">{{ $image->title}}</div>
      <div class="total_views">{{ $image->total_views}}</div>
      <div class="total_like">{{ $image->total_like}}</div>
      <div class="total_dislike">{{ $image->total_dislike}}</div>
    </div>
  </a>
</div>
@endforeach




<div class="modal fade product_view bd-example-modal-lg" id="product_view">
    <div class="modal-dialog modal-dialog-centered bd-example-modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 product_img">
                        <span id="largeimg-name"></span>
                        <img id="popbg" src="{{ asset('storage/uploads/large/'.$image->preview) }}" class="img-responsive">
                    </div>
                    <div class="col-md-12 product_content"><br>
                        <table class="table table-bordered">
                            <tr>
                                <td>
                                    <div class="like-dislike-btn">
                                        <input type="hidden" id="cmImageValueField"/>
                                        <div id="cm-like-btn" class="like-btn" data-value="1"><img src="{{ asset('img/like.png') }}"><span id="like-count"></span></div>
                                        <div id="cm-dislike-btn" class="dislike-btn" data-value="0"><img src="{{ asset('img/dislike.png') }}"><span id="dislike-count"></span></div>
                                    </div>
                                </td>

                                <td colspan="2">
                                    <h4 class="title color-red" style="margin-top: 30px;">Pornstar Name :-<span id="image-name"></span></h4>
                                </td>
                            </tr>
                            <tr>
                                <td rowspan="2">
                                    <h4 class="color-red">Views :- <span id="views"></span></h4>
                                </td>
                            
                                <td>
                                    <h4 class="color-red">Category :- <span id="category-name"></span></h4>
                                </td>
                            </tr><tr>
                                <td>
                                    <h4 class="color-red">Tags :- <span id="tags-names"></span></h4>
                                </td>
                            </tr>
                        </table>
                        
                        
                        

                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content rounded-0">
          <div class="modal-body py-0">            
            <div class="d-flex main-content">
              <div id="popbg" class="bg-image promo-img mr-3" style="background-image: url('images/img_1.jpg');">
                <span class="price">$2000</span>
              </div>
              <div class="content-text p-4 px-5 align-item-stretch">
                <div class="text-center">
                    <a href="#" class="share"><span class="icon-share"></span></a>
                    <h3 class="mb-3 line">Grand Prix 4000</h3>
                    <p class="mb-3">
                        <span class="icon-star text-warning"></span>
                        <span class="icon-star text-warning"></span>
                        <span class="icon-star text-warning"></span>
                        <span class="icon-star text-warning"></span>
                        <span class="icon-star"></span>
                    </p>

                    <p class="mb-5">All their equipment and instruments are alive. The sky was this is cloudless and of a deep dark blue. A shining crescent far beneath the flying vessel.</p>

                    <div class="d-flex text-center social w-50 mx-auto">
                        <a href="#" class="d-inline-block d-flex align-items-center mr-auto like">
                            <span class="icon-heart mr-2 icon"></span> <span>25</span>
                        </a>
                        <a href="#" class="d-inline-block d-flex align-items-center mx-auto message">
                            <span class="icon-chat mr-2 icon"></span> <span>10</span>
                        </a>
                        <a href="#" class="d-inline-block d-flex align-items-center ml-auto add">
                            <span class="icon-add mr-2"></span> <span>55</span>
                        </a>
                    </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

@if(request()->ajax() && $images->count() != 0)
	<div class="container-paginator">
		{{ $images->appends(['timeframe' => request()->get('timeframe')])->links() }}
	</div>
@endif


