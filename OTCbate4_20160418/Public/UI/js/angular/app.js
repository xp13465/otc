/*   
//                            _ooOoo_    
//                           o8888888o    
//                           88" . "88    
//                           (| -_- |)    
//                            O\ = /O    
//                        ____/`---'\____    
//                      .   ' \\| |// `.    
//                       / \\||| : |||// \    
//                     / _||||| -:- |||||- \    
//                       | | \\\ - /// | |    
//                     | \_| ''\---/'' | |    
//                      \ .-\__ `-` ___/-. /    
//                   ___`. .' /--.--\ `. . __    
//                ."" '< `.___\_<|>_/___.' >'"".    
//               | | : `- \`.;`\ _ /`;.`/ - ` : | |    
//                 \ \ `-. \_ __\ /__ _/ .-` / /    
//         ======`-.____`-.___\_____/___.-`____.-'======    
//                            `=---='    
//    
//         .............................................    
//                  佛祖保佑             永无BUG   
*/
angular.module('storeApp',[]).config(function($httpProvider){    
 $httpProvider.defaults.transformRequest = function(obj){      
    var str = [];      
    for(var p in obj){        
      str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));      
    }      
    return str.join("&");   
  }     
  $httpProvider.defaults.headers.post = { 
      'Content-Type': 'application/x-www-form-urlencoded'   
  }  
}).factory('serviceUrl', ['$http', function($http) {
  var service = {};
  service.add = function(data ,params, success, error) {
    $http.post( '/Guest/cust/add?q=' + moment().format('x'), data, {
      params: params
    }).then(success, error);

    // $http({
    //     method:'post',
    //     url:'/Guest/cust/add?q=' + moment().format('x'),
    //     data:data,
    //     headers:{'Content-Type': 'application/x-www-form-urlencoded'},
    //     transformRequest: function(obj) {
    //       var str = [];
    //       for(var p in obj){
    //         str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
    //       }
    //       return str.join("&");
    //     }
    //  }).then(success, error);
  };
  service.getcrm = function(params, success, error) {
    $http.get( '/Guest/cust/getcrm?q=' + moment().format('x'), {
      params: params
    }).then(success, error);
  };
  service.getcustinfo = function(params, success, error) {
    $http.get( '/Guest/cust/getcustinfo?q=' + moment().format('x'), {
      params: params
    }).then(success, error);
  };
  service.custlogout = function(params, success, error) {
    $http.get( '/Guest/cust/custlogout?q=' + moment().format('x'), {
      params: params
    }).then(success, error);
  };
  service.setcrm = function(data ,params, success, error) {
    $http.post( '/Guest/cust/setcrm?q=' + moment().format('x'), data, {
      params: params
    }).then(success, error);
  };
  service.login = function(data ,params, success, error) {
    $http.post( '/Guest/cust/login?q=' + moment().format('x'), data, {
      params: params
    }).then(success, error);
  };
  service.userlist = function(data ,params, success, error) {
    $http.post( '/Guest/cust/userlist?q=' + moment().format('x'), data, {
      params: params
    }).then(success, error);
  };
  service.getInvestList = function(data,params, success, error) {
    $http.post( '/Guest/Product/getInvestList?q=' + moment().format('x'), data, {
      params: params
    }).then(success, error);
  };
  service.getInvestInfo = function(params, success, error) {
    $http.post( '/Guest/Product/getInvestInfo?q=' + moment().format('x'), {}, {
      params: params
    }).then(success, error);
  };
  service.doInvest = function(data,params, success, error) {
    $http.post( '/Guest/Invest/doInvest?q=' + moment().format('x'), data, {
      params: params
    }).then(success, error);
  };
  service.myivs_dnf = function(data,params, success, error) {
    $http.post( '/Guest/Cust/myivs_dnf?q=' + moment().format('x'), data, {
      params: params
    }).then(success, error);
  };  
  service.clivslist = function(data,params, success, error) {
    $http.post( '/Guest/Invest/clivslist?q=' + moment().format('x'), data, {
      params: params
    }).then(success, error);
  };  
  service.finishInvest = function(data,params, success, error) {
    $http.post( '/Guest/invest/finishInvest?q=' + moment().format('x'), data, {
      params: params
    }).then(success, error);
  }; 
  service.redemptionInvest = function(data,params, success, error) {
    $http.post( '/Guest/invest/redemptionInvest?q=' + moment().format('x'), data, {
      params: params
    }).then(success, error);
  }; 
  service.cancelInvest  = function(data,params, success, error) {
    $http.post( '/Guest/invest/cancelInvest?q=' + moment().format('x'), data, {
      params: params
    }).then(success, error);
  };
  // service.tlist  = function(data,params, success, error) {
  //   $http.post( '/admin/cfmast/tlist?q=' + moment().format('x'), data, {
  //     params: params
  //   }).then(success, error);
  // };
  service.userModifypwd  = function(data,params, success, error) {
    $http.post( '/guest/cust/userModifypwd?q=' + moment().format('x'), data, {
      params: params
    }).then(success, error);
  };
  service.getUserNodeList  = function(data,params, success, error) {
    $http.post( '/guest/access/getUserNodeList?q=' + moment().format('x'), data, {
      params: params
    }).then(success, error);
  };
  service.updateSelfPassword  = function(data,params, success, error) {
    $http.post( '/admin/user/updateSelfPassword?q=' + moment().format('x'), data, {
      params: params
    }).then(success, error);
  };
  service.getThisDetail  = function(data,params, success, error) {
    $http.post( '/Guest/Product/getThisDetail?q=' + moment().format('x'), data, {
      params: params
    }).then(success, error);
  };  
  service.getThisRecord  = function(data,params, success, error) {
    $http.post( '/Guest/Product/getThisRecord?q=' + moment().format('x'), data, {
      params: params
    }).then(success, error);
  };
  service.restartIvsRight  = function(params, success, error) {
    $http.get( '/Guest/Invest/restartIvsRight?q=' + moment().format('x'), {
      params: params
    }).then(success, error);
  };
  service.getRightSchedule  = function(data,params, success, error) {
    $http.post( '/Guest/Invest/getRightSchedule?q=' + moment().format('x'), data, {
      params: params
    }).then(success, error);
  };
  service.getCapitalpool  = function(data,params, success, error) {
    $http.post( '/guest/product/getCapitalpool?q=' + moment().format('x'), data, {
      params: params
    }).then(success, error);
  };
  return service;
}]).controller('mainCtrl', ['$scope', 'serviceUrl','$rootScope','$sce',
  function($scope, serviceUrl, $rootScope, $sce) {
    var vm = this;
    $scope.paginationConf = {};
    $scope.showUserAccount = function(){
      $rootScope.$broadcast('user.account.show', {});
    }
    $scope.showUserLogin = function(){
      $rootScope.$broadcast('user.login.show', {});
    }
    $scope.setCrmInfoFn = function(data){
      $rootScope.$broadcast('crm.info.show', data);
    }
    $scope.setUserInfolistFn = function(){
      $rootScope.$broadcast('user.infolist.show',{});
    }
    $scope.showProductList = function(data){
      $rootScope.$broadcast('product.list.show',data);
    }
    $scope.showBigImg = function(data){
      $rootScope.$broadcast('show.img.show',data);
    }
    $scope.showProductBox = function(data){
      $rootScope.$broadcast('product.box.show',data);
    }
    $scope.showProductPurchaseFn = function(data){
      $rootScope.$broadcast('product.purchase.show',data);
    }
    $scope.showManagePurchaseFn = function(){
      $rootScope.$broadcast('manage.purchase.show', {});
    }   
    $scope.showManageRightFn = function(){
      $rootScope.$broadcast('manage.right.show', {});
    }
    $scope.showSetPersonFn = function(){
      $rootScope.$broadcast('set.person.show', {});
    }
    $scope.showSetMyselfFn = function(){
      $rootScope.$broadcast('set.myself.show', {});
    }
    $scope.showProductDocFn = function(data){
      $rootScope.$broadcast('product.doc.show', data);
    }
    $scope.showProductDocFn_reset = function(data){
      $rootScope.$broadcast('product.doc_reset.show', data);
    }
    $scope.showInvestRecordFn = function(data){
      $rootScope.$broadcast('invest.record.show', data);
    }    
    $scope.showSpeedRightFn = function(data){
      $rootScope.$broadcast('speed.right.show', data);
    }
    $scope.showProductSelectFn = function(){
      $rootScope.$broadcast('product.select.show', {});
    }
    $scope.showPromptBookFn = function(){
      $rootScope.$broadcast('prompt.book.show', {});
    }
    serviceUrl.getUserNodeList({},{},function(data){
       var data = data.data;
       var names_158 = '';
       var names_161 = '';
       for(var i=0;i<data.length;i++){
		   $scope["node_id_"+data[i]['node_id']] = data[i]['name'];
			// if(data[i]['node_id'] == 161){//客户密码管理
			  // names_161 = data[i]['name'];
			// }
			// if(data[i]['node_id'] == 160){//个人设置管理
			  // names_160 = data[i]['name'];
			// } 
       }
       // $scope.node_id_157 = names_157;
       // $scope.node_id_161 = names_161;
    })
}]).directive('userAccount', ['serviceUrl', '$rootScope',
  function(serviceUrl, $rootScope) {
    return {
      priority: 200,
      templateUrl:baseUrl + 'template/userAccount.html',
      replace: true,
      restrict: 'A',
      scope:  false,
      link: function postLink(scope, iElement, iAttrs) {
        scope.userAccount = 0;
        $rootScope.$on('user.account.show', function(e, data) {
          scope.role = {};
          scope.info ={};
          scope.userAccount = 1;
        });
        scope.add = function(){
          if(!scope.info.nam_cust_real){
            alerts.show('姓名不能为空！')
            return;
          }
          if(!verificationRule.isChinese(scope.info.nam_cust_real)){
            alerts.show('姓名不符合规则！')
            return;
          }


          if(!scope.info.cod_cust_id_no){
            alerts.show('身份证号不能为空！')
            return;
          }
          if(!verificationRule.isCardNum(scope.info.cod_cust_id_no)){
            alerts.show('身份证号不符合规则！')
            return;
          }



          if(!scope.info.tel){
            alerts.show('手机号不能为空！')
            return;
          }
          if(!verificationRule.isIphone(scope.info.tel)){
            alerts.show('手机号不符合规则！')
            return;
          }


          if(!scope.info.password){
            alerts.show('密码不能为空！')
            return;
          }
          if(scope.info.password.length < 6){
            alerts.show('密码必须大于6位！')
            return;
          }
          if(!scope.info.repassword){
            alerts.show('确认密码不能为空！')
            return;
          }
          if(scope.info.repassword != scope.info.password){
            alerts.show('两次密码不同！')
            return;
          }
          serviceUrl.add({
              cod_cust_id_no:scope.info.cod_cust_id_no,
              tel:  scope.info.tel,
              nam_cust_real: scope.info.nam_cust_real,
              password: scope.info.password,
              repassword: scope.info.repassword
           },{},function(data){
              var msg = data.data;
              if(msg.status == 1){
                 scope.userAccount = 0;
                 scope.setCrmInfoFn(msg.uid);
                 scope.readOnlyCrmInfo = {
                    'status':false
                  };
              }else{
                alerts.show(msg.msg);
                return;
              }
           })
        }
        scope.passwordRole = function(event){
          var flag = event.target.value;
          var status = verificationRule.isPassword(flag);
           switch(status){
              case 'role_one':
                scope.role = {};
                scope.role.role_one = 1;
                break;
              case 'role_two':
                scope.role = {};
                scope.role.role_two = 1;
                break;
              case 'role_three':
                scope.role = {};
                scope.role.role_three = 1;
                break;
              default:
                scope.role = {};
                break;
           }

        }
        scope.closeAccountFn = function(){
          scope.userAccount = 0;
        }
      }
    }
}]).directive('crmInfo', ['serviceUrl', '$rootScope','$timeout',
  function(serviceUrl, $rootScope,$timeout) {
    return {
      priority: 200,
      templateUrl:baseUrl + 'template/crmInfo.html',
      replace: true,
      restrict: 'A',
      scope: false,
      link: function postLink(scope, iElement, iAttrs) {
        scope.crmInfo = 0;
        $rootScope.$on('crm.info.show', function(e, data) {
          
          scope.crmUid = data;
          scope.crmInfo = 1;
          $timeout(function(){
            uploaderImg();
          },14);
          serviceUrl.getcrm({
            uid : data
          },function(data){
            var data = data.data;
             if(data.status == 1){
                scope.scrmInfo = data.data;
                scope.scrmInfo.crm_file = scope.scrmInfo.crm_file ==''?[]:scope.scrmInfo.crm_file.split("|");
             }else{
               alerts.show(data.msg)
             }
          })
        });
        scope.setcrm = function(){
           if(!scope.scrmInfo.bizcode || !scope.scrmInfo.address){
              alerts.show('邮编和地址必填！');
              return;
           }
           var flag = {
              'uid': scope.crmUid,
              'source': scope.scrmInfo.source,
              'custname': scope.scrmInfo.custname,
              'consultant': scope.scrmInfo.consultant,
              'team': scope.scrmInfo.team,
              'storemanager': scope.scrmInfo.storemanager,
              'store': scope.scrmInfo.store,
              'division': scope.scrmInfo.division,
              'areamanager': scope.scrmInfo.areamanager,
              'producttype': scope.scrmInfo.producttype,
              'receiptdate': scope.scrmInfo.receiptdate,
              'contractamount': scope.scrmInfo.contractamount,
              'contractno': scope.scrmInfo.contractno,
              'receivablesamount': scope.scrmInfo.receivablesamount,
              'rateofreturn': scope.scrmInfo.rateofreturn,
              'installments': scope.scrmInfo.installments,
              'paymentmethod': scope.scrmInfo.paymentmethod,
              'iscontinued': scope.scrmInfo.iscontinued,
              'plandate': scope.scrmInfo.plandate,
              'outprincipal': scope.scrmInfo.outprincipal,
              'outinterest': scope.scrmInfo.outinterest,
              'realmanagementfee': scope.scrmInfo.realmanagementfee,
              'breakcontractamountrate': scope.scrmInfo.breakcontractamountrate,
              'breakcontractamount': scope.scrmInfo.breakcontractamount,
              'birthday': scope.scrmInfo.birthday,
              'tel': scope.scrmInfo.tel,
              'bizcode': scope.scrmInfo.bizcode,
              'address': scope.scrmInfo.address,
              'bankaccount': scope.scrmInfo.bankaccount,
              'bankopen': scope.scrmInfo.bankopen,
              'informationbypost': scope.scrmInfo.informationbypost,
              'memo': scope.scrmInfo.memo,
              'crm_file': scope.scrmInfo.crm_file.join("|")
           };
           serviceUrl.setcrm(flag,{},function(data){
               var data = data.data;
               if(data.status == 1){
                  alerts.show(data.msg);
                  scope.crmInfo = 0;
               }else{
                  alerts.show(data.msg);
               }
              
           })
        }
        scope.closeCrmInfoFn = function(){
          scope.crmInfo = 0;
          scope.scrmInfo.crm_file = '';
        }
        scope.showUploadImgFn = function(index){
          scope.showBigImg(scope.scrmInfo.crm_file[index]);
        }
        scope.delUploadImg = function(index){
          scope.scrmInfo.crm_file.splice(index,1);
        }
        function uploaderImg(){
          var uploaderCode = new WebUploader.create({
                auto: true,
                swf:baseUrl +'/images/desktop/Uploader.swf',
                server: '/Guest/Cust/uploadcrm_pic',
                pick: '#btnUploadImg',
                duplicate:true, 
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,png',
                    mimeTypes: 'image/*'
                }
          });
          // uploaderCode.on( 'beforeFileQueued', function( file ) {
          //     if(file.size > 2048000){
          //       alerts.show('上传图片大小不超过2M');
          //       return false;
          //     }
          // });
          uploaderCode.on( 'uploadError', function( file ) {
              alerts.show('上传失败');
          });
          uploaderCode.on( 'uploadSuccess', function( file , msg ){
              scope.scrmInfo.crm_file.push(msg._raw);
              scope.$apply();
          });
        }
       

      }
    }
}]).directive('userLogin', ['serviceUrl', '$rootScope',
  function(serviceUrl, $rootScope) {
    return {
      priority: 200,
      templateUrl:baseUrl + 'template/userLogin.html',
      replace: true,
      restrict: 'A',
      scope:  false,
      link: function postLink(scope, iElement, iAttrs) {
        scope.userLogin = 0;
        scope.userLoginInfo = {
           data : {
             'nam_cust_real':''
           }
        };
        $rootScope.$on('user.login.show', function(e, data) {
          scope.userLogin = 1;
          // serviceUrl.getcustinfo({},function(data){
          //    var data = data.data;
          //    scope.userLoginInfo = 0;
          //     console.log(data);
          // })
          scope.userLoginInfo.status = 0;
          scope.login = {};
        });

        scope.closeLoginFn = function(){
          scope.userLogin = 0;
        }
        scope.loginFn = function(){
           if(!scope.login.cod_cust_id_no){
              alerts.show('身份证号不能为空！');
              return;
           }
           if(!scope.login.password){
              alerts.show('登录密码不能为空！');
              return;
           }
           serviceUrl.login({
              cod_cust_id_no : scope.login.cod_cust_id_no,
              password : scope.login.password
           },{},function(data){
              var data = data.data;
              if(data.status == 1){
                 // scope.showProductSelectFn()
                 scope.showProductBox(data);
                 scope.userLogin = 0;
              }else{
                 alerts.show(data.msg);
              }
           })
        }
        scope.loginOutFn = function(){
          serviceUrl.custlogout({},function(data){
              var data = data.data;
              if(data.status == 1){
                 alerts.show(data.msg);
                 scope.userLoginInfo.status = 0;
              }else{
                 alerts.show(data.msg);
              }
          })
        }
        scope.submitFn = function($event){
            var code = $event.keyCode;
            if(code == '13'){
               scope.loginFn();
            }
        }
      }
    }
}]).directive('userInfolist', ['serviceUrl', '$rootScope','$timeout',
  function(serviceUrl, $rootScope,$timeout) {
    return {
      priority: 200,
      templateUrl:baseUrl + 'template/userInfolist.html',
      replace: true,
      restrict: 'A',
      scope: false,
      link: function postLink(scope, iElement, iAttrs) {
        var dereg;
        scope.userInfolist = 0;
        scope.userInfolistIteams = [];
        scope.TimeNode = [{
            'id':0,
            'name':'不限'
          },{
            'id':1,
            'name':'一周内'
          },{
            'id':2,
            'name':'一月内'
          },{
            'id':3,
            'name':'三月内'
          },{
            'id':4,
            'name':'三月以上'
          }
        ];
        scope.dataTimeList = {};
        scope.dataTimeList.TimeNodeCurrent = 0;
        $rootScope.$on('user.infolist.show', function(e, data) {
            init();
        });
        function init(datas){
          scope.userInfolist = 1;
            $timeout(function(){
              $(".form_datetime1").datetimepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                language :'zh-CN',
                minView:3
              }).on("hide",function(){
                 var $this = $(this);
                 var _this = this;
                 scope.dataTimeList.start = _this.value;
              });
              $(".form_datetime2").datetimepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                language :'zh-CN',
                minView:3
              }).on("hide",function(){
                 var $this = $(this);
                 var _this = this;
                 scope.dataTimeList.end = _this.value;
              });
            },14)
            if(datas != 1){
               scope.paginationConf = {
                    currentPage: 1,
                    itemsPerPage: 10,
                    pagesLength: 15,
                    perPageOptions: [10, 20, 50, 100]
                }
            }
            
            dereg = scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage',function(){
              if(scope.userInfolist != 1){
                 return;
              }
              commonAjax({ 
                'page':scope.paginationConf.currentPage,
                'limit':scope.paginationConf.itemsPerPage,
                'status':scope.dataTimeList.TimeNodeCurrent,
                'keyword':scope.dataTimeList.keywordText?scope.dataTimeList.keywordText:'',
                'date_cls':scope.dataTimeList.TimeNodeCurrent
              })
            });
        }
        function commonAjax(data){
           serviceUrl.userlist(data,{},function(data){
                var data = data.data;
               scope.paginationConf.totalItems = data.total;
                scope.userInfolistIteams = data.items;
            })
        }
        scope.closeUserInfolistFn = function(){
           scope.userInfolist = 0;
           dereg();
        }
        scope.lookInfolistFn = function(index,flag){
            scope.readOnlyCrmInfo = {
              'status':flag
            };
            var uid = scope.userInfolistIteams[index].cod_cust_id;
            scope.userInfolist = 1;
            scope.setCrmInfoFn(uid);
        }

        scope.changeSelectFn = function(data){
            dereg();
            scope.dataTimeList.TimeNodeCurrent = data;
            scope.dataTimeList.keywordText = '';
            init(1);
        }
        // scope.screenFn = function(){
        //   if(!scope.dataTimeList.start || !scope.dataTimeList.end){
        //       alerts.show('起止时间不能为空！');
        //       return;
        //   }
        //   scope.paginationConf = {
        //       currentPage: 1,
        //       itemsPerPage: 10,
        //       pagesLength: 15,
        //       perPageOptions: [10, 20, 50, 100],
        //       onChange: function(){
        //          commonAjax({ 
        //             'b_time':scope.dataTimeList.start,
        //             'e_time':scope.dataTimeList.end
        //          })
        //       }
        //   }
        // }
        scope.searchListFn = function(){
          dereg();
           init();
        }
      }
    }
}]).directive('productList', ['serviceUrl', '$rootScope',
  function(serviceUrl, $rootScope) {
    return {
      priority: 200,
      templateUrl:baseUrl + 'template/productList.html',
      replace: true,
      restrict: 'A',
      scope: false,
      link: function postLink(scope, iElement, iAttrs) {
        scope.productList = 0;
        $rootScope.$on('product.list.show', function(e, data) {
          init(data);
        });
        function init(data){
          scope.productListInfo = {};
          scope.productList = 1;
          serviceUrl.getInvestInfo({
            'id': data
          },function(data){
             var data = data.data;
             scope.productListInfo = data;
             __info();
          })

          function __info(){
              scope.repeatProductListInfo = [{
               'name':'项目介绍',
               'con':scope.productListInfo.memo,
               'isShow':true,
               'img':baseUrl +'/images/desktop/add_icon_01.png',
            },{
               'name':'担保方介绍',
               'con':scope.productListInfo.dbfjs,
               'isShow':false,
               'img':baseUrl +'/images/desktop/add_icon_02.png',
            },{
               'name':'风险提示',
               'con':scope.productListInfo.fxts,
               'isShow':false,
               'img':baseUrl +'/images/desktop/add_icon_03.png',
            },{
               'name':'资金安全',
               'con':scope.productListInfo.zjaq,
               'isShow':false,
               'img':baseUrl +'/images/desktop/add_icon_04.png',
            },{
               'name':'债权规则',
               'con':scope.productListInfo.zqgz,
               'isShow':false,
               'img':baseUrl +'/images/desktop/add_icon_05.png',
            },{
               'name':'资产安全',
               'con':scope.productListInfo.zcaq,
               'isShow':false,
               'img':baseUrl +'/images/desktop/add_icon_06.png',
            }];
            scope.repeatProductListInfoInit = {
               msg : scope.repeatProductListInfo[0]['con']
            }
          }
        }
        scope.closeProductListFn = function(){
           scope.productList = 0;
        }
        scope.productMoneyFn = function(){
           var data = parseInt(scope.productListInfo.money);
           var reg = /^[1-9]\d*$/;
           var flag = reg.test(data);
           var moneyStatusMin;
           var moneyStatusMax;
           if(scope.produceCategory.status == 1){
             var min = scope.productListInfo.amt_cf_inv_min * 10000;
             var max = scope.productListInfo.amt_cf_inv_max == 0?Infinity:scope.productListInfo.amt_cf_inv_max* 10000;
             var step = 10000;
             moneyStatusMin = _editNuber(min);
             moneyStatusMax = _editNuber(max);
           }
           if(scope.produceCategory.status == 2){
             var min = scope.productListInfo.amt_ct_min;
             var max = scope.productListInfo.amt_ct_max== 0?Infinity:scope.productListInfo.amt_ct_max;
             var step = 10000;
             moneyStatusMin = min;
             moneyStatusMax = max;
           }
           if(!flag || !(data%step == 0 && data >= min && data <= max)){
               var typetitle="";
               var typeunit="";
              if(scope.produceCategory.status == 2){
                 typetitle='份数';
                 typeunit='份';
              }else if(scope.produceCategory.status == 1){
                 typetitle='金额';
                 typeunit='元';
              }
              if(data < min){
                alerts.show('该产品最小投资'+typetitle+'为'+moneyStatusMin+typeunit);
              }else if(data > max){
                alerts.show('该产品最大投资'+typetitle+'为'+moneyStatusMax+typeunit);
              }else if(data%step > 0){
                alerts.show('最小单位为'+step+typeunit);
              }else{
                alerts.show('请填入正确的'+typetitle+'！');
              }
              // if(scope.produceCategory.status == 2){
              //   alerts.show('请填入正确的份数！');
              // }
              // if(scope.produceCategory.status == 1){
              //   alerts.show('请填入正确的金额！');
              // }
              return;
           }else{
              serviceUrl.getcustinfo({},function(data){
                 var data = data.data;
                 var datas;
                 if(data.status == 1){
                      datas = data.data;
                      datas.push_id = scope.productListInfo.id;
                      datas.push_amt_ivs = scope.produceCategory.status==1?scope.productListInfo.money:scope.productListInfo.money*scope.productListInfo.amt_cf_inv_each;
                      datas.push_cf_ctl_id = scope.productListInfo.period_id;
                      datas.push_ctl_ivs_cnt = scope.productListInfo.money;
                      scope.showProductPurchaseFn(datas);
                 }else if(data.status == -1){
                    scope.showUserLogin();
                    scope.productList = 0;
                 }else{
                    alerts.show(data.msg);
                 }
              })
           }
        }
        function _editNuber(data){
           return parseFloat(data).toLocaleString() + '.00'
        }
        scope.getClass = function($index,list){
           return {
              'hover':list[$index]['isShow']
           }
        }
        scope.eleFn = function(flag,$index,list){
           angular.forEach(list, function(data,index){
            //data等价于array[index]
              data['isShow'] = false;
              list[$index]['isShow'] = flag;
           });
           
           if(flag == 1){
             scope.repeatProductListInfoInit.msg = list[$index]['con'];
           }
        }
      }
    }
}]).directive('showImg', ['serviceUrl', '$rootScope',
  function(serviceUrl, $rootScope) {
    return {
      priority: 200,
      templateUrl:baseUrl + 'template/showImg.html',
      replace: true,
      restrict: 'A',
      scope: false,
      link: function postLink(scope, iElement, iAttrs) {
        scope.showImgShow = 0;
        $rootScope.$on('show.img.show', function(e, data) {
            scope.showImgShow = 1;
            scope.uploadImgInfo = data;
        });
        scope.closeImgFn = function(){
           scope.showImgShow = 0;
        }
      }
    }
}]).directive('productBox', ['serviceUrl', '$rootScope',
  function(serviceUrl, $rootScope) {
    return {
      priority: 200,
      templateUrl:baseUrl + 'template/productBox.html',
      replace: true,
      restrict: 'A',
      scope: false,
      link: function postLink(scope, iElement, iAttrs) {
        scope.produceCategory = {};
        scope.productBox = 0;
        $rootScope.$on('product.box.show', function(e, data) {
           init(data); 
        });
        function init(data){
           //判断那种类型(金钱购买 or 份数购买) produceCategory.status = 1?2
            //console.log(data);
            scope.produceCategory = {
              status:1//data.investment_type

            };
            scope.productBoxArr =[];
            scope.productBox = 1;
            serviceUrl.getInvestList({
                'investment_type':data.investment_type,
                'capitalid':data.capitalid

            },{},function(data){
               var data = data.data;
               for(var i=0;i<data.length;i++){
                 data[i].ctr_ct_finish_point = data[i].ctr_ct_finish*439;
               }
               scope.productBoxArr = data;
            })
        }
        scope.closeProductBoxFn = function(){
           scope.productBox = 0;
        }
        scope.runProductInfoFn = function(data){
          scope.productBox = 0;
          scope.showProductList(data)
          scope.showPromptBookFn();
        }
      }
    }
}]).directive('productPurchase', ['serviceUrl', '$rootScope',
  function(serviceUrl, $rootScope) {
    return {
      priority: 200,
      templateUrl:baseUrl + 'template/productPurchase.html',
      replace: true,
      restrict: 'A',
      scope: false,
      link: function postLink(scope, iElement, iAttrs) {
        scope.productPurchase = 0;
        scope.productPurchaseObj = {};
        $rootScope.$on('product.purchase.show', function(e, data) {
            scope.productPurchase = 1;
            scope.productPurchaseObj = data;
        });
        scope.closeproductPurchaseFn = function(){
           scope.productPurchase = 0;
        }
        scope.productPurchaseGet = function(){
            serviceUrl.doInvest({
                'id':scope.productPurchaseObj.push_id,
                'amt_ivs':scope.productPurchaseObj.push_amt_ivs,
                'cf_ctl_id':scope.productPurchaseObj.push_cf_ctl_id,
                'password':scope.productPurchaseObj.push_password,
                'type':scope.produceCategory.status,
                'ctl_ivs_cnt':scope.productPurchaseObj.push_ctl_ivs_cnt
            },{},function(data){
                scope.productPurchase = 0;
                var data = data.data;
                if(data.status ==  1){
                   scope.showProductDocFn(data.id);
                }else if(data.status == 0){
                   alerts.show(data.msg);
                }else if(data.status == '-1'){
                   alerts.show('业务员未登陆!');
                   window.location.href = '/Admin/common/login';
                }else if(data.status == '-2'){
                   alerts.show('客户未登陆!');
                   scope.closeProductListFn();
                   scope.showUserLogin();
                }
            })
        }
      }
    }
}]).directive('productDoc', ['serviceUrl', '$rootScope','$timeout',
  //签署模块 
  function(serviceUrl, $rootScope,$timeout) {
    return {
      priority: 200,
      templateUrl:baseUrl + 'template/productDoc.html',
      replace: true,
      restrict: 'A',
      scope: false,
      link: function postLink(scope, iElement, iAttrs) {
        scope.productDoc = 0;
        scope.productDocObj = {};
        $rootScope.$on('product.doc.show', function(e, data) {//data = 48;
            scope.productDoc = 1;
            serviceUrl.getThisDetail({
              'ivsid':data//data
            },{},function(data){
                var data = data.data.items;
                scope.productDocObj = data;

                $timeout(function(){
                  uploaderImg();
                },14);
            })
        });
        
        scope.closeproductDocFn = function(){
          scope.productDoc = 0;
        }
        scope.failproductDocFn = function(){
          confirms.show('确定放弃购买吗？',function(flag){
              if(flag){
                 serviceUrl.cancelInvest({
                    'id':scope.productDocObj.id
                 },{},function(data){
                    var data = data.data;
                    if(data.status == 1){
                      alerts.show(data.msg);
                      scope.productDoc = 0;
                    }else{
                      alerts.show(data.msg);
                    }
                 })
              }
           })
        }
        scope.productDocGetFn = function(){
          var reg = /^[a-zA-Z0-9]+$/ig;
          var reg_flag = reg.test(scope.productDocObj.pos_order);

          if(!scope.productDocObj.sales){
               alerts.show('销售经理必填！');
               return;
           }
           if(!scope.productDocObj.pos_order){
               alerts.show('POS单号必填！');
               return;
           }
           if(!reg_flag){
               alerts.show('POS单号必须为数字和字母！');
               return;
           }
           if(!scope.productDocObj.pos_file){
               alerts.show('请上传POS单扫描件！');
               return;
           }
           serviceUrl.finishInvest({
              'pos_order':scope.productDocObj.pos_order, 
              'id':scope.productDocObj.id,
              'sales':scope.productDocObj.sales
           },{},function(data){
              var data = data.data;
                scope.productDoc = 0;
                scope.productList = 0;
              if(data.status == 1){
                alerts.show(data.msg);
                scope.RefreshPursearchList(1);
              }else{
                alerts.show(data.msg);
              }
           })
        }
        function uploaderImg(){
          var uploaderCode = new WebUploader.create({
                auto: true,
                swf:baseUrl +'/images/desktop/Uploader.swf',
                server: '/Guest/Invest/purchaseUplodFile',
                pick: '#btnUploadImgs',
                duplicate:true, 
                formData:{'ivsid':scope.productDocObj.id},
                method :'POST',
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,png',
                    mimeTypes: 'image/*'
                }
          });
          uploaderCode.on( 'uploadError', function( file ) {
              alerts.show('上传失败');
          });
          uploaderCode.on( 'uploadSuccess', function( file , msg ){
              var data = msg.suc;
              if(msg.suc == 1){
                 alerts.show(msg.msg);
                 scope.productDocObj.pos_file = msg.file_url;

              }else{
                alerts.show(msg.msg);
                return;
              }
              scope.$apply();
          });
        }

      }
    }
}]).directive('productDocreset', ['serviceUrl', '$rootScope','$timeout',
  //签署模块 
  function(serviceUrl, $rootScope,$timeout) {
    return {
      priority: 200,
      templateUrl:baseUrl + 'template/productDoc_reset.html',
      replace: true,
      restrict: 'A',
      scope: false,
      link: function postLink(scope, iElement, iAttrs) {
        scope.productDoc_reset = 0;
        scope.productDocObj_reset = {};
        $rootScope.$on('product.doc_reset.show', function(e, data) {//data = 48;
            scope.productDoc_reset = 1;
            serviceUrl.getThisDetail({
              'ivsid':data//data
            },{},function(data){
                var data = data.data.items;
                scope.productDocObj_reset = data;

                $timeout(function(){
                  uploaderImg();
                },14);
            })
        });
        
        scope.closeproductDocFn_reset = function(){
          scope.productDoc_reset = 0;
        }
        scope.failproductDocFn_reset = function(){
           scope.productDoc_reset = 0;
        }
        scope.productDocGetFn_reset = function(){
          var reg = /^[a-zA-Z0-9]+$/ig;
          var reg_flag = reg.test(scope.productDocObj_reset.redemption_order);
          if(!scope.productDocObj_reset.redemption_sales){
               alerts.show('销售经理必填！');
               return;
           }
           if(!scope.productDocObj_reset.password){
               alerts.show('客户密码必填！');
               return;
           }
           if(!scope.productDocObj_reset.redemption_order){
               alerts.show('POS单号必填！');
               return;
           }
           if(!reg_flag){
               alerts.show('POS单号必须为数字和字母！');
               return;
           }
           if(!scope.productDocObj_reset.redemption_file){
               alerts.show('请上传POS单扫描件！');
               return;
           }
           serviceUrl.redemptionInvest({
              'redemption_order':scope.productDocObj_reset.redemption_order, 
              'id':scope.productDocObj_reset.id,
              'redemption_sales':scope.productDocObj_reset.redemption_sales,
              'password':scope.productDocObj_reset.password
           },{},function(data){
              var data = data.data;
                scope.productDoc_reset = 0;
                alerts.show(data.msg);
                scope.RefreshPursearchList(1);
           })
        }
        function uploaderImg(){
          var uploaderCode = new WebUploader.create({
                auto: true,
                swf:baseUrl +'/images/desktop/Uploader.swf',
                server: '/Guest/Invest/purchaseUplodFile',
                pick: '#btnUploadImgs',
                duplicate:true, 
                formData:{'ivsid':scope.productDocObj_reset.id},
                method :'POST',
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,png',
                    mimeTypes: 'image/*'
                }
          });
          uploaderCode.on( 'uploadError', function( file ) {
              alerts.show('上传失败');
          });
          uploaderCode.on( 'uploadSuccess', function( file , msg ){
              var data = msg.suc;
              if(msg.suc == 1){
                 alerts.show(msg.msg);
                 scope.productDocObj_reset.redemption_file = msg.file_url;

              }else{
                alerts.show(msg.msg);
                return;
              }
              scope.$apply();
          });
        }

      }
    }
}]).directive('tmPagination',[function(){
    return {
        restrict: 'EA',
        template: '<div class="page-list">' +
            '<ul class="pagination" ng-show="conf.totalItems > 0">' +
            '<li ng-class="{disabled: conf.currentPage == 1}" ng-click="prevPage()"><span>&laquo;</span></li>' +
            '<li ng-repeat="item in pageList track by $index" ng-class="{active: item == conf.currentPage, separate: item == \'...\'}" ' +
            'ng-click="changeCurrentPage(item)">' +
            '<span>{{ item }}</span>' +
            '</li>' +
            '<li ng-class="{disabled: conf.currentPage == conf.numberOfPages}" ng-click="nextPage()"><span>&raquo;</span></li>' +
            '</ul>' +
            '<div class="page-total" ng-show="conf.totalItems > 0">' +
            '第<input type="text" ng-model="jumpPageNum"  ng-keyup="jumpToPage($event)"/>页 ' +
            '每页<select ng-model="conf.itemsPerPage" ng-options="option for option in conf.perPageOptions " ng-change="changeItemsPerPage()"></select>' +
            '/共<strong>{{ conf.totalItems }}</strong>条' +
            '</div>' +
            '<div class="no-items" ng-show="conf.totalItems <= 0">暂无数据</div>' +
            '</div>',
        replace: true,
        scope: {
            conf: '='
        },
        link: function(scope, element, attrs){

            // 变更当前页
            scope.changeCurrentPage = function(item){
                if(item == '...'){
                    return;
                }else{
                    scope.conf.currentPage = item;
                }
            };

            // 定义分页的长度必须为奇数 (default:9)
            scope.conf.pagesLength = parseInt(scope.conf.pagesLength) ? parseInt(scope.conf.pagesLength) : 9 ;
            if(scope.conf.pagesLength % 2 === 0){
                // 如果不是奇数的时候处理一下
                scope.conf.pagesLength = scope.conf.pagesLength -1;
            }

            // conf.erPageOptions
            if(!scope.conf.perPageOptions){
                scope.conf.perPageOptions = [10, 15, 20, 30, 50];
            }

            // pageList数组
            function getPagination(){
                // conf.currentPage
                scope.conf.currentPage = parseInt(scope.conf.currentPage) ? parseInt(scope.conf.currentPage) : 1;
                // conf.totalItems
                scope.conf.totalItems = parseInt(scope.conf.totalItems);

                // conf.itemsPerPage (default:15)
                // 先判断一下本地存储中有没有这个值
                if(scope.conf.rememberPerPage){
                    if(!parseInt(localStorage[scope.conf.rememberPerPage])){
                        localStorage[scope.conf.rememberPerPage] = parseInt(scope.conf.itemsPerPage) ? parseInt(scope.conf.itemsPerPage) : 15;
                    }

                    scope.conf.itemsPerPage = parseInt(localStorage[scope.conf.rememberPerPage]);


                }else{
                    scope.conf.itemsPerPage = parseInt(scope.conf.itemsPerPage) ? parseInt(scope.conf.itemsPerPage) : 15;
                }

                // numberOfPages
                scope.conf.numberOfPages = Math.ceil(scope.conf.totalItems/scope.conf.itemsPerPage);

                // judge currentPage > scope.numberOfPages
                if(scope.conf.currentPage < 1){
                    scope.conf.currentPage = 1;
                }

                if(scope.conf.currentPage > scope.conf.numberOfPages){
                    scope.conf.currentPage = scope.conf.numberOfPages;
                }

                // jumpPageNum
                scope.jumpPageNum = scope.conf.currentPage;

                // 如果itemsPerPage在不在perPageOptions数组中，就把itemsPerPage加入这个数组中
                var perPageOptionsLength = scope.conf.perPageOptions.length;
                // 定义状态
                var perPageOptionsStatus;
                for(var i = 0; i < perPageOptionsLength; i++){
                    if(scope.conf.perPageOptions[i] == scope.conf.itemsPerPage){
                        perPageOptionsStatus = true;
                    }
                }
                // 如果itemsPerPage在不在perPageOptions数组中，就把itemsPerPage加入这个数组中
                if(!perPageOptionsStatus){
                    scope.conf.perPageOptions.push(scope.conf.itemsPerPage);
                }

                // 对选项进行sort
                scope.conf.perPageOptions.sort(function(a, b){return a-b});

                scope.pageList = [];
                if(scope.conf.numberOfPages <= scope.conf.pagesLength){
                    // 判断总页数如果小于等于分页的长度，若小于则直接显示
                    for(i =1; i <= scope.conf.numberOfPages; i++){
                        scope.pageList.push(i);
                    }
                }else{
                    // 总页数大于分页长度（此时分为三种情况：1.左边没有...2.右边没有...3.左右都有...）
                    // 计算中心偏移量
                    var offset = (scope.conf.pagesLength - 1)/2;
                    if(scope.conf.currentPage <= offset){
                        // 左边没有...
                        for(i =1; i <= offset +1; i++){
                            scope.pageList.push(i);
                        }
                        scope.pageList.push('...');
                        scope.pageList.push(scope.conf.numberOfPages);
                    }else if(scope.conf.currentPage > scope.conf.numberOfPages - offset){
                        scope.pageList.push(1);
                        scope.pageList.push('...');
                        for(i = offset + 1; i >= 1; i--){
                            scope.pageList.push(scope.conf.numberOfPages - i);
                        }
                        scope.pageList.push(scope.conf.numberOfPages);
                    }else{
                        // 最后一种情况，两边都有...
                        scope.pageList.push(1);
                        scope.pageList.push('...');

                        for(i = Math.ceil(offset/2) ; i >= 1; i--){
                            scope.pageList.push(scope.conf.currentPage - i);
                        }
                        scope.pageList.push(scope.conf.currentPage);
                        for(i = 1; i <= offset/2; i++){
                            scope.pageList.push(scope.conf.currentPage + i);
                        }

                        scope.pageList.push('...');
                        scope.pageList.push(scope.conf.numberOfPages);
                    }
                }

                if(scope.conf.onChange){
                    scope.conf.onChange();
                }
                scope.$parent.conf = scope.conf;
            }

            // prevPage
            scope.prevPage = function(){
                if(scope.conf.currentPage > 1){
                    scope.conf.currentPage -= 1;
                }
            };
            // nextPage
            scope.nextPage = function(){
                if(scope.conf.currentPage < scope.conf.numberOfPages){
                    scope.conf.currentPage += 1;
                }
            };

            // 跳转页
            scope.jumpToPage = function(){
                scope.jumpPageNum = scope.jumpPageNum.replace(/[^0-9]/g,'');
                if(scope.jumpPageNum !== ''){
                    scope.conf.currentPage = scope.jumpPageNum;
                }
            };

            // 修改每页显示的条数
            scope.changeItemsPerPage = function(){
                // 清除本地存储的值方便重新设置
                if(scope.conf.rememberPerPage){
                    localStorage.removeItem(scope.conf.rememberPerPage);
                }
            };

            scope.$watch(function(){
                var newValue = scope.conf.currentPage + ' ' + scope.conf.totalItems + ' ';
                // 如果直接watch perPage变化的时候，因为记住功能的原因，所以一开始可能调用两次。
                //所以用了如下方式处理
                if(scope.conf.rememberPerPage){
                    // 由于记住的时候需要特别处理一下，不然可能造成反复请求
                    // 之所以不监控localStorage[scope.conf.rememberPerPage]是因为在删除的时候会undefind
                    // 然后又一次请求
                    if(localStorage[scope.conf.rememberPerPage]){
                        newValue += localStorage[scope.conf.rememberPerPage];
                    }else{
                        newValue += scope.conf.itemsPerPage;
                    }
                }else{
                    newValue += scope.conf.itemsPerPage;
                }
                return newValue;

            }, getPagination);

        }
    };
}]).directive('managePurchase', ['serviceUrl', '$rootScope','$timeout',
  function(serviceUrl, $rootScope,$timeout) {
    return {
      priority: 200,
      templateUrl:baseUrl + 'template/managePurchase.html',
      replace: true,
      restrict: 'A',
      scope: false,
      link: function postLink(scope, iElement, iAttrs) {
        var dereg;
        scope.managePurchase = 0;
        scope.mPurIteams = [];
        scope.mPurTimeNode = [{
            'id':0,
            'name':'不限'
          },{
            'id':1,
            'name':'10分钟内'
          },{
            'id':2,
            'name':'30分钟内'
          },{
            'id':3,
            'name':'1小时内'
          },{
            'id':4,
            'name':'1天内'
          },{
            'id':5,
            'name':'1天以上'
          }
        ];
        scope.mPurStatusNode = [{
          'id':-999,
          'name':'不限'
        },{
          'id':-1,
          'name':'已作废'
        },{
          'id':0,
          'name':'待确认'
        },{
          'id':1,
          'name':'已完成'
        },{
          'id':2,
          'name':'已赎回'
        }]
        scope.mPurdataTimeList = {};
        scope.mPurdataTimeList.mPurTimeNodeCurrent = 0;
        scope.mPurdataTimeList.mPurStatusNodeCurrent = -999;
        $rootScope.$on('manage.purchase.show', function(e, data) {
            init();
        });
        function init(datas){
          scope.managePurchase = 1;
            $timeout(function(){
              $(".form_datetime3").datetimepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                language :'zh-CN',
                minView:3
              }).on("hide",function(){
                 var $this = $(this);
                 var _this = this;
                 scope.mPurdataTimeList.start = _this.value;
              });
              $(".form_datetime4").datetimepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                language :'zh-CN',
                minView:3
              }).on("hide",function(){
                 var $this = $(this);
                 var _this = this;
                 scope.mPurdataTimeList.end = _this.value;
              });
            },14);
            if(datas != 1){
               scope.paginationConf = {
                    currentPage: 1,
                    itemsPerPage: 10,
                    pagesLength: 15,
                    perPageOptions: [10, 20, 50, 100]
                }
            }
            
            
            dereg = scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage',function(){
              if(scope.managePurchase != 1){
                 return;
              }
                mPurcommonAjax({ 
                  'page':scope.paginationConf.currentPage,
                  'limit':scope.paginationConf.itemsPerPage,
                  'status':scope.mPurdataTimeList.mPurStatusNodeCurrent,
                  'keyword':scope.mPurdataTimeList.keywordText?scope.mPurdataTimeList.keywordText:'',
                  'date_cls':scope.mPurdataTimeList.mPurTimeNodeCurrent
                })
            });
        }
        function mPurcommonAjax(data){
           serviceUrl.myivs_dnf(data,{},function(data){
                var data = data.data;
                scope.paginationConf.totalItems = data.total;
                scope.mPurIteams = data.items;
            })
        }
        scope.closemPurchaseFn = function(){
           scope.managePurchase = 0;
           dereg();
        }
        scope.mPurTimes =function(data){
          dereg();
          scope.mPurdataTimeList.mPurTimeNodeCurrent = data;
          scope.mPurdataTimeList.keywordText = '';
          init(1);
        }
        scope.mPurStatus =function(data){
            dereg();
            scope.mPurdataTimeList.mPurStatusNodeCurrent = data;
            scope.mPurdataTimeList.keywordText = '';
            init(1);
        }
        // scope.mPurchangeSelectFn = function(data){
        //   mPurcommonAjax({ 
        //       'page':scope.paginationConf.currentPage,
        //       'limit':scope.paginationConf.itemsPerPage,
        //       'date_cls':data
        //    })
        // }
        // scope.mPurscreenFn = function(){
        //   if(!scope.mPurdataTimeList.start || !scope.mPurdataTimeList.end){
        //       alerts.show('起止时间不能为空！');
        //       return;
        //   }
        //   mPurcommonAjax({ 
        //       'b_time':scope.mPurdataTimeList.start,
        //       'e_time':scope.mPurdataTimeList.end
        //    })
        // }
        scope.mPursearchListFn = function(){
           dereg();
           init();
        }
        scope.mPurfinishInvestFn = function(id){
           scope.showProductDocFn(id);
           scope.RefreshPursearchList = function(data){
              dereg();
              if(data == 1&&scope.managePurchase == 1){
                  mPurcommonAjax({ 
                    'page':scope.paginationConf.currentPage,
                    'limit':scope.paginationConf.itemsPerPage,
                    'status':scope.mPurdataTimeList.mPurStatusNodeCurrent,
                    'keyword':scope.mPurdataTimeList.keywordText?scope.mPurdataTimeList.keywordText:'',
                    'date_cls':scope.mPurdataTimeList.mPurTimeNodeCurrent
                  })
              }
              init(1);
           };
           // serviceUrl.finishInvest({
           //    'pos_order':pos, 
           //    'id':id
           // },{},function(data){
           //    var data = data.data;
           //    if(data.status == 1){
           //      alerts.show(data.msg);
           //      scope.managePurchase = 0;
           //    }else{
           //      alerts.show(data.msg);
           //    }
           // })
        }
        scope.mPurcancelInvestFn = function(id){
           confirms.show('确定放弃购买吗？',function(flag){
              if(flag){
                 serviceUrl.cancelInvest({
                    'id':id
                 },{},function(data){
                    var data = data.data;
                    if(data.status == 1){
                      alerts.show(data.msg);
                      dereg();
                      mPurcommonAjax({ 
                        'page':scope.paginationConf.currentPage,
                        'limit':scope.paginationConf.itemsPerPage,
                        'status':scope.mPurdataTimeList.mPurStatusNodeCurrent,
                        'keyword':scope.mPurdataTimeList.keywordText?scope.mPurdataTimeList.keywordText:'',
                        'date_cls':scope.mPurdataTimeList.mPurTimeNodeCurrent
                      });
                      init(1);
                    }else{
                      alerts.show(data.msg);
                    }
                 })
              }
           })
        }
        scope.mPurredemptionInvestFn = function(id){
          scope.showProductDocFn_reset(id);
           scope.RefreshPursearchList = function(data){
              dereg();
              if(data == 1&&scope.managePurchase == 1){
                  mPurcommonAjax({ 
                    'page':scope.paginationConf.currentPage,
                    'limit':scope.paginationConf.itemsPerPage,
                    'status':scope.mPurdataTimeList.mPurStatusNodeCurrent,
                    'keyword':scope.mPurdataTimeList.keywordText?scope.mPurdataTimeList.keywordText:'',
                    'date_cls':scope.mPurdataTimeList.mPurTimeNodeCurrent
                  })
              }
              init(1);
           };
        }
      }
    }
}]).directive('manageRight', ['serviceUrl', '$rootScope','$timeout',
  function(serviceUrl, $rootScope,$timeout) {
    return {
      priority: 200,
      templateUrl:baseUrl + 'template/manageRight.html',
      replace: true,
      restrict: 'A',
      scope: false,
      link: function postLink(scope, iElement, iAttrs) {
        var dereg;
        scope.manageRight = 0;
        scope.mRigIteams = [];
        scope.mRigTimeNode = [{
            'id':0,
            'name':'不限'
          },{
            'id':1,
            'name':'一周内'
          },{
            'id':2,
            'name':'一月内'
          },{
            'id':3,
            'name':'三月内'
          },{
            'id':4,
            'name':'三月以上'
          }
        ];
        scope.mRigStatusNode = [{
          'id':-999,
          'name':'不限'
        },{
          'id':0,
          'name':'待确权'
        },{
          'id':1,
          'name':'确权中'
        },{
          'id':2,
          'name':'确权成功'
        },{
          'id':3,
          'name':'确权失败'
        }]
        scope.mRigdataTimeList = {};
        scope.mRigdataTimeList.mRigTimeNodeCurrent = 0;
        scope.mRigdataTimeList.mRigStatusNodeCurrent =-999;
        $rootScope.$on('manage.right.show', function(e, data) {
            init();
        });
        function init(datas){
          scope.manageRight = 1;
            $timeout(function(){
              $(".form_datetime5").datetimepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                language :'zh-CN',
                minView:3
              }).on("hide",function(){
                 var $this = $(this);
                 var _this = this;
                 scope.mRigdataTimeList.start = _this.value;
              });
              $(".form_datetime6").datetimepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                language :'zh-CN',
                minView:3
              }).on("hide",function(){
                 var $this = $(this);
                 var _this = this;
                 scope.mRigdataTimeList.end = _this.value;
              });
            },14);
            if(datas != 1){
               scope.paginationConf = {
                  currentPage: 1,
                  itemsPerPage: 10,
                  pagesLength: 15,
                  perPageOptions: [10, 20, 50, 100]
              }
            }
            
            dereg = scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', function(){
              if(scope.manageRight != 1){
                 return;
              }
              mRigcommonAjax({ 
                'page':scope.paginationConf.currentPage,
                'limit':scope.paginationConf.itemsPerPage,
                'status':scope.mRigdataTimeList.mRigStatusNodeCurrent,
                'keyword':scope.mRigdataTimeList.keywordText?scope.mRigdataTimeList.keywordText:'',
                'date_cls':scope.mRigdataTimeList.mRigTimeNodeCurrent
              })
            });
        }
        function mRigcommonAjax(data){
           serviceUrl.clivslist(data,{},function(data){
                var data = data.data;
                scope.paginationConf.totalItems = data.total;
                scope.mRigIteams = data.items;
            })
        }
        scope.closemRigchaseFn = function(){
           scope.manageRight = 0;
           dereg();
        }
        scope.mRigTimes =function(data){
            dereg();
            scope.mRigdataTimeList.mRigTimeNodeCurrent = data;
            scope.mRigdataTimeList.keywordText = '';
            init(1);
        }
        scope.mRigStatus =function(data){
            dereg();
            scope.mRigdataTimeList.mRigStatusNodeCurrent = data;
            scope.mRigdataTimeList.keywordText = '';
            init(1);
        }
        // scope.mRigchangeSelectFn = function(data){
        //   scope.paginationConf = {
        //       currentPage: 1,
        //       itemsPerPage: 10,
        //       pagesLength: 15,
        //       perPageOptions: [10, 20, 50, 100],
        //       onChange: function(){

        //       }
        //   }
        //    mRigcommonAjax({ 
        //       'page':scope.paginationConf.currentPage,
        //       'limit':scope.paginationConf.itemsPerPage,
        //       'date_cls':data
        //    })
        // }
        // scope.mRigscreenFn = function(){
        //   if(!scope.mRigdataTimeList.start || !scope.mRigdataTimeList.end){
        //       alerts.show('起止时间不能为空！');
        //       return;
        //   }
        //   scope.paginationConf = {
        //       currentPage: 1,
        //       itemsPerPage: 10,
        //       pagesLength: 15,
        //       perPageOptions: [10, 20, 50, 100],
        //       onChange: function(){
                
        //       }
        //   }
        //    mRigcommonAjax({ 
        //       'starttime':scope.mRigdataTimeList.start,
        //       'stoptime':scope.mRigdataTimeList.end
        //    })
        // }
        scope.mRigsearchListFn = function(){
           dereg();
           init();
        }
        scope.mRigfinishInvestFn = function(pos,id){
           serviceUrl.finishInvest({
              'pos_order':pos, 
              'id':id
           },{},function(data){
              var data = data.data;
              if(data.status == 1){
                alerts.show(data.msg);
                dereg();
                mRigcommonAjax({ 
                  'page':scope.paginationConf.currentPage,
                  'limit':scope.paginationConf.itemsPerPage,
                  'status':scope.mRigdataTimeList.mRigStatusNodeCurrent,
                  'keyword':scope.mRigdataTimeList.keywordText?scope.mRigdataTimeList.keywordText:'',
                  'date_cls':scope.mRigdataTimeList.mRigTimeNodeCurrent
                });
                init(1);
              }else{
                alerts.show(data.msg);
              }
           })
        }
        scope.mRigcancelInvestFn = function(id){
           serviceUrl.cancelInvest({
              'id':id
           },{},function(data){
              var data = data.data;
              if(data.status == 1){
                alerts.show(data.msg);
                dereg();
                mRigcommonAjax({ 
                  'page':scope.paginationConf.currentPage,
                  'limit':scope.paginationConf.itemsPerPage,
                  'status':scope.mRigdataTimeList.mRigStatusNodeCurrent,
                  'keyword':scope.mRigdataTimeList.keywordText?scope.mRigdataTimeList.keywordText:'',
                  'date_cls':scope.mRigdataTimeList.mRigTimeNodeCurrent
                });
                init(1);
              }else{
                alerts.show(data.msg);
              }
           })
        }
        scope.againRightFn = function(id){
            confirms.show('是否确认提交重新确权？',function(flag){
              if(flag){
                 serviceUrl.restartIvsRight({
                    'ivsid':id
                 },function(data){
                    var data = data.data;
                    if(data.status != 0){
                      alerts.show(data.msg);
                      dereg();
                      mRigcommonAjax({ 
                        'page':scope.paginationConf.currentPage,
                        'limit':scope.paginationConf.itemsPerPage,
                        'status':scope.mRigdataTimeList.mRigStatusNodeCurrent,
                        'keyword':scope.mRigdataTimeList.keywordText?scope.mRigdataTimeList.keywordText:'',
                        'date_cls':scope.mRigdataTimeList.mRigTimeNodeCurrent
                      });
                      init(1);
                    }else{
                       alerts.show(data.msg);
                    }
                 })
              }
           })
        }
      }
    }
}]).directive('setPerson', ['serviceUrl', '$rootScope',
  function(serviceUrl, $rootScope) {
    return {
      priority: 200,
      templateUrl:baseUrl + 'template/setPerson.html',
      replace: true,
      restrict: 'A',
      scope:  false,
      link: function postLink(scope, iElement, iAttrs) {
        scope.setPerson = 0;
        $rootScope.$on('set.person.show', function(e, data) {
          scope.role = {};
          scope.setPerson = 1;
          scope.userPersonList = {};
        });
        scope.closesetPersonFn = function(){
          scope.setPerson = 0;
        }
        scope.passwordRole = function(event){
          var flag = event.target.value;
          var status = verificationRule.isPassword(flag);
           switch(status){
              case 'role_one':
                scope.role = {};
                scope.role.role_one = 1;
                break;
              case 'role_two':
                scope.role = {};
                scope.role.role_two = 1;
                break;
              case 'role_three':
                scope.role = {};
                scope.role.role_three = 1;
                break;
              default:
                scope.role = {};
                break;
           }
        }
        scope.setPersonFn = function(){
           if(!scope.userPersonList.nam_cust_real){
               alerts.show('客户姓名不能为空');
               return;
           }
           if(!verificationRule.isChinese(scope.userPersonList.nam_cust_real)){
            alerts.show('客户姓名不符合规则！')
            return;
           }

           if(!scope.userPersonList.cod_cust_id_no){
              alerts.show('身份证号不能为空');
               return;
           }
           if(!verificationRule.isCardNum(scope.userPersonList.cod_cust_id_no)){
            alerts.show('身份证号不符合规则！')
            return;
           }

           if(!scope.userPersonList.newpwd){
              alerts.show('新密码不能为空');
               return;
           }
           if(scope.userPersonList.newpwd.length < 6){
              alerts.show('新密码必须大于6位！')
              return;
           }
           if(!scope.userPersonList.newpwd2){
              alerts.show('确认新密码不能为空');
               return;
           }
           if(scope.userPersonList.newpwd2 != scope.userPersonList.newpwd){
              alerts.show('两次输入密码不一致');
               return;
           }
           serviceUrl.userModifypwd({
              nam_cust_real:scope.userPersonList.nam_cust_real,
              cod_cust_id_no:scope.userPersonList.cod_cust_id_no,
              newpwd:scope.userPersonList.newpwd,
              newpwd2:scope.userPersonList.newpwd2,
           },{},function(data){
              var data = data.data;
              alerts.show(data.msg);
           })
        }
      }
    }
}]).directive('setMyself', ['serviceUrl', '$rootScope',
  function(serviceUrl, $rootScope) {
    return {
      priority: 200,
      templateUrl:baseUrl + 'template/setMyself.html',
      replace: true,
      restrict: 'A',
      scope:  false,
      link: function postLink(scope, iElement, iAttrs) {
        scope.setMyself = 0;
        $rootScope.$on('set.myself.show', function(e, data) {
          scope.role = {};
          scope.setMyself = 1;
          scope.setMyselfList = {};
        });
        scope.closesetMyselfFn = function(){
          scope.setMyself = 0;
        }
        scope.passwordRole = function(event){
          var flag = event.target.value;
          var status = verificationRule.isPassword(flag);
           switch(status){
              case 'role_one':
                scope.role = {};
                scope.role.role_one = 1;
                break;
              case 'role_two':
                scope.role = {};
                scope.role.role_two = 1;
                break;
              case 'role_three':
                scope.role = {};
                scope.role.role_three = 1;
                break;
              default:
                scope.role = {};
                break;
           }
        }
        scope.setMyselfFn = function(){
           if(!scope.setMyselfList.old_password){
              alerts.show('当前密码不能为空');
              return;
           }
           if(!scope.setMyselfList.new_password){
              alerts.show('新密码不能为空');
              return;
           }
           if(scope.setMyselfList.new_password.length < 6){
              alerts.show('新密码必须大于6位！')
              return;
           }
           if(!scope.setMyselfList.new_passwordc){
              alerts.show('确认新密码不能为空');
              return;
           }
           if(scope.setMyselfList.new_password != scope.setMyselfList.new_passwordc){
              alerts.show('两次输入密码不一致');
              return;
           }
           serviceUrl.updateSelfPassword({
              old_password:scope.setMyselfList.old_password,
              new_password:scope.setMyselfList.new_password,
              new_passwordc:scope.setMyselfList.new_passwordc,
           },{},function(data){
              var data = data.data;
              alerts.show(data.msg);
           })
        }
 
      }
    }
}]).directive('investRecord', ['serviceUrl', '$rootScope',
  function(serviceUrl, $rootScope) {
    return {
      priority: 200,
      templateUrl:baseUrl + 'template/investRecord.html',
      replace: true,
      restrict: 'A',
      scope:  false,
      link: function postLink(scope, iElement, iAttrs) {
        scope.investRecord = 0;
        $rootScope.$on('invest.record.show', function(e, data) {
          scope.investRecord = 1;
          scope.investRecordListArr = [];
          serviceUrl.getThisRecord({
            'cfid':data.cfid,
            'ctlid':data.ctlid
          },{},function(data){
             scope.investRecordListArr = data.data.items;
          })
        });
        scope.closeinvestRecordFn = function(){
          scope.investRecord = 0;
        }

 
      }
    }
}]).directive('speedRight', ['serviceUrl', '$rootScope',
  function(serviceUrl, $rootScope) {
    return {
      priority: 200,
      templateUrl:baseUrl + 'template/speedRight.html',
      replace: true,
      restrict: 'A',
      scope:  false,
      link: function postLink(scope, iElement, iAttrs) {
        scope.speedRight = 0;
        $rootScope.$on('speed.right.show', function(e, data) {
          scope.speedRightArr = [];
          scope.speedRight = 1;
          serviceUrl.getRightSchedule({
            'right_id':data
          },{},function(data){
              scope.speedRightArr = data.data.items;
          })
        });
        scope.closespeedRightFn = function(){
          scope.speedRight = 0;
        }

 
      }
    }
}]).directive('productSelect', ['serviceUrl', '$rootScope',
  function(serviceUrl, $rootScope) {
    return {
      priority: 200,
      templateUrl:baseUrl + 'template/productSelect.html',
      replace: true,
      restrict: 'A',
      scope:  false,
      link: function postLink(scope, iElement, iAttrs) {
        scope.productSelect = 0;
        $rootScope.$on('product.select.show', function(e, data) {
          scope.productSelectArr = [];
          scope.productSelect = 1;
          serviceUrl.getCapitalpool({},{},function(data){
             scope.productSelectArr = data.data;
          })

        });
                  
        
        scope.closeproductSelectFn = function(){
          scope.productSelect = 0;
        }
        scope.productSelectFn = function(data){
            scope.showProductBox(data);
            scope.productSelect = 0;
        }
      }
    }
}]).directive('promptBook', ['serviceUrl', '$rootScope',
  function(serviceUrl, $rootScope) {
    return {
      priority: 200,
      templateUrl:baseUrl + 'template/promptBook.html',
      replace: true,
      restrict: 'A',
      scope:  false,
      link: function postLink(scope, iElement, iAttrs) {
        scope.promptBook = 0;
        $rootScope.$on('prompt.book.show', function(e, data) {
          scope.promptBook = 1;
        });
                  
        

        scope.resetpromptBookFn = function(){
          scope.promptBook = 0;
          scope.showProductBox({
            investment_type:undefined,
            capitalid:undefined
          });
        }
        scope.agreepromptBookFn =function(){
           scope.promptBook = 0;
        }
      }
    }
}]).filter('addNumberData',function(){
    return function(inputArray){
       var reg = /^[1-9]\d*$/;
       var editData = 0;
       var flag = reg.test(inputArray);
       if(flag){
          editData = parseFloat(inputArray).toLocaleString() + '.00'
       }else{
         editData='0.00';
       }
       return editData;
    }
}).filter('addNumberData2',function(){
    return function(inputArray){
          return parseFloat(inputArray).toLocaleString() + '.00';
    }
}).filter('divide100',function(){
    return function(data){
          return data/100;
    }
}).filter('trustAsHtml', ['$sce', function ($sce) {
  return function (text) {
      return $sce.trustAsHtml(text);
  }
}]).filter('delFont', [ function () {
  return function (text) {
      return text?text.replace(/font/,'del'):'';
  }
}]);



