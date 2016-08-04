msAddLinked.page.Home = function (config) {
	config = config || {};
	Ext.applyIf(config, {
		components: [{
			xtype: 'msaddlinked-panel-home', renderTo: 'msaddlinked-panel-home-div'
		}]
	});
	msAddLinked.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(msAddLinked.page.Home, MODx.Component);
Ext.reg('msaddlinked-page-home', msAddLinked.page.Home);