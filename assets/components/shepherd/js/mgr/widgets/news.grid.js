Shepherd.grid.News = function(config) {
    config = config || {};
    Ext.applyIf(config,{
	    id: 'shepherd-grid-news'
		,url: Shepherd.config.connectorUrl
		,baseParams: { action: 'mgr/newsitem/getList' }
	        ,fields: [ 'id'
			  ,'createdon'
			  ,'title'
			  ,'related_to'
			  ,'related_ids'
			  ,'content'
			  ,'contacts' ]
		,paging: true
		,remoteSort: true
		,anchor: '97%'
		,autoExpandColumn: 'title'
                ,save_action: 'mgr/newsitem/updateFromGrid'
	        ,autosave: true
		,columns: [{
		    header: _('id')
			 ,dataIndex: 'id'
			 ,sortable: true
			 ,width: 20
			 },{
		    header: _('createdon')
			 ,dataIndex: 'createdon'
			 ,sortable: true
			 ,width: 52
			 },{
		    header: _('shepherd.article_title')
			 ,dataIndex: 'title'
			 ,sortable: true
			 ,width: 100
			 ,editor: { xtype: 'textfield' }
                         },{
		    header: _('shepherd.article_contacts')
			 ,dataIndex: 'contacts'
		         },{
		    header: _('shepherd.article_related_to')
			 ,dataIndex: 'related_to'
		    }]
		    ,tbar:[{
		    xtype: 'textfield'
		     ,id: 'news-search-filter'
		     ,emptyText: _('shepherd.news_search...')
		     ,listeners: {
		       'change': {fn:this.search,scope:this}
  		      ,'render': {fn: function(cmp) {
		        new Ext.KeyMap(cmp.getEl(), {
				key: Ext.EventObject.ENTER
				    ,fn: function() {
				    this.fireEvent('change',this);
				    this.blur();
				    return true;
				}
				,scope: cmp
			      });
		    },scope:this}
		    }
		},{
		    id: 'create-news-item-button'
		    ,text: _('shepherd.newsitem_create')
		    ,handler: { xtype: 'shepherd-window-newsitem-create' ,blankValues: true }
		    }]
    });
    Shepherd.grid.News.superclass.constructor.call(this,config)
};
Ext.extend(Shepherd.grid.News,MODx.grid.Grid,{
	search: function(tf,nv,ov) {
	    var s = this.getStore();
	    s.baseParams.query = tf.getValue();
	    this.getBottomToolbar().changePage(1);
	    this.refresh();
	}
	,getMenu: function() {
	    var m = [{
		    text: _('shepherd.newsitem_update')
		    ,handler: this.updateNewsItem
		},'-',{
		    text: _('shepherd.newsitem_remove')
		    ,handler: this.removeNewsItem
		}];
	    this.addContextMenuItem(m);
	    return true;
	}
	,updateNewsItem: function(btn,e) {
	        if (!this.updateNewsItemWindow) {
		this.updateNewsItemWindow = MODx.load({
			xtype: 'shepherd-window-newsitem-update'
			,record: this.menu.record
			,listeners: {
			    'success': {fn:this.refresh,scope:this}
			}
		    });
		    } else {
			this.updateNewsItemWindow.setValues(this.menu.record);
		   }
	    if(this.menu.record.related_ids) {
		var relatedIds = this.menu.record.related_ids.split(',');
		Ext.each(relatedIds, function(id, index) {
			relatedIds[index] = parseInt(id);
		});
	        for(var i=0; i<sectorArray.length; i++) {
		    if(!(relatedIds.indexOf(parseInt(sectorArray[i]['inputValue'])) === -1))
			sectorArray[i]['checked'] = true;
		}
	        for(var i=0; i<practiceAreaArray.length; i++) {
		    if(!(relatedIds.indexOf(parseInt(practiceAreaArray[i]['inputValue'])) === -1))
			practiceAreaArray[i]['checked'] = true;
		}
	    }
       	    this.updateNewsItemWindow.show(e.target);
            Ext.getCmp('update-contacts').setValue(relatedIds);
	}
	,removeNewsItem: function() {
	    MODx.msg.confirm({
                         title: _('shepherd.newsitem_remove')
			,text: _('shepherd.newsitem_remove_confirm')
			,url: this.config.url
			,params: { action: 'mgr/newsitem/remove' ,id: this.menu.record.id }
		        ,listeners: {
			   'success': { fn:this.refresh, scope:this }
		        }
		});
	}
});
Ext.reg('shepherd-grid-news', Shepherd.grid.News);

