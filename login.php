<?php
require_once 'core/init.php';
if(Input::exists()){
    if(Token::check(Input::get('token'))){
        $validate= new Validate();
        $validation = $validate->check($_POST, array(
            'email'=>array('required'=>true),
            'password'=>array('required'=> true),
        ));

        if($validation->passed()){
            /*
            add function here to test if user is active or not active.
            //status will return true if user is active and registered
            if(user->status){ //check if user active or not active
                if user active login
            }else{
                tell user to check email for verification link
            }
            */

            $user = new User();
            //process login
            $remember = (Input::get('remember')==='on') ? true : false;
            $login = $user->login(Input::get('email'), Input::get('password'), $remember);

            if($login){
                Redirect::to('create.php');
            }else{
                echo '<p>Sorry, login failed.</p>';
            }
        }else{
            foreach($validation->errors() as $error){
                echo $error, '<br>';
            }
        }
    }
}
include('header.php');
?>
<div class="container-fluid" id="signIn">
    <div class="container" >

        <form method="post" class="form-signin" action="">
            <h2 class="form-signin-heading">Please sign in</h2>
            <p class="registerAccnt"> Don't have an account? Register <a class="registerLink" href="register.php">here</a></p>
            <label for="inputEmail" class="sr-only">Email</label>
            <input type="text" name="email" id="email" class="form-control" placeholder="Email" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
                        <div class="checkbox">
                            <label for="remember">
                                <input type="checkbox" name="remember" id="remember"> Remember me
                            </label>
                        </div>
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
            <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
        </form>
    </div>
</div>

<?php
include('footer.php');
?>