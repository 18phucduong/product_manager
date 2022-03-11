
<div class="wrapper login-page">
    <div class="container">
        <div class="row">
            <div class="col col-12">
                <div class="login-form">
                    <div class="login-form__inner">
                        <div class="row row-collapse ">
                            <div class="col col-6 sm-12 hide-on-small">
                                <div class="left-form dark text-center">
                                    <div class="left-form__img">
                                        <img src="https://picsum.photos/id/237/500/270" alt="">
                                    </div>
                                    <div class="left-form__text mx-auto">
                                        <h2 class="mb-half">Change your quantity life</h2>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam laeriores</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-6 sm-12">
                                <div class="right-form  mx-auto ">
                                    <div class="right-form__head text-center mb-2">
                                        <h1 class="mb-1">Hello Again!</h1>
                                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration i</p>
                                    </div>
                                    <div class="right-form__main mb-2">
                                        <form action="/product_manager/public/login" method="post" name="login-form" id="login-form">
                                            <div class="input-group round float-label">
                                                <input type="text" name="user_name" id="user_name" value="<?php if(isset($_COOKIE["user_name"])) { echo $_COOKIE["user_name"]; } ?>" required >
                                                <label for="user_name">Username</label>
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                            </div>
                                            <div class="input-group round float-label">
                                                <input type="password" name="password" id="password" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>" required >
                                                <label for="password">Password</label>
                                                <i class="fa fa-lock" aria-hidden="true"></i>
                                            </div>
                                            <div class="row row-collapse mb-2">
                                                <div class="col col-6">
                                                    <div class="checkbox-group">
                                                        <input type="checkbox" name="remember_pass" id="remember_pass" checked>
                                                        <label for="remember_pass" class="is-small color-gray">Remember password</label>
                                                    </div>
                                                </div>
                                                <div class="col col-6 text-right">
                                                    <a href="#" class="link is-small">Recovary password</a>
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <input type="submit" class="button expand round" name="login" value="LOGIN">
                                            </div>
                                            <div class="input-group">
                                                <button  class="button expand round outline gray">
                                                    <img src="assets/images/google-icon.png" alt="">
                                                    Sign in with google
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="right-form__bottom text-center">
                                        <p>Do u have an account yet? <a href="#" class="link">Sign Up</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
