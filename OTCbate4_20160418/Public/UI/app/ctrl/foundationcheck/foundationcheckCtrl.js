/**
 * Created by Administrator on 2015/12/7 0007.
 */

Ext.define('ui.ctrl.foundationcheck.foundationcheckCtrl', {
    extend: 'ui.extend.baseClass.baseCtrl',
    requires : [
        'ui.ctrl.foundationcheck.foundationcheckConf',
        'ui.view.foundationcheck.foundationcheckView',
        'ui.view.foundationcheck.Coms.viewPanel'
    ],
    views : [
        'ui.view.foundationcheck.foundationcheckView'
    ],

    refs:[
        {ref:'foundationcheckWin' , selector:'foundationcheckwindow'}
    ],

    constructor : function (cfg){
        this.modelConf = Ext.create('ui.ctrl.foundationcheck.foundationcheckConf');
        this.callParent(arguments);
    },

    init:function(){
        this.control({      //这里的this相当于这个控制层
            'foundationcheckpagecentergrid' : {
                render : function(e){
                    //e.grid.getStore().load();
                }
            }
        });
    },
    //配置功能按钮功能  对应Conf类中定义的operationButtons > pmsCode { text : '新建角色+' , pmsCode : 'foundationcheck.add' }
    //‘.’替换为 $  ,方法前加__
    __foundationcheck$add : function( btna , params ){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        if(!pmsCode) return;
       me.$showOptionsPanel('add', pmsCode ,function(panel ,win){
            //这里对panel进行处理
        },me.$getConfig('_sub_win_defparams'));
    },

    //listbtn  list的处理按钮事件，方法名前 加 '__'  ，根据权限pmscode指定方法名， .更换为$...方法前加__
    __foundationcheck$view : function( btna , params ){
        var me = this;
        var view = this.$getView();
        Ext.apply(params,{callback: function(panel,win){
            //me.$addWindowToFather(win);
        }});
        this.$fireModuleEvents('foundationworktable','view',params);
    },

    __foundationcheck$upload : function( btna , params ){
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
            url : me.$getConfig('urls').get('get.getfoundationfile').url,
            method : "POST",
            params : {
                capitalid: params.id
            },
            scope : me ,
            backParams: {} ,
            callback : function(response , backParams){
                //console.log(response.responseText);
                var param = Ext.decode(response.responseText);
                otc_code=param.code;
                codeText.setValue(otc_code);
                if(param.items.length>0){
                    me.__sub_showuploadlist_panel(param.items , theDocspanel ,params);
                }

                // uploadPanel.items.items[0].setValue(param.code);
            }
        });

        var codeText=Ext.create("Ext.form.field.Text",{
            name: 'code',
            id:'otc_code',
            fieldLabel: 'OTC备案代码',
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
            items : [
				
				// {
    //                 fieldLabel : 'OTC备案代码',
    //                 labelWidth: 100,
    //                 name : 'code',
    //                 columnWidth :1,
    //                 margin: 6,
    //                 xtype : 'textfield'
    //             },
				{
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
                handler : function(btn){
                    uploadPanel.getForm().submit({
                        url: me.$getConfig('urls').get('set.addfoundationfile').url , //'../Product/productAddContract',
                        params: {
                            cap_id: params.id,
                            code:Ext.getCmp('otc_code').getValue()
                        },
                        success: function(form, action){
                            // Ext.Msg.alert('成功','上传成功.');
                            //winUpload.hide();
							theDocspanel.removeAll();
							me.$requestAjax({
								url : me.$getConfig('urls').get('get.getfoundationfile').url,
								method : "POST",
								params : {
									capitalid: params.id
                                    
								},
								scope : me ,
								backParams: {} ,
								callback : function(response , backParams){
									//console.log(response.responseText);

									var param = Ext.decode(response.responseText);
									if(param.items.length>0){
										me.__sub_showuploadlist_panel(param.items , theDocspanel ,params);
									}
                                    Ext.Msg.alert('提示',action.result.msg);
								}
							});
                        },
                        failure: function(form, action){
                            Ext.Msg.alert('Error', action.result.msg);
                        }
                    })
                }
            }]
        });

        

        var winUpload=Ext.create('Ext.window.Window', {
            title: '上传审核资料',
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

    __foundationcheck$edit : function( btna , params ){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        if(!pmsCode) return;
        var param  = params || {};
        Ext.apply( param , { pmsCode : pmsCode} );

        me.$showOptionsPanel('edit', param ,function( panel ,win ){
            //这里对panel进行处理
        });
    },

    __foundationcheck$submit : function( btna , params ){
        var me = this;
        params = me.$getArrayOne(params);
       
        params.status = 1;
        var postdata = {id : params.id}
        me.$askYestNo({
            msg : '确认提交吗',
            yes : function(){
                me.$requestAjax({
                    url     :   me.$getUrlstrByUrlcode('set.foundationcheck.submit'),
                    method :    'POST',
                    params :    postdata,
                    scope  :    me,
                    backParams: {},
                    callback   :    function(response , backParams){
                        //console.log(response.responseText);
                        var param = Ext.decode(response.responseText);
                        if(param.status > 0){
                            Ext.MessageBox.alert('成功','提交成功！');
                            me.$reloadViewGrid();
                        }
                    }
                });
            }
        });
    },

	__foundationcheck$pass : function( btna , params ){
        var me = this;
        params = me.$getArrayOne(params);
        
        params.status = 2;
        var postdata = {id : params.id}
        me.$askYestNo({
            msg : '确认通过吗',
            yes : function(){
                me.$requestAjax({
                    url     :   me.$getUrlstrByUrlcode('set.foundationcheck.pass'),
                    method :    'POST',
                    params :    postdata,
                    scope  :    me,
                    backParams: {},
                    callback   :    function(response , backParams){
                        //console.log(response.responseText);
                        var param = Ext.decode(response.responseText);
                        if(param.status > 0){
                            Ext.MessageBox.alert('提示',param.msg);
                            me.$reloadViewGrid();
                        }
                    }
                });
            }
        });
    },

	__foundationcheck$back : function( btna , params ){
        var me = this;
        params = me.$getArrayOne(params);
        
        params.status = 2;
        var postdata = {id : params.id}
        me.$askYestNo({
            msg : '确认退回吗',
            yes : function(){
                me.$requestAjax({
                    url     :   me.$getUrlstrByUrlcode('set.foundationcheck.back'),
                    method :    'POST',
                    params :    postdata,
                    scope  :    me,
                    backParams: {},
                    callback   :    function(response , backParams){
                        //console.log(response.responseText);
                        var param = Ext.decode(response.responseText);
                        if(param.success > 0){
                            Ext.MessageBox.alert('成功','提交成功！');
                            me.$reloadViewGrid();
                        }
                    }
                });
            }
        });
    },


    __sub_showuploadlist_panel : function(param , fatherpanel ,proinfo){
        var me = this;
		var thedownurl = me.$getUrlstrByUrlcode("get.foundationcheck.downFile");
        for(var i in param){			
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
                        html : "<a href='"+ thedownurl + "?id=" + param[i].id +"'>"+ param[i].filename+"</a>"
                    },
                    {
                        xtype : 'button',
                        columnWidth:.1 ,
                        text : '下载',
                        atturl : thedownurl + "?id=" + param[i].id,//param[i].file,
                        handler : function(btn){
                            window.open(btn.atturl);
                        }
                    },
                    {
                        xtype : 'button',
                        columnWidth:.15 ,
                        text : '删除',
                        margin : "0 2",
                        attid : param[i].id,
                        capitalid :  proinfo.id,
                        handler : function(btn){
                            me.$askYestNo({
                                msg: '确认删除吗?',
                                yes: function () {
                                    me.$requestAjax({
                                        url : me.$getConfig('urls').get('set.delfoundationfile').url,
                                        method : "POST",
                                        params : {id : btn.attid },
                                        backParams: { } ,
                                        callback   :	function(response , backParams){
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
   /* 接口：
    * 信息面板里的 按钮 事件
    * 方法名规则  __ + 信息面板类型(view,edit,add等) + Panel + $ + 按钮定义的fnName .
    * 回参为 按钮和 本信息面板自己
    */
    __editPanel$save : function( btn , infopanel ){
        var me = this;
        var editparams = me.$getFormsParams(infopanel);

        me.$requestFromDataAjax(
            'get.foundationcheck.edit',
            editparams,
            null,
            function(params){
                if(typeof(infopanel.ownerCt) != 'undefined' && typeof(infopanel.ownerCt.close) === 'function'){
                    infopanel.ownerCt.close();
                    me.$reloadViewGrid();
                }
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
            'get.foundationcheck.view',
            mydata,
            thepanel
        );
    },

    __edit_main_render : function(thepanel){
        var me = this;
        var mydata = thepanel.getMyDatas();
        me.$requestFromDataAjax(
            'get.foundationcheck.view',
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