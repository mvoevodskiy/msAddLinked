<?php

/**
 * Class msAddLinkedMainController
 */
abstract class msAddLinkedMainController extends modExtraManagerController {
	/** @var msAddLinked $msAddLinked */
	public $msAddLinked;


	/**
	 * @return void
	 */
	public function initialize() {
		$corePath = $this->modx->getOption('msaddlinked_core_path', null, $this->modx->getOption('core_path') . 'components/msaddlinked/');
		require_once $corePath . 'model/msaddlinked/msaddlinked.class.php';

		$this->msAddLinked = new msAddLinked($this->modx);
		$this->addCss($this->msAddLinked->config['cssUrl'] . 'mgr/main.css');
		$this->addJavascript($this->msAddLinked->config['jsUrl'] . 'mgr/msaddlinked.js');
		$this->addHtml('
		<script type="text/javascript">
			msAddLinked.config = ' . $this->modx->toJSON($this->msAddLinked->config) . ';
			msAddLinked.config.connector_url = "' . $this->msAddLinked->config['connectorUrl'] . '";
		</script>
		');

		parent::initialize();
	}


	/**
	 * @return array
	 */
	public function getLanguageTopics() {
		return array('msaddlinked:default');
	}


	/**
	 * @return bool
	 */
	public function checkPermissions() {
		return true;
	}
}


/**
 * Class IndexManagerController
 */
class IndexManagerController extends msAddLinkedMainController {

	/**
	 * @return string
	 */
	public static function getDefaultController() {
		return 'home';
	}
}