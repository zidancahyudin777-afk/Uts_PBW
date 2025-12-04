// MeyDa Collection Script
console.log("MeyDa Collection loaded");

// Example simple validation or interaction
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            // Simple validation check (e.g., check for empty required fields if HTML5 validation fails or is not supported)
            // For now, we just log the submission
            console.log("Form submitted");
            // alert("Data sedang diproses...");
        });
    });
});
