var services = angular.module('usercatServices', ['ngResource']);

services.service("NameService", function($http, $filter){
  
  function filterData(data, filter){
    return $filter('filter')(data, filter)
  }
  
  function orderData(data, params){
    return params.sorting() ? $filter('orderBy')(data, params.orderBy()) : filteredData;
  }
  
  function sliceData(data, params){
    return data.slice((params.page() - 1) * params.count(), params.page() * params.count())
  }
  
  function transformData(data,filter,params){
    return sliceData( orderData( filterData(data,filter), params ), params);
  }
  
  var service = {
    cachedData:[],
    getData:function($defer, params, filter){
      if(service.cachedData.length>0){
        console.log("using cached data")
        var filteredData = filterData(service.cachedData,filter);
        var transformedData = sliceData(orderData(filteredData,params),params);
        params.total(filteredData.length)
        $defer.resolve(transformedData);
      }
      else{
        console.log("fetching data")
        $http.get("http://www.json-generator.com/api/json/get/bUAZFEHxCG").success(function(resp)
        {
          angular.copy(resp,service.cachedData)
          params.total(resp.length)
          var filteredData = $filter('filter')(resp, filter);
          var transformedData = transformData(resp,filter,params)
          
          $defer.resolve(transformedData);
        });  
      }
      
    }
  };
  return service;  
});

services.factory('UsersFactory', function ($resource) {
    return $resource('/users', {}, {
        query: { method: 'GET', isArray: true },
        create: { method: 'POST' }
    })
});

services.factory('UserFactory', function ($resource) {
    return $resource('/users/:id', {}, {
        show: { method: 'GET' },
        update: { method: 'POST', params: {id: '@id'} },
        delete: { method: 'DELETE', params: {id: '@id'} }
    })
});

services.factory('EventsFactory', function ($resource) {
    return $resource('/events', {}, {
        query: { method: 'GET', isArray: true },
        create: { method: 'POST' }
    })
});

services.factory('AttendancesFactory', function ($resource) {
    return $resource('/attendances/:id', {}, {
        query: { method: 'GET', params: {id: '@id'}, isArray: true },
        create: { method: 'POST', params: {id: '@id'} }
    })
});

services.factory('EventFactory', function ($resource) {
    return $resource('/events/:id', {}, {
        show: { method: 'GET' },
        update: { method: 'POST', params: {id: '@id'} },
        delete: { method: 'DELETE', params: {id: '@id'} }
    })
});

services.factory("Data", ['$http', 'toaster',
    function ($http, toaster) { // This service connects to our REST API
 
        var serviceBase = '/sales/';
 
        var obj = {};
        obj.toast = function (data) {
            toaster.pop(data.status, "", data.message, 10000, 'trustedHtml');
        }
        obj.get = function (q) {
            return $http.get(serviceBase + q).then(function (results) {
                return results.data;
            });
        };
        obj.post = function (q, object) {
            return $http.post(serviceBase + q, object).then(function (results) {
                return results.data;
            });
        };
        obj.put = function (q, object) {
            return $http.put(serviceBase + q, object).then(function (results) {
                return results.data;
            });
        };
        obj.delete = function (q) {
            return $http.delete(serviceBase + q).then(function (results) {
                return results.data;
            });
        };
 
        return obj;
}]);

services.service('fileUpload', ['$http', function ($http) {
    this.uploadFileToUrl = function(file, uploadUrl){
        var fd = new FormData();
        fd.append('file', file);
        $http.post(uploadUrl, fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined}
        })
        .success(function(){
        })
        .error(function(){
        });
    }
}]);
