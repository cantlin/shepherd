Shepherd.grid.Articles = function(config) {
    config = config || {};
    Ext.applyIf(config,{
	    id: 'shepherd-grid-articles'
		,url: Shepherd.config.connectorUrl
		,baseParams: { action: 'mgr/article/getList' }
	        ,fields: ['id'
			  ,'createdon'
			  ,'title'
			  ,'related_to'
			  ,'related_ids'
			  ,'status'
			  ,'content'
			  ,'contacts'
			  ,'publication']
		,paging: true
		,remoteSort: true
		,anchor: '97%'
		,autoExpandColumn: 'title'
                ,save_action: 'mgr/article/updateFromGrid'
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
		    header: _('shepherd.article_status')
			 ,dataIndex: 'status'
			 ,width: 40
			 ,sortable: true
			 ,editor: { xtype: 'shepherd-combo-statuses' }
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
			 },{
		    header: _('shepherd.article_publication')
			 ,dataIndex: 'publication'
			 ,sortable: true
			 ,width: 50
		    }]
		,tbar:[{
		    xtype: 'textfield'
		     ,id: 'articles-search-filter'
		     ,emptyText: _('shepherd.article_search...')
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
		    text: _('shepherd.article_create')
		    ,handler: { xtype: 'shepherd-window-article-create' ,blankValues: true }
		}]
    });
    Shepherd.grid.Articles.superclass.constructor.call(this,config)
};
Ext.extend(Shepherd.grid.Articles,MODx.grid.Grid,{
	search: function(tf,nv,ov) {
	    var s = this.getStore();
	    s.baseParams.query = tf.getValue();
	    this.getBottomToolbar().changePage(1);
	    this.refresh();
	}
	,getMenu: function() {
	    var m = [{
		    text: _('shepherd.article_update')
		    ,handler: this.updateArticle
		},'-',{
		    text: _('shepherd.article_remove')
		    ,handler: this.removeArticle
		}];
	    this.addContextMenuItem(m);
	    return true;
	}
	,updateArticle: function(btn,e) {
	        if (!this.updateArticleWindow) {
		this.updateArticleWindow = MODx.load({
			xtype: 'shepherd-window-article-update'
			,record: this.menu.record
			,listeners: {
			    'success': {fn:this.refresh,scope:this}
			}
		    });
		    } else {
			this.updateArticleWindow.setValues(this.menu.record);
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
       	    this.updateArticleWindow.show(e.target);
            Ext.getCmp('update-contacts').setValue(relatedIds);
	}
	,removeArticle: function() {
	    MODx.msg.confirm({
 title: _('shepherd.article_remove')
			,text: _('shepherd.article_remove_confirm')
			,url: this.config.url
			,params: { action: 'mgr/article/remove' ,id: this.menu.record.id }
		    ,listeners: {
			'success': { fn:this.refresh, scope:this }
		    }
		});
	}
});
Ext.reg('shepherd-grid-articles', Shepherd.grid.Articles);

Shepherd.window.UpdateArticle = function(config) {
    config = config || {};
    Ext.applyIf(config,{
	    title: _('shepherd.article_update')
		,url: Shepherd.config.connectorUrl
		,baseParams: { action: 'mgr/article/update' }
	    ,width: 900
	    ,fields: 
	       [{ xtype: 'hidden'
		      ,name: 'id'
		  },{ 
		  xtype: 'textfield'
		     ,fieldLabel: _('shepherd.article_title')
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
		     ,fieldLabel: _('shepherd.article_content')
		     ,name: 'content'
		     ,id: 'shepherd-article-update-content'
		     ,width: 700
		     },{
			       id:'update-contacts',
			       xtype:'superboxselect',
			       fieldLabel: 'Contacts',
			       emptyText: 'Select the Shepherd and Wedderburn personnel associated with this article.',
			       allowBlank:true,
			       name: 'related_to[]',
			       width: 700,
			       store: peopleStore,
			       //			       value: relatedIds,
			       mode: 'local',
			       displayField: 'pagetitle',
			       displayFieldTpl: '{pagetitle}',
			       valueField: 'id',
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
			       ,fieldLabel: _('shepherd.article_publication')
			       ,name: 'publication'
			       ,width: 350
		   }

 /*, {
		    xtype: 'shepherd-combo-statuses'
					 ,fieldLabel: 'Status'
					 ,name: 'status'
					 }*/
		  ]
    });
    Shepherd.window.UpdateArticle.superclass.constructor.call(this,config);
};
Ext.extend(Shepherd.window.UpdateArticle,MODx.Window);
Ext.reg('shepherd-window-article-update', Shepherd.window.UpdateArticle);

Shepherd.combo.Authors = function(config) {
    config = config || {};
    Ext.applyIf(config,{
	        id: 'shepherd-combo-authors'
		,name: 'author'
		,displayField: 'pagetitle'
		,hiddenName: 'author_id'
		,valueField: 'id'
		,fields: ['id','pagetitle']
		,url: Shepherd.config.connectorUrl
		,baseParams: { action: 'mgr/article/getAuthorList' }
	});
    Shepherd.combo.Authors.superclass.constructor.call(this, config);
};
Ext.extend(Shepherd.combo.Authors, MODx.combo.ComboBox);
Ext.reg('shepherd-combo-authors', Shepherd.combo.Authors);

/* contactsSuperbox = 
function(config) {
    config = config || {};
    Ext.applyIf(config, {
       xtype:'superboxselect',
		id:'contacts',
		fieldLabel: 'Contacts',
		emptyText: 'Select the Shepherd and Wedderburn personnel associated with this article.',
		allowBlank:true,
		name: 'related_to[]',
		width: 700,
		store: peopleStore,
		mode: 'local',
		displayField: 'pagetitle',
		displayFieldTpl: '{pagetitle}',
		valueField: 'id',
	});
    Shepherd.form.Contacts.superclass.constructor.class(this, config);
};
Ext.extend(Shepherd.form.Contacts, Ext.ux.form.SuperBoxSelect);
Ext.reg('shepherd-contacts-superbox', Shepherd.form.Contacts);
*/
// new Ext.ux.form.SuperBoxSelect({

Shepherd.combo.Statuses = function(config) {
    config = config || {};
    Ext.applyIf(config,{
	        id: 'shepherd-combo-statuses'
		,name: 'status'
		,displayField: 'key'
		,valueField: 'value'
		,mode: 'local'
		,store: new Ext.data.ArrayStore({
			id: 0
			    ,fields: ['key', 'value']
			    ,data: [['Published', 'Published'], ['Promoted', 'Promoted'], ['Hidden', 'Hidden']]
			    })

	});
    Shepherd.combo.Statuses.superclass.constructor.call(this,config);
};
Ext.extend(Shepherd.combo.Statuses, MODx.combo.ComboBox);
Ext.reg('shepherd-combo-statuses', Shepherd.combo.Statuses);

Shepherd.window.CreateArticle = function(config) {
    config = config || {};
    Ext.applyIf(config,{
	    title: _('shepherd.article_create')
	   ,url: Shepherd.config.connectorUrl
	   ,baseParams: { action: 'mgr/article/create' }
	   ,width: 900
	   ,fields: 
	      [{ xtype: 'textfield'
		     ,fieldLabel: _('shepherd.article_title')
  		     ,name: 'title'
		     ,width: 300
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
		     ,fieldLabel: _('shepherd.article_content')
		     ,name: 'content'
		     ,id: 'shepherd-article-create-content'
		     ,width: 700
		     }, {
			       id:'create-contacts',
			       xtype:'superboxselect',
			       fieldLabel: _('shepherd.article_contacts'),
			       emptyText: 'Select the Shepherd and Wedderburn personnel associated with this article.',
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
			       
					 },{
		  xtype: 'textfield'
		     ,fieldLabel: _('shepherd.article_publication')
  		     ,name: 'publication'
		     ,width: 350
		   }


/* , {
		    xtype: 'shepherd-combo-statuses'
					 ,fieldLabel: 'Status'
					 ,name: 'status'
					 }*/
		  ]
    });
    Shepherd.window.CreateArticle.superclass.constructor.call(this,config);
};
Ext.extend(Shepherd.window.CreateArticle, MODx.Window);
Ext.reg('shepherd-window-article-create', Shepherd.window.CreateArticle);
