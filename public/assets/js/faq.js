
[...document.getElementsByClassName("accordion-toggle")].forEach(function(element) {
    element.addEventListener('click', function (event) {

      // Get the target content
      var content = event.currentTarget.nextElementSibling;
      if (!content) return;

      // Prevent default link behavior
      event.preventDefault();

      // If the content is already expanded, collapse it and quit
      if (content.classList.contains('active')) {
          content.classList.remove('active');
          return;
      }

      // Get all open accordion content, loop through it, and close it
      var accordions = document.querySelectorAll('.accordion-content.active');
      for (var i = 0; i < accordions.length; i++) {
        accordions[i].classList.remove('active');
      }

      // Toggle our content
      content.classList.toggle('active');
    })
});
