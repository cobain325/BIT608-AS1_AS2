
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="loginModalLabel">Login</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="text-align: center;">
        <div id="loginFailure" class="alert alert-danger d-none" role="alert">
            Invalid login details. Please try again.
        </div>
        <p>Login information:</p>
        <form role="form" id="login">

          <div class="form-group">
            <label for="email">Email Address</label>
            <input class="form-control" type="email" id="email" autocomplete="email" placeholder="Email Address" required />
            <div class="invalid-feedback">
              Please enter a valid email address.
            </div>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" type="password" id="password" autocomplete="current-password" placeholder="Password" required />
            <div class="invalid-feedback">
              Please enter a password.
            </div>
          </div>
          <button id="loginButton" type="submit" class="btn btn-primary mt-3">
          <span id="loginSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            Login
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  const form = document.getElementById('login')
  const email = document.getElementById('email')
  const password = document.getElementById('password')
  const loginModal = new bootstrap.Modal('#loginModal')
  const loginFailure = document.getElementById('loginFailure')
  const loginSpinner = document.getElementById('loginSpinner')
  const loginButton = document.getElementById('loginButton')

  form.addEventListener('submit', event => {
    event.preventDefault();
    if (!form.checkValidity()) {
      event.stopPropagation()
    } else {
      (async () => {
        loginSpinner.classList.remove('d-none')
        loginFailure.classList.add('d-none')
        loginButton.disabled = true
        const response = await fetch('/login', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ email: email.value, password: password.value })
        });
        const content = await response.json();
        if (content.message == "success") {
          loginModal.hide();
          loginButton.disabled = false
          loginSpinner.classList.add('d-none')
          location.href = location
        } else if(content.message == "error") {
          loginButton.disabled = false
          loginSpinner.classList.add('d-none')  
          loginModal.show();
          loginFailure.classList.remove('d-none')
        }
      })()
    }
  })
</script>