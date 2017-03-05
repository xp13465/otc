/**
 * Created by Administrator on 2015/12/7 0007.
 * operationButtons : 操作按钮的定义
 * searchFileds     : 查询字段的定义
 * listOperationButtons : 条目操作按钮的定义
 */
Ext.define('ui.ctrl.investmentrecord.investmentrecordConf',{
    extend: 'ui.extend.baseClass.baseConf',
    modelName : "投资记录",
    topicalName : '投资记录',
    modelCode : 'investmentrecord',
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
        'get.investmentrecord.list' : { url : "claims/claimRecord" , 'pmsCode' : 'get.investmentrecord.list' , checkpms : 0 },
        'get.investmentrecord.view' : { url : "claims/getClaimsinfo" , 'pmsCode' : 'get.investmentrecord.info' , checkpms : 0 },
        'get.investmentrecord.edit' : { url : "claims/saveClaims" , 'pmsCode' : 'set.investmentrecord.info' , checkpms : 0 },
        'set.investmentrecord.unsale' : { url : "claims/downClaims" , 'pmsCode' : 'set.investmentrecord.unsale' , checkpms : 0 }
    },
    _opButtons : [
        // { text : '新建+' , pmsCode : 'investmentrecord.add' ,recKey : ['id']  , checkpms:0 }
        // { text : '批量删除-' , pmsCode : 'investmentrecord.disable' ,recKey : ['id']  , checkpms:0 }
    ],
    _lstOpButtons : [
        // { text : '查看' , pmsCode : 'investmentrecord.view' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1, iconCls : ''},
        // { text : '下架' , pmsCode : 'investmentrecord.unsale' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1 ,iconCls : ''}
        // { text : '退回' , pmsCode : 'investmentrecord.reject' , recKey : ['id','status']/*所需record之关键字列表*/  , checkpms:1 ,iconCls : ''}
    ],
    _scFields : [
        {fieldLabel : '债权名称' ,labelWidth : 80, width:190,name : '' , fieldtype : 'Ext.form.field.Text', pmsCode:'' , checkpms:0 ,isSummary:1,summaryName:'product_name' ,readOnly:true },
        {fieldLabel : '债权总额' ,labelWidth : 80, width:190,name : '' , fieldtype : 'Ext.form.field.Text', pmsCode:'' , checkpms:0 ,isSummary:1,summaryName:'amt_ct' ,readOnly:true },
        {fieldLabel : '已投资余额' ,labelWidth : 80,width:190, name : '' , fieldtype : 'Ext.form.field.Text', pmsCode:'' , checkpms:0 ,isSummary:1,summaryName:'alred_invested' ,readOnly:true },
        {fieldLabel : '剩余金额' ,labelWidth : 80,width:190, name : '' , fieldtype : 'Ext.form.field.Text', pmsCode:'' , checkpms:0 ,isSummary:1,summaryName:'amt_ct_last' ,readOnly:true },
        {fieldLabel : '成交时间' ,labelWidth : 80, width:190,margin:"0 5px", editable:false,name : 'dealtime' , fieldtype : 'Ext.form.field.ComboBox',displayField    : 'display', valueField     : "value", value:0,
            store : new Ext.data.ArrayStore({
                fields  :   ['value', 'display'],
                data    :   [[0,'不限'],[1,'1周内'],[2,'1个月内'],[3,'3个月内'],[4,'3个月以上']]
            }), pmsCode:'' , checkpms:0   },
		{fieldLabel : '状态' ,labelWidth : 50, editable:false,width:150 ,name : 'cod_ivs_status' , fieldtype : 'Ext.form.field.ComboBox',displayField    : 'display', valueField     : "value", value : '',
            
			store : new Ext.data.ArrayStore({
                fields  :   ['value', 'display'], 
                data    :   [['','不限'],['1','已成交'],['2','已赎回']]
            }), pmsCode:'' , checkpms:0   },
      //  {fieldLabel : '起始时间' ,labelWidth : 70, name : 'startdate' , fieldtype : 'Ext.form.field.Date', pmsCode:'' , checkpms:0   },
       // {fieldLabel : '-' ,labelWidth : 20, name : 'enddate' , fieldtype : 'Ext.form.field.Date', pmsCode:'' , checkpms:0   },
        
        {fieldLabel : '关键字' ,labelWidth : 50,width:190, name : 'keyword' , fieldtype : 'Ext.form.field.Text', pmsCode:'' , checkpms:0  , emptyText : '（客户名称）' },
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
        { header: '客户名称',width: 100,   dataIndex: 'nam_cust_real'} ,
        { header: '身份证',width: 160,   dataIndex: 'cod_cust_id_no'} ,
        { header: '投资标的',width: 160,   dataIndex: 'title'} ,
        { header: '状态',width: 160,   dataIndex: 'status'} ,
        { header: '投资金额(元)',width: 160,   dataIndex: 'amt_ivs'} ,
        
        { header: '成交时间', width: 160,  dataIndex: 'dat_create' } 
    ] ,
    //_addInfo : [],
    _viewInfo : [],
    //_addInfo : [],
    _sub_win_defparams : { width:800 , height:500  , maximizable : true },  //子窗口初始参数
    
    _publicInfo : [
        // {
        //     title : '基本信息',
        //     // typeMode : ["view","edit","add"],
        //     xtype : 'form',
        //     layout : 'column',
        //     padding : 10,
        //     autoScroll : true,
        //     items :[
        //         {
        //             fieldLabel : '债权ID',
        //             labelWidth: 70,
        //             name : 'id',
        //             margin: 6,
        //             columnWidth :1,
        //             readOnly:true,
        //             filedType : 'Number'
        //         },{
        //             fieldLabel : '借款人姓名',
        //             labelWidth: 80,
        //             name : 'borrower',
        //             columnWidth :.5,
        //             margin: 6,
        //             filedType : 'Text'
        //         },{
        //             fieldLabel : '所在城市',
        //             labelWidth: 70,
        //             name : 'city',
        //             columnWidth :.5,
        //             margin: 6,
        //             filedType : 'Text'
        //         }
        //         ,{
        //             fieldLabel : '证件号码',
        //             labelWidth: 70,
        //             name : 'cod_card_no',
        //             columnWidth :.5,
        //             margin: 6,
        //             filedType : 'Text'
        //         },{
        //             fieldLabel : '手机号码',
        //             labelWidth: 70,
        //             name : 'telephone',
        //             columnWidth :.5,
        //             margin: 6,
        //             filedType : 'Text'
        //         }
        //         ,{
        //             fieldLabel : '开始日期',
        //             labelWidth: 70,
        //             name : 'startdate',
        //             columnWidth :.5,
        //             margin: 6,
        //             filedType : 'Text'
        //         },{
        //             fieldLabel : '结束日期',
        //             labelWidth: 70,
        //             name : 'enddate',
        //             columnWidth :.5,
        //             margin: 6,
        //             filedType : 'Text'
        //         },{
        //             fieldLabel : '期数',
        //             labelWidth: 70,
        //             name : 'period',
        //             columnWidth :.5,
        //             margin: 6,
        //             filedType : 'Text'
        //         },{
        //             fieldLabel : '金额',
        //             labelWidth: 70,
        //             name : 'amt_cf_inv_price',
        //             columnWidth :.5,
        //             margin: 6,
        //             filedType : 'Text'
        //         },{
        //             fieldLabel : '预期年化收益率',
        //             labelWidth: 70,
        //             name : 'rat_cf_inv_min',
        //             columnWidth :.5,
        //             margin: 6,
        //             filedType : 'Text'
        //         },{
        //             fieldLabel : '还款方式',
        //             labelWidth: 70,
        //             name : 'repay',
        //             columnWidth :.5,
        //             margin: 6,
        //             filedType : 'Text'
        //         },{
        //             fieldLabel : '借款用途',
        //             labelWidth: 70,
        //             name : 'use',
        //             columnWidth :1,
        //             margin: 6,
        //             filedType : 'TextArea'
        //         }
        //     ]
        // },{
        //     title : '投资记录',
        //     xtype : 'form',
        //     typeMode : ["edit","view"],
        //     layout : 'column',
        //     padding : 10,
        //     autoScroll : true,
        //     //collapsible:true,
        //     items :[]
        // }
    ]
});