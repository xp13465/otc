/**
 * Created by Administrator on 2015/12/7 0007.
 */

Ext.define('ui.ctrl.investmentproductaudit.investmentproductauditCtrl', {
    extend: 'ui.extend.baseClass.baseCtrl',
    requires : [
        'ui.ctrl.investmentproductaudit.investmentproductauditConf',
        'ui.view.investmentproductaudit.investmentproductauditView',
        'ui.view.investmentproductaudit.Coms.viewPanel'
    ],
    views : [
        'ui.view.investmentproductaudit.investmentproductauditView'
    ],

    refs:[
        {ref:'investmentproductauditWin' , selector:'investmentproductauditwindow'}
    ],

    constructor : function (cfg){
        this.modelConf = Ext.create('ui.ctrl.investmentproductaudit.investmentproductauditConf');
        this.callParent(arguments);
    },

    init:function(){
        this.control({      //这里的this相当于这个控制层
            'investmentproductauditpagecentergrid' : {
                render : function(e){
                    //e.grid.getStore().load();
                }
            }
        });
    },

    //配置功能按钮功能  对应Conf类中定义的operationButtons > pmsCode { text : '新建角色+' , pmsCode : 'investmentproductaudit.add' }
    //‘.’替换为 $  ,方法前加__
    __investmentproductaudit$add : function( btna , params ){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        if(!pmsCode) return;
        me.$showOptionsPanel('add', pmsCode ,function(panel ,win){
            //这里对panel进行处理
        });
    },
    __investmentproductaudit$cexiao : function( btna , params ){
        var me = this;
        // params = me.$getArrayOne(params);
        var ids=[];
        var records=me.$getGridSelections();
        var postParams={id:''};
        var validateFlag=true;
        Ext.each(records,function(item){
            if(item.data.status=='1'){
                Ext.Msg.show({
                    title : '失败',
                    msg  : '节点不是无效状态！',
                    icon: Ext.Msg.ERROR,
                });
                validateFlag=false;
                return false;
            }else{
                ids.push(item.data.id);
            }
            
        });
        postParams.id=ids.join();
        // postParams.status=3;
       
        if(validateFlag){
            me.$askYestNo({
                msg : '确认删除吗',
                yes : function(){
                    me.$requestAjax({
                        url     :   me.$getUrlstrByUrlcode('set.investmentproductaudit.delete'),
                        method :    'POST',
                        params :    postParams,
                        scope  :    me,
                        backParams: {},
                        callback   :    function(response , backParams){
                            //console.log(response.responseText);
                            var param = Ext.decode(response.responseText);
                            if(param.status > 0){
                                Ext.MessageBox.alert('成功','删除成功！');
                                me.$reloadViewGrid();
                            }
                        }
                    });
                }
            });
        }
        
    },
    __investmentproductaudit$delete : function( btna , params ){
        var me = this;
        params = me.$getArrayOne(params);
        // if(params.status == 1){
        //     Ext.Msg.show({
        //         title : '失败',
        //         msg  : '节点不是无效状态！',
        //         icon: Ext.Msg.ERROR,
        //     });
        //     return;
        // }
        // params.status = 3;
        me.$askYestNo({
            msg : '确认删除吗',
            yes : function(){
                me.$requestAjax({
                    url     :   me.$getUrlstrByUrlcode('set.investmentproductaudit.delete'),
                    method :    'POST',
                    params :    params,
                    scope  :    me,
                    backParams: {},
                    callback   :    function(response , backParams){
                        //console.log(response.responseText);
                        var param = Ext.decode(response.responseText);
                        if(param.status > 0){
                            Ext.MessageBox.alert('成功','删除成功！');
                            me.$reloadViewGrid();
                        }
                    }
                });
            }
        });
    },
    //listbtn  list的处理按钮事件，方法名前 加 '__'  ，根据权限pmscode指定方法名， .更换为$...方法前加__
    __investmentproductaudit$view : function( btna , params ){
        // var me = this;
        // var view = this.$getView();
        // Ext.apply(params,{callback: function(panel,win){
        //     //me.$addWindowToFather(win);
        // }});
        // this.$fireModuleEvents('investmentproductadd','view',params);
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        if(!pmsCode) return;
        var param  = params || {};
        Ext.apply( param , { pmsCode : pmsCode} );

        me.$showOptionsPanel('view', param ,function( panel ,win ){
            //这里对panel进行处理
            var clsname = "ui.ctrl.assetpackagelist.assetpackagelistCtrl";
             Ext.Loader.require([
                clsname
            ],function(d){
                var modelX = Ext.create(clsname , {ctrl : me});
                modelX.modelConf._listParams.cf_mast_id=param.id;
                // console.log('a'+modelX.modelConf._listParams.cod_cl_id);
                var viewPanel= modelX.createViewByModule('assetpackagelist');
                viewPanel.bodyBorder=false;
                // console.log(viewPanel);
               // panel.formsList[1].removeAll();
               panel.formsList[1].add(viewPanel);
               panel.doLayout();
               
            },this);
        });
    },

    __investmentproductaudit$edit : function( btna , params ){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        if(!pmsCode) return;
        var param  = params || {};
        Ext.apply( param , { pmsCode : pmsCode} );

        me.$showOptionsPanel('edit', param ,function( panel ,win ){
            //这里对panel进行处理
        });
    },
    __investmentproductaudit$upload : function( btna , params ){
        var me = this;
        //getUserUploadContract
        var otc_code='';

        var theDocspanel = Ext.create("ui.extend.base.Panel",{
            border : 0 ,
            columnWidth :1 ,
            myStamp : 'theDocsList',
            layout : 'column',
            items : []
        });
        
        me.$requestAjax({
            url : me.$getConfig('urls').get('get.investmentproductaudit.getfiles').url,
            method : "POST",
            params : {
                cfid: params.id
            },
            scope : me ,
            backParams: {} ,
            callback : function(response , backParams){
                
                var param = Ext.decode(response.responseText);
                otc_code=param.code;
                codeText.setValue(otc_code);
                // console.log(param);
                if(param.items.length>0){
                    me.__sub_showuploadlist_panel(param , theDocspanel ,params);
                }
            }
        });
        var codeText=Ext.create("Ext.form.field.Text",{
            name: 'code',
            id:'otc_code',
            fieldLabel: 'OTC产品代码',
            value:''

        })
        var otcpanel = Ext.create("ui.extend.base.Panel" , {
            border : 0 ,
            columnWidth :1 ,
            margin : 10 ,
            layout : 'column',
            items : [codeText]
        });
        // theDocspanel.items.add(otcpanel);
        var uploadPanel = Ext.create( "ui.extend.base.Form",{
            columnWidth :1,
            layout : 'column',
            border :  0,
            padding : 10,
            styleHtmlCls : 'fileuploadfieldclass',
            // code:codeText,
            styleHtmlContent : true,
            items : [{
                xtype: 'filefield',
                buttonConfig : {
                    text : '选择附件'
                },
                name: 'file',
                columnWidth:.9,
                border : 0 ,
                blankText: '请上传文件',
                listeners:{
                    "change" : function( field, str , eOpts ){
                        field.nextSibling().enable();
                    }
                },
                anchor : '100%'
            },{
                xtype : 'button',
                columnWidth:.15,
                margin : "0 5" ,
                text : '保存' ,
                // disabled : true ,
                handler : function(btn){
                    // console.log(this.code);
                    uploadPanel.getForm().submit({
                        url: me.$getConfig('urls').get('set.investmentproductaudit.upload').url , //'../Product/productAddContract',
                        params: {
                            cf_id: params.id,
                            code:Ext.getCmp('otc_code').getValue()
                        },
                        success: function(form, action){
                            me.$requestAjax({
                                url : me.$getConfig('urls').get('get.investmentproductaudit.getfiles').url,
                                method : "POST",
                                params : {
                                    cfid: params.id
                                },
                                scope : me ,
                                backParams: {} ,
                                callback : function(response , backParams){
                                    
                                    var param = Ext.decode(response.responseText);
                                    // console.log(param);
                                    if(param.items.length>0){
                                        theDocspanel.removeAll();
                                        me.__sub_showuploadlist_panel(param , theDocspanel ,params);
                                    }
                                    Ext.Msg.alert('提示',action.result.msg);
                                }
                            });
                            
                            //winUpload.hide();
                            // me.__sub_showuploadlist_panel([action.result.data] , theDocspanel ,params);
                        },
                        failure: function(form, action){
                            me.$requestAjax({
                                url : me.$getConfig('urls').get('get.investmentproductaudit.getfiles').url,
                                method : "POST",
                                params : {
                                    cfid: params.id
                                },
                                scope : me ,
                                backParams: {} ,
                                callback : function(response , backParams){
                                    
                                    var param = Ext.decode(response.responseText);
                                    // console.log(param);
                                    if(param.items.length>0){
                                        theDocspanel.removeAll();
                                        me.__sub_showuploadlist_panel(param , theDocspanel ,params);
                                    }
                                    Ext.Msg.alert('提示',action.result.msg);
                                }
                            });
                        }
                    })
                }
            }]
        });

        var winUpload=Ext.create('Ext.window.Window', {
            title: '上传资料',
            width: 600,
            height:300,
            minWidth: 300,
            minHeight: 100,
            bodyStyle:'padding:5px;',
            buttonAlign : 'center' ,
            autoScroll : true,
            items : [otcpanel,theDocspanel],
           
            buttons: [uploadPanel]
        });
        winUpload.show();
    },
    __sub_showuploadlist_panel : function(param , fatherpanel ,proinfo){
        var me = this;
        // console.log(proinfo);
        // console.log(param);
        for(var i=0;i<param.items.length;i++){

            var tmpanel = Ext.create("ui.extend.base.Panel" , {
                border : 0 ,
                columnWidth :1 ,
                margin : 10 ,
                layout : 'column',
                items : [
                    {
                        xtype : 'panel' ,
                        border : 0 ,
                        items : [] ,
                        columnWidth:.7 ,
                        html : "<a href='../"+ param.items[i].file +"'>"+ param.items[i].filename+"</a>"
                    },
                    {
                        xtype : 'button',
                        columnWidth:.1 ,
                        text : '下载',
                        atturl:me.$getConfig('urls').get('get.investmentproductaudit.downfile').url,
                        fieldid:param.items[i].id,
                        handler : function(btn){
                            // var btnRef=this;
                            window.open(btn.atturl+'?id='+btn.fieldid);
                        }
                    },
                    {
                        xtype : 'button',
                        columnWidth:.1 ,
                        text : '删除',
                        margin : '0 0 0 2',
                        fieldid : param.items[i].id,
                        cfid :  proinfo.id,
                        handler : function(btn){
                            var btnRef=this;
                            me.$askYestNo({
                                msg: '确认删除吗?',
                                yes: function () {
                                    // console.log(btnRef.cfid);
                                    me.$requestAjax({
                                        url : me.$getConfig('urls').get('set.investmentproductaudit.deleteupload').url,
                                        method : "POST",
                                        params : {cfid:btnRef.cfid,fileid:btnRef.fieldid},
                                        backParams: { } ,
                                        callback   :    function(response , backParams){
                                            //console.log(response.responseText);
                                            var param = Ext.decode(response.responseText);
                                            var father  = btn.ownerCt;
                                            father.hide(200,function(){
                                                father.destroy();
                                            });
                                            Ext.MessageBox.alert("删除成功",param.msg);
                                        }
                                    });
                                }
                            })
                        }
                    }
                ]
            });
            fatherpanel.add(tmpanel);
        }
    },
    __investmentproductaudit$approve : function( btna , params ){
        var me = this;
        params = me.$getArrayOne(params);
        // if(params.status == 2){
        //     Ext.Msg.show({
        //         title : '失败',
        //         msg  : '已经是通过状态！',
        //         icon: Ext.Msg.ERROR,
        //     });
        //     return;
        // }
        params.status = 4;
        me.$askYestNo({
            msg : '确认通过吗',
            yes : function(){
                me.$requestAjax({
                    url     :   me.$getUrlstrByUrlcode('set.investmentproductaudit.change'),
                    method :    'POST',
                    params :    params,
                    scope  :    me,
                    backParams: {},
                    callback   :    function(response , backParams){
                        //console.log(response.responseText);
                        var param = Ext.decode(response.responseText);
                        if(param.status > 0){
                            Ext.MessageBox.alert('成功','审核成功！');
                            me.$reloadViewGrid();
                        }
                    }
                });
            }
        });
    },
    __investmentproductaudit$reject : function( btna , params ){
        var me = this;
        params = me.$getArrayOne(params);
        // if(params.status == 3){
        //     Ext.Msg.show({
        //         title : '失败',
        //         msg  : '已经是退回状态！',
        //         icon: Ext.Msg.ERROR,
        //     });
        //     return;
        // }
        params.status = 3;
         me.$askYestNo({
             msg : '确认退回吗?',
             yes : function(){
                 me.$requestAjax({
                     url     :   me.$getUrlstrByUrlcode('set.investmentproductaudit.reject'),
                     method :    'POST',
                     params :    params,
                     scope  :    me,
                     backParams: {},
                     callback   :    function(response , backParams){
                         //console.log(response.responseText);
                         var param = Ext.decode(response.responseText);
                         if(param.status > 0){
                             Ext.MessageBox.alert('成功','退回成功！');
                             me.$reloadViewGrid();
                         }
                     }
                 });
             }
         });
        //me.$askYestNoPrompt('提示','退回理由',function(btn,text){
        //    if(btn=='ok'){
        //        params.memo=text;
        //        me.$requestAjax({
        //            url     :   me.$getUrlstrByUrlcode('set.investmentproductaudit.change'),
        //            method :    'POST',
        //            params :    params,
        //            scope  :    me,
        //            backParams: {},
        //            callback   :    function(response , backParams){
        //                //console.log(response.responseText);
        //                var param = Ext.decode(response.responseText);
        //                if(param.status > 0){
        //                    Ext.MessageBox.alert('成功','退回成功！');
        //                    me.$reloadViewGrid();
        //                }
        //            }
        //        });
        //    }
        //});
    },
    
   /* 接口：
    * 信息面板里的 按钮 事件
    * 方法名规则  __ + 信息面板类型(view,edit,add等) + Panel + $ + 按钮定义的fnName .
    * 回参为 按钮和 本信息面板自己
    */
    __editPanel$save : function( btn , infopanel ){
        var me = this;
        var editparams = me.$getFormsParams(infopanel);
        if( !me.$checkValid(infopanel)) return;
        me.$requestFromDataAjax(
            'get.investmentproductaudit.edit',
            editparams,
            infopanel,
            function(params){
                if(typeof(infopanel.ownerCt) != 'undefined' && typeof(infopanel.ownerCt.close) === 'function'){
                    infopanel.ownerCt.close();
                    me.$reloadViewGrid();
                }
            }
        );
    },
    __addPanel$save : function( btn , infopanel ){

        var me = this;
        var editparams = me.$getFormsParams(infopanel);
        if( !me.$checkValid(infopanel)) return;
        me.$requestFromDataAjax(
            'get.investmentproductaudit.edit',
            editparams,
            infopanel,
            function(params){
                if(typeof(infopanel.ownerCt) != 'undefined' && typeof(infopanel.ownerCt.close) === 'function'){
                    infopanel.ownerCt.close();
                }
                me.$reloadViewGrid();
            }
        );
    },

    /* 接口：
     * 功能信息面板子form的 render 处理
     * 命名规则： __  +  optype(操作类型) + _sub_render
     */
    __view_sub_render : function(theform){
        alert(theform.getForm());
    },

    /* 接口：
     * 功能信息面板的 render 处理
     * 命名规则： __  +  optype(操作类型) + _main_render
     * 作用域 ctrl
     */
    __view_main_render : function(thepanel){
        var me = this;
        var mydata = thepanel.getMyDatas();
        me.$requestFromDataAjax(
            'get.investmentproductaudit.view',
            mydata,
            thepanel
        );
    },

    __edit_main_render : function(thepanel){
        var me = this;
        var mydata = thepanel.getMyDatas();
        me.$requestFromDataAjax(
            'get.investmentproductaudit.view',
            mydata,
            thepanel
        );
    },
    /* 接口：
     * 功能信息面板的 字段组件的 初始 方法
     * 命名规则： __  +  optype(操作类型) + _fieldinit
     */
    __view_fieldinit : function(field){
        if(field) field.readOnly = true;
    },

    __edit_fieldinit : function(field){
        if(!field) return;
        if(field.name === 'update_time') field.disabled = true;
    },
    __add_fieldinit : function(field){
        if(!field) return;
        if(field.name === 'update_time') field.hide();
    }

});