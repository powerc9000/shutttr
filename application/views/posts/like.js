$('document').ready(function() {  
   $('.like').click(function() {
       var t               = $(this),
        username        = t.attr('username'),
        poster_username = t.attr('poster-username'),
        slug            = t.siblings('.post-slug').text(),
        liking;

    if (username != poster_username) {

        if(liking !== true) {

            liking = true;

            var numberlikes = t.children().children('.num-likes').text()
                numberlikes = parseInt(numberlikes, 10);

            var text        = t.attr('like'),
                postplace   = t.attr('href'),
                loadergif   = $('.loader-gif');

            loadergif.css('display', 'block');

            if (text == 'like') {

                $('#loader').remove();

                $.post(postplace, '', function(response) {


                    loadergif.fadeOut('1000', function() {
                        liking = false;
                        t.attr('href', "posts/unlike_post/" + slug);
                t.attr('like', 'unlike');
                t.children('.like-data-tooltip').attr('data-tooltip', 'Unlike Post');
                t.addClass('green');
                    );


                });

                

                if (numberlikes < numberlikes + 1) {
                    t.children().children('.num-likes').text(numberlikes + 1);
                }

            }
            else if (text == 'unlike') {

                $('#loader').remove();

                $.post(postplace, '', function(response) {
                    t.attr('href', "posts/like_post/" + slug);
                t.attr('like', 'like');
                t.children('.like-data-tooltip').attr('data-tooltip', 'Like Post');
                t.removeClass('green');

                    $('.loader-gif').fadeOut('1000', function() {
                        liking = false;
                    });

                });

                

                if (numberlikes > numberlikes - 1) {
                    $(this).children().children('.num-likes').text(numberlikes - 1);
                }

            }
        }

    }
    else {
        alert('you can\'t like your own post!');
    }
    return false;
});
 });
});