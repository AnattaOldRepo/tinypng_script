<?php

class ImageCompressor
	extends Tinify\Tinify {

	protected $_validExtensions = array();

	public function __construct($apiKey = null, $validExtensions = null) {
		$this->setKey($apiKey);
		$this->setValidExtensions($validExtensions);
	}

	public function getValidExtensions() {
		return $this->_validExtensions;
	}

	public function setValidExtensions($ext) {
		if (!is_array($ext)) {
			$ext = array($ext);
		}

		$this->_validExtensions = $ext;
	}

	public function run($folder) {
		if (!$this->validate()) {
			return;
		}

		$files = $this->findFiles($folder);

		/** @var SplFileInfo $file */
		foreach ($files as $file) {
			$this->compress($file);
		}

		$this->debug("Compression has been completed.");
	}

	public function compress($file) {
		try {
			$this->debug("Compressing: '{$file->getPathname()}'");

			//$source = \Tinify\Source::fromFile($file->getRealPath());
			//$source->toFile($file->getRealPath());
		} catch(Exception $e) {
			$this->error("Exception while compressing file '{$file->getPathname()}'");
		}
	}

	/**
	 * Validates the API Key
	 *
	 * @return bool
	 */
	public function validate() {
		$this->debug("Validating API Key...");

		try {
			\Tinify\validate();

			return true;
		} catch(Exception $e) {
			$this->debug("Failed to validate!");
		}

		return false;
	}

	/**
	 * Recursively returns all images in the given folder
	 * @param $folder
	 * @return RegexIterator
	 */
	protected function findFiles($folder) {
		$pattern = $this->_getPattern();
		$dir = new RecursiveDirectoryIterator($folder);
		$ite = new RecursiveIteratorIterator($dir);
		$files = new RegexIterator($ite, $pattern, RegexIterator::MATCH);

		return $files;
	}

	protected function _getPattern() {
		$extensionRegex = implode('|', $this->_validExtensions);

		return "/.*\.({$extensionRegex})$/";
	}

	protected function debug($message) {
		echo $message . PHP_EOL;
	}

	protected function error($message) {
		echo '[ERROR] - ' . $message . PHP_EOL;
	}
}