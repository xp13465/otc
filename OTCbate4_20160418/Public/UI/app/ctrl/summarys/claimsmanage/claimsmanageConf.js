/**
 * Created by Administrator on 2015/12/7 0007.
 */
Ext.define('ui.ctrl.summarys.claimsmanage.claimsmanageConf', {
    extend: 'ui.extend.baseClass.baseConf',
    modelName : "系统参数设置",
    constructor: function(){
        this.callParent(arguments);
        var param = arguments[0];
        var ret = param || {};

        //在此配置此summary类型容器 的模块
        this.loadModelsList = this.loadModelsList || [];
        Ext.merge(this.loadModelsList ,[
            // { name: '债权录入', iconCls: 'notebook-icon', module: 'claimsAdd', group : '' , desc : "" , type : 1  , msgs : 0},
            // { name: '债权审核', iconCls : 'process-table-icon',  module: 'claimsaudit' , group : '' , desc : "" , type : 1 , msgs : 0},
            // { name: '债权发布', iconCls : 'process-table-icon',  module: 'claimspublish' , group : '' , desc : "" , type : 1 , msgs : 0},
            // { name: '债权管理', iconCls : 'process-table-icon',  module: 'claimsmanage' , group : '' , desc : "" , type : 1 , msgs : 0}
            
        ]);

        Ext.apply(ret,this.getDefaultWinSize());
        Ext.apply(this,ret);
    }
});