<script>
    const forgotPasswordLink = document.getElementById('forgot-password-link');
    const forgotPasswordSection = document.getElementById('forgot-password');
    const backToLoginLink = document.getElementById('back-to-login');

    forgotPasswordLink.addEventListener('click', function(event) {
      event.preventDefault(); 
      forgotPasswordSection.style.display = 'block'; 
    });

    backToLoginLink.addEventListener('click', function(event) {
      event.preventDefault(); 
      forgotPasswordSection.style.display = 'none'; 
    });
  </script>