/**
 * Created by Administrator on 2015/12/24 0024.
 */
Ext.define('ui.view.node.nodeComs.viewPanel', {
    extend: 'ui.extend.baseClass.coms.baseBusTabPanel',
    alias: 'widget.nodeviewpanel',
    initComponent : function(){
        var me = this;
        this.callParent(arguments);
        var theform = Ext.create('ui.extend.base.Form',{
            title : '基本信息',
            autoShow : true ,
            html:"AAA"
        });
        this.addPanel(theform);
        theform = Ext.create('ui.extend.base.Form',{
            title : '基本信息1' ,
            html:"BBB"
        });
        this.addPanel(theform);
    }
});