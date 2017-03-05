/**
 * Created by Administrator on 2015/12/7 0007.
 * operationButtons : 操作按钮的定义
 * searchFileds     : 查询字段的定义
 * listOperationButtons : 条目操作按钮的定义
 */
Ext.define('ui.ctrl.investmentproductlist.investmentproductlistConf',{
    extend: 'ui.extend.baseClass.baseConf',
    modelName : "投资产品详情",
    topicalName : '投资产品详情',
    modelCode : 'investmentproductlist',
    groupCode : '',

    infoIconCls : {view:'',edti:'',add:''},
    init : function(){
        this.callParent(arguments);
    },

    constructor: function(){
        var me = this;
        this.callParent(arguments);

        this.urlslist = this.urlslist || {};
        this.$extendConfigJson('urlslist', this._urls);
        //模块的操作按钮
        this.$extendConfigArr('operationButtons',this._opButtons);
        //查询条件field设置
        this.$extendConfigArr('searchFileds',this._scFields);
        //条目操作按钮的定义
        this.$extendConfigArr('listOperationButtons',this._lstOpButtons);

        this.$extendConfigJson('infoPanelButtons',this._infoPanelButtons);
        //
        var param = arguments[0];
        var ret = param || {};
        Ext.apply(ret,this.getDefaultWinSize());
        Ext.apply(this,ret);
    },
    _listParams:{},
    _urls : {
        'get.investmentproductlist.list' : { url : "cfmast/productdetail" , 'pmsCode' : 'get.investmentproductlist.list' , checkpms : 0 },
        'get.investmentproductlist.view' : { url : "claims/getClaimsinfo" , 'pmsCode' : 'get.investmentproductlist.info' , checkpms : 0 },
        'get.investmentproductlist.edit' : { url : "claims/saveClaims" , 'pmsCode' : 'set.investmentproductlist.info' , checkpms : 0 },
        'set.investmentproductlist.unsale' : { url : "claims/downClaims" , 'pmsCode' : 'set.investmentproductlist.unsale' , checkpms : 0 }
    },
    _opButtons : [
        // { text : '新建+' , pmsCode : 'investmentproductlist.add' ,recKey : ['id']  , checkpms:0 }
        // { text : '批量删除-' , pmsCode : 'investmentproductlist.disable' ,recKey : ['id']  , checkpms:0 }
    ],
    _lstOpButtons : [
        { text : '查看' , pmsCode : 'investmentproductlist.view' , recKey : ['id','cod_period']/*所需record之关键字列表*/  , checkpms:1, iconCls : ''}
        // { text : '下架' , pmsCode : 'investmentproductlist.unsale' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1 ,iconCls : ''}
        // { text : '退回' , pmsCode : 'investmentproductlist.reject' , recKey : ['id','status']/*所需record之关键字列表*/  , checkpms:1 ,iconCls : ''}
    ],
    _scFields : [
        
        {fieldLabel : '发售时间' ,labelWidth : 80, editable:false,width:190 ,name : 'dat_modify' , fieldtype : 'Ext.form.field.ComboBox',displayField    : 'display', valueField     : "value", value : 0,
            value : '' ,
			store : new Ext.data.ArrayStore({
                fields  :   ['value', 'display'],
                data    :   [['','不限'],[1,'1周内'],[2,'1个月内'],[3,'3个月内'],[4,'3个月以上']]
            }), pmsCode:'' , checkpms:0   },
        // {fieldLabel : '起始时间' ,labelWidth : 70, name : 'startdate' , fieldtype : 'Ext.form.field.Date', pmsCode:'' , checkpms:0   },
        // {fieldLabel : '-' ,labelWidth : 20, name : 'enddate' , fieldtype : 'Ext.form.field.Date', pmsCode:'' , checkpms:0   },
        {fieldLabel : '产品状态' ,labelWidth : 70,width:190 , name : 'status' , fieldtype : 'Ext.form.field.ComboBox', pmsCode:'' , checkpms:0,
            displayField    : 'statusname',
            valueField  : "status",
			value : '' ,
            store : Ext.create('Ext.data.ArrayStore',{
                fields  :   ['status', 'statusname'],
				autoLoad:true,
                // data : [['','不限'],['0','未完成'],['1','待审核'],['2','待发布'],['3','审核退回'],['4','待销售'],['5','销售中'],['6','已售罄']] 
                proxy: Ext.create( 'ui.extend.base.Ajax',{
                    url : '/Admin/Cfmast/getStatusSelect/type/1'
                })
            })
        },
        {fieldLabel : '标的状态' ,labelWidth : 80, width:190 ,editable:false,name : 'bid_cf_status' , fieldtype : 'Ext.form.field.ComboBox',displayField    : 'display', valueField     : "value", 
		value : 0,
            store : new Ext.data.ArrayStore({
                fields  :   ['value', 'display'],
                data    :   [[0,'不限'],[1,'销售中'],[2,'已售罄'],[3,'未销售']]
            }), pmsCode:'' , checkpms:0   },
        {fieldLabel : '关键字' ,labelWidth : 50, name : 'keyword' ,width:200 , fieldtype : 'Ext.form.field.Text', pmsCode:'' , checkpms:0  , emptyText : '标的名称或资产包' },
        {fieldLabel : '查询' ,text : '查询' ,iconCls : '', fieldtype : 'Ext.button.Button'  , submitBtn : true , clickFn : '$search', pmsCode:'' , checkpms:0 }
    ],

    /*
    * 配置信息面板里的按钮，并制定事件后缀： fnName
    * */
    _infoPanelButtons : {
        'all' : [],
        'view' : [],
        'edit' : [{text : '保存' , fnName : 'save'}],
        'add' : [{text : '新建保存' , fnName : 'save'}]
    },
    /*
     * grid数据列表的头部定义*/
    _listGridHeader : [
        { header: '序号',width: 80,  dataIndex: 'id' } ,
        { header: '标的名称',width: 160,   dataIndex: 'bidname'} ,
        { header: '资产包',width: 100,   dataIndex: 'capitalname'} ,
        // { header: '',hidden:true,width: 100,   dataIndex: 'cod_period'} ,
        { header: '产品状态',width: 100,   dataIndex: 'cod_cf_status'} ,
        { header: '总金额',width: 150,   dataIndex: 'amt_ct'} ,
        { header: '标的状态',width: 100,   dataIndex: 'ctr_ct_finish',renderer:function(v){
            if(v == 0){
                return '未完成';
            }else if(v == 6){
                return '待审核';
            }else if(v == 7){
                return 'OTC审核准备';
            }else if(v == 8){
                return 'OTC审核中';
            }else if(v == 9){
                return 'OTC审核退回';
            }else if(v == 3){
                return '审核退回';
            }else if(v == 4){
                return '待发布';
            }else if(v == 1){
                return '正常';
            }else if(v == 2){
                return '暂停销售';
            }else if(v == 10){
                return '发布退回';
            }
            return v;
        }} ,
        { header: '剩余金额',width: 160,   dataIndex: 'amt_ct_last'} ,
        //{ header: '收益权投资转让人数(人)',width: 100,   dataIndex: 'allp2'} ,
        //{ header: '债权投资转让人数(人)',width: 100,   dataIndex: 'allp'} ,
        { header: '投资人数(人)',width: 100,   dataIndex: 'allp'} ,
        { header: '发售时间', width: 160,  dataIndex: 'dat_modify' }
    ] ,
    //_addInfo : [],
    _viewInfo : [],
    //_addInfo : [],
    _sub_win_defparams : { width:700 , height:500  , maximizable : true },  //子窗口初始参数
    
    _publicInfo : [

    ]
});