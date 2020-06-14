var url = 'http://proyecto-laravel.com.devel';

window.addEventListener("load", function(){
   
    $('.btn-like').css('cursor','pointer');
    $('.btn-dislike').css('cursor','pointer');
    
    function like(){
        $('.btn-like').unbind('click').click(function(){
          $(this).addClass('btn-dislike').removeClass('btn-like');
          $(this).attr('src',url+'/img/heart-red.png');
          numLikes = $(this).next();
          $.ajax({
              url: url+'/like/'+$(this).data('id'),
              type:'GET',
              success: function(response){
                  if(response.like){
                      numLikes.text(response.likes);
                  } else {
                      console.log("error al dar like");
                  }
                  
              }
          });
          
          dislike();
        });
    }
    like();
    
    function dislike(){
        $('.btn-dislike').unbind('click').click(function(){
          $(this).addClass('btn-like').removeClass('btn-dislike');
          $(this).attr('src',url+'/img/heart-black.png');
          numLikes = $(this).next();
            $.ajax({
              url: url+'/dislike/'+$(this).data('id'),
              type:'GET',
              success: function(response){
                  if(response.like){
                      numLikes.text(response.likes);
                  } else {
                      console.log("error al dar dislike");
                  }
                  
              }
          });
            
            like();
        });
    }
    dislike();
   
   
   // buscador
   $('#buscador').submit(function(){
      $(this).attr('action',url+'/gente/'+$('#buscador #search').val());
   });
});
