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
            <form ng-submit="Question.go_add_question()" id="quick_ask" ng-controller="QuestionAddController">
                <div class="navbar-item">
                    <input ng-model="Question.new_question.title" type="text"/>
                </div>

                <div class="navbar-item">
                    <button type="submit">Submit Question</button>
                </div>

            </form>

        </div>
    </div>
    <div class="fr">
        <a ui-sref="home" class="navbar-item">Home</a>
        @if (is_log_in())
            <a ui-sref="login" class="navbar-item">User: {{session('username')}}</a>
            <a href="{{url('api/logout')}}" class="navbar-item">Log Out</a>
        @else
            <a ui-sref="login" class="navbar-item">Login</a>
            <a ui-sref="signup" class="navbar-item">Signup</a>
        @endif
    </div>
</div>

<div class="page">
    <div ui-view></div>
</div>

</body>

<script type="text/ng-template" id="home.tpl">
<div ng-controller="HomeController" class="home card container">
    <h1>Newest Update</h1>
    <div class="item-set">
        <div ng-repeat="item in Timeline.data" class="item">
            <div class="vote"></div>
            <div class="item-content">
                <h3 class="title">Title: [: item.title:]</h3>
                <div class="content-owner">Question Owner: [:item.user.username:]</div>
                <div class="content-main"></div>
                <div class="action-set">
                    <div class="comment">COMMENT</div>
                </div>

                <div class="comment-block">
                    <div class="hr"></div>
                    <div class="comment-item-set">
                        <div class="rect"></div>
                        <div class="comment-item clearfix">
                            <div class="user">CUser</div>
                            <div class="comment-content">
                                comment content
                            </div>
                        </div>
                    </div>

                </div>


        </div>
            <div class="hr"></div>
     </div>

    </div>
</div>
</script>

    <script type="text/ng-template" id="login.tpl">
        <div ng-controller="LoginController" class="'login container">
            <div class="card">
                <h1>Login</h1>
                <form name="login_form" ng-submit="User.login()">
                    <div class="input-group">
                        <label>User Name: </label>
                        <input name="username"
                               type="text"
                               ng-model="User.login_data.username"
                               required
                        >

                    </div>

                    <div class="input-group">
                        <label>Password: </label>
                        <input name="password"
                               type="password"
                               ng-model="User.login_data.password"
                               required>
                    </div>
                    <div ng-if="User.login_failed" class="input-error-set">
                        Username or password error.
                    </div>



                    <div class="=input-group">
                        <button type="submit"
                                ng-disabled="login_form.username.$error.required ||
                                login_form.password.$error.required">
                            Login</button>
                    </div>

                </form>
            </div>
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

    <script type="text/ng-template" id="question.add.tpl">
        <div ng-controller="QuestionAddController" class="question_add_container">
            <div class="card">
                <form name="question_add_form" ng-submit="Question.add()" >
                    <div class="input-group">
                        <label>Question Title: </label>
                        <input type="text"
                               name="title"
                               ng-model="Question.new_question.title"
                               required>
                    </div>

                    <div class="input-group">
                        <label>Description: </label>
                        <textarea type="text"
                                  ng-model="Question.new_question.desc"
                                  name="desc"
                                  required></textarea>
                    </div>

                    <div class="input-group">
                        <button type="submit" ng-disabled="question_add_form.$invalid">Submit</button>
                    </div>
                </form>
            </div>

        </div>

        Add a question.
    </script>

</html>