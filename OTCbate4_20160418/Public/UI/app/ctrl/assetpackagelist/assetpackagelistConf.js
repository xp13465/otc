/**
 * Created by Administrator on 2015/12/7 0007.
 * operationButtons : 操作按钮的定义
 * searchFileds     : 查询字段的定义
 * listOperationButtons : 条目操作按钮的定义
 */
Ext.define('ui.ctrl.assetpackagelist.assetpackagelistConf',{
    extend: 'ui.extend.baseClass.baseConf',
    modelName : "资产包清单",
    topicalName : '资产包清单',
    modelCode : 'assetpackagelist',
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
        'get.assetpackagelist.list' : { url : "cfmast/capitalbags" , 'pmsCode' : 'get.assetpackagelist.list' , checkpms : 0 },
        // 'get.assetpackagelist.view' : { url : "Foundation/foundAllClaims" , 'pmsCode' : 'get.assetpackagelist.info' , checkpms : 0 },
        'get.assetpackagelist.edit' : { url : "claims/saveClaims" , 'pmsCode' : 'set.assetpackagelist.info' , checkpms : 0 },
        'set.assetpackagelist.unsale' : { url : "claims/downClaims" , 'pmsCode' : 'set.assetpackagelist.unsale' , checkpms : 0 }
    },
    _opButtons : [
        // { text : '新建+' , pmsCode : 'assetpackagelist.add' ,recKey : ['id']  , checkpms:0 }
        // { text : '批量删除-' , pmsCode : 'assetpackagelist.disable' ,recKey : ['id']  , checkpms:0 }
    ],
    _lstOpButtons : [
        { text : '查看' , pmsCode : 'assetpackagelist.view' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1, iconCls : ''}
        // { text : '下架' , pmsCode : 'assetpackagelist.unsale' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1 ,iconCls : ''}
        // { text : '退回' , pmsCode : 'assetpackagelist.reject' , recKey : ['id','status']/*所需record之关键字列表*/  , checkpms:1 ,iconCls : ''}
    ],
    _scFields : [
        
        // {fieldLabel : '发售时间' ,labelWidth : 80, editable:false,name : 'dat_modify' , fieldtype : 'Ext.form.field.ComboBox',displayField    : 'display', valueField     : "value", value : 0,
        //     store : new Ext.data.ArrayStore({
        //         fields  :   ['value', 'display'],
        //         data    :   [[0,'不限'],[1,'1周内'],[2,'1个月内'],[3,'3个月内'],[4,'3个月以上']]
        //     }), pmsCode:'' , checkpms:0   },
        // {fieldLabel : '起始时间' ,labelWidth : 70, name : 'startdate' , fieldtype : 'Ext.form.field.Date', pmsCode:'' , checkpms:0   },
        // {fieldLabel : '-' ,labelWidth : 20, name : 'enddate' , fieldtype : 'Ext.form.field.Date', pmsCode:'' , checkpms:0   },
        {fieldLabel : '资产包类型' ,labelWidth : 80, name : 'status' , fieldtype : 'Ext.form.field.ComboBox', pmsCode:'' , checkpms:0,
            displayField    : 'statusname',
            valueField  : "status",
			value : '',
            store : Ext.create('Ext.data.ArrayStore',{
                fields  :   ['status', 'statusname'],
                data : [['','不限'],['1','债权转让'],['2','收益权转让']]
                // proxy: Ext.create( 'ui.extend.base.Ajax',{
                //     url : '/Admin/Cfmast/getStatusSelect/type/1'
                // })
            })
        },
        // {fieldLabel : '标的状态' ,labelWidth : 80, editable:false,name : 'bid_cf_status' , fieldtype : 'Ext.form.field.ComboBox',displayField    : 'display', valueField     : "value", value : 0,
        //     store : new Ext.data.ArrayStore({
        //         fields  :   ['value', 'display'],
        //         data    :   [[0,'不限'],[1,'销售中'],[2,'已售罄'],[3,'未销售']]
        //     }), pmsCode:'' , checkpms:0   },
        {fieldLabel : '关键字' ,labelWidth : 50, name : 'keyword' , fieldtype : 'Ext.form.field.Text', pmsCode:'' , checkpms:0  , emptyText : '（资产包名称）' },
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
        { header: '资产包名称',width: 160,   dataIndex: 'name',renderer:function(v,p,record){
            if(record.data.isshow == 1){
                return "<span class='star-open-icon'></span>" + v + "";
            }
            return "<span class='star-close-icon'></span>" + v + "";
        }} ,
        // { header: '',hidden:true,width: 100,   dataIndex: 'cod_period'} ,
        { header: '资产包类型',width: 100,   dataIndex: 'investment_type',renderer:function(v){
            if(v == 1){
                return '债权转让';
            }else if(v == 2){
                return '收益权转让';
            }
            return v;
        }} ,
        { header: '资产包状态',width: 100,   dataIndex: 'status',renderer:function(v){
            if(v == 0){
                return '未完成';
            }else if(v == 1){
                return '待审核';
            }else if(v == 2){
                return '审核通过';
            }else if(v == 3){
                return '审核退回';
            }
            return v;
        }} ,
        { header: '总募集规模(元)',width: 160,   dataIndex: 'all_amount'} ,
        { header: '实际规模(元)',width: 160,   dataIndex: 'expected_amount'} ,
        { header: '未售卖金额(元)',width: 160,   dataIndex: 'surplus_amount'},
		{ header: '售卖中余额(元)',width: 160,   dataIndex: 'total_amount'} ,
        // { header: '发售时间', width: 160,  dataIndex: 'dat_modify' }
    ] ,
    //_addInfo : [],
    _viewInfo : [],
    //_addInfo : [],
    _sub_win_defparams : { width:900 , height:500  , maximizable : true },  //子窗口初始参数
    
    _publicInfo : [
        {
            title : '债权清单',
            xtype : 'form',
            typeMode : ["edit","view"],
            layout : 'fit',
            padding : 0,
            //collapsible:true,
            items :[]
        }
    ]
});