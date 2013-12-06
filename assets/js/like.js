$('document').ready(function() {  
   $('.like').click(function() {
        var thee = $(this);
        var username = $(this).attr('username');
        var poster_username = $(this).attr('poster-username');
        var slug = $(this).siblings('.post-slug').text();
        $(this).fadeTo('100',0);
        if (username !== poster_username) {
            var numberlikes = $(this).children().children('.num-likes').text();
            $('.loader-gif').css('display', 'block');
            numberlikes = parseInt(numberlikes, 10);
            var text = $(this).attr('like');
            var postplace = $(this).attr('href');
            if (text === 'like') {
                $('#loader').remove();
                $.post(postplace, '', function(response) {
                    $('.loader-gif').fadeOut('1000', function(){
                         thee.attr('href', "posts/unlike_post/" + slug);
                        thee.attr('like', 'unlike');
                        thee.children('.like-data-tooltip').attr('data-tooltip', 'Unlike Post');
                        thee.addClass('green');
                        thee.fadeTo('500',1);
                    });
                       

                });
                
                if (numberlikes < numberlikes + 1) {
                    thee.children().children('.num-likes').text(numberlikes + 1);
                }
            }
            else if (text === 'unlike') {
                $('#loader').remove();
                $.post(postplace, '', function(response) {
                    $('.loader-gif').fadeOut('1000',function(){
                        thee.attr('href', "posts/like_post/" + slug);
                        thee.attr('like', 'like');
                        thee.children('.like-data-tooltip').attr('data-tooltip', 'Like Post');
                        thee.removeClass('green');
                        thee.fadeTo('500',1);
                    });
                        
                });
               
                if (numberlikes > numberlikes - 1) {
                    thee.children().children('.num-likes').text(numberlikes - 1);
                }
            }

        }
        else {
            alert('you can\'t like your own post!');

        }
        return false;
 });
});