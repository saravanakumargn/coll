'use strict';

var studyApp = angular.module('studyApp', []);

studyApp.config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

studyApp.controller('CourceController', ['$scope', function ($scope) {
        var vm = this;
        vm.title = 'Customers';
        function defaultAll() {
            vm.cource = {};
            vm.cource.branchModal = [];
        }
        defaultAll();

        vm.addBranch = function () {
            console.log('addBranch')
            vm.cource.branchModal.push({

            });
        };
        $scope.newData = function (allBranches) {
            console.log(allBranches)
            var branchcount = allBranches.length;
            for (var i = 0; i < branchcount; i++) {
                //var label = allBranches[i].bn+" "+allBranches[i].bc;
                var label = allBranches[i].bc;
                $('#branchesList').append("<option value='" + allBranches[i].id + "'>" + label + "</option>");
            }
        };
    }]);