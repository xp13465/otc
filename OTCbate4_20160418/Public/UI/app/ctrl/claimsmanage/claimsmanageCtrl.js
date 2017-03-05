/**
 * Created by Administrator on 2015/12/7 0007.
 */

Ext.define('ui.ctrl.claimsmanage.claimsmanageCtrl', {
    extend: 'ui.extend.baseClass.baseCtrl',
    requires : [
        'ui.ctrl.claimsmanage.claimsmanageConf',
        'ui.view.claimsmanage.claimsmanageView',
        'ui.view.claimsmanage.Coms.viewPanel'
    ],
    views : [
        'ui.view.claimsmanage.claimsmanageView'
    ],

    refs:[
        {ref:'claimsmanageWin' , selector:'claimsmanagewindow'}
    ],

    constructor : function (cfg){
        this.modelConf = Ext.create('ui.ctrl.claimsmanage.claimsmanageConf');
        this.callParent(arguments);
    },

    init:function(){
        this.control({      //这里的this相当于这个控制层
            'claimsmanagepagecentergrid' : {
                render : function(e){
                    //e.grid.getStore().load();
                }
            }
        });
    },
    
    //配置功能按钮功能  对应Conf类中定义的operationButtons > pmsCode { text : '新建角色+' , pmsCode : 'claimsmanage.add' }
    //‘.’替换为 $  ,方法前加__
    __claimsmanage$add : function( btna , params ){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        if(!pmsCode) return;
        me.$showOptionsPanel('add', pmsCode ,function(panel ,win){
            //这里对panel进行处理
        });
    },
    __claimsmanage$cexiao : function( btna , params ){
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
                        url     :   me.$getUrlstrByUrlcode('set.claimsmanage.delete'),
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
    __claimsmanage$unsale : function( btna , params ){
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
                    url     :   me.$getUrlstrByUrlcode('set.claimsmanage.unsale'),
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
    __claimsmanage$view : function( btna , params ){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        if(!pmsCode) return;
        var param  = params || {};
        Ext.apply( param , { pmsCode : pmsCode} );

        me.$showOptionsPanel('view', param ,function( panel ,win ){
            //这里对panel进行处理
           
            var clsname = "ui.ctrl.investmentrecord.investmentrecordCtrl";
             Ext.Loader.require([
                clsname
            ],function(d){
                var modelX = Ext.create(clsname , {ctrl : me});
                modelX.modelConf._listParams.cod_cl_id=param.id;
                // console.log('a'+modelX.modelConf._listParams.cod_cl_id);
                var viewPanel= modelX.createViewByModule('investmentrecord');
                viewPanel.bodyBorder=false;
                // console.log(viewPanel);
               // panel.formsList[1].removeAll();
               panel.formsList[1].add(viewPanel);
               panel.doLayout();
               
            },this);
            
        });
    },

    __claimsmanage$edit : function( btna , params ){
        var me = this;
        var pmsCode = btna.pmsCode?btna.pmsCode:($(btna).attr('pmscode')?$(btna).attr('pmscode'):null);
        if(!pmsCode) return;
        var param  = params || {};
        Ext.apply( param , { pmsCode : pmsCode} );

        me.$showOptionsPanel('edit', param ,function( panel ,win ){
            //这里对panel进行处理
        });
    },
    __claimsmanage$approve : function( btna , params ){
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
                    url     :   me.$getUrlstrByUrlcode('set.claimsmanage.change'),
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
    __claimsmanage$reject : function( btna , params ){
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
                    url     :   me.$getUrlstrByUrlcode('set.claimsmanage.change'),
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
            'get.claimsmanage.edit',
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
            'get.claimsmanage.edit',
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
     * 功能信息面板的 render 处理
     * 命名规则： __  +  optype(操作类型) + _main_render
     * 作用域 ctrl
     */
    __view_main_render : function(thepanel){
        var me = this;
        var mydata = thepanel.getMyDatas();
        me.$requestFromDataAjax(
            'get.claimsmanage.view',
            mydata,
            thepanel
        );
    },

    __edit_main_render : function(thepanel){
        var me = this;
        var mydata = thepanel.getMyDatas();
        me.$requestFromDataAjax(
            'get.claimsmanage.view',
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
        if(cfg.pmsCode === 'claimsmanage.unsale'){
			if(record.data.zcb_status_code==2){
				return false;
			}else if(record.data.status_code !="4"){
				return false
			}
            
        }
        
        return true;
    }

});