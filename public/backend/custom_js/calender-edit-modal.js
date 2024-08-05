$(document).ready(function(){
    // hide default buttons of edit form
    $("#formbutton , #deleteButton").addClass("d-none");
   //  edit and back button functions
   let backBtn = $("#backButton");
   let editBtn = $("#formEditButton");
   let form = $("#calender-edit-form");
   let details = $("#Details");
    $(editBtn).on("click", function(){
        $(this).removeClass("show");
        backBtn.addClass("show");
        details.removeClass("show").addClass("d-none");
        form.removeClass("d-none").addClass("show");
    });

    $(backBtn).on("click", function(){
        $(this).removeClass("show");
        editBtn.addClass("show");
        form.removeClass("show").addClass("d-none");
        details.removeClass("d-none").addClass("show");
    });

});