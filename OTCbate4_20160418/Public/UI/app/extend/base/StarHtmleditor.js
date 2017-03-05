/**
 * Created by Administrator on 2015/12/14 0014.
 */
Ext.define('ui.extend.base.StarHtmleditor',{
    extend:'Ext.form.FieldContainer',
    mixins:{
        field:Ext.form.field.Field
    },
    ueditorInstance: null,
    initialized: false,
    tempValue:'',
    readOnly:false,
    isChanged:false,
    initComponent: function () {  
    	console.log('me');      
        var me = this;
        // me.addEvents('initialize', 'change'); // 为ueditor添加一个初始化完成的事件
        var id = me.id + '-ueditor';
        me.html = '<script id="' + id + '" type="text/plain" name="' + me.name + '"></script>';
        //调用当前方法的父类方法详见Ext.Base
        me.callParent(arguments);
        me.initField();
        // me.addEvents('initialize', 'change'); // 为ueditor添加一个初始化完成的事件
        me.on('render', function () {
            var width = me.width - 105;
            var height = me.height - 109;
            var config = {initialFrameWidth: width, initialFrameHeight: height,readonly:me.readOnly,zIndex:100000000000};
            

            me.ueditorInstance =UE.getEditor(id, config);
            // UE.getEditor(id, config);
            //console.log(UE.getEditor(id, config));
            // me.ueditorInstance.readonly=me.readOnly;
            me.ueditorInstance.ready(function () {
                // console.log('ready');
                 me.initialized = true;
                 me.setValue(me.tempValue);
                 me.fireEvent('initialize', me);
                 me.ueditorInstance.addListener('contentChange', function () {
                     // alert(111);
                     me.fireEvent('change', me);
                 });
                 
                 
                 // console.log(me);
            });
        });
    },
    getValue: function () {
    	// console.log('getValue');
    	// console.log(me.getValue());
         var me = this,
         value = '';
         if (me.initialized) {
             value = me.ueditorInstance.getContent();
             
         }
         me.value = value;
         // console.log(value);
         return value;
     },
     setValue: function (value) {
        // console.log('setValue');
         var me = this;
         if (value === null || value === undefined) {
             value = '';
         }else{
             me.isChanged = true;
         }
         if (me.initialized) {   
         console.log('setContent'+value);       
             me.ueditorInstance.setContent(value);
              
         }else{
         	me.tempValue=value;
         }
         // console.log(value);
         return me;
     },
     setReadOnly:function(value){
        this.ueditorInstance.readonly=value;
     },
     onDestroy:function () {
         this.ueditorInstance.destroy();
     }
});