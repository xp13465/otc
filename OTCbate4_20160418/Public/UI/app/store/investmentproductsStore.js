/**
 * Created by Administrator on 2015/12/14 0014.
 */

Ext.define('ui.store.investmentproductsStore',{
    extend : 'ui.extend.base.Store',
    fields : [
        'id',
        'allp',
        'allp2',
        'amt_ct',
        'amt_time',
        'cod_cf_status',
        'rat_cf_inv_min',
        'title',
        'dat_create'
        
    ]
});
/*
Ext.create('Ext.data.Store', {
    storeId:'simpsonsStore',
    fields:['name', 'email', 'phone'],
    data:{'items':[
        { 'name': 'Lisa',  "email":"lisa@simpsons.com",  "phone":"555-111-1224"  },
        { 'name': 'Bart',  "email":"bart@simpsons.com",  "phone":"555-222-1234" },
        { 'name': 'Homer', "email":"home@simpsons.com",  "phone":"555-222-1244"  },
        { 'name': 'Marge', "email":"marge@simpsons.com", "phone":"555-222-1254"  }
    ]},
    proxy: {
        type: 'memory',
        reader: {
            type: 'json',
            root: 'items'
        }
    }
});
*/