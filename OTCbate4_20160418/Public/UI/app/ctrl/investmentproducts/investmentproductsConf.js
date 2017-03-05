/**
 * Created by Administrator on 2015/12/7 0007.
 * operationButtons : 操作按钮的定义
 * searchFileds     : 查询字段的定义
 * listOperationButtons : 条目操作按钮的定义
 */
Ext.define('ui.ctrl.investmentproducts.investmentproductsConf',{
    extend: 'ui.extend.baseClass.baseConf',
    modelName : "投资产品管理",
    topicalName : '投资产品管理',
    modelCode : 'investmentproducts',
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
        'get.investmentproducts.list' : { url : "cfmast/tlist" , 'pmsCode' : 'get.investmentproducts.list' , checkpms : 0 },
        'get.investmentproducts.view' : { url : "cfmast/tdetail" , 'pmsCode' : 'get.investmentproducts.info' , checkpms : 0 },
        'get.investmentproducts.edit' : { url : "cfmast/productEdit" , 'pmsCode' : 'set.investmentproducts.info' , checkpms : 0 },
        'set.investmentproducts.down' : { url : "cfmast/shelfmast" , 'pmsCode' : 'set.investmentproducts.down' , checkpms : 0 },
        'set.investmentproducts.start' : { url : "cfmast/start" , 'pmsCode' : 'set.investmentproducts.start' , checkpms : 0 },
        'set.investmentproducts.pending' : { url : "cfmast/pausemast" , 'pmsCode' : 'set.investmentproducts.pending' , checkpms : 0 }
    },
    _opButtons : [
        // { text : '新建+' , pmsCode : 'investmentproducts.add' ,recKey : ['id']  , checkpms:0 }
        // { text : '批量删除-' , pmsCode : 'investmentproducts.disable' ,recKey : ['id']  , checkpms:0 }
    ],
    _lstOpButtons : [
        { text : '查看' , pmsCode : 'investmentproducts.view' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1, iconCls : ''},
        { text : '编辑' , pmsCode : 'investmentproducts.edit' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1, iconCls : ''},
        { text : '暂停销售' , pmsCode : 'investmentproducts.pending' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1, iconCls : ''},
        { text : '启动销售' , pmsCode : 'investmentproducts.start' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1, iconCls : ''},
        { text : '下架' , pmsCode : 'investmentproducts.down' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1 ,iconCls : ''}
        // { text : '退回' , pmsCode : 'investmentproducts.reject' , recKey : ['id','status']/*所需record之关键字列表*/  , checkpms:1 ,iconCls : ''}
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
        {fieldLabel : '产品状态' ,labelWidth : 70,width:190 , name : 'status' , fieldtype : 'Ext.form.field.ComboBox', pmsCode:'' , checkpms:0,
            displayField    : 'statusname',
            valueField  : "status",
			value : '',
            store : Ext.create('Ext.data.ArrayStore',{
                fields  :   ['status', 'statusname'],
				autoload:true,
                data : [['','不限']],
                proxy: Ext.create( 'ui.extend.base.Ajax',{
                    url : '/Admin/Cfmast/getStatusSelect/type/1'
                })
            })
        },
        {fieldLabel : '录入时间' ,labelWidth : 80, width:230,name : 'add_time' , fieldtype : 'Ext.form.field.ComboBox',displayField	: 'display', valueField 	: "value", value : 0,
            editable:false,
            store : new Ext.data.ArrayStore({
                fields	: 	['value', 'display'],
                data	:	[[0,'不限'],[1,'1周内'],[2,'1个月内'],[3,'3个月内'],[4,'3个月以上']]
            }), pmsCode:'' , checkpms:0   },
        // {fieldLabel : '产品类型' ,labelWidth : 70, name : 'title' , fieldtype : 'Ext.form.field.ComboBox', pmsCode:'' , checkpms:0,
        //     displayField    : 'statusname',
        //     valueField  : "status",
        //     store : Ext.create('Ext.data.ArrayStore',{
        //         fields  :   ['status', 'statusname'],
        //         data : [['0','不限'],['1','泰盛'],['2','泰丰'],['3','安享'],['4','安盈']]
        //     })
        // },
        // {fieldLabel : '录入时间' ,labelWidth : 80, editable:false,name : 'dat_create' , fieldtype : 'Ext.form.field.ComboBox',displayField    : 'display', valueField     : "value", value : 0,
        //     store : new Ext.data.ArrayStore({
        //         fields  :   ['value', 'display'],
        //         data    :   [[0,'不限'],[1,'1周内'],[2,'1个月内'],[3,'3个月内'],[4,'3个月以上']]
        //     }), pmsCode:'' , checkpms:0   },
        // {fieldLabel : '起始时间' ,labelWidth : 70, name : 'startdate' , fieldtype : 'Ext.form.field.Date', pmsCode:'' , checkpms:0   },
        // {fieldLabel : '-' ,labelWidth : 20, name : 'enddate' , fieldtype : 'Ext.form.field.Date', pmsCode:'' , checkpms:0   },
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
        { header: '产品名称',width: 160,   dataIndex: 'title' , renderer : function(v,p,record){
            if(record.data.isshow == 1){
                return "<span class='star-open-icon'></span>" + v + "";
            }
            return "<span class='star-close-icon'></span>" + v + "";
        }} ,
        { header: '产品状态',width: 160,   dataIndex: 'cod_cf_status',renderer:function(v){
            if(v == 1){
                return '正常';
            }else if(v == 2){
                return '暂停销售';
            }else if(v == 3){
                return '下架';
            }
            return v;
        }} ,
        //{ header: '收益权投资转让人数(人)',width: 160,   dataIndex: 'allp2'} ,
        //{ header: '债权投资转让人数(人)',width: 160,   dataIndex: 'allp'} ,
        { header: '投资人数(人)',width: 160,   dataIndex: 'allp'} ,
        { header: '已投资金额',width: 160,   dataIndex: 'amt_ct',renderer:function(v){
            if(v==null){

            }else
                return v+" 元";
        }} ,
        { header: '预期年化收益率',width: 160,   dataIndex: 'rat_cf_inv_min',renderer:function(v){
            if(v==null){

            }else
                return v+" %";
        }} ,
        { header: '期限',width: 160,   dataIndex: 'amt_time'} ,
        { header: '录入时间', width: 160,  dataIndex: 'dat_create' } 
       
    ] ,
    //_addInfo : [],
    _viewInfo : [],
    //_addInfo : [],
    _sub_win_defparams : { width:900 , height:500  , maximizable : true },  //子窗口初始参数
    
    _publicInfo : [
        {
            title : '产品信息',
            // typeMode : ["view","edit","add"],
            xtype : 'form',
            layout : 'column',
            padding : 10,
            autoScroll : true,
            //mySamle: "theBasePanel",
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
                    emptyText:'xxxxx',
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
                //{
                //    fieldLabel : '资产包类型',
                //    labelWidth: 90,
                //    name : 'cod_cf_inv_type',
                //    columnWidth :.5,
                //    margin: 6,
                //    beforeLabelTextTpl:'<span style="color:red">*</span>',
                //    // allowBlank:false,
                //    emptyText:'请选择资产包类型',
                //    triggerAction : 'all',
                //    editable:false,
                //    displayField : 'name',//这俩是关键
                //    valueField  : "capitalid",//这俩是关键不写对 显示不出来
                //    //store :Ext.create('Ext.data.ArrayStore',{
                //    //        fields  :   ['capitalid', 'name'],
                //    //        proxy: Ext.create( 'ui.extend.base.Ajax',{
                //    //            url : '/Admin/Cfmast/getModelSelect'
                //    //        })
                //    //    }),
                //    store:new Ext.data.ArrayStore({
                //        fields  :   ['capitalid', 'name'],
                //        data    :   [[1,'债权资产包'],[2,'收益权资产包']],
                //    }),
                //    filedType :'ComboBox'
                //},
                //{
                //    fieldLabel : '资产包',
                //    labelWidth: 80,
                //    name : 'capitalid',
                //    columnWidth :.5,
                //    margin: 6,
                //    beforeLabelTextTpl:'<span style="color:red">*</span>',
                //    // allowBlank:false,
                //    emptyText:'请选择资产包',
                //    filedType : 'ComboBox',
                //    displayField : 'name',
                //    valueField  : "id",
                //    store :  new  Ext.data.ArrayStore({
                //        fields  :   ['id', 'name'],
                //        data    :   []
                //    })
                //}
            ]

        },{
            title : '投资产品详情',
            xtype : 'form',
            typeMode : ["view"],
            layout : 'fit',
            padding : 0,
            
            //collapsible:true,
            items :[]
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