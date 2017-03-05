/**
 * Created by Administrator on 2015/12/17 0017.
 */

Ext.define('ui.ctrl.summarys.foundationmanage.foundationmanageCtrl', {
    extend: 'ui.extend.baseClass.baseCtrl',
    uses : [
        'ui.ctrl.summarys.foundationmanage.foundationmanageConf',
        'ui.view.summarys.foundationmanage.foundationmanageView'
    ],
    views : [
        'ui.view.summarys.foundationmanage.foundationmanageView'
    ],
    constructor : function (cfg){
        this.modelConf = Ext.create('ui.ctrl.summarys.foundationmanage.foundationmanageConf');
        this.callParent(arguments);
    },

    init:function(){
        this.control({       //这里的this相当于这个控制层

        });

    },

    initComponent : function(){
        //this.
    }
});