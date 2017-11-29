console.log('=======base js======')
;(function () {
    'use strict';
    angular.module('xiaohu',['ui.router'])
    //Change angular from {{}} to [: :], to avoid the conflict between
        // angular and Laravel
        .config(function ($interpolateProvider,
                          $stateProvider,
                          $urlRouterProvider)
        {
            $interpolateProvider.startSymbol('[:');
            $interpolateProvider.endSymbol(':]');

            $urlRouterProvider.otherwise('/home');

            $stateProvider
                .state('home',{
                    url:'/home',
                    template:'home.tpl'
                })
                .state('login',{
                    url:'/login',
                    template:'login.tpl'
                })
        })

})();
