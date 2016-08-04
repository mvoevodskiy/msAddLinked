msAddLinked.panel.Home = function (config) {
	config = config || {};
	Ext.apply(config, {
		baseCls: 'modx-formpanel',
		layout: 'anchor',
		/*
		 stateful: true,
		 stateId: 'msaddlinked-panel-home',
		 stateEvents: ['tabchange'],
		 getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
		 */
		hideMode: 'offsets',
		items: [{
			html: '<h2>' + _('msaddlinked') + '</h2>',
			cls: '',
			style: {margin: '15px 0'}
		}, {
			xtype: 'modx-tabs',
			defaults: {border: false, autoHeight: true},
			border: true,
			hideMode: 'offsets',
			items: [{
				title: _('msaddlinked_items'),
				layout: 'anchor',
				items: [{
					html: _('msaddlinked_intro_msg'),
					cls: 'panel-desc',
				}, {
					xtype: 'msaddlinked-grid-items',
					cls: 'main-wrapper',
				}]
			}]
		}]
	});
	msAddLinked.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(msAddLinked.panel.Home, MODx.Panel);
Ext.reg('msaddlinked-panel-home', msAddLinked.panel.Home);
