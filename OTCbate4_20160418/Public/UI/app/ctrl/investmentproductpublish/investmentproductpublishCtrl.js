/**
 * Created by Administrator on 2015/12/7 0007.
 */

Ext.define('ui.ctrl.investmentproductpublish.investmentproductpublishCtrl', {
    extend: 'ui.extend.baseClass.baseCtrl',
    requires : [
        'ui.ctrl.investmentproductpublish.investmentproductpublishConf',
        'ui.view.investmentproductpublish.investmentproductpublishView',
        'ui.view.investmentproductpublish.Coms.viewPanel'
    ],
    views : [
        'ui.view.investmentproductpublish.investmentproductpublishView'
    ],

    refs:[
        {ref:'investmentproductpublishWin' , selector:'investmentproductpublishwindow'}
    ],

    constructor : function (cfg){
        this.modelConf = Ext.create('ui.ctrl.investmentproductpublish.investmentproductpublishConf');
        this.callParent(arguments);
    },

    init:function(){
        this.control({      //这里的this相当于这个控制层
            'investmentproductpublishpagecentergrid' : {
                render : function(e){
                    //e.grid.getStore().load();
                }
            }
        });
    },

    //配置功能按钮功能  对应Conf类中定义的operationButtons > pmsCode { text : '新建角色+' , pmsCode : 'investmentproductpublish.add' }
    //‘.’替换为 $  ,方法前加__
    __investmentproductpublish$add : function( btna , params ){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        if(!pmsCode) return;
        me.$showOptionsPanel('add', pmsCode ,function(panel ,win){
            //这里对panel进行处理
        });
    },
    __investmentproductpublish$cexiao : function( btna , params ){
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
                        url     :   me.$getUrlstrByUrlcode('set.investmentproductpublish.delete'),
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
    __investmentproductpublish$publish : function( btna , params ){
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
        params.cfm_id = params.id;
        me.$askYestNo({
            msg : '确认发布吗',
            yes : function(){
                me.$requestAjax({
                    url     :   me.$getUrlstrByUrlcode('set.investmentproductpublish.publish'),
                    method :    'POST',
                    params :    params,
                    scope  :    me,
                    backParams: {},
                    callback   :    function(response , backParams){
                        //console.log(response.responseText);
                        var param = Ext.decode(response.responseText);
                        if(param.status > 0){
                            Ext.MessageBox.alert('成功','发布成功！');
                            me.$reloadViewGrid();
                        }
                    }
                });
            }
        });
    },
    //listbtn  list的处理按钮事件，方法名前 加 '__'  ，根据权限pmscode指定方法名， .更换为$...方法前加__
    __investmentproductpublish$view : function( btna , params ){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        if(!pmsCode) return;
        var param  = params || {};
        Ext.apply( param , { pmsCode : pmsCode} );

            me.$showOptionsPanel('view', param ,function( panel ,win ){
                //这里对panel进行处理
                var theDocspanel = Ext.create("ui.extend.base.Panel",{
                    border : 0 ,
                    columnWidth :1 ,
                    myStamp : 'theDocsList',
                    layout : 'column',
                    items : []
                });
                me.$requestAjax({
                    url : me.$getConfig('urls').get('get.investmentproductpublish.getfiles').url,
                    method : "POST",
                    params : {
                        cfid: params.id
                    },
                    scope : me ,
                    backParams: {} ,
                    callback : function(response , backParams){
                        
                        var param = Ext.decode(response.responseText);
                        console.log(param);
                        if(param.items.length>0){
                            me.__sub_showuploadlist_panel(param , theDocspanel ,params);
                        }
                        panel.formsList[1].add(theDocspanel);
                        panel.doLayout();
                    }
                });

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
                        html : "<a target='_blank' href='"+ param.items[i].file +"'>"+ param.items[i].filename+"</a>"
                    },
                    {
                        xtype : 'button',
                        columnWidth:.1 ,
                        text : '下载',
                        atturl : param.items[i].file,
                        handler : function(btn){
                            window.open(btn.atturl);
                        }
                    },
                    {
                        xtype : 'button',
                        columnWidth:.1 ,
                        text : '删除',
                        margin : "0 2",
                        fieldid : param.items[i].id,
                        cfid :  proinfo.id,
                        handler : function(btn){
                            me.$askYestNo({
                                msg: '确认删除吗?',
                                yes: function () {
                                    me.$requestAjax({
                                        url : me.$getConfig('urls').get('set.investmentproductaudit.deleteupload').url,
                                        method : "POST",
                                        params : {cfid:this.cfid,fieldid:fieldid},
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
    __investmentproductpublish$edit : function( btna , params ){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        if(!pmsCode) return;
        var param  = params || {};
        Ext.apply( param , { pmsCode : pmsCode} );

        me.$showOptionsPanel('edit', param ,function( panel ,win ){
            //这里对panel进行处理
        });
    },
    __investmentproductpublish$approve : function( btna , params ){
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
                    url     :   me.$getUrlstrByUrlcode('set.investmentproductpublish.change'),
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
    __investmentproductpublish$reject : function( btna , params ){
        var me = this;
        params = me.$getArrayOne(params);
        if(params.status == 10){
            Ext.Msg.show({
                title : '失败',
                msg  : '已经是退回状态！',
                icon: Ext.Msg.ERROR,
            });
            return;
        }
        params.cfm_id = params.id;
        me.$askYestNo({
            msg : '确认退回吗',
            yes : function(){
                me.$requestAjax({
                    url     :   me.$getUrlstrByUrlcode('set.investmentproductpublish.reject'),
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
            'get.investmentproductpublish.edit',
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
            'get.investmentproductpublish.edit',
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
            'get.investmentproductpublish.view',
            mydata,
            thepanel
        );
    },

    __edit_main_render : function(thepanel){
        var me = this;
        var mydata = thepanel.getMyDatas();
        me.$requestFromDataAjax(
            'get.investmentproductpublish.view',
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