/**
 * Created by Administrator on 2015/12/7 0007.
 */

Ext.define('ui.ctrl.foundationlist.foundationlistCtrl', {
    extend: 'ui.extend.baseClass.baseCtrl',
    requires : [
        'ui.ctrl.foundationlist.foundationlistConf',
        'ui.view.foundationlist.foundationlistView',
        'ui.view.foundationlist.Coms.viewPanel'
    ],
    views : [
        'ui.view.foundationlist.foundationlistView'
    ],

    refs:[
        {ref:'foundationlistWin' , selector:'foundationlistwindow'}
    ],

    constructor : function (cfg){
        this.modelConf = Ext.create('ui.ctrl.foundationlist.foundationlistConf');
        this.callParent(arguments);
    },

    init:function(){
        this.control({      //这里的this相当于这个控制层
            'foundationlistpagecentergrid' : {
                render : function(e){
                    //e.grid.getStore().load();
                }
            }
        });
    },
    
    //配置功能按钮功能  对应Conf类中定义的operationButtons > pmsCode { text : '新建角色+' , pmsCode : 'foundationlist.add' }
    //‘.’替换为 $  ,方法前加__
    __foundationlist$add : function( btna , params ){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        if(!pmsCode) return;
        me.$showOptionsPanel('add', pmsCode ,function(panel ,win){
            //这里对panel进行处理
        });
    },
    __foundationlist$cexiao : function( btna , params ){
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
                        url     :   me.$getUrlstrByUrlcode('set.foundationlist.delete'),
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
    __foundationlist$unsale : function( btna , params ){
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
            msg : '确认下架吗',
            yes : function(){
                me.$requestAjax({
                    url     :   me.$getUrlstrByUrlcode('set.foundationlist.unsale'),
                    method :    'POST',
                    params :    params,
                    scope  :    me,
                    backParams: {},
                    callback   :    function(response , backParams){
                        //console.log(response.responseText);
                        var param = Ext.decode(response.responseText);
                        if(param.status > 0){
                            Ext.MessageBox.alert('成功','下架成功！');
                            me.$reloadViewGrid();
                        }
                    }
                });
            }
        });
    },
    //listbtn  list的处理按钮事件，方法名前 加 '__'  ，根据权限pmscode指定方法名， .更换为$...方法前加__
    __foundationlist$view : function( btna , params ){
        var me = this;
        var view = this.$getView();
        Ext.apply(params,{callback: function(panel,win){
            //me.$addWindowToFather(win);
        }});
        // console.log(params);
        this.$fireModuleEvents('foundationworktable','view',params);
    },

    __foundationlist$edit : function( btna , params ){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        if(!pmsCode) return;
        var param  = params || {};
        Ext.apply( param , { pmsCode : pmsCode} );

        me.$showOptionsPanel('edit', param ,function( panel ,win ){
            //这里对panel进行处理
        });
    },
    __foundationlist$appending : function( btna , params ){
        var me = this;
        params = me.$getArrayOne(params);
        // console.log(params);
        if(params.status != 2){
            Ext.Msg.show({
                title : '失败',
                msg  : '审核通过可暂停！',
                icon: Ext.Msg.ERROR,
            });
            return;
        }
        // params.status = 2;
        me.$askYestNo({
            msg : '确认暂停吗',
            yes : function(){
                me.$requestAjax({
                    url     :   me.$getUrlstrByUrlcode('set.foundationlist.appending'),
                    method :    'POST',
                    params :    params,
                    scope  :    me,
                    backParams: {},
                    callback   :    function(response , backParams){
                        //console.log(response.responseText);
                        var param = Ext.decode(response.responseText);
                        if(param.status > 0){
                            Ext.MessageBox.alert('成功','暂停成功！');
                            me.$reloadViewGrid();
                        }
                    }
                });
            }
        });
    },
    __foundationlist$restart : function( btna , params ){
        var me = this;
        params = me.$getArrayOne(params);
        if(params.status != 4){
            Ext.Msg.show({
                title : '失败',
                msg  : '已暂停可恢复！',
                icon: Ext.Msg.ERROR,
            });
            return;
        }
        // params.status = 3;
        me.$askYestNo({
            msg : '确认恢复吗',
            yes : function(){
                me.$requestAjax({
                    url     :   me.$getUrlstrByUrlcode('set.foundationlist.restart'),
                    method :    'POST',
                    params :    params,
                    scope  :    me,
                    backParams: {},
                    callback   :    function(response , backParams){
                        //console.log(response.responseText);
                        var param = Ext.decode(response.responseText);
                        if(param.status > 0){
                            Ext.MessageBox.alert('成功','恢复成功！');
                            me.$reloadViewGrid();
                        }
                    }
                });
            }
        });
    },
    __foundationlist$rebuy : function( btna , params ){
        var me = this;
        //getUserUploadContract     
        
        me.$requestAjax({
            url : me.$getConfig('urls').get('get.foundationclaim.list').url,
            method : "POST",
            params : {
                id: params.id
            },
            scope : me ,
            backParams: {} ,
            callback : function(response , backParams){
                //console.log(response.responseText);
                var param = Ext.decode(response.responseText);
                countText.setValue(param.total_amount);

                // uploadPanel.items.items[0].setValue(param.code);
            }
        });

        var countText=Ext.create("Ext.form.field.Text",{
            name: 'total_amount',
            id:'total_amount',
            fieldLabel: '可回购金额',
            value:''

        });
        var rebuyText=Ext.create("Ext.form.field.Text",{
            name: 'repurchaseNum',
            id:'repurchaseNum',
            fieldLabel: '回购金额'
            // value:''

        })
        var rebuypanel = Ext.create("ui.extend.base.Form" , {
            layout : 'column',
            border :  0,
            padding : 10,
            columnWidth :1 ,
            margin : 10 ,
            items : [countText,rebuyText]
        });


        var winUpload=Ext.create('Ext.window.Window', {
            title: '回购',
            width: 600,
            height:300,
            minWidth: 300,
            minHeight: 100,
            bodyStyle:'padding:5px;',
            buttonAlign : 'center' ,
            autoScroll : true,
            items : [rebuypanel],
            buttons: [{
                // xtype : 'button',
                columnWidth:.15,
                margin : "0 5" ,
                text : '回购' ,
                handler : function(btn){
                    rebuypanel.getForm().submit({
                        url: me.$getConfig('urls').get('set.foundationlist.repurchase').url , //'../Product/productAddContract',
                        params: {
                            id: params.id
                            // code:Ext.getCmp('otc_code').getValue()
                        },
                        success: function(form, action){
                            Ext.Msg.alert('成功', action.result.msg);
                            winUpload.close();
                            me.$reloadViewGrid();
                        },
                        failure: function(form, action){
                            Ext.Msg.alert('失败', action.result.msg);
                        }
                    })
                }
            }]
        });
        winUpload.show();
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
            'get.foundationlist.edit',
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
            'get.foundationlist.edit',
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
            'get.foundationlist.view',
            mydata,
            thepanel
        );
    },

    __edit_main_render : function(thepanel){
        var me = this;
        var mydata = thepanel.getMyDatas();
        me.$requestFromDataAjax(
            'get.foundationlist.view',
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
    },
	__check_list_btn_event : function(cfg ,record){
        if(cfg.pmsCode === 'foundationlist.appending'){
            if(record.data.status !="2")return false;
        }
        if(cfg.pmsCode === 'foundationlist.restart'){
            if(record.data.status !="4")return false;
        }
		// console.log(cfg.pmsCode)
		if(cfg.pmsCode === 'foundationlist.rebuy'){
            if(record.data.canhuigou !="1")return false;
        }
		
        return true;
    }

});