<?php

$modx->regClientStartupScript($modx->config['assets_url'].'components/tinymce/jscripts/tiny_mce/tiny_mce.js');
$modx->regClientStartupScript($shepherd->config['jsUrl'].'tiny_mce.js');
$modx->regClientStartupScript($shepherd->config['jsUrl'].'mgr/ext/Ext.ux.TinyMCE.min.js');
$modx->regClientStartupScript($shepherd->config['jsUrl'].'mgr/ext/SuperBoxSelect/SuperBoxSelect.js');
$modx->regClientStartupScript($shepherd->config['jsUrl'].'mgr/shepherd.js');

$modx->regClientCSS($shepherd->config['jsUrl'].'mgr/ext/SuperBoxSelect/superboxselect-gray-extend.css');

$modx->regClientStartupHTMLBlock(
'<script type="text/javascript">
Ext.onReady(function() {
    Shepherd.config = '.$modx->toJSON($shepherd->config).';

practiceAreaArray = [];

var practiceAreaStore = new Ext.data.JsonStore({
   url: Shepherd.config.connectorUrl                                                           
  ,root: "results"
  ,baseParams: { action: "mgr/resource/getList" ,parent: 123 }
  ,fields: ["id", "pagetitle"]
  ,autoLoad: false
  ,listeners: {
      load: function(t, records, options) {
          for (var i=0; i<records.length; i++) {
          practiceAreaArray.push({name: "related_to[]", inputValue: records[i].data.id + "", boxLabel: records[i].data.pagetitle});
          }
      }   
  }  
});

practiceAreaStore.load();

sectorArray = [];

var sectorStore = new Ext.data.JsonStore({
   url: Shepherd.config.connectorUrl                                                           
  ,root: "results"
  ,baseParams: { action: "mgr/resource/getList" ,parent: 124 }
  ,fields: ["id", "pagetitle"]
  ,autoLoad: false
  ,listeners: {
      load: function(t, records, options) {
          for (var i=0; i<records.length; i++) {
          sectorArray.push({name: "related_to[]", inputValue: records[i].data.id, boxLabel: records[i].data.pagetitle});
          }   
      }   
  }  
});

sectorStore.load();

peopleStore = new Ext.data.JsonStore({
   url: Shepherd.config.connectorUrl                                                           
  ,root: "results"
  ,baseParams: { action: "mgr/resource/getList" ,template: 2 }
  ,fields: ["id", "pagetitle"]
  ,autoLoad: true
});

});
</script>'
);

return;