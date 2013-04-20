<?php
$auth = <<<EOD
//AuthComponent Object
//(
//    [_loggedIn] => 
//    [components] => Array
//        (
//            [0] => Session
//            [1] => RequestHandler
//        )
//
//    [authenticate] => 
//    [authorize] => controller
//    [ajaxLogin] => 
//    [flashElement] => default
//    [userModel] => User
//    [userScope] => Array
//        (
//        )
//
//    [fields] => Array
//        (
//            [username] => username
//            [password] => password
//        )
//
//    [sessionKey] => 
//    [actionPath] => 
//    [loginAction] => Array
//        (
//            [plugin] => 
//            [controller] => users
//            [action] => login
//        )
//
//    [loginRedirect] => Array
//        (
//            [plugin] => 
//            [controller] => /
//        )
//
//    [logoutRedirect] => Array
//        (
//            [plugin] => 
//            [controller] => /
//        )
//
//    [object] => 
//    [loginError] => This message shows up when the wrong credentials are used
//    [authError] => Please log in to proceed.
//    [autoRedirect] => 1
//    [allowedActions] => Array
//        (
//            [0] => display
//        )
//
//    [actionMap] => Array
//        (
//            [index] => read
//            [add] => create
//            [edit] => update
//            [view] => read
//            [remove] => delete
//            [create] => create
//            [read] => read
//            [update] => update
//            [delete] => delete
//        )
//
//    [data] => Array
//        (
//        )
//
//    [params] => Array
//        (
//            [named] => Array
//                (
//                )
//
//            [pass] => Array
//                (
//                )
//
//            [controller] => workshops
//            [action] => upcoming
//            [plugin] => 
//            [form] => Array
//                (
//                )
//
//            [url] => Array
//                (
//                    [url] => workshops
//                )
//
//        )
//
//    [_methods] => Array
//        (
//            [1] => upcoming
//            [2] => index
//            [3] => view
//            [4] => add
//            [5] => edit
//            [6] => delete
//            [7] => initaccount
//            [8] => slug
//            [9] => initcompany
//            [10] => pullsplash
//            [11] => mainnavigation
//            [13] => verifysearchdata
//            [14] => firstofweek
//            [15] => lastofweek
//            [16] => xweeksago
//            [17] => sincexweeksago
//            [18] => monthspan
//            [19] => yearspan
//            [20] => buildstandardsearchconditions
//            [21] => buildadvancedtextsearchconditions
//            [22] => buildadvanceddatesearchconditions
//            [23] => constructdaterangecondition
//        )
//
//    [enabled] => 1
//    [Session] => SessionComponent Object
//        (
//            [__active] => 1
//            [__bare] => 0
//            [valid] => 
//            [error] => 
//            [_userAgent] => 3bc2bec168582c4ecef0d854f7f2e1f2
//            [path] => /bindery
//            [lastError] => 
//            [security] => medium
//            [time] => 1365099170
//            [sessionTime] => 1365111170
//            [cookieLifeTime] => 
//            [watchKeys] => Array
//                (
//                )
//
//            [id] => 
//            [host] => localhost
//            [timeout] => 
//            [enabled] => 1
//        )
//
//    [RequestHandler] => RequestHandlerComponent Object
//        (
//            [ajaxLayout] => ajax
//            [enabled] => 1
//            [__responseTypeSet] => 
//            [params] => Array
//                (
//                    [named] => Array
//                        (
//                        )
//
//                    [pass] => Array
//                        (
//                        )
//
//                    [controller] => workshops
//                    [action] => upcoming
//                    [plugin] => 
//                    [form] => Array
//                        (
//                        )
//
//                    [url] => Array
//                        (
//                            [url] => workshops
//                        )
//
//                )
//
//            [__requestContent] => Array
//                (
//                    [javascript] => text/javascript
//                    [js] => text/javascript
//                    [json] => application/json
//                    [css] => text/css
//                    [html] => Array
//                        (
//                            [0] => text/html
//                            [1] => */*
//                        )
//
//                    [text] => text/plain
//                    [txt] => text/plain
//                    [csv] => Array
//                        (
//                            [0] => application/vnd.ms-excel
//                            [1] => text/plain
//                        )
//
//                    [form] => application/x-www-form-urlencoded
//                    [file] => multipart/form-data
//                    [xhtml] => Array
//                        (
//                            [0] => application/xhtml+xml
//                            [1] => application/xhtml
//                            [2] => text/xhtml
//                        )
//
//                    [xhtml-mobile] => application/vnd.wap.xhtml+xml
//                    [xml] => Array
//                        (
//                            [0] => application/xml
//                            [1] => text/xml
//                        )
//
//                    [rss] => application/rss+xml
//                    [atom] => application/atom+xml
//                    [amf] => application/x-amf
//                    [wap] => Array
//                        (
//                            [0] => text/vnd.wap.wml
//                            [1] => text/vnd.wap.wmlscript
//                            [2] => image/vnd.wap.wbmp
//                        )
//
//                    [wml] => text/vnd.wap.wml
//                    [wmlscript] => text/vnd.wap.wmlscript
//                    [wbmp] => image/vnd.wap.wbmp
//                    [pdf] => application/pdf
//                    [zip] => application/x-zip
//                    [tar] => application/x-tar
//                )
//
//            [mobileUA] => Array
//                (
//                    [0] => Android
//                    [1] => AvantGo
//                    [2] => BlackBerry
//                    [3] => DoCoMo
//                    [4] => iPod
//                    [5] => iPhone
//                    [6] => J2ME
//                    [7] => MIDP
//                    [8] => NetFront
//                    [9] => Nokia
//                    [10] => Opera Mini
//                    [11] => PalmOS
//                    [12] => PalmSource
//                    [13] => portalmmm
//                    [14] => Plucker
//                    [15] => ReqwirelessWeb
//                    [16] => SonyEricsson
//                    [17] => Symbian
//                    [18] => UP\.Browser
//                    [19] => webOS
//                    [20] => Windows CE
//                    [21] => Xiino
//                )
//
//            [__acceptTypes] => Array
//                (
//                    [0] => text/html
//                    [1] => application/xhtml+xml
//                    [2] => application/xml
//                    [3] => */*
//                )
//
//            [__renderType] => 
//            [ext] => 
//            [__typesInitialized] => 
//        )
//
//)
EOD;
            ?>
