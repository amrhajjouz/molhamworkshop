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
    <script src="{{ asset('libs/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('libs/chart-js/Chart.extension.min.js') }}"></script>
    
    <script src="{{ asset('js/theme.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    
    <script src="{{ asset('js/angular.min.js') }}"></script>
    <script src="{{ asset('js/angular-route.js') }}"></script>
    
    {{-- trello  --}}
    
    {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.0.0/moment.min.js"></script> --}}
    <script src="https://trello.com/1/client.js?key=478a021e0eee1bc54f97f29c1e6149f6"></script>
    <script src="https://p.trellocdn.com/embed.min.js"></script>

    {{-- Google Drive --}}
       {{-- <script src="https://apis.google.com/js/client.js"></script> --}}

  <script async defer src="https://apis.google.com/js/api.js"> onreadystatechange="if (this.readyState === 'complete') this.onload()"</script>

{{-- 

    <script type="text/javascript">

    // The Browser API key obtained from the Google API Console.
    // Replace with your own Browser API key, or your own key.
    var developerKey = "AIzaSyBqzy_qnXlJbHr6pExKeow1NYJX4d2oTXY";

    // The Client ID obtained from the Google API Console. Replace with your own Client ID.
    var clientId = "120230772858-lg8cb520vnjn9gfcle83l90v4kqo3d5g.apps.googleusercontent.com";

    // Replace with your own project number from console.developers.google.com.
    // See "Project number" under "IAM & Admin" > "Settings"
    var appId = "test-api-project-314916";

    // Scope to use to access user's Drive items.
    var scope = ['https://www.googleapis.com/auth/drive.file'];

    var pickerApiLoaded = false;
    var oauthToken;

    // Use the Google API Loader script to load the google.picker script.
    function loadPicker() {
      gapi.load('auth', {'callback': onAuthApiLoad});
      gapi.load('picker', {'callback': onPickerApiLoad});
    }

    function onAuthApiLoad() {
      window.gapi.auth.authorize(
          {
            'client_id': clientId,
            'scope': scope,
            'immediate': false
          },
          handleAuthResult);
    }

    function onPickerApiLoad() {
      pickerApiLoaded = true;
      createPicker();
    }

    function handleAuthResult(authResult) {
      if (authResult && !authResult.error) {
        oauthToken = authResult.access_token;
        createPicker();
      }
    }

    // Create and render a Picker object for searching images.
    function createPicker() {
      if (pickerApiLoaded && oauthToken) {
        var view = new google.picker.View(google.picker.ViewId.DOCS);
        view.setMimeTypes("image/png,image/jpeg,image/jpg,*");
        var picker = new google.picker.PickerBuilder()
            .enableFeature(google.picker.Feature.NAV_HIDDEN)
            .enableFeature(google.picker.Feature.MULTISELECT_ENABLED)
            .setAppId(appId)
            .setOAuthToken(oauthToken)
            .addView(view)
            .addView(new google.picker.DocsUploadView())
            // .setDeveloperKey(developerKey)
            .setCallback(pickerCallback)
            .build();
         picker.setVisible(true);
      }
    }

    // A simple callback implementation.
    function pickerCallback(data) {
      if (data.action == google.picker.Action.PICKED) {
        var fileId = data.docs[0].id;
        console.log( data.docs)
        alert('The user selected: ' + fileId);
      }
    }
    </script>

     <script type="text/javascript" src="https://apis.google.com/js/api.js?onload=loadPicker"></script>
 





     --}}





    @foreach ($routes as $r)
    <script src="{{ asset('ng/controllers/' . $r['controller_path'] . '?t=' . time()) }}"></script>
    @endforeach

    <script>
        var appUrl = "{{ $app_url }}";
        var apiUrl = "{{ $api_url }}";
        var appDebug = {{ env('APP_DEBUG') }};
        var appTitle = $('title').text();
        var auth = {id: "{{ auth()->user()->id }}", name: "{{ auth()->user()->name }}", email: "{{ auth()->user()->email }}"};
        
        var routes = JSON.parse(("{{ $routes->toJson() }}").replace(/&quot;/g,'"'));
        var locales = JSON.parse(("{{ $locales->toJson() }}").replace(/&quot;/g,'"'));
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
            $rootScope.$routeName = '';
            $rootScope.$routeParams = '';
            $rootScope.$r = $r;
            $rootScope.$auth = auth;
            
            // console.log($rootScope.$auth);
            
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
                $rootScope.$routeName = angular.copy($rootScope.$page.routeName);
                $rootScope.$routeParams = angular.copy($rootScope.$page.routeParams);
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
                template : '<button class="btn btn-primary" ng-click="updateFormModel();form.request.send();form.$submitted = true;" ng-disabled="form.$invalid || !form.unregisteredRequiredModels.valid || form.$pristine || form.request.sending || form.$submitted"><i ng-hide="form.request.sending || (!form.request.sending && form.$submitted && !form.request.error)" class="@{{ icon }}"></i><div ng-show="form.request.sending" class="spinner-border spinner-border-sm" role="status"></div><i ng-show="!form.request.sending && form.$submitted && !form.request.error" class="fa fa-check"></i>&nbsp; <span ng-transclude></span></button>',
                link : function (scope, element, attrs) {
                    console.log(scope.form)
                    scope.updateFormModel = function () {
                        if (scope.form.model)
                            scope.form.request.config.data = scope.form.model;
                    }
                }
            };
        });
        
        app.directive('contentCard', function ($timeout, $rootScope) {
            
            return {
                restrict: 'E',
                transclude: true,
                scope : {
                    contentModel : '=',
                    contentTitle : '@',
                    contentName : '@',
                },
                replace : true,
                template: 
                '<div class="card mt-4">' +
                    '<div class="card-header">' +
                        '<div class="row align-items-center">' +
                            '<div class="col">' +
                                '<h4 class="card-header-title">@{{ contentTitle }}</h4>' +
                            '</div>' +
                            '<div class="col-auto">' +
                                '<button ng-click="editContent();" class="btn btn-sm btn-white">تعديل</button>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<div class="card-header row d-flex">' +
                        '<div class="col">' +
                            '<ul class="nav nav-tabs card-header-tabs nav-overflow">' +
                                '<li class="nav-item" ng-repeat="l in locales">' +
                                    '<a href="javascript:;" id="@{{ l.code }}-link" ng-click="changeCardLocale(l);" class="nav-link locale-link" ng-class="{active: (cardCurrentLocale.code == l.code)}">@{{ l.name }}</a>' +
                                '</li>' +
                            '</ul>' +
                        '</div>' +
                    '</div>' +
                    '<div class="card-body py-4">' +
                        '<p ng-repeat="l in locales" ng-show="(cardCurrentLocale.code == l.code)" dir="@{{ l.dir }}" class="text-@{{ l.align }}">@{{ contentModel[l.code] }}</p>' +
                    '</div>' +
                
                    '<div class="card-body border-top" ng-show="cardModificationState" ng-transclude>' +
                
                    '</div>' +
                    
                '</div>',
                
                link : function (scope, element, attrs) {
                    
                    $timeout(function () {
                        scope.locales = locales;
                        scope.cardCurrentLocale = {code: locales[0].code, name: locales[0].name, dir: locales[0].dir};
                        scope.changeCardLocale = function (locale) {
                            scope.cardCurrentLocale = locale;
                        }
                        
                        scope.cardModificationState = false;
                        
                        var formElement = element[0].getElementsByTagName('FORM')[0];
                        
                        var formModelName = formElement.getAttribute('model');
                        var localeLable = formElement.getElementsByClassName('locale-label')[0];
                        var elementScope = angular.element(element).scope();
                        
                        scope.editContent = function () {
                            scope.cardModificationState = !scope.cardModificationState;
                            eval('elementScope.' + formModelName + '.locale = ' + '"' + scope.cardCurrentLocale.code + '"');
                            eval('elementScope.' + formModelName + '.name = ' + '"' + scope.contentName + '"');
                            if (scope.contentModel[scope.cardCurrentLocale.code])
                                eval('elementScope.' + formModelName + '.value = ' + '"' + scope.contentModel[scope.cardCurrentLocale.code] + '"');
                            localeLable.innerHTML = scope.cardCurrentLocale.name;
                        }
                    });
                }
            };
        });
        
        app.directive('request', function ($timeout) {
            
            return {
                require: 'form',
                scope : {
                    name : '=',
                    request : '=',
                    model: '=',
                },
                
                link : function (scope, element, attrs) {
                    
                    $timeout(function () {
                        
                        var elementScope = angular.element(element).scope();
                        
                        scope.name.request = scope.request;
                        scope.name.unregisteredRequiredModels.updateValidity = function () {
                            scope.name.unregisteredRequiredModels.valid = true;
                            for (i=0; i<this.models.length; i++) {
                                if (eval('elementScope.' + this.models[i]) == false) {
                                    scope.name.unregisteredRequiredModels.valid = false;
                                    break ;
                                }
                            }
                        }
                        
                        scope.name.unregisteredRequiredModels.updateValidity();
                        scope.name.model = (scope.model) ? scope.model : null;
                        
                        element.on("change", function () {
                            scope.name.model = (scope.model) ? scope.model : null;
                            resetFormSubmittedStateOnChange();
                        });
                        
                        element.on("input", function () {
                            scope.name.model = (scope.model) ? scope.model : null;
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
        
        app.directive('ngError', function ($rootScope) {
            
            return {
                restrict: 'A',
                scope : {
                    ngError : '=',
                },
                
                link : function (scope, element, attrs) {
                    
                    if (attrs.ngError) {
                        
                        var errorElementClassName = attrs.ngError.toLowerCase().split('.').join('-');
                        $('<div class="invalid-feedback display-none ' + errorElementClassName + '"></div>').insertAfter($(element));
                        
                        var elementScope = angular.element(element).scope();
                        
                        var clearError = function () {
                            if (scope.ngError) {
                                $(element).removeClass('is-invalid');
                                $('.' + errorElementClassName).addClass('display-none');
                                $('.' + errorElementClassName).html('');
                                scope.ngError = null;
                            }
                        };

                        $rootScope.$on('apiRequestError', function(event, options) {
                            var errors = eval('elementScope.' + attrs.ngError);
                            if (errors) {
                                $(element).addClass('is-invalid');
                                $('.' + errorElementClassName).removeClass('display-none');
                                $('.' + errorElementClassName).html(errors[0]);
                            } else {
                                clearError();
                            }
                        });
                        element.on("change", function () {
                            clearError();
                        });
                        element.on("input", function () {
                            clearError();
                        }); 
                    }
                }
            };
        });
        
        app.directive('select2', function ($rootScope, $page, $timeout) {
            
            return {
                restrict: 'E',
                transclude: true,
                scope : {
                    model : '@',
                    ajaxUrl : '@',
                    ajaxData : '=',
                    placeholder: '@',
                    multiple: '@',
                    minLength: '@',
                    errorModel: '=',
                },
                replace : true,
                template: '<select class="form-control" ng-transclude></select>',
                link : function (scope, element, attrs) {
                    
                    $timeout(function () {
                        
                        var select2Config = {
                            multiple: (element[0].multiple) ? true : false,
                            placeholder: (attrs.placeholder) ? attrs.placeholder : null,
                            minimumInputLength: (attrs.minLength) ? attrs.minLength : ((attrs.ajaxUrl) ? 1 : 0),
                        };
                        
                        if (attrs.ajaxUrl) {
                            
                            var path = attrs.ajaxUrl;
                            var query = {};
                            
                            if (attrs.ajaxUrl.indexOf("?") != -1) {
                                var queryStr = attrs.ajaxUrl.substr(attrs.ajaxUrl.indexOf("?") + 1);
                                path = attrs.ajaxUrl.substr(0, attrs.ajaxUrl.indexOf("?"));
                                query = JSON.parse('{"' + decodeURI(queryStr).replace(/"/g, '\\"').replace(/&/g, '","').replace(/=/g,'":"') + '"}');
                            }
                            
                            select2Config.ajax = {
                                url: apiUrl + path,
                                dataType: 'json',
                                data: function (params) {
                                    if (attrs.ajaxData)
                                        query = Object.assign(query, scope.ajaxData);
                                    return Object.assign(query, {q: params.term});
                                },
                                processResults: function (data) {
                                    // Transforms the top-level key of the response object from 'items' to 'results'
                                    return {
                                        results: data
                                    };
                                }
                            };
                            select2Config.delay = 250;
                            select2Config.allowClear = false;
                        }
                        
                        if (element[0].multiple) {
                            element[0].setAttribute('multiple', 'multiple');
                        }
                        
                        var elementScope = angular.element(element).scope();
                        
                        element.on("change", function () {
                            eval('elementScope.' + attrs.model + ' = ' + JSON.stringify($(element).val()) + ';');
                            if (modelForm) {
                                elementScope[modelForm].$pristine = false;
                                elementScope[modelForm].$dirty = true;
                                elementScope[modelForm].unregisteredRequiredModels.updateValidity();
                            }
                            elementScope.$apply();
                        });
                        
                        var initOptions = element[0].getElementsByTagName('OPTION');
                        var initModelValue = [];
                        var initOptionsToRemove = [];
                        
                        for (i=0; i<initOptions.length; i++) {
                            if (attrs.ajaxUrl && !initOptions[i].selected)
                                initOptionsToRemove.push(initOptions[i]);                            
                            
                            if (element[0].multiple && initOptions[i].selected)
                                initModelValue.push(initOptions[i].value);
                            else if (initOptions[i].selected) {
                                initModelValue = initOptions[i].value;
                            }
                        }
                        
                        for (i=0; i<initOptionsToRemove.length; i++) {
                            initOptionsToRemove[i].remove();
                        }
                        
                        eval('elementScope.' + attrs.model + ' = ' + JSON.stringify(initModelValue) + ';');
                        elementScope.$apply();
                        
                        // Check if element's parent is modal
                        var parentElement = element[0].parentElement;
                        do {
                            parentElement = parentElement.parentElement;
                        } while (parentElement.nodeName != 'BODY' && !parentElement.classList.contains("modal"));
                        if (parentElement.classList.contains("modal")) select2Config.dropdownParent = $(parentElement);
                        
                        $(element).select2(select2Config);
                        
                        var modelForm;
                        
                        var parentElement = element[0].parentElement;
                        
                        do {
                            parentElement = parentElement.parentElement;
                        } while (parentElement.nodeName != 'BODY' && parentElement.nodeName != 'FORM');
                        
                        if (parentElement.nodeName == 'FORM' && parentElement.getAttribute('name')) {
                            var modelForm = parentElement.getAttribute('name');
                            if (elementScope[modelForm] && $(element).prop('required')) {
                                elementScope[modelForm].unregisteredRequiredModels.models[elementScope[modelForm].unregisteredRequiredModels.models.length] = attrs.model;
                                elementScope.$apply();
                            }
                        }
                    });
                    
                    if (attrs.errorModel) {
                        
                        var errorElementClassName = attrs.errorModel.toLowerCase().split('.').join('-');
                        $('<div class="invalid-feedback display-none ' + errorElementClassName + '"></div>').insertAfter($(element));
                        
                        var elementScope = angular.element(element).scope();
                        
                        var clearError = function () {
                            if (scope.errorModel) {
                                $(element).removeClass('is-invalid');
                                $('.' + errorElementClassName).addClass('display-none');
                                $('.' + errorElementClassName).html('');
                                scope.errorModel = null;
                            }
                        };
                        
                        $rootScope.$on('apiRequestError', function(event, options) {
                            var errors = eval('elementScope.' + attrs.errorModel);
                            if (errors) {
                                $(element).addClass('is-invalid');
                                $('.' + errorElementClassName).removeClass('display-none');
                                $('.' + errorElementClassName).html(errors[0]);
                            } else {
                                clearError();
                            }
                        });
                        
                        element.on("change", function () {
                            clearError();
                        });
                        element.on("input", function () {
                            clearError();
                        }); 
                    }
                    
                }
            };
        });
        
        app.directive('modal', function ($rootScope, $timeout) {
            
            return {
                restrict: 'E',
                transclude: true,
                scope : {
                    showCallback : '&',
                    hideCallback : '&',
                },
                replace : true,
                template: '<div class="modal fade" tabindex="-1" role="dialog"><div class="modal-dialog modal-lg" role="document"><div class="modal-content" ng-transclude></div></div></div>',
                link : function (scope, element, attrs) {
                    $timeout(function () {
                        
                        var modalFormsElements = element[0].getElementsByTagName('FORM');
                        var modalForms = [];
                        
                        for (i=0; i<modalFormsElements.length; i++) {
                            var formName = modalFormsElements[i].getAttribute('name');
                            if (formName) {
                                var currentChildTail = scope.$$childTail;
                                while (currentChildTail != null && !(formName in currentChildTail)) {
                                    currentChildTail = currentChildTail.$$childTail;
                                }
                                
                                if (formName in currentChildTail) {
                                    modalForms[modalForms.length] = currentChildTail[formName];
                                }
                            }
                            
                        }                        
                        
                        $(element).on('shown.bs.modal', function (e) {
                            for (i=0; i<modalForms.length; i++) {
                                modalForms[i].$setPristine();
                            }
                            if (attrs.showCallback) {
                                scope.showCallback();
                            }
                            angular.element(element).scope().$apply();
                        });
                        
                        if (attrs.hideCallback) {
                            $(element).on('hidden.bs.modal', function (e) {
                                scope.hideCallback();
                                angular.element(element).scope().$apply();
                            });
                        }
                    });
                }
            };
        });
        
        app.directive('modalTitle', function () {
            
            return {
                restrict: 'E',
                transclude: true,
                scope : {
                    
                },
                replace : true,
                template: '<div class="modal-header"><h4 class="modal-title" ng-transclude></h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>',
            };
        });
        
        app.directive('modalBody', function () {
            
            return {
                restrict: 'E',
                transclude: true,
                scope : {
                    
                },
                replace : true,
                template: '<div class="modal-body" ng-transclude></div>',
            };
        });
        
        app.directive('modalFooter', function () {
            
            return {
                restrict: 'E',
                transclude: true,
                scope : {
                    
                },
                replace : true,
                template: '<div class="modal-footer" ng-transclude></div>',
            };
        });
        
        app.directive('dropdown', function ($rootScope, $page) {
            
            return {
                restrict: 'E',
                transclude: true,
                scope : {},
                replace : true,
                template : '<div class="dropdown"><a href="javascript:;" class="color-black mr-2" role="button" data-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a><div class="dropdown-menu" ng-transclude></div></div>',
            };
        });
        
        app.directive('dropdownItem', function ($rootScope, $page) {
            
            return {
                restrict: 'E',
                transclude: true,
                scope : {},
                replace : true,
                template : '<a class="dropdown-item" ng-transclude></a>',
            };
        });
        
        app.directive('datatable', function ($rootScope, $page) {
            
            return {
                restrict: 'E',
                transclude: true,
                scope : {
                    datalist: '=',
                },
                replace : true,
                link : function (scope, element, attrs) {
                    var tablesElements = element[0].getElementsByTagName('table');
                    if (tablesElements.length > 0) {
                        for (i=0; i<tablesElements.length; i++) {
                            tablesElements[i].classList.add('table');
                            tablesElements[i].classList.add('table-sm');
                            tablesElements[i].classList.add('card-table');
                        }
                    }
                    
                    var pageSelect = element[0].getElementsByClassName('page-select')[0];                    
                    
                    $(pageSelect).change(function() {
                        scope.datalist.page(pageSelect.value);
                    });
                    
                    var searchInput = element[0].getElementsByClassName('search')[0];
                    searchInput.value = scope.datalist.q;
                    
                    $(searchInput).on('keypress', function(e) {
                        if (e.which == 13 && (searchInput.value != '' || (searchInput.value == '' && scope.datalist.q != ''))) {
                            scope.datalist.search(searchInput.value);
                        }
                    });
                    
                },
                template : '<div>' +
                                '<div class="card">' +
                                    '<div class="card-header">' +
                                        '<div class="row align-items-center">' +
                                            '<div class="col">' +
                                                '<div class="input-group input-group-flush input-group-merge">' +
                                                    '<input type="search" class="form-control form-control-prepended search" placeholder="اكتب كلمة للبحث ثم اضغط Enter  ...">'+
                                                    '<div class="input-group-prepend">' +
                                                        '<div class="input-group-text">' +
                                                            '<span ng-show="!datalist.searching" class="fe fe-search"></span>' +
                                                            '<span ng-show="datalist.searching" class="spinner-border spinner-border-sm"></span>' +
                                                        '</div>' +
                                                    '</div>' +
                                                '</div>'+
                                            '</div>'+
                                            '<div class="col-auto">' +
                                                '<button ng-show="datalist.nextPageUrl" ng-click="datalist.nextPage();" class="btn btn-sm btn-white" type="button" data-toggle="tooltip" data-placement="top" title="الصفحة التالية">' +
                                                    '<i class="fe fe-arrow-right"></i>' +
                                                '</button>'+
                                                '<button ng-show="datalist.prevPageUrl" ng-click="datalist.prevPage();" class="btn btn-sm btn-white" type="button" data-toggle="tooltip" data-placement="top" title="الصفحة السابقة">' +
                                                    '<i class="fe fe-arrow-left"></i>' +
                                                '</button>  '+
                                                //'<button class="btn btn-sm btn-white" type="button" data-toggle="tooltip" data-placement="top" title="خيارات الفلترة والعرض">' +
                                                //    '<i class="fe fe-sliders"></i>' +
                                                //'</button> ' +
                                                //'<button class="btn btn-sm btn-white" type="button" data-toggle="tooltip" data-placement="top" title="تصدير القائمة الى ملف CSV">' +
                                                //    '<i class="fe fe-download"></i>' +
                                                //'</button>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="table-responsive">' +
                                        '<ng-transclude></ng-transclude>' +
                                        '<table>' +
                                            '<tbody ng-show="datalist.data.length == 0">' +
                                                '<tr>' +
                                                    '<td class="text-center">' +
                                                        '<div class="pt-3 pb-2 h4" ng-show="datalist.data.length == 0">لا يوجد أية عناصر في هذه القائمة</div>' +
                                                    '</td>' +
                                                '</tr>' +
                                            '</tbody>' +
                                        '</table>' +
                                    '</div>' +
                                    '<div class="card-footer d-flex justify-content-between" ng-hide="datalist.data.length == 0">' +
                                        '<div class="col my-0">' +
                                            '<div class="text-right h4 mt-2">العدد الكلي : @{{ datalist.total }}</div>' +
                                        '</div>' +
                                        '<div class="col-auto form-group my-0">' +
                                            '<select class="form-control form-control-sm page-select">' +
                                                '<option ng-repeat="p in datalist.pages" value="@{{ p }}" ng-selected="(p == datalist.currentPage)">الصفحة @{{ p }}</option>' +
                                            '</select>' +
                                        '</div>' +
                                        '<div class="col my-0">' +
                                            '<div class="text-left h4 mt-2">النتائج : <span dir="ltr">@{{ datalist.from }} <i class="fe fe-arrow-right"></i> @{{ datalist.to }}</span></div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>'+
                            '</div>'
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
        
        app.factory('$apiRequest', function($http, $q, $page, $rootScope) {
            
            return {
                
                config : function (config, successCallback = null) {
                    
                    if (typeof config == 'string')
                        config = {'method' : 'GET', url : apiUrl + config};
                    else if ('url' in config) config.url = apiUrl + config.url;
                    
                    return {
                        
                        config: config, sending : false, sent : false, response : null, data : null, error : '', errors : {},
                        
                        send : function (returnData = false) {                            
                            
                            var q = $q.defer(); this.sending = true; this.response = ''; this.data = null; this.error = ''; this.errors = {}; var _this = this;
                            
                            $page.sendingHttpRequest = true; 
                            
                            $http(this.config).then(function (response) {
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
                                if (this.error != '' && $page.loading == false) {
                                    $rootScope.$broadcast("apiRequestError", this.error);
                                    alert(this.error);
                                }
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
        
        app.factory('$datalist', function($apiRequest, $q, $location, $page) {
            
            return function (path, changeRouteOnLoad = false) {
                
                return {
                    
                    // Flags
                    loaded: false,
                    loading: false,
                    searching: false,
                    filtering: false,
                    
                    q: '', // Search Query
                    filters: {}, // Filters
                    params: {}, // Initial Query
                    
                    path: path, // should be api path 
                    data: null,
                    currentPage: 1,
                    nextPageUrl: null, // should be api path 
                    prevPageUrl: null, // should be api path 
                    firstPageUrl: null, // should be api path 
                    lastPage: null,
                    lastPageUrl: null, // should be api path 
                    perPage: null,
                    from: null,
                    to: null,
                    total: null,
                    
                    pages: [],
                    
                    load : function (v = null) {
                        // send request to path?params&filters&q
                        var requestQuery = Object.assign(angular.copy(this.params), this.filters);
                        if (this.q) requestQuery.q = this.q; else delete requestQuery.q;
                        if (v && !isNaN(v)) requestQuery.page = v;
                        if (!this.loaded && changeRouteOnLoad) {
                            if ($page.routeParams) {
                                requestQuery = Object.assign(requestQuery, $page.routeParams);
                                if ('q' in $page.routeParams) this.q = $page.routeParams.q;
                            }
                        }
                        requestQuery = new URLSearchParams(requestQuery);
                        requestQueryString = requestQuery.toString();
                        var q = $q.defer();
                        var _this = this;
                        var requestUrl = (v && isNaN(v)) ? v : this.path + ((requestQueryString) ? '?' + requestQueryString : '');
                        $apiRequest.config(requestUrl, function (response, data) {
                            var dataKeys = Object.keys(data);
                            for (i=0; i<dataKeys.length; i++) {
                                var keySplitted = dataKeys[i].split('_');
                                for (j=0; j<keySplitted.length; j++) {
                                    if (j > 0) keySplitted[j] = keySplitted[j].charAt(0).toUpperCase() + keySplitted[j].slice(1);
                                }
                                if (typeof data[dataKeys[i]] == 'string') data[dataKeys[i]] = data[dataKeys[i]].replace(apiUrl, '');
                                _this[keySplitted.join('')] = data[dataKeys[i]];
                            }
                            _this.pages = [];
                            for (i=1; i<=_this.lastPage; i++) _this.pages[_this.pages.length] = i;
                            _this.clearFlags();
                            _this.loaded = true;
                            q.resolve(_this);
                        }).getData();
                        return q.promise;
                    },
                    
                    search : function (q) {
                        this.q = q;
                        this.searching = true;
                        if (changeRouteOnLoad) $location.search({q: ((q == '') ? null : q), page: null});
                        return this.load();
                    }, 
                    
                    filter : function (filters) {
                        // set this.filters = filters
                        // return this.load();
                        return ;
                    },
                    
                    nextPage : function () {
                        if (this.nextPageUrl && !this.loading) {
                            if (changeRouteOnLoad) $location.search('page', this.currentPage + 1);
                            return this.load(this.nextPageUrl);
                        }
                    },
                    
                    prevPage : function () {
                        if (this.prevPageUrl && !this.loading) {
                            if (changeRouteOnLoad) $location.search('page', this.currentPage - 1);
                            return this.load(this.prevPageUrl);
                        }
                    },
                    
                    page : function (p) {
                        if (changeRouteOnLoad) $location.search('page', p);
                        return this.load(p);
                    },
                    
                    clearFlags : function () {
                        this.loading = false;
                        this.searching = false;
                        this.filtering = false;
                    }
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
                reloadOnUrl : false,
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
                reloadOnUrl : false,
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