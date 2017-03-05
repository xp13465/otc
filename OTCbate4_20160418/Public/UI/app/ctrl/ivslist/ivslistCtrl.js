/**
 * Created by Administrator on 2015/12/7 0007.
 */

Ext.define('ui.ctrl.ivslist.ivslistCtrl', {
    extend: 'ui.extend.baseClass.baseCtrl',
    requires : [
        'ui.ctrl.ivslist.ivslistConf',
        'ui.view.ivslist.ivslistView',
        'ui.view.ivslist.Coms.viewPanel'
    ],
    views : [
        'ui.view.ivslist.ivslistView'
    ],

    refs:[
        {ref:'ivslistWin' , selector:'ivslistwindow'}
    ],

    constructor : function (cfg){
        this.modelConf = Ext.create('ui.ctrl.ivslist.ivslistConf');
        this.callParent(arguments);
    },

    init:function(){
        this.control({      //这里的this相当于这个控制层
            'ivslistpagecentergrid' : {
                render : function(e){
                    //e.grid.getStore().load();
                }
            }
        });
    },

    //配置功能按钮功能  对应Conf类中定义的operationButtons > pmsCode { text : '新建角色+' , pmsCode : 'ivslist.add' }
    //‘.’替换为 $  ,方法前加__
    __ivslist$downloadexcel : function( btna , params ){
        var me = this;
        var view =  this.$getView();
        var url = me.$getUrlstrByUrlcode("get.ivslist.downloadexcel");
        var postdata = view.getFormPanel().getForm().getFieldValues();
        var str = "?";
        for(var i in postdata){
			var tmp = postdata[i];
			if(i=="startdate"||i=="enddate"){
				 var tmp = Ext.Date.format(tmp,"Y-m-d");
			}
            str += i;
            str += "=" + tmp;
            str += "&";
        }
        url = url + str;
        //alert(url)
        window.open(url);

    },
    __ivslist$downloadpos : function( btna , params ){
        var me = this;
        var view =  this.$getView();
        var url = me.$getUrlstrByUrlcode("get.ivslist.downloadall");
        var postdata = view.getFormPanel().getForm().getFieldValues();
        var str = "?";
        for(var i in postdata){
           var tmp = postdata[i];
			if(i=="startdate"||i=="enddate"){
				 var tmp = Ext.Date.format(tmp,"Y-m-d");
			}
            str += i;
            str += "=" +tmp
            str += "&"
        }
        url = url + str;
        //alert(url)
        window.open(url);
    },

    __ivslist$listdownload : function( btna , params ){
        var me = this;
        var view =  this.$getView();
        var url = me.$getUrlstrByUrlcode("get.ivslist.downloadlist");
        var str = "?id=" + params.id + "&";
        url = url + str;
        //alert(url);
        window.open(url);
    },
	__ivslist$confirm : function( btna , params ){
        var me = this;
        //getUserUploadContract
        var arrivaldate='';

        var theDocspanel = Ext.create("ui.extend.base.Panel",{
            border : 0 ,
            columnWidth :1 ,
            myStamp : 'theDocsList',
            layout : 'column',
            items : []
        });
        
        var codeText=Ext.create("Ext.form.field.Date",{
            name: 'code',
            id:'arrivaldate',
            fieldLabel: '到账日期',
            value:'',
            labelWidth: 70,
            name : 'startdate',
            columnWidth :0.9,
            margin: 6,
            allowBlank:false,
            beforeLabelTextTpl:'<span style="color:red">*</span>',
            blankText:"请选择确认日期",
            format:'Y-m-d',
            submitFormat:'Y-m-d',
            filedType : 'Date'

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
                xtype : 'button',
                columnWidth:.15,
                margin : "0 5" ,
                text : '确认到账' ,
                // disabled : true ,
                handler : function(btn){
                    // console.log(this.code);
                    uploadPanel.getForm().submit({
                        url: me.$getConfig('urls').get('get.ivslist.confirm').url , //'../Product/productAddContract',
                        params: {
                            id: params.id,
                            arrivaldate:Ext.getCmp('arrivaldate').getValue()
                        },
                        success: function(form, action){
							
							Ext.Msg.alert('提示',action.result.msg);
							winConfirm.close(); 
							me.$reloadViewGrid();
                            // me.__sub_showuploadlist_panel([action.result.data] , theDocspanel ,params);
                        },
                        failure: function(form, action){
                             Ext.Msg.alert('提示',action.result.msg);
                        }
                    })
                }
            }]
        });

        var winConfirm=Ext.create('Ext.window.Window', {
            title: '确认到账',
            width: 400,
            height:200,
            minWidth: 300,
            minHeight: 100,
            bodyStyle:'padding:5px;',
            buttonAlign : 'center' ,
            autoScroll : true,
            items : [otcpanel,theDocspanel],
           
            buttons: [uploadPanel]
        });
        winConfirm.show();
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
            'get.ivslist.view',
            mydata,
            thepanel
        );
    },

    __edit_main_render : function(thepanel){
        var me = this;
        var mydata = thepanel.getMyDatas();
        me.$requestFromDataAjax(
            'get.ivslist.view',
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
        if(cfg.pmsCode === 'ivslist.confirm'){
            if(record.data.usr_arrival !="0"  )return false;
        }
        return true;
    }

});