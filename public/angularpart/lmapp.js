var lmapp = angular.module("LmApp", ["ngRoute"]);

lmapp.config(function($routeProvider){
    $routeProvider
    .when("/", {
        templateUrl : "angularpart/views/dashboard.html"
        , controller : "DashboardController"
    })
    .when("/category/:category_id", {
        templateUrl : "angularpart/views/category.html"
        , controller : "CategoryController"
    })
    .when("/item/:item_id", {
        templateUrl : "angularpart/views/item.html"
        , controller : "ItemController"
    })
    .otherwise({redirectTo:'/'});
});

lmapp.controller("DashboardController", function($scope, $http){
    $scope.modal = [];
    $scope.name = "Manash";
    $scope.modalClick = function(item_id, status_id, type_id){
        $scope.modal.item_parent_id = item_id;
        $scope.modal.status_id = status_id;
        $scope.modal.type_id = type_id;
    }

    $scope.modalFormSubmit = function(){
        // $scope.modal.item_parent_id = item_id;
        // $scope.modal.status_id = status_id;
        
        var req = {
            method: 'POST',
            url: '/item/add',
            headers: {
              'Content-Type': undefined
            },
            data: { item_parent_id: $scope.modal.item_parent_id, status_id: $scope.modal.status_id, item_title: $scope.modal.item_title, type_id: $scope.modal.type_id }
        }
           
        $http(req)
        .then(function successCallback(response){
            angular.forEach($scope.dashboard, function(value, key){
                if(value.status_id == $scope.modal.status_id){
                    value.milestones.push(response.data);
                    $scope.modal = [];
                }
            });
        }
        , function errorCallback(response){});
    }

    $http({
        method: 'GET',
        url: '/dashboard'
    }).then(function successCallback(response) {
        $scope.dashboard = response.data;
        console.log($scope.dashboard);
    }, function errorCallback(response) {

    });
});

lmapp.controller("CategoryController", function($scope, $routeParams){
    $scope.id = $routeParams.category_id;
});

lmapp.controller("ItemController", function($scope, $routeParams){
    $scope.id = $routeParams.item_id;
});