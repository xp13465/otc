/**
 * Created by Administrator on 2015/12/14 0014.
 */
Ext.define('ui.view.foundationclaim.Coms.pageCenter', {
    extend: 'ui.extend.baseClass.coms.basePageCenter',
    alias: 'widget.foundationclaimpagecenter',
    region : 'center',
    layout : 'border',
    baseCls : 'my-panel-no-border',
    html : '&nbsp;',
    requires : [
        'ui.view.foundationclaim.Coms.ListGrid'
    ],

    constructor : function(cfg){
        this.callParent(arguments);
    },

    init: function(){

    },

    initComponent : function(){
        var me = this;
        this.gridpanel = Ext.create('ui.view.foundationclaim.Coms.ListGrid',{
            ctrl : this.ctrl
        });

        me.items = [this.gridpanel];
        this.callParent();
    }
});