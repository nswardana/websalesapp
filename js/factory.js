usercatApp.factory("Access", ["$q", "UserProfile",
function($q, UserProfile) {

  "use strict";

  var Access = {

    OK: 200,
    UNAUTHORIZED: 401,
    FORBIDDEN: 403,

    hasRole: function(role) {
      var deferred = $q.defer();
      UserProfile.then(function(userProfile) {
        if (userProfile.$hasRole(role)) {
          deferred.resolve(Access.OK);
        } else if (userProfile.$isAnonymous()) {
          deferred.reject(Access.UNAUTHORIZED);
        } else {
          deferred.reject(Access.FORBIDDEN);
        }
      });
      return deferred.promise;
    },

    hasAnyRole: function(roles) {
      var deferred = $q.defer();
      UserProfile.then(function(userProfile) {
        if (userProfile.$hasAnyRole(roles)) {
          deferred.resolve(Access.OK);
        } else if (userProfile.$isAnonymous()) {
          deferred.reject(Access.UNAUTHORIZED);
        } else {
          deferred.reject(Access.FORBIDDEN);
        }
      });
      return deferred.promise;
    },

    isAnonymous: function() {
      var deferred = $q.defer();
      UserProfile.then(function(userProfile) {
        if (userProfile.$isAnonymous()) {
          deferred.resolve(Access.OK);
        } else {
          deferred.reject(Access.FORBIDDEN);
        }
      });
      return deferred.promise;
    },

    isAuthenticated: function() {
      var deferred = $q.defer();
      UserProfile.then(function(userProfile) {
        if (userProfile.$isAuthenticated()) {
          deferred.resolve(Access.OK);
        } else {
          deferred.reject(Access.UNAUTHORIZED);
        }
      });
      return deferred.promise;
    }

  };

  return Access;

}]);

usercatApp.factory("User", ["$resource",
function($resource) {

  "use strict";

  return $resource("authtest", { id: "@id" }, {

    profile: {
      method: "GET",
      params: { attr: "profile" }
    }

  });

}]);




usercatApp.factory("UserProfile", ["$q", "User",
function($q, User) {

  "use strict";

  var userProfile = {};

  var fetchUserProfile = function() {
    var deferred = $q.defer();
    User.profile(function(response) {

      for (var prop in userProfile) {
        if (userProfile.hasOwnProperty(prop)) {
          delete userProfile[prop];
        }
      }

      deferred.resolve(angular.extend(userProfile, response, {

        $refresh: fetchUserProfile,

        $hasRole: function(role) {
          return userProfile.roles.indexOf(role) >= 0;
        },

        $hasAnyRole: function(roles) {
          return !!userProfile.roles.filter(function(role) {
            return roles.indexOf(role) >= 0;
          }).length;
        },

        $isAnonymous: function() {
          return userProfile.anonymous;
        },

        $isAuthenticated: function() {
          return !userProfile.anonymous;
        }

      }));

    });
    return deferred.promise;
  };

  return fetchUserProfile();

}]);


