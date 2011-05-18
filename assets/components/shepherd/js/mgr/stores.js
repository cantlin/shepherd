Ext.onReady(function() {

practiceAreaArray = [];

var practiceAreaStore = new Ext.data.JsonStore({
   url: Shepherd.config.connectorUrl                                                           
  ,root: "results"
  ,baseParams: { action: "mgr/resource/getList" ,parent: 123 }
  ,fields: ["id", "pagetitle"]
  ,autoLoad: true
  ,listeners: {
      load: function(t, records, options) {
          for (var i=0; i<records.length; i++) {
          practiceAreaArray.push({name: "related_to[]", inputValue: records[i].data.id + "", boxLabel: records[i].data.pagetitle});
          }
      }   
  }  
});

sectorArray = [];

var sectorStore = new Ext.data.JsonStore({
   url: Shepherd.config.connectorUrl                                                           
  ,root: "results"
  ,baseParams: { action: "mgr/resource/getList" ,parent: 124 }
  ,fields: ["id", "pagetitle"]
  ,autoLoad: true
  ,listeners: {
      load: function(t, records, options) {
          for (var i=0; i<records.length; i++) {
          sectorArray.push({name: "related_to[]", inputValue: records[i].data.id, boxLabel: records[i].data.pagetitle});
          }   
      }   
  }  
});

peopleStore = new Ext.data.JsonStore({
   url: Shepherd.config.connectorUrl                                                           
  ,root: "results"
  ,baseParams: { action: "mgr/resource/getList" ,template: 2 }
  ,fields: ["id", "pagetitle"]
  ,autoLoad: true
});

});