/**
 * Created by Administrator on 2015/12/14 0014.
 */
Ext.define('ui.view.node.nodeComs.pageCenter', {
    extend: 'ui.extend.baseClass.coms.basePageCenter',
    alias: 'widget.nodepagecenter',
    region : 'center',
    layout : 'border',
    baseCls : 'my-panel-no-border',
    html : '&nbsp;',
    requires : [
        'ui.store.node.nodeStore',
        'ui.view.node.nodeComs.nodeListGrid'
    ],

    constructor : function(cfg){
        this.callParent(arguments);
    },

    init: function(){

    },

    initComponent : function(){
        var me = this;
        this.gridpanel = Ext.create('ui.view.node.nodeComs.nodeListGrid',{
            ctrl : this.ctrl
        });

        me.items = [this.gridpanel];
        this.callParent();
    }
});