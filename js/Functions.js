$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID

    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
        }
    });

    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })

});


function deleteEvent(event){
    var elem = document.getElementById(event);
    console.log(elem);
    $.ajax({
        type: "POST",
        url: "..//deleteEvent.php",
        data: {
            id:event
        }
    });
    elem.remove();
}



$("#containerr").on('click', '.remove', function(){
    $(this).closest('.helpcont').remove();
});

/**
 * dynamically displays the users event name
 */
$("#eventName").keyup(function(){
    var cleanedString;
    var textinput = $('#eventName').val().substring(0,255);
            cleanedString = textinput.replace(new RegExp(" ","g"),"_");
            $("#userInput").text(cleanedString);
});

var x = document.getElementById("demo");

/**
 * returns the users geolocation
 *
 *
 */
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}
function showPosition(position) {
    x.innerHTML = "Latitude: " + position.coords.latitude +
        "<br>Longitude: " + position.coords.longitude;
}

/**
 * @func geoplugin_city() returns the users city
 * @func geoplugin_region() returns the users state
 *
 * sets the div district to the users city and state
 */
var district = geoplugin_city();
var region = geoplugin_region();

$("#locationSearch").val(district+","+" "+region);



function redirect(){
    window.location="create.php";
}

//fetches color of submitted image
//retruns the dominant hex color of a submitted image
function fetchColor(){
    var img = imagePreview;
   var  getImg = document.getElementById(img);
    var colorThief = new ColorThief();
   var rgb= colorThief.getColor(getImg);
}

function RGB2Color(r,g,b)
{
    var color= this.byte2Hex(r) + this.byte2Hex(g) + this.byte2Hex(b);
    console.log(color);
    var inverted= invertColor(color);
    var matchColor = getSimilarColors(inverted);
    $(".previewImage").css("color",matchColor);
    var font = document.getElementById('font');
    $.post("addEvent",{font:matchColor});
    $("#font").val(matchColor);
    return inverted;
}

function byte2Hex (n)
{
    var nybHexString = "0123456789ABCDEF";
    return String(nybHexString.substr((n >> 4) & 0x0F,1)) + nybHexString.substr(n & 0x0F,1);
}

//return the complimentary color of a given hex
function invertColor(hexTripletColor) {
    var color = hexTripletColor;
    color = color.substring(1);           // remove #
    color = parseInt(color, 16);          // convert to integer
    color = 0xFFFFFF ^ color;             // invert three bytes
    color = color.toString(16);           // convert to hex
    color = ("000000" + color).slice(-6); // pad with leading zeros
    color = "#" + color;                  // prepend #
    return color;
}

//Find similar color based off of an array of flat colors

    function getSimilarColors (color) {
        var base_colors=["16A085","2ECC71","27AE60","3498DB","2980B9","9B59B6","8E44AD","34495E","2C3E50","2C3E50","F1C40F","F39C12","E67E22","D35400","E74C3C","C0392B","ECF0F1","BDC3C7","95A5A6","7F8C8D"];

        //Convert to RGB, then R, G, B
        var color_rgb = hex2rgb(color);
        var color_r = color_rgb.split(',')[0];
        var color_g = color_rgb.split(',')[1];
        var color_b = color_rgb.split(',')[2];

        //Create an emtyp array for the difference betwwen the colors
        var differenceArray=[];

        //Function to find the smallest value in an array
        Array.min = function( array ){
            return Math.min.apply( Math, array );
        };


        //Convert the HEX color in the array to RGB colors, split them up to R-G-B, then find out the difference between the "color" and the colors in the array
        $.each(base_colors, function(index, value) {
            var base_color_rgb = hex2rgb(value);
            var base_colors_r = base_color_rgb.split(',')[0];
            var base_colors_g = base_color_rgb.split(',')[1];
            var base_colors_b = base_color_rgb.split(',')[2];

            //Add the difference to the differenceArray
            differenceArray.push(Math.sqrt((color_r-base_colors_r)*(color_r-base_colors_r)+(color_g-base_colors_g)*(color_g-base_colors_g)+(color_b-base_colors_b)*(color_b-base_colors_b)));
        });

        //Get the lowest number from the differenceArray
        var lowest = Array.min(differenceArray);

        //Get the index for that lowest number
        var index = differenceArray.indexOf(lowest);

        //Function to convert HEX to RGB
        function hex2rgb( colour ) {
            var r,g,b;
            if ( colour.charAt(0) == '#' ) {
                colour = colour.substr(1);
            }

            r = colour.charAt(0) + colour.charAt(1);
            g = colour.charAt(2) + colour.charAt(3);
            b = colour.charAt(4) + colour.charAt(5);

            r = parseInt( r,16 );
            g = parseInt( g,16 );
            b = parseInt( b ,16);
            return r+','+g+','+b;
        }

        //Return the HEX code
        return base_colors[index];
    }


//dynamically add image
$("#eventImage").on("change", function()
{
    var files = !!this.files ? this.files : [];
    if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

    if (/^image/.test( files[0].type)){ // only image file
        var reader = new FileReader(); // instance of the FileReader
        reader.readAsDataURL(files[0]); // read the local file

        reader.onloadend = function(){ // set image data as background of div

            $(".previewImage").css("background-image","url("+this.result+")");
            getSrc(this.result);
        }
    }
});


var img = document.createElement("img");

img.onload = function () {
    var colorThief = new ColorThief();
    var rgb = colorThief.getColor(img);
    RGB2Color(rgb[0],rgb[1],rgb[2]);

};
function getSrc(source){
    img.src=source;
}

$(document).ready(function(){
    $(".url").hide();
});
function displayUrl(id){

    $("#url"+id).toggle();
}



//Show modal
window.onload = function(){
    if ( document.getElementById('showModal') ){

        $('#myModal').modal('show');
    }

};


// vanilla JS
// init with element

$(document).ready(function(){
    var grid = document.querySelector('.masonry-container');
    var msnry = new Masonry( grid, {
        // options...
        itemSelector: '.item',
        columnWidth:'.item'
    });
});

/**
 * Instantiate clipboard
 */
new Clipboard('.fa-share-alt');

/**
 *
 */

$(document).ready(function(){


});

function displayRegistrants(eventID){
    $('#registrantsModal'+eventID).modal('show');
}

function redirectToEventDetails(uID, eID){
    document.location.href="/eventDetails/"+uID+"/"+eID;
}
