/**
 * Created by Administrator on 2015/12/17 0017.
 */

Ext.define('ui.ctrl.summarys.claimsmanage.claimsmanageCtrl', {
    extend: 'ui.extend.baseClass.baseCtrl',
    uses : [
        'ui.ctrl.summarys.claimsmanage.claimsmanageConf',
        'ui.view.summarys.claimsmanage.claimsmanageView'
    ],
    views : [
        'ui.view.summarys.claimsmanage.claimsmanageView'
    ],
    constructor : function (cfg){
        this.modelConf = Ext.create('ui.ctrl.summarys.claimsmanage.claimsmanageConf');
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