/**
 * Created by Administrator on 2015/12/7 0007.
 */

Ext.define('ui.ctrl.foundationworktable.foundationworktableCtrl', {
    extend: 'ui.extend.baseClass.baseCtrl',
    requires : [
        'ui.ctrl.foundationworktable.foundationworktableConf',
        'ui.view.foundationworktable.foundationworktableView',
        'ui.view.foundationworktable.Coms.viewPanel'
    ],
    views : [
        'ui.view.foundationworktable.foundationworktableView'
    ],

    refs:[
        {ref:'foundationworktableWin' , selector:'foundationworktablewindow'}
    ],

    constructor : function (cfg){
        this.modelConf = Ext.create('ui.ctrl.foundationworktable.foundationworktableConf' , {ctrl : cfg.ctrl});
        this.callParent(arguments);
    },

    init : function(){
        this.control({      //这里的this相当于这个控制层
            'foundationworktablepagecentergrid' : {
                render : function(e){
                    //e.grid.getStore().load();
                }
            }
        });
    },

    //配置功能按钮功能  对应Conf类中定义的operationButtons > pmsCode { text : '新建角色+' , pmsCode : 'foundationworktable.add' }
    //‘.’替换为 $  ,方法前加__
    __foundationworktable$add : function( btna , params ){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        //if(!pmsCode) return;
        
        me.$showOptionsPanel('add', pmsCode ,function(panel ,win){
            //这里对panel进行处理
        },me.$getConfig('_sub_win_defparams'));
        // console.log(Ext.getCmp('memo'));
        
    },

    //listbtn  list的处理按钮事件，方法名前 加 '__'  ，根据权限pmscode指定方法名， .更换为$...方法前加__
    __foundationworktable$view : function( btna , params ){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        //if(!pmsCode) return;
        var param  = params || {};
        Ext.apply( param , { pmsCode : pmsCode} );

        me.$showOptionsPanel('view', param ,function( panel ,win ){
            //这里对panel进行处理
            console.log(params);
            if(typeof(params.callback) === 'function'){
                params.callback.call( me,panel ,win );
            }

        },me.$getConfig('_sub_win_defparams'));
    },

    __foundationworktable$edit : function( btna , params ){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        //if(!pmsCode) return;
        var param  = params || {};
        Ext.apply( param , { pmsCode : pmsCode} );

        me.$showOptionsPanel('edit', param ,function( panel ,win ){
            //这里对panel进行处理
            if(typeof(params.callback) === 'function'){
                params.callback.call( me , panel , win );
            }
            console.log(win);
        },me.$getConfig('_sub_win_defparams'));
    },

    __foundationworktable$alldelete : function(btna , params){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        var records = me.$getGridSelections();
        if(records.length<1){
            Ext.MessageBox.alert('提示','请选择删除记录！');
            return;
        }
        me.$askYestNo({
            msg : "确认删除选中的"+ records.length +"条记录吗",
            yes : function(){
                me.__sub_delete_foundation.call(me,records);
            }
        });
    },

    __foundationworktable$delete : function(btna , params){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        var records = [{id : params.id}];

        me.$askYestNo({
            msg : '确认删除此记录吗',
            yes : function(){
                me.__sub_delete_foundation.call(me,records);
            }
        });
    },

    __foundationworktable$submit : function( btna , params ){
        var me = this;
        params = me.$getArrayOne(params);
        
        me.$askYestNo({
            msg : '确认提交吗',
            yes : function(){
                me.$requestAjax({
                    url     :   me.$getUrlstrByUrlcode('get.foundationworktable.submit'),
                    method :    'POST',
                    params :    {id : params.id},
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


    __sub_delete_foundation : function(rec){
        var me = this;
        var ids = "";
        for(var i in rec){
            if(rec[i].id > 0 ){
                ids += rec[i].id;
            }
            if(i<rec.length-1) ids += ",";
        }

        me.$requestAjax({
            url     :   me.$getUrlstrByUrlcode('get.foundationworktable.delete'),
            method :    'POST',
            params :    {id : ids},
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
    },
   /* 接口：
    * 信息面板里的 按钮 事件
    * 方法名规则  __ + 信息面板类型(view,edit,add等) + Panel + $ + 按钮定义的fnName .
    * 回参为 按钮和 本信息面板自己
    */
    __editPanel$save : function( btn , infopanel ){
        var me = this;
        var editparams = me.$getFormsParams(infopanel);
        if( !me.$checkValid(infopanel)){
            Ext.MessageBox.alert("录入不完整","信息录入不完整，请确认");
            return;
        }
        me.$requestFromDataAjax(
            'get.foundationworktable.edit',
            editparams,
            null,
            function(params){
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
        var addparams = me.$getFormsParams(infopanel);
        if( !me.$checkValid(infopanel)){
            Ext.MessageBox.alert("录入不完整","信息录入不完整，请确认");
            return;
        }
        me.$requestFromDataAjax(
            'get.foundationworktable.add',
            addparams,
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
        //alert(theform.getForm());
    },

    /* 接口：
     * 功能信息面板的 render 处理
     * 命名规则： __  +  optype(操作类型) + _main_render
     * 作用域 ctrl
     */
    __all_main_render : function(thepanel){
        var me = this;
        var form = $findByparam(thepanel , { mySamle : 'theForm'});
        form = form[0];
        form = form.getForm();

        var typefield = form.findField("investment_type");
        var cf_mast_idfield = form.findField("cf_mast_id");
        // typefield.getValue()
        me.__sub_load_list_fn(thepanel);
        typefield.on("select" , function(field , newvalue , oldvalue){
            me.__sub_load_list_fn(thepanel);
        });
        // console.log(form);

    },

    __sub_load_list_fn : function(thepanel){
        var me = this;
        var form = $findByparam(thepanel , { mySamle : 'theForm'});
        form = form[0];
        form = form.getForm();

        var typefield = form.findField("investment_type");
        var cf_mast_idfield = form.findField("cf_mast_id");

        me.$requestAjax({
            url : me.$getUrlstrByUrlcode("get.foundationworktable.mast") , //'../Foundation/allFoundation',
            method : "POST",
            params : {/**/ cf_inv_type : typefield.getValue()},
            callback : function(response , backParams){
                var param = Ext.decode(response.responseText);
                var items = param.items;
                var data = [];
                items.forEach(function(ar){
                    data.push([ar.id , ar.title]);
                });
                var store = new  Ext.data.ArrayStore({
                    fields  :   ['id', 'title'],
                    data    :   data
                });
                cf_mast_idfield.clearValue();
                cf_mast_idfield.bindStore(store);
                thepanel.setLoading(false);
            }
        });
    },

    __view_main_render : function(thepanel){
        var me = this;
        var theform = thepanel.findTabPanel({ myStamp : 'theClaimList'});
        theform = theform.getForm();
    },
    //表单数据加载之后
    __all_post_after_main_event : function(thepanel){
        var me = this;
        var theform = thepanel.findTabPanel({ myStamp : 'theClaimList'});
        var thebaseform = thepanel.findTabPanel({ myStamp : 'theForm'});
        var optype = thepanel.optype;
        var thePostData = thepanel.getMyDatas();
        var data = thepanel.$postValue;
//console.log(data);
        if(thebaseform && !data.otc_code){
            var otc_codefield = thebaseform.getForm().findField('otc_code');
            if(otc_codefield) otc_codefield.setVisible(false);
        }

        if(optype == 'view'){
            var clsname = "ui.ctrl.foundationclaim.foundationclaimCtrl";
            Ext.Loader.require([
                clsname
            ],function(d){
                var modelX = Ext.create(clsname , {ctrl : me});
                modelX.modelConf._listParams.id = data.id;

                var viewPanel= modelX.createViewByModule('foundationclaim');
                viewPanel.bodyBorder = false;

                viewPanel.on('render',function(){
                    var grid = viewPanel.getGridPanel();
                    var form = viewPanel.getFormPanel();
                    var store = grid.getStore();
                    store.load({id : data.id});
                    //modelX.$fireGridLoadList();
                });
                theform.add(viewPanel);
                theform.doLayout();

            },this);

            me.$requestAjax({
                url     :   me.$getUrlstrByUrlcode('get.foundationworktable.uploadlist'),
                method :    'POST',
                params :    { capitalid : data.id },
                scope  :    me,
                backParams: {},
                callback   :    function(response , backParams){
                    //console.log(response.responseText);
                    var theuploads = thepanel.findTabPanel({ myStamp : 'uploads'});
                    var param = Ext.decode(response.responseText);
                    var items = param.items;
                    if(items.length>0){
                        me.__sub_showuploadlist_panel(items , theuploads );
                    }else{
                        // theuploads.destroy();
                    }
                }
            });
        }
    },

    __sub_showuploadlist_panel : function(param , fatherpanel ,proinfo){
        var me = this;
        var thedownurl = me.$getUrlstrByUrlcode("get.foundationworktable.downFile");
        for(var i in param){
            var urls = thedownurl + "?id=" + param[i].id;
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
                        html : "<a target='_blank' href='"+ urls +"'>"+ param[i].filename+"</a>"
                    },
                    {
                        xtype : 'button',
                        columnWidth:.1 ,
                        text : '下载',
                        atturl : urls,
                        handler : function(btn){
                            window.open(btn.atturl);
                        }
                    }
                ]
            });
            fatherpanel.add(tmpanel);
        }
    },
/*添加字段及编辑删除自定义字段的事件定义--end*/
/*SUBSUBSUBSUB-----END*/

    __view_main_render : function(thepanel){
        var me = this;
        var mydata = thepanel.getMyDatas();
        me.$requestFromDataAjax(
            'get.foundationworktable.view',
            mydata,
            thepanel,
            function(params){
                // console.log(params);
            }
        );
    },

    __add_main_render : function(thepanel){
        var me = this;
    },

    __edit_main_render : function(thepanel){
        var me = this;
        var mydata = thepanel.getMyDatas();
        me.$requestFromDataAjax(
            'get.foundationworktable.view',
            mydata,
            thepanel
        );
    },

    /* 接口：
     * 功能信息面板的 字段组件的 初始 方法
     * 命名规则： __  +  optype(操作类型) + _fieldinit
     */
    __view_fieldinit : function(field){
        if(field.name === 'id') this.$setFieldStyle(field , 'disabled');
        if(field) field.readOnly = true;
        if(field.name === 'memo') field.readOnly=true;
    },

    __edit_fieldinit : function(field){
        if(field.name === 'total_amount') this.$setFieldStyle(field , 'disabled');
    },

    __add_fieldinit : function(field){ //otc_code
        if(field.name === 'total_amount') this.$setFieldStyle(field , 'readonly');
        if(field.name === 'otc_code') this.$setFieldStyle(field , 'disabled');
        if(field.name === 'id') this.$setFieldStyle(field , 'disabled');
    },

    __all_fieldinit : function(field,type  ,theform ,params){
    },

    __check_list_btn_event : function(cfg ,record){
        if(cfg.pmsCode === 'foundationworktable.submit'){
            if(record.data.status != 0 && record.data.status != 3 ) return false;
        }
        if(cfg.pmsCode === 'foundationworktable.edit'){
            if(record.data.status != 0 && record.data.status != 3) return false;
        }
        if(cfg.pmsCode === 'foundationworktable.delete'){
            if(record.data.status != 0 && record.data.status != 3 ) return false;
        }
        return true;
    }

});