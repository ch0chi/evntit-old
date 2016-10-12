<?php
$relPath = realPath($_SERVER['DOCUMENT_ROOT']);
require_once ("$relPath/core/init.php");

//decode


if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $checkToken = Token::check(Input::get('token'));

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'email' => array(
                'required' => true,
                'min' => 7,
                'max' => 255,
                'unique' => 'users'
            ),
            'username'=> array(
                'required'=>true,
                'min' => 3,
                'max' => 255,
                'unique'=>'users'
            ),
            'password' => array(
                'required' => true,
                'min' => 8
            ),
            'passwordAgain' => array(
                'required' => true,
                'matches' => 'password'
            )
        ));

        if ($validation->passed()) {
            $users=new User();
            $clients = new User();
            $trackDB = 0; //will be used for relational databases
            $salt=Hash::salt(32);

            try{
                //if trackDB = 0 then add clientPrivate fields
                if($trackDB===0){
                    $users->create('users',array(
                        'email'=> Input::get('email'),
                        'username'=>Input::get('username'),
                        'password'=> Hash::make(Input::get('password'),$salt),
                        'salt'=> $salt,
                        'registerDate'=> date('Y-m-d')
                    ));
                }
            }catch(Exception $e){
                die($e->getMessage());
            }


            $login = $users->login(Input::get('email'), Input::get('password'), false);
            Redirect::to('create.php');
            Session::flash('success','You have been registered! Please Log in!');
            //upon refresh redirect to index.php


        } else {
            foreach($validation->errors() as $error){
                echo $error,'<br>';
            }

        }
    }
}
include('header.php');
?>


<div class="container-fluid reg">

    <h2 class="form-signin-heading registerHead">Create Account </h2>
    <form method="post" class="form-signin" action="">

        <label for="firstName" class="sr-only">First Name</label>
        <input type="text" name="firstName" id="firstName" value="<?php echo Input::get('firstName') ?>" class="form-control" placeholder="First Name">

        <label for="lastName" class="sr-only">Last Name</label>
        <input type="text" name="lastName" id="lastName" value="<?php echo Input::get('lastName') ?>" class="form-control" placeholder="Last Name">

        <label for="username" class="sr-only">Username</label>
        <input type="text" name="username" id="username" value="<?php echo Input::get('username') ?>" class="form-control" placeholder="Username">

        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" id="password" value="" class="form-control" placeholder="Password">

        <label for="passwordAgain" class="sr-only">Enter your password again</label>
        <input type="password" name="passwordAgain" id="passwordAgain" class="form-control" placeholder="Re-enter Password">

        <label for="email" class="sr-only">Email</label>
        <input type="email" name="email" id="email" value="<?php echo Input::get('email') ?>" class="form-control" placeholder="Email">


        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
    </form>
</div>
<?php
include('footer.php');
?>
