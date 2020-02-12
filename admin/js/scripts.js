$(document).ready(function() {

// EDITOR CKEDITOR
    ClassicEditor
        .create(document.querySelector('#body'))

});




// SELECT AND DESELECT ALL BOXES IN view_all_posts
    $(document).ready(function(){
    $('#selectAllBoxes').click(function(event){
        if(this.checked){
            $('.checkBoxes').each(function(){
                this.checked = true;
            });
        } else {
            $('.checkBoxes').each(function(){
                this.checked = false;
            });
        }
    });
 });


// LOADER
        $(document).ready(function() {
            // var div_box = <div id='load-screen'><div id='loading'></div></div> //this is in the header
            // $("body").prepend(div_box);
       $('#load-screen').delay(300).fadeOut(300, function(){
          $(this).remove();
       });
});





// MESSAGES FADING IDEA FOR FUTURE



function loadUsersOnline(){
    $.get("functions.php?onlineusers=result", function(data){
        $(".usersonline").text(data);
    });
}
setInterval(function(){
loadUsersOnline();
},500);

