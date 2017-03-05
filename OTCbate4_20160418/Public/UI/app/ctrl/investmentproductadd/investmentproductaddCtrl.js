/**
 * Created by Administrator on 2015/12/7 0007.
 */

Ext.define('ui.ctrl.investmentproductadd.investmentproductaddCtrl', {
    extend: 'ui.extend.baseClass.baseCtrl',
    requires : [
        'ui.ctrl.investmentproductadd.investmentproductaddConf',
        'ui.view.investmentproductadd.investmentproductaddView',
        'ui.view.investmentproductadd.Coms.viewPanel'
    ],
    views : [
        'ui.view.investmentproductadd.investmentproductaddView'
    ],

    refs:[
        {ref:'investmentproductaddWin' , selector:'investmentproductaddwindow'}
    ],

    constructor : function (cfg){
        this.modelConf = Ext.create('ui.ctrl.investmentproductadd.investmentproductaddConf');
        this.callParent(arguments);
    },

    init:function(){
        this.control({      //这里的this相当于这个控制层
            'investmentproductaddpagecentergrid' : {
                render : function(e){
                    //e.grid.getStore().load();
                }
            }
        });
    },

    //配置功能按钮功能  对应Conf类中定义的operationButtons > pmsCode { text : '新建角色+' , pmsCode : 'investmentproductadd.add' }
    //‘.’替换为 $  ,方法前加__
    __investmentproductadd$add : function( btna , params ){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        if(!pmsCode) return;
        me.$showOptionsPanel('add', pmsCode ,function(panel ,win){
            //这里对panel进行处理
        });
    },
    __investmentproductadd$cexiao : function( btna , params ){
        var me = this;
        // params = me.$getArrayOne(params);
        var ids=[];
        var records=me.$getGridSelections();
        var postParams={cfm_id:''};
        var validateFlag=true;
        if(records.length<1){
            Ext.MessageBox.alert('提示','请选择删除记录！');
            return;
        }
        Ext.each(records,function(item){
            // if(item.data.status=='1'){
            //     Ext.Msg.show({
            //         title : '失败',
            //         msg  : '节点不是无效状态！',
            //         icon: Ext.Msg.ERROR,
            //     });
            //     validateFlag=false;
            //     return false;
            // }else{
            //     ids.push(item.data.id);
            // }
            ids.push(item.data.id);
        });
        postParams.cfm_id=ids.join();
        // postParams.status=3;
       
        if(validateFlag){
            me.$askYestNo({
                msg : '确认删除吗',
                yes : function(){
                    me.$requestAjax({
                        url     :   me.$getUrlstrByUrlcode('set.investmentproductadd.delete'),
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
    __investmentproductadd$delete : function( btna , params ){
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
            msg : '确认删除吗',
            yes : function(){
                me.$requestAjax({
                    url     :   me.$getUrlstrByUrlcode('set.investmentproductadd.delete'),
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
    __investmentproductadd$view : function( btna , params ){
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

    __investmentproductadd$edit : function( btna , params ){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        if(!pmsCode) return;
        var param  = params || {};
        Ext.apply( param , { pmsCode : pmsCode} );

        me.$showOptionsPanel('edit', param ,function( panel ,win ){
            //这里对panel进行处理
        });
    },
    __investmentproductadd$submit : function( btna , params ){
        var me = this;
        params = me.$getArrayOne(params);
        // if(params.status == 1){
        //     Ext.Msg.show({
        //         title : '失败',
        //         msg  : '已经是启用状态！',
        //         icon: Ext.Msg.ERROR,
        //     });
        //     return;
        // }
        params.cf_id = params.id;
        me.$askYestNo({
            msg : '确认提交吗',
            yes : function(){
                me.$requestAjax({
                    url     :   me.$getUrlstrByUrlcode('set.investmentproductadd.submit'),
                    method :    'POST',
                    params :    params,
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
    __investmentproductadd$stop : function( btna , params ){
        var me = this;
        params = me.$getArrayOne(params);
        if(params.status == 2){
            Ext.Msg.show({
                title : '失败',
                msg  : '已经是禁用状态！',
                icon: Ext.Msg.ERROR,
            });
            return;
        }
        params.status = 2;
        me.$askYestNo({
            msg : '确认禁用吗',
            yes : function(){
                me.$requestAjax({
                    url     :   me.$getUrlstrByUrlcode('set.investmentproductadd.change'),
                    method :    'POST',
                    params :    params,
                    scope  :    me,
                    backParams: {},
                    callback   :    function(response , backParams){
                        //console.log(response.responseText);
                        var param = Ext.decode(response.responseText);
                        if(param.status > 0){
                            Ext.MessageBox.alert('成功','禁用成功！');
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
            'get.investmentproductadd.edit',
            editparams,
            infopanel,
            function(params){
                // console.log(params);

                if(typeof(infopanel.ownerCt) != 'undefined' && typeof(infopanel.ownerCt.close) === 'function'){
                    Ext.MessageBox.alert("保存成功","信息编辑保存成功");
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
            'get.investmentproductadd.add',
            editparams,
            infopanel,
            function(params){
                // console.log(params);
                if(typeof(infopanel.ownerCt) != 'undefined' && typeof(infopanel.ownerCt.close) === 'function'){
                    infopanel.ownerCt.close();
                }
                me.$reloadViewGrid();
            }
        );
    },

    //表单数据加载之后
    __all_post_after_main_event : function(thepanel) {
        //alert('after');
        var me = this;
        var optype = thepanel.optype;
        var thePostData = thepanel.getMyDatas();
        var data = thepanel.$postValue;

        if(data.cod_cf_inv_type){
            var form = $findByparam(thepanel , { mySamle : 'theBasePanel'});
            form = form[0];
            form = form.getForm();
            var typefield = form.findField("cod_cf_inv_type");
            var namefield = form.findField("capitalid");

            thepanel.setLoading(true);
            me.$requestAjax({
                url : '../cfmast/allFoundation',
                method : "POST",
                params : {type : data.cod_cf_inv_type},
                callback : function(response , backParams){
                    var param = Ext.decode(response.responseText);
                    var items = param.items;
                    var data = [];
                    items.forEach(function(ar){
                        data.push([ar.id , ar.name]);
                    });

                    var store =  new  Ext.data.ArrayStore({
                        fields  :   ['id', 'name'],
                        data    :   data
                    })
                    namefield.clearValue();
                    namefield.bindStore(store);

                    thepanel.setLoading(false);
                }
            });
        }
    },
    /* 接口：
     * 功能信息面板子form的 render 处理
     * 命名规则： __  +  optype(操作类型) + _sub_render
     */
    __view_sub_render : function(theform){
        //alert(theform.getForm());
    },
    /* 接口：
     * 功能信息面板的 render 处理
     * 命名规则： __  +  optype(操作类型) + _main_render
     * 作用域 ctrl
     */
    //__all_main_render : function(thepanel){
    //    var me = this;
    //    var form = $findByparam(thepanel , { mySamle : 'theBasePanel'});
    //    form = form[0];
    //    form = form.getForm();
    //    var typefield = form.findField("cod_cf_inv_type");
    //    var namefield = form.findField("capitalid");
    //    typefield.on("select" , function(field , newvalue , oldvalue){
    //        thepanel.setLoading(true);
    //        me.$requestAjax({
    //            url : '../cfmast/allFoundation',
    //            method : "POST",
    //            params : {type : field.getValue()},
    //            callback : function(response , backParams){
    //                var param = Ext.decode(response.responseText);
    //                var items = param.items;
    //                var data = [];
    //                items.forEach(function(ar){
    //                    data.push([ar.id , ar.name]);
    //                });
    //
    //                var store =  new  Ext.data.ArrayStore({
    //                    fields  :   ['id', 'name'],
    //                    data    :   data
    //                })
    //                namefield.clearValue();
    //                namefield.bindStore(store);
    //
    //                thepanel.setLoading(false);
    //            }
    //        });
    //    });
    //},
    /* 接口：
     * 功能信息面板的 render 处理
     * 命名规则： __  +  optype(操作类型) + _main_render
     * 作用域 ctrl
     */
    __view_main_render : function(thepanel){
        var me = this;
        var mydata = thepanel.getMyDatas();
        me.$requestFromDataAjax(
            'get.investmentproductadd.view',
            mydata,
            thepanel
        );
    },

    __edit_main_render : function(thepanel){
        var me = this;
        var mydata = thepanel.getMyDatas();
        me.$requestFromDataAjax(
            'get.investmentproductadd.view',
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
		// console.log(cfg)
		// console.log(record)
        if(cfg.pmsCode === 'investmentproductadd.submit'){
            if(record.data.cod_cf_status_code !="0"&&record.data.cod_cf_status_code !="3"&&record.data.cod_cf_status_code !="10")return false;
        }
		if(cfg.pmsCode === 'investmentproductadd.delete'){
            if(record.data.cod_cf_status_code !="0"&&record.data.cod_cf_status_code !="3"&&record.data.cod_cf_status_code !="10")return false;
        }
		if(cfg.pmsCode === 'investmentproductadd.edit'){
            if(record.data.cod_cf_status_code !="0"&&record.data.cod_cf_status_code !="3" && record.data.cod_cf_status_code !="10")return false;
        }
        
        return true;
    }

});