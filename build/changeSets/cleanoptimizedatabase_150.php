<?php
/*************************************************************************************************
 * Copyright 2016 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Customizations.
* Licensed under the vtiger CRM Public License Version 1.1 (the "License"); you may not use this
* file except in compliance with the License. You can redistribute it and/or modify it
* under the terms of the License. JPL TSolucio, S.L. reserves all rights not expressly
* granted by the License. coreBOS distributed by JPL TSolucio S.L. is distributed in
* the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
* warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. Unless required by
* applicable law or agreed to in writing, software distributed under the License is
* distributed on an "AS IS" BASIS, WITHOUT ANY WARRANTIES OR CONDITIONS OF ANY KIND,
* either express or implied. See the License for the specific language governing
* permissions and limitations under the License. You may obtain a copy of the License
* at <http://corebos.org/documentation/doku.php?id=en:devel:vpl11>
*************************************************************************************************/

class cleanoptimizedatabase_150 extends cbupdaterWorker {

	function applyChange() {
		if ($this->hasError()) $this->sendError();
		if ($this->isApplied()) {
			$this->sendMsg('Changeset '.get_class($this).' already applied!');
		} else {
			// add Role2Picklist Index for Speed
			$this->ExecuteQuery('ALTER TABLE `vtiger_role2picklist` ADD INDEX(`picklistvalueid`)');
			// Extend description data-type (eg. allow large emails to be stored)
			$this->ExecuteQuery('ALTER TABLE vtiger_crmentity MODIFY COLUMN description MEDIUMTEXT');
			// change related and product IDs on Ticket to INT for minor performance enhancement
			$this->ExecuteQuery('ALTER TABLE vtiger_troubletickets CHANGE parent_id parent_id INT(19) NULL', array());
			$this->ExecuteQuery('ALTER TABLE vtiger_troubletickets CHANGE product_id product_id INT(19) NULL', array());
			$this->sendMsg('Changeset '.get_class($this).' applied!');
			$this->markApplied();
		}
		$this->finishExecution();
	}

}