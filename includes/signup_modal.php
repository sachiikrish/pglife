<div class="modal fade" id="exampleModal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Signup with PGLife</h5>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             
             <form id="signup_form" method="post" action="api/signup.php">
              <div class="input-group flex-nowrap">
                <span class="input-group-text" id="addon-wrapping"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" name="name" placeholder="Full Name" aria-label="Username" aria-describedby="addon-wrapping">
              </div>
              <div class="input-group flex-nowrap">
                <span class="input-group-text" id="addon-wrapping"><i class="fas fa-phone-alt"></i></span>
                <input type="text" class="form-control" name="phone_number" placeholder="Phone Number" aria-label="Username" aria-describedby="addon-wrapping">
              </div>
              <div class="input-group flex-nowrap">
                <span class="input-group-text" id="addon-wrapping"><i class="fas fa-envelope"></i></span>
                <input type="text" class="form-control" name="email" placeholder="Email" aria-label="Username" aria-describedby="addon-wrapping">
              </div>
              <div class="input-group flex-nowrap">
                <span class="input-group-text" id="addon-wrapping"><i class="fas fa-lock"></i></span>
                <input type="password" class="form-control" name="password" placeholder="Password" aria-label="Username" aria-describedby="addon-wrapping">
              </div>
              <div class="input-group flex-nowrap">
                <span class="input-group-text" id="addon-wrapping"><i class="fas fa-university"></i></span>
                <input type="text" class="form-control" name="college" placeholder="College" aria-label="Username" aria-describedby="addon-wrapping">
              </div>
    
              <div>I'm a 
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="Male">
                    <label class="form-check-label" for="inlineRadio1">Male</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="Female">
                    <label class="form-check-label" for="inlineRadio2">Female</label>
                  </div>
             </form>        
             <button type="submit" class="btn btn-primary">Create Account</button>
                  </div>
                 
    
    
    
            </div>
            <div class="modal-footer">
              Already have an account?<a href="" data-dismiss="modal" data-toggle="modal" data-target="#login-modal">Login</a>
            </div>
          </div>
        </div>
      </div>
    