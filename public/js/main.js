// $(function(){
//     $("#form-total").steps({
//         headerTag: "h2",
//         bodyTag: "section",
//         transitionEffect: "fade",
//         enableAllSteps: true,
//         stepsOrientation: "vertical",
//         autoFocus: true,
//         transitionEffectSpeed: 500,
//         titleTemplate : '<div class="title">#title#</div>',
//         labels: {
//             previous : 'Back Step',
//             next : 'Next',
//             finish : '',
//             current : ''
//         },
//     })
// });

$(function () {
    $("#form-total").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "fade",
        enableAllSteps: true,
        stepsOrientation: "vertical",
        autoFocus: true,
        transitionEffectSpeed: 500,
        titleTemplate: '<div class="title">#title#</div>',
        labels: {
            previous: 'Back Step',
            next: 'Next',
            finish: 'Submit',
            current: ''
        },
        onStepChanging: function (event, currentIndex, newIndex) {
            // Validate form before allowing next step
            return true; // Modify this based on validation logic
        },
        onFinishing: function (event, currentIndex) {
            // Final validation before form submission
            return true; // Modify this based on validation logic
        },
        onFinished: function (event, currentIndex) {
            // Submit form when last step is finished
            $("#driverForm").submit();
        }
    });
});


// $(function () {
//     $("#form-total").steps({
//         headerTag: "h2",
//         bodyTag: "section",
//         transitionEffect: "fade",
//         enableAllSteps: true,
//         stepsOrientation: "vertical",
//         autoFocus: true,
//         transitionEffectSpeed: 500,
//         titleTemplate: '<div class="title">#title#</div>',
//         labels: {
//             previous: 'Back Step',
//             next: 'Next',
//             finish: 'Submit',
//             current: ''
//         },
//         onStepChanging: function (event, currentIndex, newIndex) {
//             // Perform client-side validation
//             var form = $("#driverForm");
//             form.validate().settings.ignore = ":disabled,:hidden";
//             return form.valid();
//         },
//         onFinishing: function (event, currentIndex) {
//             // Final validation before submitting the form
//             var form = $("#driverForm");
//             form.validate().settings.ignore = ":disabled";
//             return form.valid();
//         },
//         onFinished: function (event, currentIndex) {
//             // Submit form when finished
//             $('#driverForm').submit();
//         }
//     });
// });



