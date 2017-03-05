/**
 * Created by Administrator on 2015/12/14 0014.
 */

Ext.define('ui.store.claimslistStore',{
    extend : 'ui.extend.base.Store',
    fields : [
        // 'id',
        'borrower',
        'amt_ct_last',
        'dat_create',
        'pname',
        'status',
        'cod_cl_id',
        'cod_cf_ctl_id',
        'cod_cf_ivs_id',
        'cod_cf_id',
        'nam_cust_real',
        'cod_ivs_type',
        'product_name',
        'amt_ivs'

        
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