<?php

declare(strict_types=1);


/**
 * Nextcloud - Backup now. Restore later.
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Maxence Lange <maxence@artificial-owl.com>
 * @copyright 2021, Maxence Lange <maxence@artificial-owl.com>
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */


namespace OCA\Backup\Command;


use OC\Core\Command\Base;
use OCA\Backup\Db\ExternalFolderRequest;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Class ExternalList
 *
 * @package OCA\Backup\Command
 */
class ExternalList extends Base {


	/** @var ExternalFolderRequest */
	private $externalFolderRequest;


	/**
	 * ExternalList constructor.
	 *
	 * @param ExternalFolderRequest $externalFolderRequest
	 */
	public function __construct(ExternalFolderRequest $externalFolderRequest) {
		$this->externalFolderRequest = $externalFolderRequest;

		parent::__construct();
	}


	/**
	 *
	 */
	protected function configure() {
		$this->setName('backup:external:list')
			 ->setDescription('Listing configured external filesystem');
	}


	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 *
	 * @return int
	 */
	protected function execute(InputInterface $input, OutputInterface $output): int {
		$output = new ConsoleOutput();
		$output = $output->section();
		$table = new Table($output);
		$table->setHeaders(['StorageId', 'Storage Folder']);
		$table->render();

		foreach ($this->externalFolderRequest->getAll() as $externalFolder) {
			$table->appendRow(
				[
					$externalFolder->getStorageId(),
					$externalFolder->getRoot()
				]
			);
		}

		return 0;
	}

}
