/**
 * Created by Administrator on 2015/12/7 0007.
 * operationButtons : 操作按钮的定义
 * searchFileds     : 查询字段的定义
 * listOperationButtons : 条目操作按钮的定义
 */
Ext.define('ui.ctrl.fundmanage.fundmanageConf',{
    extend: 'ui.extend.baseClass.baseConf',
    modelName : "资产包管理",
    topicalName : '资产包管理',
    modelCode : 'fundmanage',
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
        'get.fundmanage.list' : { url : "Foundation/foundationList" , 'pmsCode' : 'get.ivslist.list' , checkpms : 0 },
        'get.fundmanage.downloadexcel' : { url : "Cfmast/outpos2excel" , 'pmsCode' : 'get.ivslist.download' , checkpms : 0 },
        'get.fundmanage.downloadall' : { url : "Cfmast/ZipPosFiles" , 'pmsCode' : 'get.claimslist.view' , checkpms : 0 },
        'get.fundmanage.downloadlist' : { url : "Cfmast/downposfile" , 'pmsCode' : 'get.claimslist.view' , checkpms : 0 }
    },
    _opButtons : [
      //  { text : '导出EXCEL' , pmsCode : 'ivslist.downloadexcel' ,recKey : ['id']  , permisstionCode:"Admin-Cfmast-outpos2excel" , checkpms:0 },
      //  { text : '打包下载扫描件' , pmsCode : 'ivslist.downloadpos' ,recKey : ['id']   , permisstionCode:"Admin-Cfmast-ZipPosFiles" , checkpms:0  }
    ],
    _lstOpButtons : [
       // { text : '下载' , pmsCode : 'ivslist.listdownload' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1, iconCls : ''}
    ],
    _scFields : [
      /*  {fieldLabel : '起始时间' ,labelWidth : 70, name : 'startdate' , fieldtype : 'Ext.form.field.Date', pmsCode:'' , checkpms:0   },
        {fieldLabel : '-' ,labelWidth : 20, name : 'enddate' , fieldtype : 'Ext.form.field.Date', pmsCode:'' , checkpms:0   },

        {fieldLabel : '查询' ,text : '查询' ,iconCls : '', fieldtype : 'Ext.button.Button'  , submitBtn : true , clickFn : '$search', pmsCode:'' , checkpms:0 }*/
        //{fieldLabel : '导出EXCEL' ,text : '导出EXCEL' ,iconCls : '', fieldtype : 'Ext.button.Button'  , submitBtn : true , clickFn : '$search', pmsCode:'' , checkpms:0 },
        //{fieldLabel : '打包下载扫描件' ,text : '打包下载扫描件' ,iconCls : '', fieldtype : 'Ext.button.Button'  , submitBtn : true , clickFn : '$search', pmsCode:'' , checkpms:0 }
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
        { header: '基金名称',width: 180,   dataIndex: 'name'} ,
        { header: '持有人',width: 100,   dataIndex: 'holder'} ,
        { header: '资产类型',width: 130,   dataIndex: 'investment_type'} ,
        { header: '总金额',width: 120,   dataIndex: 'total_amount'} ,
        { header: '剩余金额',width: 120,   dataIndex: 'surplus_amount'} ,
		{ header: '购买方式',width: 130,   dataIndex: 'memo'} ,
        { header: '创建人员',width: 150,   dataIndex: 'usr_create'} ,
        { header: '创建时间',width: 160,   dataIndex: 'dat_create'}
/*        { header: '所属门店',width: 100,   dataIndex: 'department_name'} ,
        { header: '录入人',width: 100,   dataIndex: 'user_name'} */
        
        
    ] ,
    //_addInfo : [],
    _viewInfo : [],
    //_addInfo : [],
    _sub_win_defparams : { width:900 , height:500  , maximizable : true },  //子窗口初始参数
    
    _publicInfo : [

    ]
});