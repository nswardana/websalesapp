usercatApp.directive('ngInitial', function() {
  return {
    restrict: 'A',
    controller: [
      '$scope', '$element', '$attrs', '$parse', function($scope, $element, $attrs, $parse) {
        var getter, setter, val;
        val = $attrs.ngInitial || $attrs.value;
        getter = $parse($attrs.ngModel);
        setter = getter.assign;
        setter($scope, val);
      }
    ]
  };
});

usercatApp.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;
            
            element.bind('change', function(){
                scope.$apply(function(){
                    modelSetter(scope, element[0].files[0]);
                });
            });
        }
    };
}]);

usercatApp.directive('modal', function () {
    return {
      template: '<div class="modal fade">' + 
          '<div class="modal-dialog">' + 
            '<div class="modal-content">' + 
              '<div class="modal-header">' + 
                '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' + 
                '<h4 class="modal-title">{{ title }}</h4>' + 
              '</div>' + 
              '<div class="modal-body" ng-transclude></div>' + 
            '</div>' + 
          '</div>' + 
        '</div>',
      restrict: 'E',
      transclude: true,
      replace:true,
      scope:true,
      link: function postLink(scope, element, attrs) {
        scope.title = attrs.title;

        scope.$watch(attrs.visible, function(value){
          if(value == true)
            $(element).modal('show');
          else
            $(element).modal('hide');
        });

        $(element).on('shown.bs.modal', function(){
          scope.$apply(function(){
            scope.$parent[attrs.visible] = true;
          });
        });

        $(element).on('hidden.bs.modal', function(){
          scope.$apply(function(){
            scope.$parent[attrs.visible] = false;
          });
        });
      }
    };
  });


usercatApp.directive('onBeforePrint', ['$window', '$rootScope', '$timeout', function onBeforePrint($window, $rootScope, $timeout) {
  var beforePrintDirty = false;
  var listeners = [];
 
  var beforePrint = function() {
    if (beforePrintDirty) return;
 
    beforePrintDirty = true;        
 
    if (listeners) {
      for (var i = 0, len = listeners.length; i < len; i++) {
        listeners[i].triggerHandler('beforePrint');
      }
 
      var scopePhase = $rootScope.$$phase;
 
      // This must be synchronious so we call digest here.
      if (scopePhase != '$apply' && scopePhase != '$digest') {
        $rootScope.$digest();
      }
    }
 
    $timeout(function() {
      // This is used for Webkit. For some reason this gets called twice there.
      beforePrintDirty = false;
    }, 100, false);
  };
 
  if ($window.matchMedia) {
    var mediaQueryList = $window.matchMedia('print');
    mediaQueryList.addListener(function(mql) {
      if (mql.matches) {
        beforePrint();
      }
    });
  }
 
  $window.onbeforeprint = beforePrint;
 
  return function(scope, iElement, iAttrs) {
    function onBeforePrint() {
      scope.$eval(iAttrs.onBeforePrint);
    }
 
    listeners.push(iElement);
    iElement.on('beforePrint', onBeforePrint);
 
    scope.$on('$destroy', function() {
      iElement.off('beforePrint', onBeforePrint);
 
      var pos = -1;
 
      for (var i = 0, len = listeners.length; i < len; i++) {
        var currentElement = listeners[i];
 
        if (currentElement === iElement) {
          pos = i;
          break;
        }
      }
 
      if (pos >= 0) {
        listeners.splice(pos, 1);
      }
    });
  };
}])
