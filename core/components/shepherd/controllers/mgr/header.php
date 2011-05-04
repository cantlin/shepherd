<?php

$modx->regClientStartupScript($modx->config['assets_url'].'components/tinymce/jscripts/tiny_mce/tiny_mce.js');
$modx->regClientStartupScript($shepherd->config['jsUrl'].'mgr/Ext.ux.TinyMCE.min.js');
// $modx->regClientStartupScript($modx->config['assets_url'].'components/tinymce/xconfig.js');
// $modx->regClientStartupScript($modx->config['assets_url'].'components/tinymce/tiny.min.js');
$modx->regClientStartupScript($shepherd->config['jsUrl'].'mgr/shepherd.js');

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
          practiceAreaArray.push({name: "practice_areas[]", id: records[i].data.id, boxLabel: records[i].data.pagetitle});
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
          sectorArray.push({name: "sectors[]", id: records[i].data.id, boxLabel: records[i].data.pagetitle});
          }   
      }   
  }  
});

sectorStore.load();

});
</script>'
);

return;