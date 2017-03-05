/**
 * Created by Administrator on 2015/12/7 0007.
 */
Ext.define('ui.ctrl.foundationclaim.foundationclaimCtrl', {
    extend: 'ui.extend.baseClass.baseCtrl',
    requires : [
        'ui.ctrl.foundationclaim.foundationclaimConf',
        'ui.view.foundationclaim.foundationclaimView',
        'ui.view.foundationclaim.Coms.viewPanel'
    ],
    views : [
        'ui.view.foundationclaim.foundationclaimView'
    ],

    refs:[
        {ref:'foundationclaimWin' , selector:'foundationclaimwindow'}
    ],

    constructor : function (cfg){
        this.modelConf = Ext.create('ui.ctrl.foundationclaim.foundationclaimConf' , {ctrl : cfg.ctrl});
        this.callParent(arguments);
    },

    init : function(){
        this.control({      //这里的this相当于这个控制层
            'foundationclaimpagecentergrid' : {
                render : function(e){
                    //e.grid.getStore().load();
                }
            }
        });
    },

    //配置功能按钮功能  对应Conf类中定义的operationButtons > pmsCode { text : '新建角色+' , pmsCode : 'foundationclaim.add' }
    //‘.’替换为 $  ,方法前加__

   /* 接口：
    * 信息面板里的 按钮 事件
    * 方法名规则  __ + 信息面板类型(view,edit,add等) + Panel + $ + 按钮定义的fnName .
    * 回参为 按钮和 本信息面板自己
    */

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
        var theform = thepanel.findTabPanel({ myStamp : 'theForm'});
        theform = theform.getForm();
    },
    //表单数据加载之后
    __all_post_after_main_event : function(thepanel){

    },

/*添加字段及编辑删除自定义字段的事件定义--end*/
/*SUBSUBSUBSUB-----END*/

    /* 接口：
     * 功能信息面板的 字段组件的 初始 方法
     * 命名规则： __  +  optype(操作类型) + _fieldinit
     */
    __check_list_btn_event : function(cfg ,record){
        return true;
    }

});