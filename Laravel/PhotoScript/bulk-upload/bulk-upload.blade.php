@extends('admin.layout')

@section('css')
<link href="{{ asset('plugins/iCheck/all.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/tagsinput/jquery.tagsinput.min.css') }}" rel="stylesheet" type="text/css" />

<script src="{{ asset('js/dropzone.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('js/dropzone.min.css') }}">

<style type="text/css">

.position-relative {
    position: relative;
}


.filer-input-dragDrop {
    display: block;
    width: 100%;
    margin: 0 auto 25px auto;
    padding: 50px 0;
    color: #8d9499;
    color: #97A1A8;
    cursor: pointer;
    background: #fff;
    border-radius: 6px;
    border: 2px dashed #C8CBCE;
    text-align: center;
    -webkit-transition: box-shadow 0.3s,
                        border-color 0.3s;
    -moz-transition: box-shadow 0.3s,
                        border-color 0.3s;
    transition: box-shadow 0.3s,
                        border-color 0.3s;
                        overflow: hidden;
}
.filer-input-dragDrop:hover,
.hoverClass {
	border-color: #868686;
}
.filer.dragged .filer-input-dragDrop {
    border-color: #aaa;
    box-shadow: inset 0 0 20px rgba(0,0,0,.08);
}

.filer.dragged .filer-input-dragDrop * {
    pointer-events: none;
}

.filer.dragged .filer-input-icon {
    -webkit-transform: rotate(180deg);
    -ms-transform: rotate(180deg);
    transform: rotate(180deg);
}

.filer.dragged .filer-input-text,
.filer.dragged .filer-input-choose-btn {
    filter: alpha(opacity=30);
    opacity: 0.3;
}

.filer-input-dragDrop .filer-input-icon {
    font-size: 70px;
    margin-top: -10px;
    -webkit-transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    transition: all 0.3s ease;
}

.filer-input-text h3 {
    margin: 0;
    font-size: 18px;
}

.filer-input-text span {
    font-size: 12px;
}

.filer-input-choose-btn {
    display: inline-block;
    padding: 8px 14px;
    outline: none;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    white-space: nowrap;
    font-size: 12px;
    font-weight: bold;
    color: #8d9496;
    border-radius: 3px;
    border: 1px solid #c6c6c6;
    vertical-align: middle;
    background-color: #fff;
    box-shadow: 0px 1px 5px rgba(0,0,0,0.05);
    -webkit-transition: all 0.2s;
    -moz-transition: all 0.2s;
    transition: all 0.2s;
}

.filer-input-choose-btn:hover,
.filer-input-choose-btn:active {
    color: inherit;
}

.filer-input-choose-btn:active {
    background-color: #f5f5f5;
}
.p-box {
  padding: 20px;
}
/* Mimic table appearance */
   div.table {
     display: table;
   }
   div.table .file-row {
     display: table-row;
   }
   div.table .file-row > div {
     display: table-cell;
     vertical-align: top;
     border-top: 1px solid #ddd;
     padding: 8px;
   }
   div.table .file-row:nth-child(odd) {
     background: #f9f9f9;
   }

   /* The total progress gets shown by event listeners */
   #total-progress {
     opacity: 0;
     transition: opacity 0.3s linear;
   }

   /* Hide the progress bar when finished */
   #previews .file-row.dz-success .progress {
     opacity: 0;
     transition: opacity 0.3s linear;
   }

   /* Hide the delete button initially */
   #previews .file-row .delete {
     display: none;
   }

   /* Hide the start and cancel buttons and show the delete button */

   #previews .file-row.dz-success .start,
   #previews .file-row.dz-success .cancel {
     display: none;
   }
   #previews .file-row.dz-success .delete {
     display: block;
   }
  .name {
    white-space: normal !important;
    word-wrap: break-word !important;
    word-break: break-word !important;
  }
