/**
 * Created by Administrator on 2015/12/7 0007.
 * operationButtons : 操作按钮的定义
 * searchFileds     : 查询字段的定义
 * listOperationButtons : 条目操作按钮的定义
 */
Ext.define('ui.ctrl.foundationcheck.foundationcheckConf',{
    extend: 'ui.extend.baseClass.baseConf',
    modelName : "资产包审核",
    topicalName : '资产包审核',
    modelCode : 'foundationcheck',
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
        'get.foundationcheck.list' : { url : "Foundation/getFundsAuditList" , 'pmsCode' : 'get.foundationcheck.list' , checkpms : 0 },
        'set.foundationcheck.pass' : { url : "Foundation/auditFoundation" , 'pmsCode' : 'set.foundationcheck.pass' , checkpms : 0 },
		'set.foundationcheck.back' : { url : "Foundation/foundSendBack" , 'pmsCode' : 'set.foundationcheck.back' , checkpms : 0 },
        'set.addfoundationfile' :  { url : "Foundation/foundationFileUpload" , 'pmsCode' : 'set.addfoundationfile' , checkpms : 0 },
        'get.getfoundationfile' :  { url : "Foundation/FoundAllUploadFile" , 'pmsCode' : 'get.getfoundationfile' , checkpms : 0 },
        'set.delfoundationfile' :  { url : "Foundation/FoundDelUploadFile" , 'pmsCode' : 'set.delfoundationfile' , checkpms : 0 },
		'get.foundationcheck.downFile' : { url : "Foundation/downFile" , 'pmsCode' : 'get.foundationcheck.downFile' , checkpms : 0 }
    },

    _opButtons : [
       
    ],

    _lstOpButtons : [
    { text : '查看' , pmsCode : 'foundationcheck.view' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1, iconCls : ''},    
	{ 'permissionCode' : "foundationcheck.upload",checkpms:0 , text : '上传审核资料' , pmsCode : 'foundationcheck.upload' , recKey : ['id']/*所需record之关键字列表*/  , iconCls : ''},
	{ 'permissionCode' : "foundationcheck.pass",checkpms:0 , text : '通过' , pmsCode : 'foundationcheck.pass' , recKey : ['id','status']/*所需record之关键字列表*/  , iconCls : ''},
	{ 'permissionCode' : "foundationcheck.back",checkpms:0 , text : '退回' , pmsCode : 'foundationcheck.back' , recKey : ['id','status']/*所需record之关键字列表*/  , iconCls : ''}
    ],

    _scFields : [
        {fieldLabel : '录入时间' ,editable:false,labelWidth : 80,width:190 , name : 'add_time' , fieldtype : 'Ext.form.field.ComboBox',displayField	: 'display', valueField 	: "value", value : 1,
			value:"",
		   store : new Ext.data.ArrayStore({
                fields	: 	['value', 'display'],
				autoLoad: true,
                data    :   [["",'不限'],[1,'1周内'],[2,'1个月内'],[3,'3个月内'],[4,'3个月以上']]
            }), pmsCode:'' , checkpms:0   },
        {fieldLabel : '关键字' ,labelWidth :80, name : 'keyword' ,width:190 , fieldtype : 'Ext.form.field.Text',
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
        'add' : []
    },
    /*
     * grid数据列表的头部定义*/
    _listGridHeader : [
        { header: '序号',width: 80,  dataIndex: 'id' } ,
        { header: '资产包名称',width: 160,   dataIndex: 'name'} ,
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
        { header: '录入时间', width: 180,  dataIndex: 'dat_create' }
        
    ] ,
    //_addInfo : [],
    _sub_win_defparams : { width:600 , height:480 },  //子窗口初始参数
    _viewInfo : [],
    _publicInfo : []
});