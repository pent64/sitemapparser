<?php
namespace Src;
use Exception;
use SimpleXMLElement;

/**
 * Used to parse xml sitemap from the site
 *
 * Class Parser
 * @package Src
 */
class Parser {
	protected $file;
	protected $old;
	protected $new;
	protected $to_html;
	protected $counter;

	/**
	 * Parser constructor.
	 *
	 * @param string $filePath
	 * @param string $old_domain
	 * @param string $new_domain
	 * @param string $output
	 * @param bool $to_html
	 * @param int $counter
	 *
	 * @throws Exception
	 */
	public function __construct(string $filePath, string $old_domain, string $new_domain, string $output, bool $to_html, int $counter = 1)
	{
		if (!file_exists($filePath) && strpos($filePath, 'http') === false) {
			throw new Exception('File not found');
		}
		if (empty($output)) {
			$this->file = false;
		} else {
			if (file_get_contents($output)) {
				file_put_contents($output,'');
			}
			$this->file = fopen($output,'a+');
		}
		$this->old = $old_domain;
		$this->new = $new_domain;
		$this->to_html = $to_html;
		$this->counter = $counter;
		$this->read(new SimpleXMLElement(file_get_contents($filePath)));
	}

	/**
	 * Parses given xml object file into array
	 *
	 * @param $xmlObject
	 *
	 * @return bool
	 */
	public function read($xmlObject): bool
	{
		if (isset($xmlObject->sitemap) && !empty($xmlObject->sitemap)) {
			foreach ($xmlObject->sitemap as $sitemap) {
				$loc = strval($sitemap->loc);
				if ( $data = file_get_contents( $loc ) ) {
					$this->read(new SimpleXMLElement( $data ));
				}
			}
		}
		if (isset($xmlObject->url) && !empty($xmlObject->url)) {
			foreach ($xmlObject->url as $url) {
				$loc = strval($url->loc);
				$this->output($loc);
			}
		}
		return true;
	}

	private function output(string $data) {
		if (!empty($this->old) && !empty($this->new)) {
			$data = str_replace($this->old,$this->new,$data);
		}
		if ($this->to_html) {
			$data = '<a href="'.$data.'">'.$this->counter.'</a><br/>'.PHP_EOL;
			$this->counter++;
		}
		if ($this->file !== false && $this->file !== null) {
			fwrite($this->file,$data);
		} else {
			echo $data.PHP_EOL;
		}
	}
}