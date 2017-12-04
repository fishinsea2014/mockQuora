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

                .state('question',{
                    abstract:true,
                    url:'/question',
                    template:'<div ui-view></div>'
                })

                .state('question.add',{
                    url:'/add',
                    templateUrl:'question.add.tpl'
                })
        }])

        .service('UserService',[
            '$state',
            '$http',
            function ($state,$http) {
                var me=this;
                me.signup_data = {};
                me.login_data={};
                me.signup=function () {
                    console.log('sign up service');
                    $http.post('/api/signUp',me.signup_data)
                    .then(function (r) {
                        console.log('r',r);
                        if(r.data.status){
                            me.signup_data={};
                            $state.go('login');
                        }
                    },function (e) {
                        console.log('e',e);
                    })
                }
                
                me.login=function () {
                    $http.post('api/login',me.login_data)
                        .then(function (r) {
                            if (r.data.status){
                                location.href='/';
                            }
                            else{
                                me.login_failed=true;
                            }
                            console.log('login service');
                        },function (e) {
                            console.log('e',e)
                        })

                }

                me.username_exists=function(){
                    $http.post('api/user/exist',
                        {username: me.signup_data.username})
                        .then(function (result1) {
                            console.log("result : ", result1.data.count);
                            // console.log('res',result1.data.status);
                            // console.log('res',result1.data.data.count);
                            // if(result1.data.status && result1.data.data.count)
                            if (result1.data.count)
                                me.signup_username_exists=true;
                            else
                                me.signup_username_exists=false;
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
                },function (newdata,olddata) {
                    if(newdata.username !==olddata.username )
                        UserService.username_exists();
                },true);

            }
        ])

        .controller('LoginController',[
            '$scope',
            'UserService',
            function ($scope,UserService) {
            $scope.User=UserService
        }])

        .service('QuestionService',[
            '$http',
            '$state',
            function ($http,$state) {
                var me=this;
                me.new_question={};
                me.go_add_question=function () {
                    $state.go('question.add')
                }

                me.add=function () {
                    if(!me.new_question.title) {
                        console.log('no question title');
                        return;
                    }
                    console.log('add a new question');
                    $http.post('/api/question/add',me.new_question)
                        .then(function (r) {
                            console.log('r',r);
                            if (r.data.status){
                                me.new_question={};
                                $state.go('home');
                            }
                        },function (e) {

                        })
                }
            }
        ])
        .controller('QuestionAddController',[
            '$scope',
            'QuestionService',
            function ($scope,QuestionService) {
                $scope.Question=QuestionService;
            }

        ])

})();
