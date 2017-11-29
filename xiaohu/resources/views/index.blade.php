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
<div class="navbar">
    <a href="" ui-sref="home"> Home Page</a>
    <a href="" ui-sref="login">Log In</a>
</div>
<div>
    <div ui-view></div>
</div>

</body>

<script type="text/ng-template" id="home.tpl">
    <div>
        <h1>Home page tpl</h1>
        home page
    </div>
</script>

<script type="text/ng-template" id="login.tpl">
    <div>
        <h1>Log In tpl</h1>
        log in page
    </div>
</script>
</html>