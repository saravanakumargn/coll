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
        vm.phoneNo = 'fffffff';
        vm.querySearch = querySearch;
        vm.selectedItemChange = selectedItemChange;

        vm.branchesText = '';
        vm.collegeDetails = '';
//    vm.selectedItem = {"id":"83242298-6951-11e7-958e-b083fea7641b","bn":"civil engg. and planning","bc":"CP"}
//    vm.searchTextChange   = searchTextChange;
        function defaultAll() {
            vm.cource = {};
            vm.cource.branchModal = [];
//            vm.cource.branchModal = [
//                {
//                    "course": {
//                        "id": "83242298-6951-11e7-958e-b083fea7641b", "bn": "civil engg. and planning", "bc": "CP"
//                    },
//                    "bc": "CP",
//                    "st": 2012
//                },
//                {
//                    "course": {
//                        "id": "8346c874-6951-11e7-958e-b083fea7641b", "bn": "production engineering (sandwich) (ss)", "bc": "PS"
//                    },
//                    "bc": "PS",
//                    "st": 2010
//                }
//            ];
        }
        defaultAll();
        vm.addBranch = function () {
            vm.cource.branchModal.push({

            });
        };
        vm.deleteBranch = function (index) {
            vm.cource.branchModal.splice(index, 1);
        };
        vm.delAllBranch = function () {
            vm.cource.branchModal = [];
            vm.branchesText = '';
        };

        $scope.newData = function (allBranches) {
//            branchData = allBranches;
            vm.repos = loadAll(allBranches);
            branchData = allBranches;
//            console.log(allBranches)
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
//            console.log(index);
//            console.log('Item changed to ' + JSON.stringify(item));
            vm.cource.branchModal[index].course = item;
        }

        function querySearch(query) {
            var results = query ? vm.repos.filter(createFilterFor(query)) : vm.repos;
            return results;
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
                return (item.bc.toLowerCase().indexOf(lowercaseQuery) === 0);
            };
        }

        $scope.$watch('vm.branchesText', function (newValue, oldValue) {
//            console.log(newValue)
            // console.log(val);
            var columns = newValue.split(/\r?\n/);
            // console.log(columns);
            for (var i = 0; i < columns.length; i++) {
                if (columns[i]) {
                    var courseAray = columns[i].trim();
                    // console.log(name);
                    var items = courseAray.split(/\r?\t/);
                    // console.log(items)
//                    console.log('*********');
                    var branchObj = {};
                    var index = 0;
                    for (var j = 0; j < items.length; j++) {
                        var item = items[j].trim();
                        if (item.length > 0) {
//                            console.log(item + " " + index);
                            switch (index) {
                                case 0:
                                    var branchItem = branchData.filter(createFilterPaste(item));
                                    if (branchItem.length > 0) {
                                        branchObj["course"] = branchItem[0];
                                    }
//                                    branchObj["course"] = branchData.filter(createFilterPaste(item));
                                    branchObj["bc"] = item;
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
//                    console.log(branchObj);
                    vm.cource.branchModal.push(branchObj);
                }
            }
        });

        $scope.$watch('vm.collegeDetails', function (newValue, oldValue) {
            var columns = newValue.split(/\r?\n/);
   console.log(columns);
            //for(i=0; i < columns.length; i++){
            for (var i = 0; i < 4; i++) {
                if (columns[i]) {
                    var name = columns[i].trim();
     console.log(name);    
                    switch (i) {
                        case 0:
                            if (name !== '--' && name.length >= 5) {
                                vm.cource.phoneNo = name;
                                vm.phoneNo = name;
                            } else {
                                vm.cource.phoneNo = '';
                            }
                            break;
                        case 1:
                            if (name !== '--' && name.length >= 5) {
                                vm.cource.faxNo = name;
                            } else {
                                vm.cource.faxNo = '';
                            }
                            break;
                        case 2:
                            if (name !== '--' && name.length >= 5) {
                                vm.cource.emailId = name;
                            } else {
                                vm.cource.emailId = '';
                            }
                            break;
                        case 3:
                            if (name !== '--' && name.length >= 5) {
                                vm.cource.website = name;
                            } else {
                                vm.cource.website = '';
                            }
                            break;
                    }
                }
            }
        });
    }]);