<?php defined('SYSPATH') or die('No direct script access');
/**
 * Reads an OPML file and fetches the RSS feed URLs. The RSS URLs 
 * are contained in the <outline> elements
 *
 * @author      Ushahidi Dev Team
 * @package     Swiftriver - https://github.com/ushahidi/Swiftriver_v2
 * @category    Libraries
 * @copyright   (c) 2012 Ushahidi Inc <http://www.ushahidi.com>
 * @license     http://www.gnu.org/licenses/agpl.html GNU Affero General Public License (AGPL) 
 */
class Swiftriver_OPML_Import {
	
	/**
	 * DOM representation of the OPML XML
	 * @var DOMDocument
	 */
	private $dom;

	/**
	 * List of feeds fetched from the OMPL file
	 * @var array
	 */
	private $feeds = array();

	/**
	 * Constructor. Prepares the system for processing an OPML file
	 */
	public function __construct()
	{
		$this->dom = new DOMDocument();
	}

	/**
	 * @param string $ompl_file Name of the OPML file
	 */
	public function init($opml_file_name)
	{
		try
		{
			// Load the OPML
			$this->dom->load($opml_file_name);

			// Get the body node
			// All <outline> entries should be within the <body> element
			$body = $this->dom->getElementsByTagName("body");
			
			if ($body AND $body->item(0))
			{
				// Create SimpleXMLElement object from the body node
				$node = simplexml_import_dom($body->item(0));

				// Traverse the node and extrac the <outline> entries
				$this->_traverse_node($node);
			}
			
			return TRUE;
		}
		catch (Kohana_Exception $e)
		{
			// Get the errors
			$errors = array();
			foreach (libxml_get_errors() as $error)
			{
				$errors[] = $error->code.": ".$error->message;
			}

			// Log the error
			Kohana::$log->add(Log::ERROR, implode("\n", $errors));
			return FALSE;
		}
		
	}

	/**
	 * Traverses an SimpleXMLElement item including its children
	 * and extracts RSS urls
	 *
	 * @param SimpleXMLElement $node
	 */
	private function _traverse_node($node)
	{
		foreach ($node->children() as $element)
		{
			// Check if the current element has child nodes
			$has_children = (bool) count($element->children());

			if ($has_children)
			{
				// Travese the node...
				$this->_traverse_node($element);
			}
			else
			{
				// Get the attriutes object of the <outline> item
				$attributes = $element->attributes();

				// Get the XML URL and pass it through the URL validator
				$rss_url = (string) $attributes->xmlUrl;
				if (Valid::url($rss_url))
				{
					// Fetch the title and URL attributes
					$this->feeds[] = array(
						'title' => (string) $attributes->title,
						'url' => $rss_url
					);
				}
			}
		}
	}

	/**
	 * Gets the feeds specified in the OMPL file
	 *
	 * @return array
	 */
	public function get_feeds()
	{
		return $this->feeds;
	}
}
?>