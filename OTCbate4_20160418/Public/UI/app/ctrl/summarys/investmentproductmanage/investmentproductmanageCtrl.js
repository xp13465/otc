/**
 * Created by Administrator on 2015/12/17 0017.
 */

Ext.define('ui.ctrl.summarys.investmentproductmanage.investmentproductmanageCtrl', {
    extend: 'ui.extend.baseClass.baseCtrl',
    uses : [
        'ui.ctrl.summarys.investmentproductmanage.investmentproductmanageConf',
        'ui.view.summarys.investmentproductmanage.investmentproductmanageView'
    ],
    views : [
        'ui.view.summarys.investmentproductmanage.investmentproductmanageView'
    ],
    constructor : function (cfg){
        this.modelConf = Ext.create('ui.ctrl.summarys.investmentproductmanage.investmentproductmanageConf');
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