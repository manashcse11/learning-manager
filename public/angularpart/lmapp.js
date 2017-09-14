var lmapp = angular.module("LmApp", ["ngRoute", "dndLists"]);

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
    .when("/dragdrop", {
        templateUrl : "angularpart/views/simple/simple-frame.html"
        , controller : "SimpleDemoController"
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
                    value.milestones.unshift(response.data);
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
    }, function errorCallback(response) {

    });

    $scope.initial = 0;
    $scope.count = 0;
    $scope.$watch('dashboard', function() { // Watch drag drop
        $scope.count++;
        if($scope.count > 1){

            var req = {
                method: 'POST',
                url: '/item/sort',
                headers: {
                  'Content-Type': undefined
                },
                data: $scope.dashboard
            }
               
            $http(req)
            .then(function successCallback(response){
                console.log(response);
            }
            , function errorCallback(response){});

            $scope.count = 0;
        }
        
    }, true);
});

lmapp.controller("CategoryController", function($scope, $http, $routeParams){
    $scope.id = $routeParams.category_id;
});

lmapp.controller("ItemController", function($scope, $http, $routeParams, $location){
    $scope.item_id = $routeParams.item_id;
    $http({
        method: 'GET',
        url: '/item/' + $scope.item_id
    }).then(function successCallback(response) {
        $scope.statuses = response.data.statuses;
        $scope.item = response.data.item;
        $scope.breadcrumb = response.data.breadcrumb;
    }, function errorCallback(response) {

    });

    $scope.itemFormSave = function(){
        
        var req = {
            method: 'POST',
            url: '/item/'+$scope.item.item_id+'/update',
            headers: {
              'Content-Type': undefined
            },
            data: $scope.item
        }
           
        $http(req)
        .then(function successCallback(response){
            $location.path('/');
        }
        , function errorCallback(response){});
    }
});

lmapp.controller("SimpleDemoController", function($scope) {
    $scope.models = {
        selected: null,
        lists: {"A": [], "B": []}
    };

    // Generate initial model
    for (var i = 1; i <= 3; ++i) {
        $scope.models.lists.A.push({label: "Item A" + i});
        $scope.models.lists.B.push({label: "Item B" + i});
    }

    // Model to JSON for demo purpose
    $scope.$watch('models', function(model) {
        $scope.modelAsJson = angular.toJson(model, true);
    }, true);

});