/**
 * Created by Administrator on 2015/12/7 0007.
 * operationButtons : 操作按钮的定义
 * searchFileds     : 查询字段的定义
 * listOperationButtons : 条目操作按钮的定义
 */
Ext.define('ui.ctrl.ivslist.ivslistConf',{
    extend: 'ui.extend.baseClass.baseConf',
    modelName : "POS投资记录",
    topicalName : 'POS投资记录',
    modelCode : 'ivslist',
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
        'get.ivslist.list' : { url : "cfmast/poslist" , 'pmsCode' : 'get.ivslist.list' , checkpms : 0 },
        'get.ivslist.downloadexcel' : { url : "Cfmast/outpos2excel" , 'pmsCode' : 'get.ivslist.download' , checkpms : 0 },
        'get.ivslist.downloadall' : { url : "Cfmast/ZipPosFiles" , 'pmsCode' : 'get.claimslist.view' , checkpms : 0 },
		'get.ivslist.confirm' : { url : "cfmast/confirmarrival" , 'pmsCode' : 'get.ivslist.confirm' , checkpms : 0 },
        'get.ivslist.downloadlist' : { url : "Cfmast/downposfile" , 'pmsCode' : 'get.claimslist.view' , checkpms : 0 }
    },
    _opButtons : [
        { text : '导出EXCEL' , pmsCode : 'ivslist.downloadexcel' ,recKey : ['id']  , permisstionCode:"Admin-Cfmast-outpos2excel" , checkpms:0 },
        { text : '打包下载扫描件' , pmsCode : 'ivslist.downloadpos' ,recKey : ['id']   , permisstionCode:"Admin-Cfmast-ZipPosFiles" , checkpms:0  }
    ],
    _lstOpButtons : [
        { text : '下载' , pmsCode : 'ivslist.listdownload' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1, iconCls : ''},
		{ text : '确认到账' , pmsCode : 'ivslist.confirm' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1 ,iconCls : ''},
    ],
    _scFields : [
        {fieldLabel : '成交时间' ,labelWidth : 70,width:220, name : 'startdate' , fieldtype : 'Ext.form.field.Date', pmsCode:'' , checkpms:0   },
        {fieldLabel : '-' ,labelWidth : 20,width:170,name : 'enddate' , fieldtype : 'Ext.form.field.Date', pmsCode:'' , checkpms:0   },
		{fieldLabel : '标的名称' ,labelWidth : 70, width:190 ,name : 'productname' , fieldtype : 'Ext.form.field.Text', pmsCode:'' , checkpms:0 , emptyText : '（标的名称）'  },
		{fieldLabel : '客户姓名' ,labelWidth : 70, width:190 ,name : 'custname' , fieldtype : 'Ext.form.field.Text', pmsCode:'' , checkpms:0 , emptyText : '（客户姓名）'  },
		{fieldLabel : '销售经理' ,labelWidth : 70, width:190 ,name : 'salesname' , fieldtype : 'Ext.form.field.Text', pmsCode:'' , checkpms:0 , emptyText : '（销售经理）'  },
		{fieldLabel : '录入人' ,labelWidth : 50, margin:"0 5px", width:170 ,name : 'username' , fieldtype : 'Ext.form.field.Text', pmsCode:'' , checkpms:0 , emptyText : '（录入人）'  },
		{fieldLabel : '查询' ,text : '查询' ,iconCls : '', fieldtype : 'Ext.button.Button'  , submitBtn : true , clickFn : '$search', pmsCode:'' , checkpms:0 }
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
        { header: '客户姓名',width: 80,   dataIndex: 'nam_cust_real'} ,
        { header: '客户身份证号',width: 180,   dataIndex: 'cod_cust_id_no'} ,
        { header: '标的名称',width: 160,   dataIndex: 'bid'} ,
        { header: '投资金额',width: 120,   dataIndex: 'amt_int_total'} ,
        { header: '份数',width: 60,   dataIndex: 'ctl_ivs_cnt'} ,
		{ header: '每份金额',width: 120,   dataIndex: 'amt_ivs'} ,
        { header: '成交时间',width: 180,   dataIndex: 'dat_modify'} ,
        { header: 'POS单号',width: 160,   dataIndex: 'pos_order'} ,
        { header: '部门',width: 100,   dataIndex: 'department_name'} ,
        { header: '城市',width: 100,   dataIndex: 'city'} ,
        { header: '营业区',width: 100,   dataIndex: 'yingyequ'} ,
        { header: '业务部',width: 100,   dataIndex: 'yewubu'} ,
        { header: '社区门店',width: 100,   dataIndex: 'shequmendian'} ,
        { header: '销售经理',width: 100,   dataIndex: 'sales'} , 
        { header: '录入人',width: 100,   dataIndex: 'user_name'} ,
        { header: '到账日期',width: 120,   dataIndex: 'arrivaldate'} ,
        { header: '确认人',width: 100,   dataIndex: 'arrivaluname'} ,
        { header: '确认时间',width: 100,   dataIndex: 'dat_arrival'} 
        
        
    ] ,
    //_addInfo : [],
    _viewInfo : [],
    //_addInfo : [],
    _sub_win_defparams : { width:900 , height:500  , maximizable : true },  //子窗口初始参数
    
    _publicInfo : [

    ]
});