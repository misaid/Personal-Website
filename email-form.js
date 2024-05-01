document.getElementById("email-form").addEventListener("submit", function(event) {
    event.preventDefault(); 

    var name = document.getElementById("name").value;
    var message = document.getElementById("message").value.replace(/\n/g, "%0A");
    var subject = "Inquiry from " + name;

    var body = "" + message; // Prefix "Message:" and include the message
    var emailLink = "mailto:misaid@ualberta.ca?subject=" + encodeURIComponent(subject) + "&body=" + encodeURIComponent(body);
    
    window.location.href = emailLink; // Open email client with mailto link
});
