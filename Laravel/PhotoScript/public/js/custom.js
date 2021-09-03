
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
});
