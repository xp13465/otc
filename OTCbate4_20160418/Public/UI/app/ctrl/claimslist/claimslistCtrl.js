/**
 * Created by Administrator on 2015/12/7 0007.
 */

Ext.define('ui.ctrl.claimslist.claimslistCtrl', {
    extend: 'ui.extend.baseClass.baseCtrl',
    requires : [
        'ui.ctrl.claimslist.claimslistConf',
        'ui.view.claimslist.claimslistView',
        'ui.view.claimslist.Coms.viewPanel'
    ],
    views : [
        'ui.view.claimslist.claimslistView'
    ],

    refs:[
        {ref:'claimslistWin' , selector:'claimslistwindow'}
    ],

    constructor : function (cfg){
        this.modelConf = Ext.create('ui.ctrl.claimslist.claimslistConf');
        this.callParent(arguments);
    },

    init:function(){
        this.control({      //这里的this相当于这个控制层
            'claimslistpagecentergrid' : {
                render : function(e){
                    //e.grid.getStore().load();
                }
            }
        });
    },

    //配置功能按钮功能  对应Conf类中定义的operationButtons > pmsCode { text : '新建角色+' , pmsCode : 'claimslist.add' }
    //‘.’替换为 $  ,方法前加__
    __claimslist$add : function( btna , params ){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        if(!pmsCode) return;
        me.$showOptionsPanel('add', pmsCode ,function(panel ,win){
            //这里对panel进行处理
        });
    },
    __claimslist$cexiao : function( btna , params ){
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
                        url     :   me.$getUrlstrByUrlcode('set.claimslist.delete'),
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
    __claimslist$publish : function( btna , params ){
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
            msg : '确认发布吗',
            yes : function(){
                me.$requestAjax({
                    url     :   me.$getUrlstrByUrlcode('set.claimslist.publish'),
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
    __claimslist$view : function( btna , params ){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        if(!pmsCode) return;
        var param  = params || {};
        Ext.apply( param , { pmsCode : pmsCode} );
        me.$requestAjax({
                url : me.$getConfig('urls').get('get.claimslist.viewclaimsinfo').url,
                method : "POST",
                params : {
                    cod_cf_ivs_id: params.id,
                    cf_mast_id:param.cod_cf_id,
                    cf_ctl_id:param.cod_cf_ctl_id,
                    cod_cust_id:param.cod_cust_id

                },
                scope : me ,
                backParams: {} ,
                callback : function(response , backParams){
                    
                    var param = Ext.decode(response.responseText);
                    // console.log(param);
                    if(param.items.length>0){
                        me.modelConf._publicInfo=[];
                       for(var i=0 ;i<param.items.length;i++){
                            // var newPanel= Ext.create('Ext.panel.Panel', {
                               
                            //     title : '基本信息',
                            //     typeMode : ["view","edit","add"],
                            //     xtype : 'form',
                            //     layout : 'column',
                            //     padding : 10,
                            //     autoScroll : true,
                            //     items :[{
                            //         fieldLabel : '借款人姓名',
                            //         labelWidth: 80,
                            //         name : 'borrower',
                            //         columnWidth :.5,
                            //         margin: 6,
                            //         filedType : 'Text'
                            //     }]
                            // });
                            var newTab={
                                title : param.items[i].product_name,
                                typeMode : ["view","edit","add"],
                                xtype : 'form',
                                layout : 'column',
                                padding : 10,
                                autoScroll : true,
                                items :[{
                                    fieldLabel : '债权名称',
                                    labelWidth: 80,
                                    name : 'product_name',
                                    columnWidth :.5,
                                    margin: 6,
                                    filedType : 'Text',
                                    value:param.items[i].product_name
                                },{
                                    fieldLabel : '已投金额',
                                    labelWidth: 80,
                                    name : 'investmoney',
                                    columnWidth :.5,
                                    margin: 6,
                                    filedType : 'Text',
                                    value:param.items[i].investmoney
                                },{
                                    fieldLabel : '债权金额',
                                    labelWidth: 80,
                                    name : 'amt_ct',
                                    columnWidth :.5,
                                    margin: 6,
                                    filedType : 'Text',
                                    value:param.items[i].amt_ct
                                },{
                                    fieldLabel : '剩余金额',
                                    labelWidth: 80,
                                    name : 'amt_ct_last',
                                    columnWidth :.5,
                                    margin: 6,
                                    filedType : 'Text',
                                    value:param.items[i].amt_ct_last
                                },{
                                    fieldLabel : '借款人姓名',
                                    labelWidth: 80,
                                    name : 'borrower',
                                    columnWidth :.5,
                                    margin: 6,
                                    filedType : 'Text',
                                    value:param.items[i].borrower
                                },{
                                    fieldLabel : '对应投资金额',
                                    labelWidth: 100,
                                    name : 'amt_ivs',
                                    columnWidth :.5,
                                    margin: 6,
                                    filedType : 'Text',
                                    value:param.items[i].amt_ivs
                                },{
                                    fieldLabel : '客户姓名',
                                    labelWidth: 80,
                                    name : 'nam_cust_real',
                                    columnWidth :.5,
                                    margin: 6,
                                    filedType : 'Text',
                                    value:param.items[i].nam_cust_real
                                },{
                                    fieldLabel : '所在城市',
                                    labelWidth: 80,
                                    name : 'city',
                                    columnWidth :.5,
                                    margin: 6,
                                    filedType : 'Text',
                                    value:param.items[i].city
                                },{
                                    fieldLabel : '证件号码',
                                    labelWidth: 80,
                                    name : 'cod_card_no',
                                    columnWidth :.5,
                                    margin: 6,
                                    filedType : 'Text',
                                    value:param.items[i].cod_card_no
                                },{
                                    fieldLabel : '手机号码',
                                    labelWidth: 80,
                                    name : 'telephone',
                                    columnWidth :.5,
                                    margin: 6,
                                    filedType : 'Text',
                                    value:param.items[i].telephone
                                },{
                                    fieldLabel : '开始日期',
                                    labelWidth: 80,
                                    name : 'startdate',
                                    columnWidth :.5,
                                    margin: 6,
                                    filedType : 'Date',
                                    value:param.items[i].startdate
                                },{
                                    fieldLabel : '结束日期',
                                    labelWidth: 80,
                                    name : 'enddate',
                                    columnWidth :.5,
                                    margin: 6,
                                    filedType : 'Date',
                                    value:param.items[i].enddate
                                },{
                                    fieldLabel : '期数',
                                    labelWidth: 80,
                                    name : 'period',
                                    columnWidth :.5,
                                    margin: 6,
                                    filedType : 'Text',
                                    value:param.items[i].period
                                },{
                                    fieldLabel : '金额',
                                    labelWidth: 80,
                                    name : 'amt_cf_inv_price',
                                    columnWidth :.5,
                                    margin: 6,
                                    filedType : 'Text',
                                    value:param.items[i].amt_cf_inv_price
                                },{
                                    fieldLabel : '预期年化收益',
                                    labelWidth: 80,
                                    name : 'rat_cf_inv_min',
                                    columnWidth :.5,
                                    margin: 6,
                                    filedType : 'Text',
                                    value:param.items[i].rat_cf_inv_min
                                },{
                                    fieldLabel : '还款方式',
                                    labelWidth: 80,
                                    name : 'repay',
                                    columnWidth :.5,
                                    margin: 6,
                                    filedType : 'Text',
                                    value:param.items[i].repay
                                },{
                                    fieldLabel : '借款用途',
                                    labelWidth: 80,
                                    name : 'use',
                                    columnWidth :1,
                                    margin: 6,
                                    filedType : 'TextArea',
                                    value:param.items[i].use
                                }]
                            };
                            me.modelConf._publicInfo.push(newTab);
                            
                        }
                        // console.log(me.modelConf._publicInfo);
                       // panel.ownerCt.doLayout();

                       me.$showOptionsPanel('view', param ,function( panel ,win ){
                            // 这里对panel进行处理
                            

                            
                        });
                    }
                    // Ext.Msg.alert('提示',action.result.msg);
                }
            });
        // console.log(me.modelConf._publicInfo);
        
    },

    __claimslist$edit : function( btna , params ){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        if(!pmsCode) return;
        var param  = params || {};
        Ext.apply( param , { pmsCode : pmsCode} );

        me.$showOptionsPanel('edit', param ,function( panel ,win ){
            //这里对panel进行处理
        });
    },
    __claimslist$approve : function( btna , params ){
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
                    url     :   me.$getUrlstrByUrlcode('set.claimslist.change'),
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

    __claimslist$reject : function( btna , params ){
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
                    url     :   me.$getUrlstrByUrlcode('set.claimslist.change'),
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
            'get.claimslist.edit',
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
            'get.claimslist.edit',
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
            'get.claimslist.view',
            mydata,
            thepanel
        );
    },

    __edit_main_render : function(thepanel){
        var me = this;
        var mydata = thepanel.getMyDatas();
        me.$requestFromDataAjax(
            'get.claimslist.view',
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
        if(cfg.pmsCode === 'claimslist.view'){
            if(record.data.cod_ivs_status !="1" )return false;
        }
        
        return true;
    }

});