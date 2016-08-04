<?php

/**
 * The home manager controller for msAddLinked.
 *
 */
class msAddLinkedHomeManagerController extends msAddLinkedMainController {
	/* @var msAddLinked $msAddLinked */
	public $msAddLinked;


	/**
	 * @param array $scriptProperties
	 */
	public function process(array $scriptProperties = array()) {
	}


	/**
	 * @return null|string
	 */
	public function getPageTitle() {
		return $this->modx->lexicon('msaddlinked');
	}


	/**
	 * @return void
	 */
	public function loadCustomCssJs() {
		$this->addCss($this->msAddLinked->config['cssUrl'] . 'mgr/main.css');
		$this->addCss($this->msAddLinked->config['cssUrl'] . 'mgr/bootstrap.buttons.css');
		$this->addJavascript($this->msAddLinked->config['jsUrl'] . 'mgr/misc/utils.js');
		$this->addJavascript($this->msAddLinked->config['jsUrl'] . 'mgr/widgets/items.grid.js');
		$this->addJavascript($this->msAddLinked->config['jsUrl'] . 'mgr/widgets/items.windows.js');
		$this->addJavascript($this->msAddLinked->config['jsUrl'] . 'mgr/widgets/home.panel.js');
		$this->addJavascript($this->msAddLinked->config['jsUrl'] . 'mgr/sections/home.js');
		$this->addHtml('<script type="text/javascript">
		Ext.onReady(function() {
			MODx.load({ xtype: "msaddlinked-page-home"});
		});
		</script>');
	}


	/**
	 * @return string
	 */
	public function getTemplateFile() {
		return $this->msAddLinked->config['templatesPath'] . 'home.tpl';
	}
}