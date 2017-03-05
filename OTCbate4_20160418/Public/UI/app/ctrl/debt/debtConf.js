/**
 * Created by Administrator on 2015/12/7 0007.
 * operationButtons : 操作按钮的定义
 * searchFileds     : 查询字段的定义
 * listOperationButtons : 条目操作按钮的定义
 */
Ext.define('ui.ctrl.debt.debtConf',{
    extend: 'ui.extend.baseClass.baseConf',
    modelName : "债权录入",
    topicalName : '债权录入',
    modelCode : 'debt',
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
        'get.debt.list' : { url : "claims/getClaimslist" , 'pmsCode' : 'get.debt.list' , checkpms : 0 },
        'get.debt.view' : { url : "claims/getClaimsinfo" , 'pmsCode' : 'get.debt.info' , checkpms : 0 },
        'get.debt.edit' : { url : "claims/saveClaims" , 'pmsCode' : 'set.debt.info' , checkpms : 0 },
        'set.debt.delete' : { url : "claims/recyClaims" , 'pmsCode' : 'set.debt.delete' , checkpms : 0 }
        


    },
    _opButtons : [
        { text : '新建+' , pmsCode : 'debt.add' ,recKey : ['id']  , checkpms:0 }
        // { text : '批量删除-' , pmsCode : 'debt.disable' ,recKey : ['id']  , checkpms:0 }
        
    ],
    _lstOpButtons : [
        { text : '查看' , pmsCode : 'debt.view' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1, iconCls : ''},
        { text : '编辑' , pmsCode : 'debt.edit' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1 ,iconCls : ''}
        // { text : '删除' , pmsCode : 'debt.delete' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1 ,iconCls : ''}
        
    ],
    _scFields : [
        {fieldLabel : '产品状态' ,labelWidth : 70, width:190 ,name : 'cod_cf_status' , fieldtype : 'Ext.form.field.ComboBox', pmsCode:'' , checkpms:0,
            displayField    : 'statusname',
            valueField  : "status",
            store : Ext.create('Ext.data.ArrayStore',{
                fields  :   ['status', 'statusname'],
                data : [['1','待审核'],['2','待发布'],['3','已发布']]
            })
        },
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
        {fieldLabel : '录入时间' ,labelWidth : 80, editable:false,name : 'dat_create' , fieldtype : 'Ext.form.field.ComboBox',displayField    : 'display', valueField     : "value", value : 0,
            store : new Ext.data.ArrayStore({
                fields  :   ['value', 'display'],
                data    :   [[0,'不限'],[1,'1周内'],[2,'1个月内'],[3,'3个月内'],[4,'3个月以上']]
            }), pmsCode:'' , checkpms:0   },
        {fieldLabel : '起始时间' ,labelWidth : 70, name : 'add_time' , fieldtype : 'Ext.form.field.Date', pmsCode:'' , checkpms:0   },
        {fieldLabel : '-' ,labelWidth : 20, name : 'end_time' , fieldtype : 'Ext.form.field.Date', pmsCode:'' , checkpms:0   },
        
        
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
        { header: '产品名称',width: 160,   dataIndex: 'title'} ,
        { header: '产品状态', width: 160,  dataIndex: 'status',renderer:function(v){
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
    _sub_win_defparams : { width:700 , height:500  , maximizable : true },  //子窗口初始参数
    
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
        }
    ]
});