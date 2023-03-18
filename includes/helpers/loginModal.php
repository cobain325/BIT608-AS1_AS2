
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
        <p>Login in:</p>
        <form role="form" id="login">

          <div class="form-group">
            <label for="email">Email Address</label>
            <input class="form-control" type="email" id="email" autocomplete="email" required />
            <div class="invalid-feedback">
              Please enter a valid email address.
            </div>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" type="password" id="password" autocomplete="current-password" required />
            <div class="invalid-feedback">
              Please enter a password.
            </div>
          </div>
          <button type="submit" class="btn btn-primary mt-3" data-bs-dismiss="modal">Login</button>
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
  form.addEventListener('submit', event => {
    event.preventDefault();
    if (!form.checkValidity()) {
      event.stopPropagation()
    } else {
      (async () => {
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
          console.log(content)
          location.href = location
        } else if(content.message == "fail") {
          loginModal.show();
          document.getElementById('loginFailure').classList.remove('d-none')
        }
      })()
    }
  })
</script>