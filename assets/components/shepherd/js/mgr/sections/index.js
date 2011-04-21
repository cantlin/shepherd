Ext.onReady(function() {
	MODx.load({ xtype: 'shepherd-page-home'});
});
 
Shepherd.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
	    components: [{
		    xtype: 'shepherd-panel-home'
			,renderTo: 'shepherd-panel-home-div'
			}]
		});
    Shepherd.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(Shepherd.page.Home,MODx.Component);
Ext.reg('shepherd-page-home',Shepherd.page.Home);
