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

        vm.branchesText = '';
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
                    "bc": "AI",
                    "st": 2002
                },
                {
                    "course": {
                        "id": "83242298-6951-11e7-958e-b083fea7641b", "bn": "civil engg. and planning", "bc": "CP"
                    },
                    "bc": "CP",
                    "st": 2012
                },
                {
                    "course": {
                        "id": "8346c874-6951-11e7-958e-b083fea7641b", "bn": "production engineering (sandwich) (ss)", "bc": "PS"
                    },
                    "bc": "PS",
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
//                repo.bn = repo.bn.toLowerCase();
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
//                console.log(item.bn+" "+item.bc)
                return (item.bn.toLowerCase().indexOf(lowercaseQuery) === 0);
            };
        }
        function createFilterPaste(query) {
            var lowercaseQuery = angular.lowercase(query);
            return function filterFn(item) {
                return (item.bc.indexOf(lowercaseQuery) === 0);
            };
        }

        $scope.$watch('vm.branchesText', function (newValue, oldValue) {
            console.log(newValue)
            // console.log(val);
            var columns = newValue.split(/\r?\n/);
            // console.log(columns);
            for (var i = 0; i < columns.length; i++) {
                if (columns[i]) {
                    var courseAray = columns[i].trim();
                    // console.log(name);
                    var items = courseAray.split(/\r?\t/);
                    // console.log(items)
                    console.log('*********');
                    var branchObj = {};
                    var index = 0;
                    for (var j = 0; j < items.length; j++) {
                        var item = items[j].trim();
                        if (item.length > 0) {
                            
                            console.log(item +" "+index);
                            switch (index) {
                                case 0:
//                                    branchObj = {                                        
//                                        "course": vm.repos.filter(createFilterFor(item))
//                                    };
                                    branchObj["course"] = createFilterPaste(item);
                                    break;
                                case 1:
                                    branchObj["approved"] = item;
                                    break;
                                case 2:
                                    branchObj["st"] = item;
                                    break;
                                case 3:
                                    break;
                                case 4:
                                    break;
                            }
index++;
                        }
                    }
                    console.log(branchObj);
                }
            }
        });
    }]);