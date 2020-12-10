<main class="login-main">
    <?php Flasher::flash();  ?>
    <div class="row-header">
        <h3>Login As Teacher</h3>
    </div>
    <div class="row-main">
        <form action="<?= BASEURL; ?>/login/loginteacher" method="post" autocomplete="off">
            <div class="form-group">
                <input 
                    type="text" 
                    name="username" 
                    id="username" 
                    minlength="6" 
                    maxlength="12" 
                    pattern="^(?=.*\d)(?=.*[a-zA-Z]).{6,12}$" 
                    class="form-control" 
                    placeholder="Username" 
                    autocomplete="off"
                    required
                >
            </div>
            <div class="form-group">
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    minlength="8" 
                    maxlength="12" 
                    pattern="^[\w@-]{8,12}$"
                    class="form-control" 
                    placeholder="Password" 
                    required
                >
            </div>
            <div class="form-group">
                <button type="submit" name="login" class="btn btn-outline-dark">Login</button>
            </div>
        </form>
    </div>
</main>