// console.log('=======base js======')
;(function () {
    'use strict';
    angular.module('xiaohu',['ui.router'])
    //Change angular from {{}} to [: :], to avoid the conflict between
    // angular and Laravel
        .config([
            '$interpolateProvider',
            '$stateProvider',
            '$urlRouterProvider',
            function ($interpolateProvider,
                          $stateProvider,
                          $urlRouterProvider)
        {
            $interpolateProvider.startSymbol('[:');
            $interpolateProvider.endSymbol(':]');

            $urlRouterProvider.otherwise('/home');

            //Router of the nav bar.
            $stateProvider
                .state('home',{
                    url:'home',
                    templateUrl:'home.tpl'
                })
                .state('login',{
                    url:'login',
                    templateUrl:'login.tpl'
                })
                .state('signup',{
                    url:'signup',
                    templateUrl:'signup.tpl'
                 })
        }])

        .service('UserService',[
            '$http',
            function ($http) {
                var me=this;
                me.signup_data = {};
                me.signup=function () {
                    console.log('sign up service');
                }

                me.username_exists=function(){
                    $http.post('api/user/exists',
                        {username:me.signup_data.username})
                        .then(function (r) {
                            console.log('r',r)
                        },function (e) {
                            console.log('e',e);
                        })

                }
        }])

        .controller('UserSignupController',[
            '$scope',
            'UserService',
            function ($scope,UserService) {
                $scope.User=UserService;
                $scope.$watch(function () {
                    return UserService.signup_data;
                },function (n,o) {
                    if(n.username !=o.username )
                        UserService.username_exists();
                },true);

            }
        ])

})();
