
$(document).ready(function(){
    // Set background image of a div on click of the button
    $(".ImagePlating").click(function(){
        var imageUrl = $(this).find("img").attr("src");
        // $("#popbg").attr('src',imageUrl);

        var image_title = $(this).find("#title").text();
        $("#image-name").text(image_title);


        var largeimg = $(this).find("#largeimg").text();
        var imageUrl1 = '/storage/uploads/large/'+largeimg;
        $("#popbg").attr('src',imageUrl1);

        var total_like = $(this).find("#total_like").text();
        $("#like-count").text(total_like);

        var total_dislike = $(this).find("#total_dislike").text();
        $("#dislike-count").text(total_dislike);

        var total_views = $(this).find("#total_views").text();
        $("#views").text(total_views);

        var category = $(this).find("#category").text();
        $("#category-name").text(category);

        var tags = $(this).find("#tags").text();
        $("#tags-names").text(tags);


    });
    // Slick Slider Start
    jQuery('.cm-horizontal-slider').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: false,
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 1,
            }
          },
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
        ]
      });
      jQuery('.cm-vertical-slider').slick({
          dots: false,
          infinite: true,
          speed: 300,
          slidesToShow: 4,
          slidesToScroll: 1,
          arrows: true,
          vertical:true,
          prevArrow:'<button type="button" class="slick-prev"><i class="ion-chevron-up"></i></button>',
          nextArrow:'<button type="button" class="slick-next"><i class="ion-chevron-down"></i></button>',
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
              }
            },
            {
              breakpoint: 992,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
          ]
        });
      jQuery('.cm-horizontal-slider, .cm-vertical-slider').removeClass('cm-display-none');
});
