/**
 * Created by Administrator on 2015/12/14 0014.
 */
Ext.define('ui.view.investmentproducts.Coms.pageCenter', {
    extend: 'ui.extend.baseClass.coms.basePageCenter',
    alias: 'widget.investmentproductspagecenter',
    region : 'center',
    layout : 'border',
    baseCls : 'my-panel-no-border',
    html : '&nbsp;',
    requires : [
        'ui.view.investmentproducts.Coms.ListGrid'
    ],

    constructor : function(cfg){
        this.callParent(arguments);
    },

    init: function(){

    },

    initComponent : function(){
        var me = this;
        this.gridpanel = Ext.create('ui.view.investmentproducts.Coms.ListGrid',{
            ctrl : this.ctrl
        });

        me.items = [this.gridpanel];
        this.callParent();
    }
});