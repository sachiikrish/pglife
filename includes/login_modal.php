<div class="modal fade modal-md" id="login-modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Login with PGLife</h5>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="login_form" action="api/login.php" method="post">
                  <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" name="email" placeholder="Email" aria-label="Username" aria-describedby="addon-wrapping">
                  </div>
                  <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" name="password" placeholder="Password" aria-label="Username" aria-describedby="addon-wrapping">
                  </div>
                   <button type="submit" class="btn btn-primary">Login</button>
                </form>
                 </div>
    
            <div class="modal-footer">
             <a href="" data-dismiss="modal" data-toggle="modal" data-target="#exampleModal">Click here</a>to register a new account.
            </div>
          </div>
        </div>
      </div>