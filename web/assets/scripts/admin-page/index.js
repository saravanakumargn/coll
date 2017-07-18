'use strict';

var studyApp = angular.module('studyApp', ['ngMaterial']);

studyApp.config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

studyApp.controller('CourceController', ['$scope', function ($scope) {
        var vm = this;
        var branchData = [];
        vm.repos = [];
        vm.querySearch = querySearch;
        vm.selectedItemChange = selectedItemChange;
//    vm.selectedItem = {"id":"83242298-6951-11e7-958e-b083fea7641b","bn":"civil engg. and planning","bc":"CP"}
//    vm.searchTextChange   = searchTextChange;
        function defaultAll() {
            vm.cource = {};
            vm.cource.branchModal = [];
            vm.cource.branchModal = [
                {
                    "course": {
                        "id": "831b581c-6951-11e7-958e-b083fea7641b",
                        "bn": "agricultural and irrigation engineering (ss)",
                        "bc": "AI"
                    },
                    "st": 2002
                },
                {
                    "course": {
                        "id": "83242298-6951-11e7-958e-b083fea7641b", "bn": "civil engg. and planning", "bc": "CP"
                    },
                    "st": 2012
                },
                {
                    "course": {
                        "id": "8346c874-6951-11e7-958e-b083fea7641b", "bn": "production engineering (sandwich) (ss)", "bc": "PS"
                    },
                    "st": 2010
                }
            ];
            vm.cource.branchModal1 = [
                {
                    "course": {
                        "id": "831b581c-6951-11e7-958e-b083fea7641b",
                        "bn": "agricultural and irrigation engineering (ss)",
                        "bc": "AI"
                    },
                    "st": 2002
                },
                {
                    "course": {
                        "id": "83242298-6951-11e7-958e-b083fea7641b", "bn": "civil engg. and planning", "bc": "CP"
                    },
                    "st": 2012
                },
                {
                    "course": {
                        "id": "8346c874-6951-11e7-958e-b083fea7641b", "bn": "production engineering (sandwich) (ss)", "bc": "PS"
                    },
                    "st": 2010
                }
            ];
        }
        defaultAll();

        vm.addBranch = function () {
            console.log('addBranch')
            vm.cource.branchModal.push({

            });
        };
        $scope.newData = function (allBranches) {
//            branchData = allBranches;
            vm.repos = loadAll(allBranches);

            console.log(allBranches)
            var branchcount = allBranches.length;
            for (var i = 0; i < branchcount; i++) {
                //var label = allBranches[i].bn+" "+allBranches[i].bc;
//                var label = allBranches[i].bc;
//                $('#branchesList').append("<option value='" + allBranches[i].id + "'>" + label + "</option>");
            }
        };

        function loadAll(allBranches) {

            return allBranches.map(function (repo) {
                repo.bn = repo.bn.toLowerCase();
                return repo;
            });
        }
        function selectedItemChange(item, index) {
            console.log(index);
            console.log('Item changed to ' + JSON.stringify(item));
            vm.cource.branchModal[index].course = item;
        }
        
//                vm.cource.branchModal.push({
//                    "course": {
//                        "id": "831b581c-6951-11e7-958e-b083fea7641b",
//                        "bn": "agricultural and irrigation engineering (ss)",
//                        "bc": "AI"
//                    },
//                    "st": 2002
//                });
//                vm.cource.branchModal.push(
//                   {
//                    "course": {
//                        "id": "83242298-6951-11e7-958e-b083fea7641b", "bn": "civil engg. and planning", "bc": "CP"
//                    },
//                    "st": 2012
//                });
        
        function querySearch(query) {
            var results = query ? vm.repos.filter(createFilterFor(query)) : vm.repos;
            return results;
//            return vm.repos.filter(createFilterFor(query));
//            var results = query ? vm.repos.filter(createFilterFor(query)) : vm.repos,
//                    deferred;
//            return results;
//            if (vm.simulateQuery) {
//                deferred = $q.defer();
//                $timeout(function () {
//                    deferred.resolve(results);
//                }, Math.random() * 1000, false);
//                return deferred.promise;
//            } else {
//                return results;
//            }
        }
        function createFilterFor(query) {
            var lowercaseQuery = angular.lowercase(query);

            return function filterFn(item) {
//console.log(item)
                return (item.bn.indexOf(lowercaseQuery) === 0);
            };

        }
    }]);