/**
 * Created by Administrator on 2015/12/7 0007.
 * operationButtons : 操作按钮的定义
 * searchFileds     : 查询字段的定义
 * listOperationButtons : 条目操作按钮的定义
 */
Ext.define('ui.ctrl.investmentproductaudit.investmentproductauditConf',{
    extend: 'ui.extend.baseClass.baseConf',
    modelName : "投资产品审核",
    topicalName : '投资产品审核',
    modelCode : 'investmentproductaudit',
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
        'get.investmentproductaudit.list' : { url : "cfmast/getUncheckProduct" , 'pmsCode' : 'get.investmentproductaudit.list' , checkpms : 0 },
        'get.investmentproductaudit.view' : { url : "cfmast/tdetail" , 'pmsCode' : 'get.investmentproductaudit.info' , checkpms : 0 },
        'get.investmentproductaudit.getfiles' : { url : "cfmast/getFileList" , 'pmsCode' : 'get.investmentproductaudit.getfiles' , checkpms : 0 },
        'get.investmentproductaudit.edit' : { url : "claims/saveClaims" , 'pmsCode' : 'set.investmentproductaudit.info' , checkpms : 0 },
        'set.investmentproductaudit.change' : { url : "cfmast/auditProduct" , 'pmsCode' : 'set.investmentproductaudit.change' , checkpms : 0 },
        'set.investmentproductaudit.upload' : { url : "cfmast/productFileUpload" , 'pmsCode' : 'set.investmentproductaudit.upload' , checkpms : 0 },
        'set.investmentproductaudit.deleteupload' : { url : "cfmast/delFiles" , 'pmsCode' : 'set.investmentproductaudit.deleteupload' , checkpms : 0 },
        'get.investmentproductaudit.downfile' : { url : "cfmast/downfile" , 'pmsCode' : 'get.investmentproductaudit.downfile' , checkpms : 0 },
        'set.investmentproductaudit.reject' : { url : "cfmast/auditProduct" , 'pmsCode' : 'set.investmentproductaudit.reject' , checkpms : 0 },
    },
    _opButtons : [
        // { text : '新建+' , pmsCode : 'investmentproductaudit.add' ,recKey : ['id']  , checkpms:0 }
        // { text : '批量删除-' , pmsCode : 'investmentproductaudit.disable' ,recKey : ['id']  , checkpms:0 }
    ],
    _lstOpButtons : [
        { text : '查看' , pmsCode : 'investmentproductaudit.view' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1, iconCls : ''},
       // { text : '上传资料' , pmsCode : 'investmentproductaudit.upload' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1 ,iconCls : ''},
        { text : '通过' , pmsCode : 'investmentproductaudit.approve' , recKey : ['id','status']/*所需record之关键字列表*/  , checkpms:1 ,iconCls : ''},
        { text : '退回' , pmsCode : 'investmentproductaudit.reject' , recKey : ['id','status']/*所需record之关键字列表*/  , checkpms:1 ,iconCls : ''}
    ],
    _scFields : [
        // {fieldLabel : '产品状态' ,labelWidth : 70, name : 'cod_cf_status' , fieldtype : 'Ext.form.field.ComboBox', pmsCode:'' , checkpms:0,
        //     displayField    : 'statusname',
        //     valueField  : "status",
        //     store : Ext.create('Ext.data.ArrayStore',{
        //         fields  :   ['status', 'statusname'],
        //         data : [['1','待审核'],['2','待发布'],['3','已发布']]
        //     })
        // },
        // {fieldLabel : '债权状态' ,labelWidth : 70, name : 'title' , fieldtype : 'Ext.form.field.ComboBox', pmsCode:'' , checkpms:0,
        //     displayField    : 'statusname',
        //     valueField  : "status",
        //     store : Ext.create('Ext.data.ArrayStore',{
        //         fields  :   ['status', 'statusname'],
        //         data : [['0','不限'],['1','销售中'],['2','待销售'],['3','已售罄'],['4','已下架'],['5','待审核'],['6','待发布']]
        //     })
        // },
        // {fieldLabel : '产品类型' ,labelWidth : 70, name : 'title' , fieldtype : 'Ext.form.field.ComboBox', pmsCode:'' , checkpms:0,
        //     displayField    : 'statusname',
        //     valueField  : "status",
        //     store : Ext.create('Ext.data.ArrayStore',{
        //         fields  :   ['status', 'statusname'],
        //         data : [['0','不限'],['1','泰盛'],['2','泰丰'],['3','安享'],['4','安盈']]
        //     })
        // },
         {fieldLabel : '录入时间' ,labelWidth : 80, editable:false,name : 'createdate' , fieldtype : 'Ext.form.field.ComboBox',displayField    : 'display', valueField     : "value", value : 0,
            value: '',
			store : new Ext.data.ArrayStore({
                fields  :   ['value', 'display'],
				autoload : true,
				data : [['','不限']],
                // data    :   [[0,'不限'],[1,'1周内'],[2,'1个月内'],[3,'3个月内'],[4,'3个月以上']]
				proxy: Ext.create( 'ui.extend.base.Ajax',{
                    url : '/Admin/Cfmast/getInsertSelect'
                })
            }), pmsCode:'' , checkpms:0   },
         {fieldLabel : '关键字' ,labelWidth : 50, name : 'keyword' , fieldtype : 'Ext.form.field.Text', pmsCode:'' , checkpms:0  , emptyText : '（产品名称）' },
        
        
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
        { header: '序号',width: 50,  dataIndex: 'id' } ,
        { header: '产品名称',width: 160,   dataIndex: 'title'} ,
        { header: '产品状态', width: 160,  dataIndex: 'cod_cf_status',renderer:function(v){
            if(v == 1){
                return '待审核';
            }else if(v == 2){
                return '待发布';
            }else if(v == 3){
                return '审核退回';
            }else if(v == 4){
                return '待销售';
            }else if(v == 5){
                return '销售中';
            }else if(v == 6){
                return '已售罄';
            }
            return v;
        } } ,
        { header: '录入时间', width: 160,  dataIndex: 'dat_create' } 
    ] ,
    //_addInfo : [],
    _viewInfo : [],
    //_addInfo : [],
    _sub_win_defparams : { width:700 , height:500  , maximizable : true },  //子窗口初始参数
    
    _publicInfo : [
        {
            title : '产品信息',
            // typeMode : ["view","edit","add"],
            xtype : 'form',
            layout : 'column',
            padding : 10,
            autoScroll : true,
            mySamle: "theBasePanel",
            items :[
                {
                    fieldLabel : '投资产品ID',
                    labelWidth: 70,
                    name : 'id',
                    margin: 6,
                    columnWidth :1,
                    hidden:true,
                    readOnly:true,
                    filedType : 'Number'
                },
                {
                    fieldLabel : '产品名称',
                    labelWidth: 80,
                    name : 'title',
                    columnWidth :.5,
                    margin: 6,
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    allowBlank:false,
                    blankText:'请输入产品名称',
                    filedType : 'Text'
                },
                {
                    fieldLabel : '每期上限金额',
                    labelWidth: 100,
                    name : 'each_amt',
                    columnWidth :.4,
                    margin: 6,
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    allowBlank:false,
                    blankText:'请填写每期上限金额',
                    filedType : 'Number'//不知道如何添加下拉列表
                }
                ,{
                    fieldLabel : '最小投资金额',
                    labelWidth: 100,
                    name : 'amt_cf_inv_min',
                    columnWidth :.4,
                    margin: 6,
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    minValue:200000,
                    step:10000,
                    allowBlank:false,
                    // minValue:0,
                    blankText:'请输入最小投资金额',
                    minText:'最小投资金额200000元',
                    filedType : 'Number'
                }
                ,{
                    filedType:'DisplayField',
                    columnWidth :.1,
                    value:'元'
                }
                ,{
                    fieldLabel : '最大投资金额',
                    labelWidth: 100,
                    name : 'amt_cf_inv_max',
                    columnWidth :.4,
                    margin: 6,
                    minValue:0,
                    step:10000,
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    allowBlank:false,
                    blankText:'请输入最大投资金额',
                    filedType : 'Number'
                },
                {
                    filedType:'DisplayField',
                    columnWidth :.1,
                    value:'元'
                },
                {
                    fieldLabel : '开始时间',
                    labelWidth: 100,
                    name : 'dat_cf_inv_begin',
                    columnWidth :.5,
                    margin: 6,

                    format:'Y-m-d H:i:s',
                    filedType : 'Date'
                }
                ,{
                    fieldLabel : '截止时间',
                    labelWidth: 100,
                    name : 'dat_cf_inv_end',
                    format:'Y-m-d H:i:s',
                    columnWidth :.5,
                    margin: 6,

                    filedType : 'Date'
                },
                {
                    fieldLabel : '项目期限',
                    labelWidth: 100,
                    name : 'amt_time',
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    allowBlank:false,
                    blankText:'请输入项目期限',
                    columnWidth :.4,
                    minValue:0,
                    decimalPrecision:0,
                    margin: 6,
                    // beforeLabelTextTpl:'个月',
                    filedType : 'Number'
                },{
                    filedType:'DisplayField',
                    columnWidth :.1,
                    value:'个月'
                }
                ,{
                    fieldLabel : '预期年化收益率',
                    labelWidth: 120,
                    name : 'rat_cf_inv_min',
                    columnWidth :.4,
                    margin: 6,
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    allowBlank:false,
                    step:0.01,
                    minValue:0,
                    blankText:'请输入预期年化收益率',
                    filedType : 'Number'
                },{
                    filedType:'DisplayField',
                    columnWidth :.1,
                    value:'%'
                },{
                    fieldLabel : '计息公式',
                    labelWidth: 90,
                    name : 'formula',
                    columnWidth:.5,
                    allowBlank :false,
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    blankText:"请选择公式",
                    editable:false,
                    margin: 6,
                    filedType : 'ComboBox',
                    displayField	: 'display',
                    valueField 	: "value",
                    value : 1,
                    store : new Ext.data.ArrayStore({
                        fields	: 	['value', 'display'],
                        data	:	[[1,'年盈公式'],[2,'月月盈公式'],[2,'月满盈公式']]
                    })
                }
            ]

        },{
            title : '资产包清单',
            xtype : 'form',
            typeMode : ["edit","view"],
            layout : 'fit',
            padding : 0,
            //collapsible:true,
            items :[]
        }
    ]
});