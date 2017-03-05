/**
 * Created by Administrator on 2015/12/7 0007.
 * operationButtons : 操作按钮的定义
 * searchFileds     : 查询字段的定义
 * listOperationButtons : 条目操作按钮的定义
 */
Ext.define('ui.ctrl.foundationlist.foundationlistConf',{
    extend: 'ui.extend.baseClass.baseConf',
    modelName : "资产包管理",
    topicalName : '资产包管理',
    modelCode : 'foundationlist',
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

    _urls : {
        'get.foundationlist.list' : { url : "Foundation/foundationList" , 'pmsCode' : 'get.foundationlist.list' , checkpms : 0 },
        'get.foundationlist.view' : { url : "claims/getClaimsinfo" , 'pmsCode' : 'get.foundationlist.info' , checkpms : 0 },
        'set.foundationlist.appending' : { url : "Foundation/pauseFound" , 'pmsCode' : 'set.foundationlist.appending' , checkpms : 0 },
        'set.foundationlist.restart' : { url : "Foundation/resumeFound" , 'pmsCode' : 'set.foundationlist.restart' , checkpms : 0 },
        'get.foundationclaim.list' : { url : "Foundation/foundAllClaims" , 'pmsCode' : 'get.foundationclaim.list' , checkpms : 0 },
        'set.foundationlist.repurchase' : { url : "Foundation/repurchase" , 'pmsCode' : 'get.foundationlist.repurchase' , checkpms : 0 }
        
    },
    
    _opButtons : [
        // { text : '新建+' , pmsCode : 'foundationlist.add' ,recKey : ['id']  , checkpms:0 }
        // { text : '批量删除-' , pmsCode : 'foundationlist.disable' ,recKey : ['id']  , checkpms:0 }
    ],
    _lstOpButtons : [
        { text : '查看' , pmsCode : 'foundationlist.view' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1, iconCls : ''},
        { text : '暂停使用' , pmsCode : 'foundationlist.appending' , recKey : ['id','status']/*所需record之关键字列表*/  , checkpms:1, iconCls : ''},
        { text : '恢复使用' , pmsCode : 'foundationlist.restart' , recKey : ['id','status']/*所需record之关键字列表*/  , checkpms:1, iconCls : ''},
        { text : '回购' , pmsCode : 'foundationlist.rebuy' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1, iconCls : ''}
        
       
    ],
    // _summaryFields:[
    //     {fieldLabel : '可投资余额' ,labelWidth : 50, name : '' , fieldtype : 'Ext.form.field.Text', pmsCode:'' , checkpms:0   }
    // ],
    _scFields : [
        {fieldLabel : '资产类型' ,labelWidth :80, width:200	,name : 'investment_type' , fieldtype : 'Ext.form.field.ComboBox',displayField	: 'display', valueField 	: "value", value : 0,
            editable:false,
            store : new Ext.data.ArrayStore({
                fields	: 	['value', 'display'],
                data	:	[[0,'不限'],[1,'债权转让'],[2,'收益权转让']]
            }), pmsCode:'' , checkpms:0   } ,
		{fieldLabel : '资产包状态' ,labelWidth :80,width:190, name : 'status' , fieldtype : 'Ext.form.field.ComboBox',displayField	: 'display', valueField 	: "value", value : 0,
            editable:false,
			value:"",
            store : new Ext.data.ArrayStore({
                fields	: 	['value', 'display'], 
				autoLoad: true,
				proxy: Ext.create( 'ui.extend.base.Ajax',{
                    url : '/Admin/Foundation/allFoundStatus/type/1'
                })
            }), pmsCode:'' , checkpms:0   } ,
        {fieldLabel : '录入时间' ,labelWidth : 80, width:190,name : 'add_time' , fieldtype : 'Ext.form.field.ComboBox',displayField	: 'display', valueField 	: "value", value : 0,
            editable:false,
            store : new Ext.data.ArrayStore({
                fields	: 	['value', 'display'],
                data	:	[[0,'不限'],[1,'1周内'],[2,'1个月内'],[3,'3个月内'],[4,'3个月以上']]
            }), pmsCode:'' , checkpms:0   },
        {fieldLabel : '关键字' ,labelWidth :80, width:200, name : 'keyword' , fieldtype : 'Ext.form.field.Text',
            emptyText:"资产包名称" , value : "", pmsCode:'' , checkpms:0   } ,
         {text : '查询' ,iconCls : '', fieldtype : 'Ext.button.Button'  , submitBtn : true , clickFn : '$search', pmsCode:'' , checkpms:0 }
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
		{ header: '资产包名称',width: 160,   dataIndex: 'name',renderer:function(v,p,record){
            if(record.data.isshow == 1){
                return "<span class='star-open-icon'></span>" + v + "";
            }
            return "<span class='star-close-icon'></span>" + v + "";
        }} ,
		
		{ header: '对应产品',width: 120,  dataIndex: 'title' } ,
        { header: '资产类型', width: 120,  dataIndex: 'investment_type' ,renderer : function(v){
            if(v == 1){
                return '债权转让';
            }else if(v == 2){
                return '收益权转让';
            }
            return v;
        } } ,
        { header: '资产包状态', width: 120,  dataIndex: 'status' ,renderer : function(v){
            if(v == 0){
                return '未完成';
            }else if(v == 1){
                return '待审核';
            }else if(v == 2){
				return '审核通过';
			}else if(v == 3){
				return '审核退回';
			}else if(v == 4){
				return '暂停使用';
			}
            return v;
        } } ,
		{ header: '实际规模(元)', width: 180,  dataIndex: 'total_amount' },
        { header: '录入时间', width: 180,  dataIndex: 'dat_create' }
        
    ] ,
    //_addInfo : [],
    _viewInfo : [],
    //_addInfo : [],
    _sub_win_defparams : { width:800 , height:500  , maximizable : true },  //子窗口初始参数
    
    _publicInfo : [
        {
            title : '基本信息',
            // typeMode : ["view","edit","add"],
            xtype : 'form',
            layout : 'column',
            padding : 10,
            autoScroll : true,
            items :[
                {
                    fieldLabel : '债权ID',
                    labelWidth: 70,
                    name : 'id',
                    margin: 6,
                    columnWidth :1,
                    readOnly:true,
                    filedType : 'Number'
                },{
                    fieldLabel : '借款人姓名',
                    labelWidth: 80,
                    name : 'borrower',
                    columnWidth :.5,
                    margin: 6,
                    filedType : 'Text'
                },{
                    fieldLabel : '所在城市',
                    labelWidth: 70,
                    name : 'city',
                    columnWidth :.5,
                    margin: 6,
                    filedType : 'Text'
                }
                ,{
                    fieldLabel : '证件号码',
                    labelWidth: 70,
                    name : 'cod_card_no',
                    columnWidth :.5,
                    margin: 6,
                    filedType : 'Text'
                },{
                    fieldLabel : '手机号码',
                    labelWidth: 70,
                    name : 'telephone',
                    columnWidth :.5,
                    margin: 6,
                    filedType : 'Text'
                }
                ,{
                    fieldLabel : '开始日期',
                    labelWidth: 70,
                    name : 'startdate',
                    columnWidth :.5,
                    margin: 6,
                    filedType : 'Text'
                },{
                    fieldLabel : '结束日期',
                    labelWidth: 70,
                    name : 'enddate',
                    columnWidth :.5,
                    margin: 6,
                    filedType : 'Text'
                },{
                    fieldLabel : '期数',
                    labelWidth: 70,
                    name : 'period',
                    columnWidth :.5,
                    margin: 6,
                    filedType : 'Text'
                },{
                    fieldLabel : '金额',
                    labelWidth: 70,
                    name : 'amt_cf_inv_price',
                    columnWidth :.5,
                    margin: 6,
                    filedType : 'Text'
                },{
                    fieldLabel : '预期年化收益率',
                    labelWidth: 70,
                    name : 'rat_cf_inv_min',
                    columnWidth :.5,
                    margin: 6,
                    filedType : 'Text'
                },{
                    fieldLabel : '还款方式',
                    labelWidth: 70,
                    name : 'repay',
                    columnWidth :.5,
                    margin: 6,
                    filedType : 'Text'
                },{
                    fieldLabel : '借款用途',
                    labelWidth: 70,
                    name : 'use',
                    columnWidth :1,
                    margin: 6,
                    filedType : 'TextArea'
                }
            ]
        },{
            title : '投资记录',
            xtype : 'form',
            typeMode : ["edit","view"],
            layout : 'fit',
            padding : 0,
            //collapsible:true,
            items :[]
        }
    ]
});