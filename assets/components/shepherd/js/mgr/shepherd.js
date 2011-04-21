var Shepherd = function(config) {
    config = config || {};
    Shepherd.superclass.constructor.call(this,config);
};
Ext.extend(Shepherd,Ext.Component,{
	page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {}
});
Ext.reg('shepherd',Shepherd);
Shepherd = new Shepherd();