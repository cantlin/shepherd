Shepherd.grid.Articles = function(config) {
    config = config || {};
    Ext.applyIf(config,{
	    id: 'shepherd-grid-articles'
		,url: Shepherd.config.connectorUrl
		,baseParams: { action: 'mgr/article/getList' }
	        ,fields: ['id','title','content']
		,paging: true
		,remoteSort: true
		,anchor: '97%'
		,autoExpandColumn: 'title'
		,columns: [{
		    header: _('id')
			 ,dataIndex: 'id'
			 ,sortable: true
			 ,width: 60
			 },{
		    header: _('shepherd.article_title')
			 ,dataIndex: 'title'
			 ,sortable: true
			 ,width: 100
			 ,editor: { xtype: 'textfield' }
		},{
		    header: _('shepherd.article_content')
				   ,dataIndex: 'content'
				   ,sortable: false
				   ,width: 350
				   ,editor: { xtype: 'textfield' }
		}]
		 });
    Shepherd.grid.Articles.superclass.constructor.call(this,config)
};
Ext.extend(Shepherd.grid.Articles, MODx.grid.Grid);
Ext.reg('shepherd-grid-articles', Shepherd.grid.Articles);