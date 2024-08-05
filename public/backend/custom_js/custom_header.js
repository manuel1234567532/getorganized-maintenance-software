function markNotificationAsRead(notificationId) {
    $.ajax({
        url: '/mark-notification-as-read/' + notificationId,
        type: 'GET',
        success: function(response) {
            // Entfernen Sie das Benachrichtigungselement aus dem DOM
            $("#notification-" + notificationId).remove();


        },
        error: function(error) {
            console.log(error);
            // Hier können Sie auch eine Fehlermeldung anzeigen, falls erforderlich
        }
    });
}
        document.addEventListener('DOMContentLoaded', function () {
       var userTypeElement = document.getElementById('userType');
       if (userTypeElement) {
           var userRoleColor = '{{ $userRoleColor }}';

           if (userRoleColor) {
               userTypeElement.style.backgroundColor = userRoleColor;
           }
       }
   });
