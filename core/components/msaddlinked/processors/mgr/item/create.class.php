<?php

/**
 * Create an Item
 */
class msAddLinkedItemCreateProcessor extends modObjectCreateProcessor {
	public $objectType = 'msAddLinkedItem';
	public $classKey = 'msAddLinkedItem';
	public $languageTopics = array('msaddlinked');
	//public $permission = 'create';


	/**
	 * @return bool
	 */
	public function beforeSet() {
		$name = trim($this->getProperty('name'));
		if (empty($name)) {
			$this->modx->error->addField('name', $this->modx->lexicon('msaddlinked_item_err_name'));
		}
		elseif ($this->modx->getCount($this->classKey, array('name' => $name))) {
			$this->modx->error->addField('name', $this->modx->lexicon('msaddlinked_item_err_ae'));
		}

		return parent::beforeSet();
	}

}

return 'msAddLinkedItemCreateProcessor';