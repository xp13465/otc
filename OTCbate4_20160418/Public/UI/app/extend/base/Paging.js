/**
 * Created by Administrator on 2015/12/14 0014.
 */
Ext.define('ui.extend.base.Paging', {
    extend: 'Ext.toolbar.Paging',
    alias: 'widget.gridpagingtoolbar',
    constructor : function(){
        this.callParent(arguments);
    },

    moveFirst: function() {
        var me = this,
        store = me.store;
        if (this.fireEvent('beforechange', this, 1) !== false) {
            if(store.lastOptions){
                this.store.loadPage(1 , store.lastOptions);
            }else{
                this.store.loadPage(1);
            }
            return true;
        }
        return false;
    },

    movePrevious: function() {
        var me = this,
            store = me.store,
            prev = store.currentPage - 1;
        if (prev > 0) {
            if (me.fireEvent('beforechange', me, prev) !== false) {
                if(store.lastOptions){
                    store.previousPage(store.lastOptions);
                }else{
                    store.previousPage();
                }
                return true;
            }
        }
        return false;
    },

    moveNext: function() {
        var me = this,
            store = me.store,
            total = me.getPageData().pageCount,
            next = store.currentPage + 1;

        if (next <= total) {
            if (me.fireEvent('beforechange', me, next) !== false) {
                if(store.lastOptions){
                    // store.lastOptions.page=next;
                    // var start=store.lastOptions.start=(next-1)*25;
                    // store.lastOptions.limit=start+25;
                    console.log(store.lastOptions);

                    store.nextPage(store.lastOptions);
                }else{
                    store.nextPage();
                }

                return true;
            }


        }
        return false;
    },

    moveLast: function() {
        var me = this,
            store = me.store,
            last = me.getPageData().pageCount;
        if (me.fireEvent('beforechange', me, last) !== false) {
            if(store.lastOptions){
                me.store.loadPage(last , store.lastOptions);
            }else{
                me.store.loadPage(last);
            }
            return true;
        }
        return false;
    },

    doRefresh: function() {
        var me = this,
            store = me.store,
            current = store.currentPage;
        if (me.fireEvent('beforechange', me, current) !== false) {
            if(store.lastOptions){
                store.loadPage(current , store.lastOptions);
            }else{
                store.loadPage(current);
            }
            return true;
        }
        return false;
    }
});