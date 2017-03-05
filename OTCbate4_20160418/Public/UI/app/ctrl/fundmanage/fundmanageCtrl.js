/**
 * Created by Administrator on 2015/12/7 0007.
 */

Ext.define('ui.ctrl.fundmanage.fundmanageCtrl', {
    extend: 'ui.extend.baseClass.baseCtrl',
    requires : [
        'ui.ctrl.fundmanage.fundmanageConf',
        'ui.view.fundmanage.fundmanageView',
        'ui.view.fundmanage.Coms.viewPanel'
    ],
    views : [
        'ui.view.fundmanage.fundmanageView'
    ],

    refs:[
        {ref:'fundmanageWin' , selector:'fundmanagewindow'}
    ],

    constructor : function (cfg){
        this.modelConf = Ext.create('ui.ctrl.fundmanage.fundmanageConf');
        this.callParent(arguments);
    },

    init:function(){
        this.control({      //这里的this相当于这个控制层
            'fundmanagepagecentergrid' : {
                render : function(e){
                    //e.grid.getStore().load();
                }
            }
        });
    },

    //配置功能按钮功能  对应Conf类中定义的operationButtons > pmsCode { text : '新建角色+' , pmsCode : 'fundmanage.add' }
    //‘.’替换为 $  ,方法前加__
    __fundmanage$downloadexcel : function( btna , params ){
        var me = this;
        var view =  this.$getView();
        var url = me.$getUrlstrByUrlcode("get.fundmanage.downloadexcel");
        var postdata = view.getFormPanel().getForm().getFieldValues();
        var str = "?";
        for(var i in postdata){
            var tmp = Ext.Date.format(postdata[i],"Y-m-d");
            str += i;
            str += "=" + tmp;
            str += "&";
        }
        url = url + str;
        //alert(url)
        window.open(url);

    },
    __fundmanage$downloadpos : function( btna , params ){
        var me = this;
        var view =  this.$getView();
        var url = me.$getUrlstrByUrlcode("get.fundmanage.downloadall");
        var postdata = view.getFormPanel().getForm().getFieldValues();
        var str = "?";
        for(var i in postdata){
            var tmp = Ext.Date.format(postdata[i],"Y-m-d");
            str += i;
            str += "=" +tmp
            str += "&"
        }
        url = url + str;
        //alert(url)
        window.open(url);
    },

    __fundmanage$listdownload : function( btna , params ){
        var me = this;
        var view =  this.$getView();
        var url = me.$getUrlstrByUrlcode("get.fundmanage.downloadlist");
        var str = "?id=" + params.id + "&";
        url = url + str;
        //alert(url);
        window.open(url);
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
            'get.fundmanage.view',
            mydata,
            thepanel
        );
    },

    __edit_main_render : function(thepanel){
        var me = this;
        var mydata = thepanel.getMyDatas();
        me.$requestFromDataAjax(
            'get.fundmanage.view',
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