</style>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h4>
           {{ trans('admin.admin') }} <i class="fa fa-angle-right margin-separator"></i> {{ trans('bulk_upload.bulk_upload') }}
          </h4>
        </section>

        <!-- Main content -->
        <section class="content">

          <div class="row">

            <div class="col-md-5">
              <div class="box p-box">
                <div class="alert alert-warning">
                  <strong>{{trans('bulk_upload.notice_bulk_upload')}}</strong>
                </div>
                  <div class="form">
                    <!-- Start Box Body -->
                   <div class="box-body">
                     <div class="form-group">
                       <label class="control-label">{{ trans('misc.tags') }}</label>
                       <div>
                         <input type="text" value="{{old('tags')}}" id="tagInput"  name="tags" class="form-control" placeholder="{{ trans('misc.tags') }}">
                       	<p class="help-block">* {{ trans('misc.add_tags_guide') }}</p>
                       </div>
                     </div>
                   </div><!-- /.box-body -->

                   <!-- Start Box Body -->
                    <div class="box-body">
                      <div class="form-group">
                        <label class="control-label">{{ trans('misc.category') }}</label>
                        <div>
                        	<select name="categories_id" class="form-control">
                        	@foreach(  App\Models\Categories::where('mode','on')->orderBy('name')->get() as $category )
                              <option @if( $category->id == 1 ) selected="selected" @endif value="{{$category->id}}">{{ $category->name }}</option>
                              @endforeach
                            </select>
                        </div>
                      </div>
                    </div><!-- /.box-body -->

                    @if ($settings->free_photo_upload == 'on')
                    <!-- Start Box Body -->
                    <div class="box-body">
                      <div class="form-group">
                        <label class="control-label">{{ trans('misc.item_for_sale') }}</label>
                        <div>
                          <select name="item_for_sale" class="form-control" id="itemForSale">
                              <<option value="free">{{ trans('misc.no_free') }}</option>
                              <option value="sale">{{ trans('misc.yes_for_sale') }}</option>
                            </select>
                        </div>
                      </div>
                    </div><!-- /.box-body -->
                  @else
                    <input type="hidden" name="item_for_sale" value="sale">
                  @endif

                    <!-- Start Box Body -->
                   <div class="box-body @if ($settings->free_photo_upload == 'on') display-none @endif" id="priceBox">
                     <div class="form-group">
                       <label class="control-label">{{ trans('misc.price') }}</label>
                       <div>
                         <input type="number" value="" name="price" class="form-control onlyNumber" autocomplete="off" id="price"  placeholder="{{ trans('misc.price') }}">
                         <p class="help-block">
                           @if (Auth::user()->author_exclusive == 'yes')
                           * {{ trans('misc.user_gain', ['percentage' => (100 - $settings->fee_commission)]) }}
                         @else
                           * {{ trans('misc.user_gain', ['percentage' => (100 - $settings->fee_commission_non_exclusive)]) }}
                           @endif
                         </p>

                         <div class="alert alert-success">
                           <h4>{{trans('misc.price_formats')}}</h4>
                           <ul class="list-unstyled">
                             <li><strong>{{trans('misc.small_photo_price')}}</strong> {{ $settings->currency_position == 'left' ? $settings->currency_symbol : null }}<span id="s-price">0</span>{{ $settings->currency_position == 'right' ? $settings->currency_symbol : null }}</li>
                             <li><strong>{{trans('misc.medium_photo_price')}}</strong> {{ $settings->currency_position == 'left' ? $settings->currency_symbol : null }}<span id="m-price">0</span>{{ $settings->currency_position == 'right' ? $settings->currency_symbol : null }}</li>
                             <li><strong>{{trans('misc.large_photo_price')}}</strong> {{ $settings->currency_position == 'left' ? $settings->currency_symbol : null }}<span id="l-price">0</span>{{ $settings->currency_position == 'right' ? $settings->currency_symbol : null }}</li>
                           </ul>
                           <small>{{trans('misc.price_maximum')}} {{\App\Helper::amountFormat($settings->max_sale_amount)}} | {{trans('misc.price_minimum')}} {{\App\Helper::amountFormat($settings->min_sale_amount)}}</small>
                         </div>
                       </div>
                     </div>
                   </div><!-- /.box-body -->

                   @if ($settings->free_photo_upload == 'on')
                    <!-- Start Box Body -->
                    <div class="box-body options_free">
                      <div class="form-group">
                        <label class="control-label">{{ trans('misc.how_use_image') }}</label>
                        <div>
                          <select name="how_use_image" class="form-control">
                              <option value="free">{{ trans('misc.use_free') }}</option>
                              <option value="free_personal">{{ trans('misc.use_free_personal') }}</option>
                               <option value="editorial_only">{{ trans('misc.use_editorial_only') }}</option>
                                <option value="web_only">{{ trans('misc.use_web_only') }}</option>
                            </select>
                        </div>
                      </div>
                    </div><!-- /.box-body -->

                    <!-- Start Box Body -->
                    <div class="box-body options_free">
                      <div class="form-group">
                        <label class="control-label">{{ trans('misc.attribution_required')  }}</label>
                        <div>

                        	<div class="radio">
                          <label class="padding-zero">
                            <input type="radio" name="attribution_required" value="yes">
                            {{ trans('misc.yes')  }}
                          </label>
                        </div>

                        <div class="radio">
                          <label class="padding-zero">
                            <input type="radio" name="attribution_required" checked value="no">
                           {{ trans('misc.no')  }}
                          </label>
                        </div>
                        </div>
                      </div>
                    </div><!-- /.box-body -->
                  @endif
                    </div><!-- form-horizontal -->
                </div><!-- /.box -->
              </div><!-- col-md -->

              <div class="col-md-7">
                <div class="box p-box">
                  <!-- form start -->
                  <div class="filer-input-dragDrop position-relative uploadFile" id="draggable">
              			<div class="filer-input-inner">
              				<div class="filer-input-icon">
              					<i class="fa fa-cloud-upload"></i>
              					</div>
              					<div class="filer-input-text">
              						<h3 class="margin-bottom-10">{{ trans('misc.click_select_image') }}</h3>
              						<h3>{{ trans('misc.max_size') }}: {{  $settings->min_width_height_image.' - '.App\Helper::formatBytes($settings->file_size_allowed * 1024)}} </h3>
              					</div>
              				</div>
              			</div><!-- draggable -->

                    <div class="btn-block text-center margin-bottom-10 display-none" id="clearList">
                      <a href="javascript:void(0);" class="cancel">
                        @lang('misc.clear_list')
                      </a>
                    </div>

                    <div class="table table-striped" class="files" id="previews">
                      <div id="template" class="file-row">
                        <!-- This is used as the file preview template -->
                        <div>
                            <span class="preview"><img data-dz-thumbnail /></span>
                        </div>
                        <div>
                            <p class="name" data-dz-name></p>
                            <strong class="success text-success" data-dz-successmessage></strong>
                            <strong class="error text-danger" data-dz-errormessage></strong>
                        </div>
                        <div>
                            <p class="size" data-dz-size></p>
                            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                              <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                            </div>
                        </div>
                      </div>
                    </div><!-- previews -->
                </div><!-- box -->

              </div><!-- col-md -->

            </div><!-- row -->


          <!-- Your Page Content Here -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection

