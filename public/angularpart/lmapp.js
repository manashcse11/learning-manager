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
    .when("/subcategory", {
        templateUrl : "angularpart/views/manage_subcatgeory.html"
        , controller : "SubcategoryController"
    })
    .otherwise({redirectTo:'/'});
});

lmapp.controller("DashboardController", function($scope, $http){
    $scope.modal = [];
    $scope.modalClick = function(status_id, type_id){
        $scope.modal.status_id = status_id;
        $scope.modal.type_id = type_id;
        $scope.modal.item_parent_id = $scope.items[0].item_id; // Set first element of item as default
        $scope.hasParent = false; // Set false, need to show Item dropdown
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
        $scope.dashboard = response.data.dashboard;
        $scope.items = response.data.items;
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
        $scope.breadcrumb = response.data.breadcrumb;
        $scope.item = response.data.item;       
        console.log($scope.item); 
        $scope.status_count = response.data.status_count;      
        $scope.statuses = response.data.statuses;
        $scope.colors = response.data.colors;
        // Progress
        if($scope.item.type_id == 4){
            $http({
                method: 'GET',
                url: '/progress/' + $scope.item_id
            }).then(function successCallback(response) {
                $scope.progress = response.data.progress;
            }, function errorCallback(response) {
        
            });
        }
        
    }, function errorCallback(response) {

    });

    $scope.itemFormSave = function(){
        delete $scope.item['child']; // delete extra keys not exist in table
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


    $scope.modal = [];
    $scope.modalClick = function(status_id, type_id){
        $scope.modal.status_id = status_id;
        $scope.modal.type_id = type_id;
        $scope.modal.item_parent_id = $scope.item.item_id; // Set first element of item as default
        $scope.hasParent = true; // Set true, do not show Item dropdown
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
            $scope.item.child.unshift(response.data);
            if($scope.modal.type_id == 5){ // Milestone
                if($scope.status_count.length > 0){
                    angular.forEach($scope.status_count, function(value, key){
                        if(value.status_id == response.data.status_id){
                            value.total++;
                        }
                    });
                }
                else{
                    $scope.status_count = [{'status_id' : response.data.status_id, 'total' : 1}];
                }
            }            
            $scope.modal = [];
        }
        , function errorCallback(response){});
    }
});

lmapp.controller("SubcategoryController", function($scope, $http, $routeParams){
    $scope.item = [];
    $http({
        method: 'GET',
        url: '/categories'
    }).then(function successCallback(response) {
        $scope.categories = response.data.categories;
        $scope.item.category_id = $scope.categories[0].category_id;
    }, function errorCallback(response) {

    });
    $http({
        method: 'GET',
        url: '/subcategories'
    }).then(function successCallback(response) {
        $scope.subcategories = response.data.subcategories;
    }, function errorCallback(response) {

    });

    $scope.addSubCategory = function(){
        var req = {
            method: 'POST',
            url: '/subcategories/add',
            headers: {
              'Content-Type': undefined
            },
            data: { item_title: $scope.item.item_title, item_description: $scope.item.item_description, category_id: $scope.item.category_id }
        }
           
        $http(req)
        .then(function successCallback(response){
            $scope.subcategories.unshift(response.data);      
            $scope.item = [];
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