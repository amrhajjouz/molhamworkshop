<!doctype html>
<html lang="ar" ng-app="app">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="ورشة العمل الخاصة بأعضاء فريق ملهم التطوعي">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Libs CSS -->
    <link rel="stylesheet" href="{{ asset('fonts/feather/feather.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/highlight-js/styles/vs2015.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/quill/dist/quill.core.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/flatpickr/dist/flatpickr.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    
    
    <!-- Theme CSS -->
    
    <link rel="stylesheet" href="{{ asset('css/theme.rtl.min.css') }}" id="stylesheetLight">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" id="stylesheetLight">    
    
    <base href="{{ $app_url }}/">
    
    <title>ورشة عمل فريق ملهم</title>
    
    <style>
    
    #loading-bar {
        position: fixed;
        top: 0;
        left: 0;
        width: 0px;
        height: 3px;
        z-index: 9999;
        box-shadow: 0px 0px 15px 0px #eee;
        border-radius: 100px;
    }
    
    </style>
    
</head>

<body dir="rtl" class="d-flex align-items-center cursor-wait" ng-class="{'cursor-wait' : $page.loading || $page.sendingHttpRequest}">
    
    <div id="loading-bar" class="bg-primary" ng-show="$page.loading"></div>
    
    <div id="page-spinner" class="container-fluid text-center">
        <div class="mb-4">
            <img src="{{ asset('img/logo.png') }}" class="mx-auto" height="50">
        </div>
        <hr style="width:80px;">
        <div class="spinner-border text-primary mt-2" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    
    <nav id="page-sidebar" class="navbar navbar-vertical fixed-right navbar-expand-md navbar-light d-none">
        <div class="container-fluid">
            
            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenavCollapse" aria-controls="sidenavCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Brand -->
            <a class="navbar-brand" href="javascript:;" ng-click="$page.reload()">
                <img src="{{ asset('img/logo.png') }}" class="navbar-brand-img mx-auto" alt="...">
            </a>
            
            <!-- User (xs) -->
            <div class="navbar-user d-md-none">
                
                <!-- Dropdown -->
                <div class="dropdown">
                    
                    <!-- Toggle -->
                    <a href="#">
                        <div class="avatar avatar-sm avatar-online">
                            <img src="{{ asset('img/avatar.png') }}" class="avatar-img rounded-circle" alt="...">
                        </div>
                    </a>
                    
                </div>
                
            </div>
            
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenavCollapse">
                @include('sidenav')
            </div>
            <!-- / .navbar-collapse -->
            
        </div>
    </nav>

    <div id="page-content" class="main-content py-md-6 pt-3 pb-5 d-none">
        <div class="row justify-content-center mx-0">
            <div class="col-lg-11" ng-view></div>
        </div>
    </div>
    
    <!-- Photo Viewer Modal -->
    <div class="modal fade" id="image-lightbox-modal" tabindex="-1" role="dialog" aria-labelledby="image-lightbox-modal" aria-hidden="true">
        <a href="javascript:;" class="modal-dismiss-icon display-4" data-dismiss="modal"><i class="fe fe-x"></i></a>
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body px-0 py-0">
                    <img class="w-100 img-fluid">
                </div> 
            </div>
        </div>
    </div>
    <!-- End Photo Viewer Modal -->    
    
    <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    
    <script src="{{ asset('libs/chart-js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('libs/highlightjs/highlight.pack.min.js') }}"></script>
    <script src="{{ asset('libs/flatpickr/dist/flatpickr.min.js') }}"></script>
    <script src="{{ asset('libs/jquery-mask-plugin/dist/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('libs/list-js/dist/list.min.js') }}"></script>
    <script src="{{ asset('libs/quill/dist/quill.min.js') }}"></script>
    <script src="{{ asset('libs/dropzone/dist/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('libs/chart-js/Chart.extension.min.js') }}"></script>
    
    <script src="{{ asset('js/theme.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    
    <script src="{{ asset('js/angular.min.js') }}"></script>
    <script src="{{ asset('js/angular-route.js') }}"></script>
    
    @foreach ($routes as $r)
    <script src="{{ asset('ng/controllers/' . $r['controller_path'] . '?t=' . time()) }}"></script>
    @endforeach

    <script>
        var appUrl = "{{ $app_url }}";
        var apiUrl = "{{ $api_url }}";
        var appDebug = {{ env('APP_DEBUG') }};
        var appTitle = $('title').text();
        var routes = JSON.parse(("{{ $routes->toJson() }}").replace(/&quot;/g,'"'));
        var app = angular.module("app", ["ngRoute"]);
        
        function $r (name, params = null, withBaseAppUrl = true) {
            
            var routeUrlPrefix = (withBaseAppUrl) ? appUrl : '';
            
            for (i=0; i<routes.length; i++) {
                if (name == routes[i].name) {
                    var routePath = routes[i].url;
                    if (routePath.indexOf(':') != -1) {
                        if (params != null && typeof(params) == 'object') {
                            var paramsKeys = Object.keys(params).sort(function(a, b) {
                                return b.length - a.length;
                            });
                            for (j=0; j<paramsKeys.length; j++) {
                                if (routePath.indexOf(':' + paramsKeys[j]) != -1) {
                                    routePath = routePath.replace(new RegExp(':' + paramsKeys[j], 'g'), params[paramsKeys[j]]);
                                }
                            }
                            if (routePath.indexOf(':') != -1) {
                                if (appDebug) console.error('Route (' + routes[i].name + ') has unset params');
                                return routeUrlPrefix;
                            }
                        } else {
                            if (appDebug) console.error('Undefined Params for Route (' + routes[i].name + ')');
                            return appUrl;
                        }
                    }
                    return routeUrlPrefix + routePath;
                }
            }
            if (appDebug) console.error('Route (' + name + ') is undefined');
            return appUrl;
        }
        
        app.run(function ($rootScope, $location, $page, $timeout) {
            
            $rootScope.$location = $location;
            $rootScope.$page = $page;
            $rootScope.sidenavLoaded = false;
            $rootScope.currentTemplateDirectory = '';
            $rootScope.$r = $r;            
            
            // refresh page if navagate to the current url
            /*document.addEventListener('click', function (e) {
                if (e.target.attributes != null && 'href' in e.target.attributes) {
                    var href = e.target.closest('a').href || '';
                    if (href != '') {
                        $rootScope = angular.element(document.body).scope().$root;
                        $rootScope.$apply(function () {
                            if (href == $rootScope.$page.currentUrl) $rootScope.$page.reload();
                        });
                    }
                }
            }, false);*/
            
            var loadingBarInterval = null;
            var loadingBarWidthPercantage = 0;
            
            $rootScope.$watch(function () {
                return $location.url(); 
            }, function (newLocation, oldLocation) {
                if (newLocation != '/404') {
                    $page.currentUrl = appUrl + newLocation;
                    $page.prevUrl = (newLocation != oldLocation) ? appUrl + oldLocation : null;
                }
            });
            
            $rootScope.$on('$routeChangeStart', function () {
                $page.resetConfig();
                $rootScope.$page.loading = true;
                $('#loading-bar').removeClass('w-100');
                $('#loading-bar').removeAttr('style');
                loadingBarWidthPercantage = 0;
                loadingBarInterval = setInterval(function () {
                    if ($rootScope.$page.loading) {
                        if (loadingBarWidthPercantage < 75) {
                            loadingBarWidthPercantage += 1.6;
                            $('#loading-bar').animate({'width': loadingBarWidthPercantage + '%'}, 15);
                        } else if (loadingBarWidthPercantage >= 75 && loadingBarWidthPercantage < 90) {
                            loadingBarWidthPercantage += 0.1;
                            $('#loading-bar').animate({'width': loadingBarWidthPercantage + '%'}, 15);
                        }
                    }
                }, 15);
            });
            
            $rootScope.$on('$routeChangeSuccess', function() {
                loadingBarWidthPercantage = 0;
                clearInterval(loadingBarInterval);
                $('#loading-bar').addClass('w-100');
                setTimeout(function ($rootScope) {
                    $rootScope = angular.element(document.body).scope().$root;
                    $rootScope.$apply(function () {
                        $rootScope.$page.loading = false;
                    });                    
                }, 500);
                
                $('#page-content').hide();
                
                $rootScope.currentTemplateDirectory = angular.copy($rootScope.$page.templateDirectory);
                
                $timeout(function () {
                    if ($page.headerTemplate != null || $page.includedTemplate != null) {
                        $rootScope.$watch(function () {
                            return $page.templatesLoaded;
                        }, function (newValue, oldValue) {
                            if (newValue) {
                                $('#page-content').fadeIn();
                                updatePageTitle();
                            }
                        });
                    } else {
                        $('#page-content').fadeIn();
                        updatePageTitle();
                    }
                });
                
                var updatePageTitle = function () {
                    if ($page.title != '')
                        $('title').text(appTitle + ' - ' + $page.title);
                    else
                        $('title').text(appTitle);
                };
                
                var alignItemsPageCenterIfRequired = function () {
                    if ($rootScope.$page.alignItemsCenter) {
                        $('body').addClass('d-flex align-items-center');
                        $('#page-content').addClass('container-fluid');
                    } else {
                        $('body').removeClass('d-flex align-items-center');
                        $('#page-content').removeClass('container-fluid');
                    }
                };
                
                var hidePageSidenavIfRequired = function () {
                    if ($rootScope.$page.sidenavHidden)
                        $('#page-sidebar').addClass('d-none').hide();
                    else
                        $('#page-sidebar').removeClass('d-none').show();
                };
                
                
                if ($('#page-spinner').is(":visible")) {
                    
                    $rootScope.$watch(function () {
                        return $rootScope.sidenavLoaded; 
                    }, function (newValue, oldValue) {
                        if (newValue) {
                            $('#page-spinner').addClass('d-none');
                            $('#page-content').removeClass('d-none');
                            alignItemsPageCenterIfRequired();
                            hidePageSidenavIfRequired();
                        }
                    });
                } else {
                    alignItemsPageCenterIfRequired();
                    hidePageSidenavIfRequired();
                }
                
                $(function () {
                    //$('.nav-link').removeClass('active');
                    $('[data-toggle=dropdown]').dropdown();
                    $('[data-toggle=tooltip]').tooltip();
                    /*$('[data-toggle="collapse"]').click(function(e) {
                        $('.collapse').collapse('hide');
                    });*/
                });
            });
            
            $rootScope.$on("$routeChangeError", function(evt, current, previous, rejection) {
                loadingBarWidthPercantage = 0;
                clearInterval(loadingBarInterval);
                $rootScope.$page.loading = false;
                if (!appDebug) $location.url('/404'); else console.error(rejection);
            });
            
        });
        
        app.directive('pageHeader', function ($compile, $page) {
            return {
                restrict: 'EA',
                transclude: true,
                scope : {
                    title: '@',
                    pretitle: '@',
                },
                replace : true,
                template : '<div class="header"><div class="header-body"><div class="row align-items-center"><div class="col"><h6 class="header-pretitle">@{{ pretitle }}</h6><h1 class="header-title display-4">@{{ title }}</h1></div><div class="col-auto"><ng-transclude></ng-transclude></div></div></div></div>',                
                link : function (scope, element, attrs, ctrls, transclude) {
                    $page.title = scope.title;
                    if (document.getElementsByTagName('page-nav').length > 0) {
                        var currentPageHeader = element[0];
                        element[0].classList.add('mb-0');
                        element[0].children[0].classList.add('pb-0');
                        element[0].children[0].classList.add('border-none');
                    }
                    element[0].removeAttribute('title');
                    element[0].removeAttribute('pretitle');
                }
            };
        });
        
        app.directive('pageNav', function ($rootScope) {
            return {
                restrict: 'E',
                transclude: true,
                replace : false,
                template: '<div class="header mb-5"><div class="header-body"><div class="row align-items-center"><div class="col"><ul id="volunteer-tabs" class="nav nav-tabs nav-overflow header-tabs" ng-transclude></ul></div></div></div></div>',
            };
        });
        
        app.directive('pageNavItem', function ($rootScope, $page) {
            
            return {
                restrict: 'EA',
                transclude: true,
                scope : {
                    route : '@',
                    params : '=',
                },
                replace : true,
                template : '<li class="nav-item"><a href="@{{ itemUrl }}" class="nav-link @{{ itemActiveClass }}" style="white-space: nowrap;" ng-transclude></a></li>',
                link : function (scope, element, attrs, ctrls, transclude) {
                    scope.itemUrl = $rootScope.$r(scope.route, scope.params);
                    scope.itemActiveClass = ($page.routeName == scope.route) ? 'active' : '';
                }
            };
        });
        
        app.directive('includeSidenav', function () {
            
            return {
                
                restrict: 'E',
                
                link : function (scope, element, attrs, ctrls, transclude) {
                    scope.sidenavTemplateUrl = function () {
                        return '{{ $app_url }}/ng/templates/basics/sidenav.htm?t={{ time() }}';
                    };
                },
                
                template: '<ng-include src="sidenavTemplateUrl()" onload="sidenavLoaded = true;"><ng-include>',
            };
        });
        
        app.directive('includeTemplate', function ($page) {
            
            return {
                
                restrict: 'E',
                
                link : function (scope, element, attrs, ctrls, transclude) {
                    scope.includedTemplateUrl = function () {
                        var templatePath = attrs.url.replace('.', '/') + '.htm';
                        return '{{ $app_url }}/ng/templates/' + templatePath  + '?t={{ time() }}';
                    };
                    $page.includedTemplate = {url: attrs.url, loaded: false};
                },
                
                template: '<ng-include src="includedTemplateUrl()" onload="$page.includedTemplate.loaded = true;$page.checkTemplates();"><ng-include>',
            };
        });
        
        app.directive('includeHeader', function ($page, $rootScope) {
            
            return {
                
                restrict: 'E',
                
                link : function (scope, element, attrs, ctrls, transclude) {
                    
                    scope.headerTemplateUrl = function () {
                        return '{{ $app_url }}/ng/templates/' + $rootScope.currentTemplateDirectory + '/header.htm' + '?t={{ time() }}';
                    };
                    $page.headerTemplate = {loaded: false};
                },
                
                template: '<ng-include src="headerTemplateUrl()" onload="$page.headerTemplate.loaded = true;$page.checkTemplates();"><ng-include>',
            };
        });
        
        app.directive('submitButton', function ($rootScope, $page) {
            
            return {
                restrict: 'EA',
                transclude: true,
                scope : {
                    icon : '@',
                    form : '=',
                },
                replace : true,
                template : '<button class="btn btn-primary" ng-click="form.request.send();form.$submitted = true;" ng-disabled="form.$invalid || form.$pristine || form.request.sending || form.$submitted"><i ng-hide="form.request.sending || (!form.request.sending && form.$submitted && !form.request.error)" class="@{{ icon }}"></i><div ng-show="form.request.sending" class="spinner-border spinner-border-sm" role="status"></div><i ng-show="!form.request.sending && form.$submitted && !form.request.error" class="fa fa-check"></i>&nbsp; <span ng-transclude></span></button>',
            };
        });
        
        app.directive('request', function ($timeout) {
            
            return {
                require: 'form',
                scope : {
                    name : '=',
                    request : '=',
                },
                
                link : function (scope, element, attrs) {
                    
                    $timeout(function () {
                        scope.name.request = scope.request;
                        
                        element.on("change", function () {
                            resetFormSubmittedStateOnChange();
                        });
                        
                        element.on("input", function () {
                            resetFormSubmittedStateOnChange();
                        });
                    });
                    
                    var resetFormSubmittedStateOnChange = function () {
                        if (scope.name.$submitted) {
                            var formScope = angular.element(element).scope();
                            formScope.$apply(function () {
                                formScope[scope.name.$name].$submitted = false;
                            });
                        }
                    };
                }
            };
        });
        
        app.service('$page', function($location, $route) {
            
            var initProperties = {routeName : null, routeParams : {}, controllerName : null, templateDirectory: '', prevUrl : null, currentUrl : null, title : '', alignItemsCenter : false, sidenavHidden : false, sidenavLoaded : false, loading : false, headerTemplate : null, includedTemplate : null, templatesLoaded : false, sendingHttpRequest : false};
            var initPropertiesKeys = Object.keys(initProperties);
            for(i=0; i<initPropertiesKeys.length; i++) this[initPropertiesKeys[i]] = initProperties[initPropertiesKeys[i]];
            
            this.set = function (newProperties) {
                var newPropertiesKeys = Object.keys(newProperties);
                for(i=0; i<newPropertiesKeys.length; i++) this[newPropertiesKeys[i]] = newProperties[newPropertiesKeys[i]];
            }
            
            this.resetConfig = function () {
                var initProperties = {title : '', alignItemsCenter : false, sidenavHidden : false, loading : false, headerTemplate : null, includedTemplate : null, templatesLoaded : false, sendingHttpRequest : false};
                var initPropertiesKeys = Object.keys(initProperties);
                for(i=0; i<initPropertiesKeys.length; i++) {
                    this[initPropertiesKeys[i]] = initProperties[initPropertiesKeys[i]];
                }
            }
            
            this.checkTemplates = function () {
                if (this.headerTemplate != null && this.includedTemplate != null && this.headerTemplate.loaded && this.includedTemplate.loaded)
                    this.templatesLoaded = true;
                else if (this.headerTemplate == null && this.includedTemplate != null && this.includedTemplate.loaded)
                    this.templatesLoaded = true;
                else if (this.headerTemplate != null && this.includedTemplate == null && this.headerTemplate.loaded)
                    this.templatesLoaded = true;
                else
                    this.templatesLoaded = false;
            }
            
            this.reload = function () {
                $route.reload();
            }
            
            this.navigate = function (routeName, routePath = null) {
                $location.url($r(routeName, routePath, false));
            }
            
        });
        
        app.factory('$apiRequest', function($http, $q, $page) {
            
            return {
                
                config : function (config, successCallback = null) {
                    
                    if (typeof config == 'string')
                        config = {'method' : 'GET', url : apiUrl + config};
                    else if ('url' in config) config.url = apiUrl + config.url;
                    
                    return {
                        
                        sending : false, sent : false, response : null, data : null, error : '', errors : {},
                        
                        send : function (returnData = false) {
                            
                            var q = $q.defer(); this.sending = true; this.response = ''; this.data = null; this.error = ''; this.errors = {}; var _this = this;
                            
                            $page.sendingHttpRequest = true; 
                            
                            $http(config).then(function (response) {
                                _this.handleResponse(response);
                                _this.abort(q);
                                if (_this.error == '' && successCallback != null && typeof successCallback == 'function') successCallback(response, response.data);
                                if (returnData) q.resolve(response.data); else q.resolve(response);
                            }, function (response) {
                                _this.handleResponse(response);
                                _this.abort(q);
                                q.resolve(response);
                            });
                            
                            return q.promise;
                        },
                        
                        getData : function () {
                            if (this.response != null && 'data' in this.response) return this.response.data; else return this.send(true);
                        },
                        
                        handleResponse : function (response) {
                            $page.sendingHttpRequest = false;
                            this.sending = false; this.response = response; this.data = response.data; this.sent = true;
                            // Handle Errors
                            if (this.data != null && typeof this.data == 'object') {
                                if ('error' in this.data) this.error = this.data.error;
                                if ('errors' in this.data) this.errors = this.data.errors;
                                if (this.error == '' && Object.keys(this.errors).length > 0) this.error = this.errors[Object.keys(this.errors)[0]][0];
                                if (this.response.statusText != 'OK') {
                                    if (this.error == '' && 'message' in this.data) this.error = this.data.message; 
                                }
                                if (this.error != '' && $page.loading == false) alert(this.error);
                            }
                        },
                        
                        abort : function (q) {
                            if (this.error != '') {
                                if ($page.loading) q.reject(this.response.data);
                                if (appDebug && this.response.statusText == 'OK') console.error(this.response.data);
                            }
                        }
                    };
                }
            };
        });
        
        app.factory('$promises', function($q) {
            return function (g) {
                return $q.all(g).then(function(data) {
                    return data;
                });
            };
        });
        
        for (i=0; i<routes.length; i++) {
            if (typeof window[routes[i].controller_name + 'Init'] == 'undefined') window[routes[i].controller_name + 'Init'] = function(){ return null; }; 
            if (appDebug && typeof window[routes[i].controller_name] == 'undefined') console.error(routes[i].controller_name + ' is undefined!');
        }
        
        app.config(function($routeProvider, $locationProvider) {
            
            <?php foreach ($routes as $r) : ?>
            
            $routeProvider.when("{{ $r['url'] }}", {
                
                templateUrl : "{{ asset('ng/templates/' . $r['template_path'] . '?t=' . time()) }}",
                controller: eval("{{ $r['controller_name'] }}"),
                controllerAs: "{{ $r['controller_name'] }}",
                reloadOnSearch : false,
                reloadOnUrl : true,
                resolve : {
                    $currentRoute : function ($page, $route) { $page.set({routeName : "{{ $r['name'] }}", routeParams : $route.current.params, controllerName : "{{ $r['controller_name'] }}", templateDirectory : "{{ $r['template_directory'] }}"}); },
                    $init : eval("{{ $r['controller_name'] . 'Init' }}"),
                },
            });
            
            <?php if ($r['name'] == '404') : ?>
            
            $routeProvider.otherwise ({
                templateUrl : "{{ asset('ng/templates/' . $r['template_path'] . '?t=' . time()) }}",
                controller: eval("{{ $r['controller_name'] }}"),
                reloadOnSearch : false,
                reloadOnUrl : true,
                resolve : {
                    $currentRoute : function ($page) { $page.set({routeName : "{{ $r['name'] }}", controllerName : "{{ $r['controller_name'] }}"}); },
                    $init : eval("{{ $r['controller_name'] . 'Init' }}"),
                },
            });
            
            <?php endif; ?>
            
            <?php endforeach; ?>
            
            $locationProvider.html5Mode(true);
        });
        
    </script>
    
</body>

</html>