@section('javascript')

  <script src="{{ asset('public/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/plugins/tagsinput/jquery.tagsinput.min.js') }}" type="text/javascript"></script>

  <script type="text/javascript">

  $("#tagInput").tagsInput({

   'delimiter': [','],   // Or a string with a single delimiter. Ex: ';'
   'width':'auto',
   'height':'auto',
     'removeWithBackspace' : true,
     'minChars' : 2,
     'maxChars' : 50,
     'defaultText':'{{ trans("misc.add_tag") }}',
});

<?php $dimensions = explode('x',$settings->min_width_height_image); ?>
var minImageWidth = {{$dimensions[0]}}, minImageHeight = {{$dimensions[1]}};

// Get the template HTML and remove it from the doument
      var previewNode = document.querySelector("#template");
      previewNode.id = "";
      var previewTemplate = previewNode.parentNode.innerHTML;
      previewNode.parentNode.removeChild(previewNode);

var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
        paramName: "photo",
        url: "{{url('panel/admin/bulk-upload')}}", // Set the url
        maxFilesize  : {{App\Helper::formatBytes($settings->file_size_allowed * 1024, 2, false)}}, //MB
        maxThumbnailFilesize: {{App\Helper::formatBytes($settings->file_size_allowed * 1024, 2, false)}},
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        timeout: 180000,
        previewTemplate: previewTemplate,
        autoQueue: true, // Make sure the files aren't queued until manually added
        previewsContainer: "#previews", // Define the container to display the previews
        clickable: ".uploadFile", // Define the element that should be used as click trigger to select files.
        dictInvalidFileType: "{{ trans('misc.formats_available') }}",
        dictFileTooBig: "{{trans('misc.max_size_upload').' '.App\Helper::formatBytes($settings->file_size_allowed * 1024)}}",
        dictResponseError: "{{ trans('misc.error') }}",
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
        init: function () {
            this.on("success", function(file, responseText) {
              $('#clearList').show();
              var sucessDisplay = file.previewTemplate.querySelector('[data-dz-successmessage]');
              sucessDisplay.innerHTML = "{{ trans('misc.uploaded_successfully') }}";
                //file.previewTemplate.setAttribute('id', responseText[0].id);
            });
            this.on('error', function(file, errorMessage) {
                $('#clearList').show();
                var errorDisplay = file.previewTemplate.querySelector('[data-dz-errormessage]');

                if (errorMessage.message != undefined || errorMessage.success == false) {
                    errorDisplay.innerHTML = "{{ trans('misc.error') }}";
                }
            });
        },
        accept: function(file, done) {

          // FileReader() asynchronously reads the contents of files (or raw data buffers) stored on the user's computer.
          var reader = new FileReader();
          reader.onload = (function(entry) {
            // The Image() constructor creates a new HTMLImageElement instance.
            var image = new Image();
            image.src = entry.target.result;
            image.onload = function() {

              if (this.width < minImageWidth || this.height < minImageHeight) {
                done("{{ trans('misc.max_size') }} {{  $settings->min_width_height_image}}");
              } else {
                done();
              }

            };
          });

          reader.readAsDataURL(file);

        }
      });

      myDropzone.on('sending', function(file, xhr, formData) {
        formData.append('tags', $('#tagInput').val());
        formData.append('categories_id', $('select[name=categories_id]').val());
        formData.append('item_for_sale', $('#itemForSale').val());
        formData.append('price', $('#price').val());
        formData.append('how_use_image', $('select[name=how_use_image]').val());
        formData.append('attribution_required',$('input[name=attribution_required]:checked').val());
      });

      // Setup the buttons for all transfers
      // The "add files" button doesn't need to be setup because the config
      // `clickable` has already been specified.
      document.querySelector("#draggable").onclick = function() {
        myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
      };

      document.querySelector(".cancel").onclick = function() {
        $('#clearList').hide();
        myDropzone.removeAllFiles(true);
      };

    //Flat red color scheme for iCheck
    $('input[type="radio"]').iCheck({
      radioClass: 'iradio_flat-red'
    });

    $('#itemForSale').on('change', function(){
      if($(this).val() == 'sale') {
  			$('#priceBox').slideDown();
        $('.options_free').slideUp();

  		} else {
  				$('#priceBox').slideUp();
          $('.options_free').slideDown();
  		}
  });

  $(".onlyNumber").keydown(function (e) {
      // Allow: backspace, delete, tab, escape, enter and .
      if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
           // Allow: Ctrl+A, Command+A
          (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
           // Allow: home, end, left, right, down, up
          (e.keyCode >= 35 && e.keyCode <= 40)) {
               // let it happen, don't do anything
               return;
      }
      // Ensure that it is a number and stop the keypress
      if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
          e.preventDefault();
      }
  });

  $('#price').on('keyup', function() {

    var valueOriginal = $('.onlyNumber').val();
    var value = parseFloat($('.onlyNumber').val());
    var element = $(this).val();

    if (element != '') {

      if (valueOriginal >= {{$settings->min_sale_amount}} && valueOriginal <= {{$settings->max_sale_amount}}) {
        var amountSmall = value;
      } else {
        amountSmall = 0;
      }
        var amountMedium = (amountSmall * 2);
        var amountLarge = (amountSmall * 3);

        $('#s-price').html(amountSmall);
        $('#m-price').html(amountMedium);
        $('#l-price').html(amountLarge);

    }

    if (valueOriginal == '') {
      $('#s-price').html('0');
      $('#m-price').html('0');
      $('#l-price').html('0');
    }
  });

</script>
@endsection
