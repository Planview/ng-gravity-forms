angular.module('ngGravityForms', [])
	.value('config', NG_GRAVITY_SETTINGS)
	.config (["$httpProvider", function ($httpProvider) {
	   $httpProvider.defaults.transformRequest = function (data) {
	       if (data == undefined) {
	         return data;
	       }
	       return jQuery.param(data);
	   };

	   $httpProvider.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded; charset=UTF-8";
	}])
	.controller('FormsCtrl', ['$scope', '$http', '$timeout', 'config', function($scope, $http, $timeout, config){
		$scope.formData = {};
		$scope.showConfirm = false;

		$scope.formSubmit = function () {
			$scope.formData.action = config.action;
			$http.post(config.ajaxUrl, $scope.formData).success(function (data) {
				$scope.formData = {};
				$scope.confirm();
			});
		};

		$scope.confirm = function () {
			$scope.showConfirm = true;
			$timeout(function () { $scope.showConfirm = false}, 5000);
		};
	}]);