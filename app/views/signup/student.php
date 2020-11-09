<main class="signup-student">
    <div class="row-header">
        <h3>Register As Student</h3>
    </div>
    <div class="row-main">
        <form action="" method="post" autocomplete="off">
            <div class="form-group">
                <input 
                    type="text" 
                    name="username" 
                    id="username" 
                    minlength="6" 
                    maxlength="12" 
                    pattern="^[a-zA-Z0-9]*$" 
                    class="form-control" 
                    placeholder="Username" 
                    autocomplete="off"
                    required
                >
                <small>Format: Combination of letters and numbers, Length: 6 - 12</small>
            </div>
            <div class="form-group">
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control"
                    placeholder="Email" 
                    autocomplete="off"
                    required
                >
            </div>
            <div class="form-group">
                <input 
                    type="tel" 
                    id="phone" 
                    name="phone"
                    minlength="10" 
                    maxlength="12" 
                    class="form-control" 
                    placeholder="Phone No" 
                    autocomplete="off"
                    required
                >
                <small>Length: 10 - 12 digit</small>
            </div>
            <div class="form-group">
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    minlength="8" 
                    maxlength="12" 
                    class="form-control" 
                    placeholder="Password" 
                    required
                >
                <small>Length: 8 - 12 characters</small>
            </div>
            <div class="form-group">
                <input 
                    type="password" 
                    name="password-confirm" 
                    id="password-confirm" 
                    minlength="8" 
                    maxlength="12" 
                    class="form-control" 
                    placeholder="Confirm Password" 
                    required
                >
            </div>
            <div class="form-group">
                <button type="submit" name="register" class="btn btn-outline-dark">Submit</button>
            </div>
        </form>
    </div>
</main>