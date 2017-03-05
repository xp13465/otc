/**
 * Created by Administrator on 2015/12/7 0007.
 * operationButtons : 操作按钮的定义
 * searchFileds     : 查询字段的定义
 * listOperationButtons : 条目操作按钮的定义
 */

Ext.define('ui.ctrl.foundationworktable.foundationworktableConf',{
    extend: 'ui.extend.baseClass.baseConf',
    modelName : "资产包录入",
    topicalName : '资产包',
    modelCode : 'foundationworktable',
    groupCode : '',
    requires : [
        'ui.view.foundationworktable.Coms.extraFieldPanel'
    ],

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

        this.$extendConfigJson('permissionCheckList',this._permissionCheckList);
        //
        var param = arguments[0];
        var ret = param || {};
        Ext.apply(ret,this.getDefaultWinSize());
        Ext.apply(this,ret);
    },

    _urls : {  //productFirstSubmit
        'get.foundationworktable.list' : { url : "Foundation/getBufferFound" , 'pmsCode' : 'get.foundationworktable.list' , checkpms : 0 } ,
        'get.foundationworktable.view' : { url : "Foundation/viewFoundation" , 'pmsCode' : 'get.foundationworktable.view' , checkpms : 0 } ,
        'get.foundationworktable.add' : { url : "Foundation/addFoundation" , 'pmsCode' : 'get.foundationworktable.add' , checkpms : 0 } ,
        'get.foundationworktable.edit' : { url : "Foundation/editFoundation" , 'pmsCode' : 'get.foundationworktable.edit' , checkpms : 0 } ,
        'get.foundationworktable.submit' : { url : "Foundation/foundationSubmit" , 'pmsCode' : 'get.foundationworktable.submit' , checkpms : 0 } ,
        'get.foundationworktable.delete' : { url : "Foundation/recyFoundation" , 'pmsCode' : 'get.foundationworktable.recyFoundation' , checkpms : 0 } ,
        'get.foundationworktable.uploadlist' : { url : "Foundation/FoundAllUploadFile" , 'pmsCode' : 'get.foundationworktable.uploadlist' , checkpms : 0 },
        'get.foundationworktable.downFile' : { url : "Foundation/downFile" , 'pmsCode' : 'get.foundationworktable.downFile' , checkpms : 0 },
		'get.foundationworktable.mast' : { url : "Foundation/cfMastSelect" , 'pmsCode' : 'get.foundationworktable.mast' , checkpms : 0 }
    },
    _permissionCheckList : [
    ],
    _opButtons : [
        { text : '新建+' , pmsCode : 'foundationworktable.add' , permissionCode : 'Admin-Foundation-addFoundation' ,recKey : ['id']  , checkpms:1 } ,
        { text : '批量删除-' , pmsCode : 'foundationworktable.alldelete' , permissionCode : 'Admin-Foundation-recyFoundation' ,recKey : ['id']  , checkpms:1 }
    ],

    _lstOpButtons : [
        { text : '查看' , pmsCode : 'foundationworktable.view' , permissionCode : 'Admin-Foundation-viewFoundation', recKey : ['id']/*所需record之关键字列表*/  , checkpms:1, iconCls : ''},
        { text : '编辑' , pmsCode : 'foundationworktable.edit'  , permissionCode : 'Admin-Foundation-editFoundation', recKey : ['id']/*所需record之关键字列表*/  , checkpms:1 ,iconCls : ''},
        { text : '提交' , pmsCode : 'foundationworktable.submit'  , permissionCode : 'Admin-Foundation-foundationSubmit', recKey : ['id','status']/*所需record之关键字列表*/  , checkpms:1 ,iconCls : ''},
        { text : '删除' , pmsCode : 'foundationworktable.delete'  , permissionCode : 'Admin-Foundation-recyFoundation', recKey : ['id']/*所需record之关键字列表*/  , checkpms:1 ,iconCls : ''}
    ],

    _scFields : [
        {fieldLabel : '资产包状态' ,labelWidth : 80,width:190 , name : 'status' , fieldtype : 'Ext.form.field.ComboBox', pmsCode:'' , checkpms:0,
            displayField    : 'statusname',
            valueField  : "status",
			value:"",
            store : Ext.create('Ext.data.ArrayStore',{
                fields  :   ['status', 'statusname'],
				autoLoad: true,
                // data : [['','不限'],['0','未完成'],['1','待审核'],['2','待发布'],['3','审核退回'],['4','待销售'],['5','销售中'],['6','已售罄']] 
                proxy: Ext.create( 'ui.extend.base.Ajax',{
                    url : '/Admin/Foundation/allFoundStatus/type/1'
                })
            })
        },
        {fieldLabel : '录入时间' ,labelWidth : 80,width:190 ,  name : 'add_time' , fieldtype : 'Ext.form.field.ComboBox',
            displayField	: 'display', valueField 	: "value", value : 0,
            editable:false,
            store : new Ext.data.ArrayStore({
                fields	: 	['value', 'display'],
                data	:	[[0,'不限'],[1,'1周内'],[2,'1个月内'],[3,'3个月内'],[4,'3个月以上']]
            }), pmsCode:'' , checkpms:0   },
        {fieldLabel : '关键字' ,labelWidth :80, width:200 , name : 'keyword' , fieldtype : 'Ext.form.field.Text',
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
        { header: '序号',width:80,  dataIndex: 'id' } ,
        { header: '资产包名称',width: 160,   dataIndex: 'name' , flex : 1} ,
        { header: '资产包状态',width: 120,   dataIndex: 'status' , renderer : function(v){
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
            }
        } ,
        { header: '录入时间',width: 170,   dataIndex: 'dat_create'}
    ] ,
    //_addInfo : [],
    _sub_win_defparams : { width:850 , height:550 },  //子窗口初始参数

    _addInfo : [] ,

    _publicInfo : [
        {
            title : '资产包信息',
            xtype : 'form',
            layout : 'column',
            padding : 10,
            autoScroll : true,
            mySamle : 'theForm',
            //collapsible:true,
            items :[
                {
                    fieldLabel : '资产包ID',
                    labelWidth: 90,
                    name : 'id',
                    readOnly : true,
                    allowBlank :false,
                    margin: 6,
                    columnWidth :1,
                    filedType : 'Text'
                },{
                    fieldLabel : '资产包名称',
                    labelWidth: 90,
                    name : 'name',
                    allowBlank :false,
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    blankText:"请输入资产包名称",
                    margin: 6,
                    columnWidth :.5,
                    filedType : 'Text'
                },
                {
                    fieldLabel : '发行方',
                    labelWidth: 80,
                    name : 'issuer',
                    margin: 6,
                    allowBlank :false,
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    blankText:"请输入发行方",
                    columnWidth :.5,
                    filedType : 'Text'
                },{
                    fieldLabel : '管理人',
                    labelWidth: 80,
                    name : 'manager',
                    allowBlank :false,
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    blankText:"请输入管理人",
                    columnWidth:.5,
                    margin: 6,
                    filedType : 'Text'
                },{
                    fieldLabel : '资金托管方',
                    labelWidth: 90,
                    name : 'zjtgf',
                    margin: 6,
                    allowBlank :false,
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    blankText:"请输入资金托管方",
                    columnWidth :.5,
                    filedType : 'Text'
                },{
                    fieldLabel : '实际规模',
                    labelWidth: 80,
                    name : 'total_amount',
                    columnWidth:.5,
                    margin: 6,
                    value : 0,
                    filedType : 'Number'
                },{
                    fieldLabel : '备案规模',
                    labelWidth: 80,
                    name : 'expected_amount',
                    columnWidth:.5,
                    minValue:0,
                    allowBlank :false,
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    blankText:"请输入备案规模",
                    margin: 6,
                    filedType : 'Number'
                },{
                    fieldLabel : '总募集规模',
                    labelWidth: 100,
                    name : 'all_amount',
                    columnWidth:.5,
                    minValue:0,
                    allowBlank :false,
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    blankText:"请输入总募集规模",
                    margin: 6,
                    filedType : 'Number'
                },{
                    fieldLabel : '起止日期',
                    labelWidth: 80,
                    name : 'startdate',
                    columnWidth:.3,
                    margin: 6,
                    format:'Y-m-d',
                    filedType : 'Date'
                },{
                    fieldLabel : ' ',
                    labelWidth: 30,
                    name : 'endtime',
                    labelSeparator:'---',
                    format:'Y-m-d',
                    columnWidth:.2,
                    margin: 6,
                    filedType : 'Date'
                },{
                    fieldLabel : '资产类型',
                    labelWidth: 90,
                    name : 'investment_type',
                    columnWidth:.5,
                    allowBlank :false,
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    blankText:"请选择类型",
                    editable:false,
                    margin: 6,
                    filedType : 'ComboBox',
                    displayField	: 'display',
                    valueField 	: "value",
                    value : 1,
                    store : new Ext.data.ArrayStore({
                        fields	: 	['value', 'display'],
                        data	:	[[1,'债权资产'],[2,'收益权资产']]
                    })
                },{
                    fieldLabel : '产品名称',
                    labelWidth: 90,
                    name : 'cf_mast_id',
                    columnWidth:.5,
                    allowBlank :true,
                  /*  beforeLabelTextTpl:'<span style="color:red">*</span>',*/
                    blankText:"请选择产品",
                    editable:false,
                    margin: 6,
                    filedType : 'ComboBox',
                    displayField	: 'title',
                    valueField 	: "id",                   
                    store : Ext.data.ArrayStore({
                        fields  :   ['id', 'title'] ,
                        data : []
                    })
                },{
                    fieldLabel : 'OTC备案代码',
                    labelWidth: 80,
                    name : 'otc_code',
                    // allowBlank :false,
                    // beforeLabelTextTpl:'<span style="color:red">*</span>',
                    // blankText:"请输入管理人",
                    columnWidth:.5,
                    margin: 6,
                    filedType : 'Text'
                },{
                    fieldLabel : '确权机构',
                    labelWidth: 90,
                    name : 'qqjg',
                    margin: 6,
                    allowBlank :false,
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    blankText:"请输入确权机构",
                    columnWidth :.5,
                    filedType : 'Text'
                },{
                    fieldLabel : '担保公司',
                    labelWidth: 90,
                    name : 'dbgs',
                    margin: 6,
                    allowBlank :false,
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    blankText:"请输入担保公司",
                    columnWidth :.5,
                    filedType : 'Text'
                },{
                    fieldLabel : '投资范围',
                    labelWidth: 80,
                    name : 'tzfw',
                    height : 80,
                    columnWidth:1,
                    margin: 6,
                    maxLength:200,
                    filedType : 'TextArea'
                },{
                    fieldLabel : '项目介绍',
                    labelWidth: 80,
                    name : 'memo',
                    // id:'memo',
                    height : 200,
                    width:'85%',
                    columnWidth:1,
                    // listeners:{
                    //     'change':function(){
                    //         this.ueditorInstance.isChanged=true;
                    //     }

                    // },
                    // fontFamilies : ['宋体','黑体'],
                    // defaultFont:'隶书',
                    // enableFont:false,
                    // defaultFont: '宋体',
                    margin: 10,
                    // maxLength:200,
                    filedType : 'HtmlEditor'
                },{
                    fieldLabel : '担保方介绍',
                    labelWidth: 80,
                    name : 'dbfjs',
                   height : 200,
                    width:'85%',
                    columnWidth:1,
                    margin: 10,
                    // enableFont:false,
                    maxLength:200,
                    filedType : 'HtmlEditor'
                },{
                    fieldLabel : '风险提示',
                    labelWidth: 80,
                    name : 'fxts',
                    height : 200,
                    width:'85%',
                    columnWidth:1,
                    margin: 10,
                    // enableFont:false,
                    maxLength:200,
                    filedType : 'HtmlEditor'
                },{
                    fieldLabel : '资金安全',
                    labelWidth: 80,
                    name : 'zjaq',
                    height : 200,
                    width:'85%',
                    columnWidth:1,
                    margin: 10,
                    // enableFont:false,
                    maxLength:200,
                    filedType : 'HtmlEditor'
                },{
                    fieldLabel : '债权规则',
                    labelWidth: 80,
                    name : 'zqgz',
                    height : 200,
                    width:'85%',
                    columnWidth:1,
                    margin: 10,
                    // enableFont:false,
                    maxLength:200,
                    filedType : 'HtmlEditor'
                },{
                    fieldLabel : '资产安全',
                    labelWidth: 80,
                    name : 'zcaq',
                    height : 200,
                    width:'85%',
                    columnWidth:1,
                    margin: 10,
                    // enableFont:false,
                    maxLength:200,
                    filedType : 'HtmlEditor'
                }
            ]
        },
        {
            title : '债权清单' ,
            xtype : 'form' ,
            layout : 'fit' ,
            padding : 0 ,
            autoScroll : true ,
            myStamp : 'theClaimList' ,
            typeMode : ["view"] ,
            items : []
        },
        {
            title : '资产包附件' ,
            xtype : 'form' ,
            layout : 'column' ,
            padding : 0 ,
            autoScroll : true ,
            myStamp : 'uploads' ,
            typeMode : ["view"] ,
            items : []
        }
    ],

	getMaster : function(key , params , theform){
        var me = this;
        return new Ext.data.ArrayStore({
            fields  :   ['id', 'title'] ,           
            autoLoad : true,
            proxy: Ext.create('ui.extend.base.Ajax',{
                url : me.urls.get('get.foundationworktable.mast').url //'../productCategory/getLeavelOne'
            })
        })
    }

});