/**
 * Created by Administrator on 2015/12/7 0007.
 */

Ext.define('ui.ctrl.claimsaudit.claimsauditCtrl', {
    extend: 'ui.extend.baseClass.baseCtrl',
    requires : [
        'ui.ctrl.claimsaudit.claimsauditConf',
        'ui.view.claimsaudit.claimsauditView',
        'ui.view.claimsaudit.Coms.viewPanel'
    ],
    views : [
        'ui.view.claimsaudit.claimsauditView'
    ],

    refs:[
        {ref:'claimsauditWin' , selector:'claimsauditwindow'}
    ],

    constructor : function (cfg){
        this.modelConf = Ext.create('ui.ctrl.claimsaudit.claimsauditConf');
        this.callParent(arguments);
    },

    init:function(){
        this.control({      //这里的this相当于这个控制层
            'claimsauditpagecentergrid' : {
                render : function(e){
                    //e.grid.getStore().load();
                }
            }
        });
    },

    //配置功能按钮功能  对应Conf类中定义的operationButtons > pmsCode { text : '新建角色+' , pmsCode : 'claimsaudit.add' }
    //‘.’替换为 $  ,方法前加__
    __claimsaudit$add : function( btna , params ){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        if(!pmsCode) return;
        me.$showOptionsPanel('add', pmsCode ,function(panel ,win){
            //这里对panel进行处理
        });
    },
    __claimsaudit$cexiao : function( btna , params ){
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
                        url     :   me.$getUrlstrByUrlcode('set.claimsaudit.delete'),
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
    __claimsaudit$delete : function( btna , params ){
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
                    url     :   me.$getUrlstrByUrlcode('set.claimsaudit.delete'),
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
    __claimsaudit$view : function( btna , params ){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        if(!pmsCode) return;
        var param  = params || {};
        Ext.apply( param , { pmsCode : pmsCode} );

        me.$showOptionsPanel('view', param ,function( panel ,win ){
            //这里对panel进行处理
        });
    },

    __claimsaudit$edit : function( btna , params ){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        if(!pmsCode) return;
        var param  = params || {};
        Ext.apply( param , { pmsCode : pmsCode} );

        me.$showOptionsPanel('edit', param ,function( panel ,win ){
            //这里对panel进行处理
        });
    },
    __claimsaudit$upload : function( btna , params ){
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
            url : me.$getConfig('urls').get('get.claimsaudit.getfiles').url,
            method : "POST",
            params : {
                cl_id: params.id
            },
            scope : me ,
            backParams: {} ,
            callback : function(response , backParams){
                //console.log(response.responseText);
                var param = Ext.decode(response.responseText);
                otc_code=param.code;
                codeText.setValue(otc_code);
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
        var uploadPanel = Ext.create( "ui.extend.base.Form",{
            columnWidth :1,
            layout : 'column',
            border :  0,
            padding : 10,
            styleHtmlCls : 'fileuploadfieldclass',
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
                    uploadPanel.getForm().submit({
                        url: me.$getConfig('urls').get('set.claimsaudit.upload').url , //'../Product/productAddContract',
                        params: {
                            cl_id: params.id,
                            code:Ext.getCmp('otc_code').getValue()
                        },
                        success: function(form, action){
                            me.$requestAjax({
                                url : me.$getConfig('urls').get('get.claimsaudit.getfiles').url,
                                method : "POST",
                                params : {
                                    cl_id: params.id
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
                        },
                        failure: function(form, action){
                            me.$requestAjax({
                                url : me.$getConfig('urls').get('get.claimsaudit.getfiles').url,
                                method : "POST",
                                params : {
                                    cl_id: params.id
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
                        html : "<a href='"+ param.items[i].file +"'>"+ param.items[i].filename+"</a>"
                    },
                    {
                        xtype : 'button',
                        columnWidth:.1 ,
                        text : '下载',
                        atturl:me.$getConfig('urls').get('get.claimsaudit.downfile').url,
                        fieldid:param.items[i].id,
                        // atturl : param.items[i].file,
                        handler : function(btn){
                            // console.log(btn.atturl);
                            window.open(btn.atturl+'?id='+btn.fieldid);
                        }
                    },
                    {
                        xtype : 'button',
                        columnWidth:.1 ,
                        text : '删除',
                        margin : "0 0 0 2",
                        file_url : param.items[i].file,
                        cl_id :  proinfo.id,
                        handler : function(btn){
                            var btnRef=this;
                            me.$askYestNo({
                                msg: '确认删除吗?',
                                yes: function () {
                                    me.$requestAjax({
                                        url : me.$getConfig('urls').get('set.claimsaudit.deleteupload').url,
                                        method : "POST",
                                        params : {cl_id:btnRef.cl_id,file_url:btnRef.file_url},
                                        backParams: { } ,
                                        callback   :    function(response , backParams){
                                            //console.log(response.responseText);
                                            var param = Ext.decode(response.responseText);
                                            var father  = btn.ownerCt;
                                            father.hide(200,function(){
                                                father.destroy();
                                            });
                                            Ext.MessageBox.alert("提示",param.msg);
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
    __claimsaudit$approve : function( btna , params ){
        var me = this;
        params = me.$getArrayOne(params);
        if(params.status == 2){
            Ext.Msg.show({
                title : '失败',
                msg  : '已经是通过状态！',
                icon: Ext.Msg.ERROR,
            });
            return;
        }
        params.status = 2;
        me.$askYestNo({
            msg : '确认通过吗',
            yes : function(){
                me.$requestAjax({
                    url     :   me.$getUrlstrByUrlcode('set.claimsaudit.change'),
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
    __claimsaudit$reject : function( btna , params ){
        var me = this;
        params = me.$getArrayOne(params);
        if(params.status == 3){
            Ext.Msg.show({
                title : '失败',
                msg  : '已经是退回状态！',
                icon: Ext.Msg.ERROR,
            });
            return;
        }
        params.status = 3;
        me.$askYestNo({
            msg : '确认退回吗',
            yes : function(){
                me.$requestAjax({
                    url     :   me.$getUrlstrByUrlcode('set.claimsaudit.change'),
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
            'get.claimsaudit.edit',
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
            'get.claimsaudit.edit',
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

    __all_post_after_main_event : function(thepanel) {
        //alert('after');
        var me = this;
        var form = $findByparam(thepanel , { mySamle : 'theBasePanel'});
        form = form[0];
        form = form.getForm();
        var postdata = thepanel.$postValue;

        var borrower = form.findField("borrower");

        
        // console.log(postdata.cod_card_type); 
        var labelValue='';
        postdata.cod_card_type==2?labelValue='<span style="color:red">*</span>公司姓名':labelValue='<span style="color:red">*</span>借款人姓名'; 

        // Ext.getCmp('claim_borrower').setFieldLabel(labelValue);
       borrower.setFieldLabel(labelValue);
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
            'get.claimsaudit.view',
            mydata,
            thepanel
        );
    },

    __edit_main_render : function(thepanel){
        var me = this;
        var mydata = thepanel.getMyDatas();
        me.$requestFromDataAjax(
            'get.claimsaudit.view',
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
        if(field.name==='cod_card_type' ){
            console.log(field);
            field.value===1?labelValue='借款人姓名':labelValue='公司姓名'; 
            Ext.getCmp('claim_borrower').setFieldLabel(labelValue);
        }
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