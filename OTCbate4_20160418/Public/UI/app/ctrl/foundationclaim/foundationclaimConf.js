/**
 * Created by Administrator on 2015/12/7 0007.
 * operationButtons : 操作按钮的定义
 * searchFileds     : 查询字段的定义
 * listOperationButtons : 条目操作按钮的定义
 */

Ext.define('ui.ctrl.foundationclaim.foundationclaimConf',{
    extend: 'ui.extend.baseClass.baseConf',
    modelName : "资产包债权列表",
    topicalName : '资产包债权列表',
    modelCode : 'foundationclaim',
    groupCode : '',
    requires : [
        'ui.view.foundationclaim.Coms.extraFieldPanel'
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
        'get.foundationclaim.list' : { url : "Foundation/foundAllClaims" , 'pmsCode' : 'get.foundationclaim.list' , checkpms : 0 }
    },
    _permissionCheckList : [
    ],
    _opButtons : [
    ],

    _lstOpButtons : [
    ],

    _scFields : [
        {fieldLabel : '债权剩余金额' ,labelWidth : 120, width:250 ,name : '' , fieldtype : 'Ext.form.field.Text', pmsCode:'' , checkpms:0 ,isSummary:1,summaryName:'total_amount' ,readOnly:true },
        {fieldLabel : '债权状态' ,labelWidth : 80, width:190 ,name : 'status' , fieldtype : 'Ext.form.field.ComboBox',
            displayField	: 'display', valueField 	: "value", value : 0,
            editable:false,
            store : new Ext.data.ArrayStore({
                fields	: 	['value', 'display'],
                data	:	[[0,'不限'],[1,'待审核'],[2,'待发布'],[3,'审核退回'],[4,'待销售'],[5,'销售中'],[6,'已售罄'],[10,'发布退回']]
            }), pmsCode:'' , checkpms:0   },
        {fieldLabel : '关键字' ,labelWidth :80,width:230 , name : 'keyword' , fieldtype : 'Ext.form.field.Text',
            emptyText:"资产包名称" , value : "", pmsCode:'' , checkpms:0   } ,
         {text : '查询' ,iconCls : '', fieldtype : 'Ext.button.Button'  , submitBtn : true , clickFn : '$search', pmsCode:'' , checkpms:0 }
    ],

    /*
    * 配置信息面板里的按钮，并制定事件后缀： fnName
    * */
    _infoPanelButtons : {
        'all' : [],
        'view' : [],
        'edit' : [],
        'add' : []
    } ,
    /*
     * grid数据列表的头部定义*/
    _listGridHeader : [
        { header: '序号',width:80,  dataIndex: 'id' } ,
        { header: '债权名称',width: 180,   dataIndex: 'product_name' , flex:1} ,
        { header: '资产类型',width: 180,   dataIndex: 'type' , renderer : function(v){
            if(v == 1){
                return '债权转让';
            }else if(v == 2){
                return '收益权转让';
            }
            return v;
        }} ,
        { header: '债权状态',width: 100,   dataIndex: 'status' , renderer : function(v){
                if(v == 0){
                    return '未完成';
                }else if(v == 1){
                    return '待审核';
                }else if(v == 2){
                    return '审核通过';
                }else if(v == 3){
                    return '审核退回';
                }else if(v == 4){
                    return '待销售';
                }else if(v == 5){
                    return '销售中';
                }else if(v == 6){
                    return '已售罄';
                }else if(v == 10){
                    return '发布退回';
                }
                return v;
            }
        } ,
        { header: '债权总额（元）',width: 130,   dataIndex: 'amt_ct'} ,
        { header: '剩余金额（元）',width: 130,   dataIndex: 'amt_ct_last'}
    ] ,
    //_addInfo : [],
    _sub_win_defparams : { width:800 , height:550 },  //子窗口初始参数

    _addInfo : [] ,

    _publicInfo : []
});