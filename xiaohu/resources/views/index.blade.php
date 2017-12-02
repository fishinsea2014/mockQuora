<!doctype html>
<html lang="en" ng-app="xiaohu">
    <head>
        <meta charset="UTF-8">
        <title>MockQuora</title>
        <link rel="'stylesheet" href="/node_modules_lib/normalize.css">
        <link rel="stylesheet" href="/css/base.css">
        <!--The following order of scripts is necessary-->
        <script src="/node_modules_lib/jquery.js"></script>
        <script src="/node_modules_lib/angular.js"></script>
        <script src="/node_modules_lib/angular-ui-router.js"></script>
        <script src="js/base.js"></script>
    </head>
<body>
<div class="navbar clearfix">
    <div class="fl">
        <div class="navbar-item brand">Quora</div>
        <div class="navbar-item">
            <input type="text"/>
        </div>
    </div>
    <div class="fr">
        <div ui-sref="home" class="navbar-item">Home</div>
        <div ui-sref="login" class="navbar-item">Login</div>
        <div ui-sref="signup" class="navbar-item">Signup</div>
    </div>
</div>

<div class="page">
    <div ui-view></div>
</div>

</body>

<script type="text/ng-template" id="home.tpl">
<div class="'home container">
    this is quora home page.
    this is quora home page.
    this is quora home page.
</div>
</script>

    <script type="text/ng-template" id="login.tpl">
        <div class="'home container">
            this is login page.
        </div>
    </script>

    <script type="text/ng-template" id="signup.tpl">
        <div ng-controller="UserSignupController" class="signup container">
            <div class="card">
                <h1>Sign Up</h1>
                [:User.signup_data:], [:User.signup_username_exists:]
                <form name="signup_form" ng-submit="User.signup()">
                    <div class="input-group">
                        <label>User Name:</label>
                        <input name="username"
                               type="text"
                               ng-minlength="4"
                               ng-maxlength="16"
                               ng-model="User.signup_data.username"
                               ng-model-options="{debounce:500}"
                               required
                        >
                        <div class="input-error-set">
                            <div ng-if="signup_form.username.$error.required && signup_form.username.$touched">
                                The user name is mondatory.
                            </div>

                            <div ng-if="User.signup_username_exists">
                                The user name already exist.
                            </div>

                        </div>
                    </div>

                    <div class="input-group">
                        <label>Password:</label>
                        <input name="password"
                               type="password"
                               ng-minlength="4"
                               ng-maxlength="16"
                               ng-model="User.signup_data.password"
                               required
                        >
                        <div class="input-error-set">
                            <div ng-if="signup_form.password.$error.required && signup_form.username.$touched">
                                The  is mondatory.
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                            ng-disabled="signup_form.$invalid">SignUp</button>
                </form>
            </div>
            this is sign up page.
        </div>
    </script>


</html>