Shepherd.window.UpdateNewsItem = function(config) {
    config = config || {};
    Ext.applyIf(config,{
	    title: _('shepherd.newsitem_update')
		,url: Shepherd.config.connectorUrl
		,baseParams: { action: 'mgr/newsitem/update' }
	    ,width: 900
	    ,fields: 
	       [{ xtype: 'hidden'
		      ,name: 'id'
		  },{ 
		  xtype: 'textfield'
		     ,fieldLabel: _('shepherd.newsitem_title')
  		     ,name: 'title'
		     ,width: 350
		     },{
		 xtype: 'tinymce'
			,tinymceSettings: {
			theme : "advanced",
			    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|"
			    + ",justifyleft,justifycenter,justifyright,justifyfull,|,styleselect"
			    + ",formatselect,fontselect,fontsizeselect",
			    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|"
			    + ",search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|"
			    + ",undo,redo,|,link,unlink,anchor,image,cleanup,code,|"
			    + ",insertdate,inserttime,preview,|,forecolor,backcolor",
			    theme_advanced_buttons3: "",
			    theme_advanced_toolbar_location : "top",
			    theme_advanced_toolbar_align : "left",
			    theme_advanced_statusbar_location : "bottom",
			    theme_advanced_resizing : false,
			    extended_valid_elements : "a[name|href|target|title|onclick]"
			    + ",img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name]"
			    + ",hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
			    template_external_list_url : "template_list.js",
			    accessibility_focus : false
                      }
		     ,fieldLabel: _('shepherd.newsitem_content')
		     ,name: 'content'
		     ,id: 'shepherd-newsitem-update-content'
		     ,width: 700
		     },{
			       id:'update-newsitem-contacts',
			       xtype:'superboxselect',
			       fieldLabel: 'Contacts',
			       emptyText: 'Select the Shepherd and Wedderburn personnel associated with this newsitem.',
			       allowBlank:true,
			       name: 'related_to[]',
			       width: 700,
			       store: peopleStore,
			       mode: 'local',
			       displayField: 'pagetitle',
			       displayFieldTpl: '{pagetitle}',
			       valueField: 'id'
			       },{
		    xtype: 'checkboxgroup'
			       ,fieldLabel: 'Sectors'
			       ,name: 'sectors'
			       ,columns: [230, 230, 1.0]
			       ,items: sectorArray
			       },{
		    xtype: 'checkboxgroup'
			       ,fieldLabel: 'Practice Areas'
			       ,name: 'practice_areas'
			       ,columns: [230, 230, 1.0]
			       ,items: practiceAreaArray
			       },{
		    xtype: 'textfield'
			       ,fieldLabel: _('shepherd.newsitem_publication')
			       ,name: 'publication'
			       ,width: 350
		   }
		  ]
    });
    Shepherd.window.UpdateNewsItem.superclass.constructor.call(this,config);
};
Ext.extend(Shepherd.window.UpdateNewsItem,MODx.Window);
Ext.reg('shepherd-window-newsitem-update', Shepherd.window.UpdateNewsItem);

/* Shepherd.combo.Authors = function(config) {
    config = config || {};
    Ext.applyIf(config,{
	        id: 'shepherd-combo-authors'
		,name: 'author'
		,displayField: 'pagetitle'
		,hiddenName: 'author_id'
		,valueField: 'id'
		,fields: ['id','pagetitle']
		,url: Shepherd.config.connectorUrl
		,baseParams: { action: 'mgr/newsitem/getAuthorList' }
	});
    Shepherd.combo.Authors.superclass.constructor.call(this, config);
};
Ext.extend(Shepherd.combo.Authors, MODx.combo.ComboBox);
Ext.reg('shepherd-combo-authors', Shepherd.combo.Authors); */

Shepherd.window.CreateNewsItem = function(config) {
    config = config || {};
    Ext.applyIf(config,{
	    title: _('shepherd.newsitem_create')
	   ,url: Shepherd.config.connectorUrl
	   ,baseParams: { action: 'mgr/newsitem/create' }
	   ,width: 900
	   ,fields: 
	      [{
	      xtype: 'textfield'
		,fieldLabel: _('shepherd.newsitem_title')
  		,name: 'title'
		,width: 300
		},{
	      xtype: 'tinymce'
	        ,fieldLabel: _('shepherd.newsitem_content')
		,name: 'content'
		,id: 'shepherd-newsitem-create-content'
		,width: 700
		,tinymceSettings: {
		  theme : "advanced",
		  theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|"
		    + ",justifyleft,justifycenter,justifyright,justifyfull,|,styleselect"
		    + ",formatselect,fontselect,fontsizeselect",
		  theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|"
		    + ",search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|"
		    + ",undo,redo,|,link,unlink,anchor,image,cleanup,code,|"
		    + ",insertdate,inserttime,preview,|,forecolor,backcolor",
		  theme_advanced_buttons3: "",
		  theme_advanced_toolbar_location : "top",
		  theme_advanced_toolbar_align : "left",
		  theme_advanced_statusbar_location : "bottom",
		  theme_advanced_resizing : false,
		  extended_valid_elements : "a[name|href|target|title|onclick]"
		    + ",img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name]"
		    + ",hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
		  template_external_list_url : "template_list.js",
		  accessibility_focus : false
		}
	      },{
	      xtype:'superboxselect'
	        ,id:'create-newsitem-contacts'
		,fieldLabel: _('shepherd.article_contacts')
		,emptyText: 'Select the Shepherd and Wedderburn personnel associated with this newsitem.'
		,allowBlank:true
		,name: 'related_to[]'
		,width: 700
		,store: peopleStore
		,mode: 'local'
		,displayField: 'pagetitle'
		,displayFieldTpl: '{pagetitle}'
		,valueField: 'id'
	      },{
	      xtype: 'checkboxgroup'
		,fieldLabel: _('shepherd.article_sectors')
		,name: 'sectors'
		,columns: [230, 230, 1.0]
		,items: sectorArray
	      },{
	      xtype: 'checkboxgroup'
		,fieldLabel: _('shepherd.article_practice_areas')
		,name: 'practice_areas'
		,columns: [230, 230, 1.0]
		,items: practiceAreaArray
	      }
	  ]
    });
    Shepherd.window.CreateNewsItem.superclass.constructor.call(this,config);
};
Ext.extend(Shepherd.window.CreateNewsItem, MODx.Window);
Ext.reg('shepherd-window-newsitem-create', Shepherd.window.CreateNewsItem);
