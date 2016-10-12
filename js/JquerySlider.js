/**
 * Created by Michael's Account on 2/22/2016.
 */

/**
 * var directionID stores the id of the nav arrow clicked
 */

var directionID;

$(document).ready(function(){

    /**
     *
     * @var int speed sets the fade speed
     * @var autoswitch enables the slideshow to be automatic
     * @var autoswitch_speed sets the speed that the slides fade to
     * @var height sets the height of the wrapper that the image is in, as well as the image height.
     * @var width sets the width of the wrapper that contains the slide, as well as the image width
     * @var type sets the type that the height and width are set in
     */
    var speed = 500; //fade speed
    var autoswitch = false; //auto slider options
    var autoswitch_speed=9000 //auto slider speed
    var height = 700; //enter height (default height is 700px)
    var width = 700;//enter width (default width is 700px)
    var type = "px"; //enter desired height and width type
    var arrowWidth = width/4;


   $('#slider').prepend("<div class=\"arrowLeft direction\"><img class='arrowLeft'src='./images/left.svg'></div>");

    $('.slideWrapper').first().addClass('active');
    $('#slider').append("<div id='next' class=\"arrowRight direction\"><img class='arrowRight' src='./images/right.svg'></div>");
    $(".arrowRight,.arrowLeft").css({"height":"100%","width":arrowWidth,"position":"absolute","z-index":"101","opacity":".3"});
    $(".arrowRight").css({"float":"right","position":"relative"});
   $(".arrowRight,.arrowLeft").mouseenter(function(){
       $(this).css("opacity",".6");
   });
    $(".arrowRight,.arrowLeft").mouseout(function(){
        $(this).css("opacity",".3");
    });



    /**
     * hides all slides unless the slide is active
     */
    $('.slideWrapper').hide();

    /**
     * initially, will show the first slide
     */
    $('.active').show();

    /**
     * event listener that checks to see if a directional arrow has been pressed
     */
    $(".direction").click(function() {
        $('.direction').removeClass('active');
        directionID = this.id; // or alert($(this).attr('id'));
        $('.active').removeClass('active').addClass('oldActive');
        if(directionID=='next') {
            if ($('.oldActive').is(':last-child')) {
                $('.slideWrapper').first().addClass('active');
            } else {
                $('.oldActive').next().addClass('active');
            }
            $('.oldActive').removeClass('oldActive');
            $('.slideWrapper').fadeOut(speed);
            $('.active').fadeIn(speed);
        }else{
            if($('.oldActive').is(':first-child')){
                $('.slideWrapper').last().addClass('active');
            }else{
                $('.oldActive').prev().addClass('active');
            }
            $('.oldActive').removeClass('oldActive');
            $('.slideWrapper').fadeOut(speed);
            $('.active').fadeIn(speed);
        }
    });
    if(autoswitch==true){
        setInterval(function(){
            $('.active').removeClass('active').addClass('oldActive');
            if($('.oldActive').is(':last-child')){
                $('.slideWrapper').first().addClass('active');
            }else{
                $('.oldActive').next().addClass('active');
            }
            $('.oldActive').removeClass('oldActive');
            $('.slideWrapper').fadeOut(speed);
            $('.active').fadeIn(speed);
        },autoswitch_speed);
    }









});
