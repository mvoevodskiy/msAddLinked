var msAddLinked = function (config) {
	config = config || {};
	msAddLinked.superclass.constructor.call(this, config);
};
Ext.extend(msAddLinked, Ext.Component, {
	page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('msaddlinked', msAddLinked);

msAddLinked = new msAddLinked();