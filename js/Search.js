
$(document).ready(function(){
    $("#suggestion-box").hide();

    $("#locationSearch").keyup(function(){

        $.ajax({
            type: "POST",
            url: "searchLocation.php",
            data:'location='+$(this).val(),
            beforeSend: function(){
                $("#locationSearch").css("background","#FFF url(../images/ajax-loader.gif) no-repeat 165px");
            },
            success: function(data){

                $("#suggestion-box").html(data);
                $("#suggestion-box").show();
                $("#locationSearch").css("background","#FFF");
            }
        });
    });
});
//Inserts users selection into input box
function selectCity(val) {
    toggleValidIfClicked();
    $("#locationSearch").val(val);
    $("#suggestion-box").hide();
}
$("#locationSearch").click(function(){
    $("#suggestion-box").toggle();

});

$(document).click(function(e) {
    var target = e.target;
    if (!$(target).is('#suggestion-box') && !$(target).parents().is('#suggestion-box')) {
        $('#menu').hide();
    }
});

//if validateLocation true, then add green border, else add red border
$("#locationSearch").keyup(function(){
    if(!validateLocation()){
        $("#searchButton").prop('disabled', true);
        $("#locationSearch").removeClass('acceptedValidation');
        $("#locationSearch").addClass('unacceptedValidation');
    }else{
        $("#searchButton").prop('disabled', false);
        $("#locationSearch").removeClass('unacceptedValidation');
        $("#locationSearch").addClass('acceptedValidation');
    }
});
//*[@id="suggestion-box"]/li[1]
function toggleValidIfClicked(){
    $("#searchButton").prop('disabled', false);
    $("#locationSearch").removeClass('unacceptedValidation');
    $("#locationSearch").addClass('acceptedValidation');

}

//Checks to see if location properly entered.
//if location inputted as "city, state"
function validateLocation(){
    var location = $("#locationSearch").val();
    var splitLocation = location.split(",");
    var city = splitLocation[0];
    var state = splitLocation[1];


    if(splitLocation.length ===1){
        return false; //no state entered
    }else{
        //check if city present
        if(city.trim()===""){
            return false; //no city entered
        }else if(state.trim()===""||state.trim().length>2){
            return false; //no state entered
        }else{
            return true;//success
        }

    }
}



