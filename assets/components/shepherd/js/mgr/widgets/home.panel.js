Shepherd.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
	    border: false
		,baseCls: 'modx-formpanel'
		,items: [{
		    html: '<h2>'+_('shepherd.management')+'</h2>'
			,border: false
			,cls: 'modx-page-header'
			},{
		    xtype: 'modx-tabs'
			,bodyStyle: 'padding: 10px'
			,defaults: { border: false ,autoHeight: true }
		    ,border: true
			 ,items: [{
			    title: _('shepherd.articles')
				 ,defaults: { autoHeight: true }
			    ,items: [{
				    html: '<p>'+_('shepherd.management_desc')+'</p><br />'
					 ,border: false
					 }, {
				    xtype: 'shepherd-grid-articles'
					 ,preventRender: true
				}]
				 }]
			 }]
		});
    Shepherd.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(Shepherd.panel.Home,MODx.Panel);
Ext.reg('shepherd-panel-home',Shepherd.panel.Home);