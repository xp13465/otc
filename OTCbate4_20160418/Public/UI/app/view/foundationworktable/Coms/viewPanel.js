/**
 * Created by Administrator on 2015/12/24 0024.
 */
// var HTMLEditor = Ext.extend(Ext.form.field.HtmlEditor, {
//     addImage : function() {
//         var editor = this;
//         var imgform = new Ext.FormPanel({
//             region : 'center',
//             labelWidth : 55,
//             frame : true,
//             bodyStyle : 'padding:5px 5px 0',
//             autoScroll : true,
//             border : false,
//             fileUpload : true,
//             items : [{
//                         xtype : 'textfield',
//                         fieldLabel : '选择文件',
//                         id : 'uploadFile',
//                         name : 'uploadFile',
//                         inputType : 'file',
//                         allowBlank : false,
//                         blankText : '文件不能为空',
//                         anchor : '90%'
//                     }],
//             buttons : [{
//                 text : '上传',
//                 handler : function() {
//                     if (!imgform.form.isValid()) {return;}
//                     imgform.form.submit({
//                         waitMsg : '正在上传......',
//                         url : 'uploadImage.ftl?doType=uploadImage',
//                         success : function(form, action) {
//                             var element = document.createElement("img");
//                             var fileURL = action.result.fileURL;
//                             element.src = 'showImg.ftl?doType=showImg&imgName=' + fileURL;
//                             if (Ext.isIE) {
//                                 editor.insertAtCursor(element.outerHTML);
//                             } else {
//                                 var selection = editor.win.getSelection();
//                                 if (!selection.isCollapsed) {
//                                     selection.deleteFromDocument();
//                                 }
//                                 selection.getRangeAt(0).insertNode(element);
//                             }
//                             //win.hide();//原始方法，但只能传一个图片
//                             //更新后的方法
//                             form.reset();
//                             win.close();
//                         },
//                         failure : function(form, action) {
//                             form.reset();
//                             if (action.failureType == Ext.form.Action.SERVER_INVALID)
//                                 Ext.MessageBox.alert('警告','上传失败',action.result.errors.msg);
//                         }
//                     });
//                 }
//             }, {
//                 text : '关闭',
//                 handler : function() {
//                     win.close(this);
//                 }
//             }]
//         })

//         var win = new Ext.Window({
//                     title : "上传图片",
//                     width : 300,
//                     height : 200,
//                     modal : true,
//                     border : false,
//                     iconCls : path + "/images/picture.png",
//                     layout : "fit",
//                     items : imgform

//                 });
//         win.show();
//     },
//     createToolbar : function(editor) {
//         HTMLEditor.superclass.createToolbar.call(this, editor);
//         this.tb.insertButton(16, {
//                     cls : "x-btn-icon",
//                     icon : path + "/images/picture.png",
//                     handler : this.addImage,
//                     scope : this
//                 });
//     }
// });

Ext.define( 'ui.view.foundationworktable.Coms.viewPanel', {
    extend: 'ui.extend.baseClass.coms.baseBusTabPanel',
    alias: 'widget.foundationworktableviewpanel',
    requires :[
        'ui.extend.base.StarHtmleditor'
        
    ],
    opType : 'view',
    opTitle : '查看',
    opIconCls : '',
    constructor : function(){
        this.callParent(arguments);
    },
    initComponent : function(){
        var me = this;
        me.formsList = [];
        me.ctrl.$assembleInfoPanel.call( me.ctrl , me , 'view' );

        this.callParent(arguments);

        for(var i=0 ; i<this.formsList.length; i++){
           this.addPanel(this.formsList[i]);
        }

    }
});