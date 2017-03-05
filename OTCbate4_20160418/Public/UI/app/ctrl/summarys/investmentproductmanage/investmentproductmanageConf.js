/**
 * Created by Administrator on 2015/12/7 0007.
 */
Ext.define('ui.ctrl.summarys.investmentproductmanage.investmentproductmanageConf', {
    extend: 'ui.extend.baseClass.baseConf',
    modelName : "系统参数设置",
    constructor: function(){
        this.callParent(arguments);
        var param = arguments[0];
        var ret = param || {};

        //在此配置此summary类型容器 的模块
        this.loadModelsList = this.loadModelsList || [];
        Ext.merge(this.loadModelsList ,[
            { name: '投资产品录入', iconCls: 'notebook-icon', module: 'investmentproductadd', group : '' , desc : "" , type : 1  , msgs : 0},
            { name: '投资产品审核', iconCls : 'process-table-icon',  module: 'investmentproductaudit' , group : '' , desc : "" , type : 1 , msgs : 0},
            { name: '投资产品发布', iconCls : 'process-table-icon',  module: 'investmentproductpublish' , group : '' , desc : "" , type : 1 , msgs : 0},
            { name: '投资产品管理', iconCls : 'process-table-icon',  module: 'investmentproducts' , group : '' , desc : "" , type : 1 , msgs : 0}
            
        ]);

        Ext.apply(ret,this.getDefaultWinSize());
        Ext.apply(this,ret);
    }
});