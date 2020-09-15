<?php
defined('JPATH_BASE') or die;

use Joomla\CMS\Plugin\CMSPlugin;
#use Joomla\CMS\Language\Text;
#use Joomla\CMS\Factory;

class PlgSystemInsertwhatwhereghsvs extends CMSPlugin
{
	protected $app;


	public function onAfterRender()
	{
		if (
			!$this->app->isClient('site')
			|| $this->app->getDocument()->getType() !== 'html'
		){
			return;
		}
		
		$insertThis = trim($this->params->get('insertWhat', ''));
		$insertWhere = $this->params->get('insertWhere', 0);

####DEBUG
#echo ' DEBUG: <pre>' . print_r($insertThis, true) . '</pre>';exit;
#$insertThis = '<!--insertThis by Plugin-->';
#$insertWhere = 'after/html';
####/DEBUG

		if (!$insertThis || !$insertWhere
		){
			return;
		}

		$buffer = $this->app->getBody();

		switch ($insertWhere)
		{
			case 'afterHead':
				$muster = '/<head[^>]*>/';
				if (preg_match($muster, $buffer, $match))
				{
					$buffer = str_replace($match[0], $match[0] . $insertThis, $buffer);
				}
				break;
			case 'before/head':
				$buffer = str_replace('</head>', $insertThis . '</head>', $buffer);
				break;
			case 'afterBody':
				$muster = '/<body[^>]*>/';
				if (preg_match($muster, $buffer, $match))
				{
					$buffer = str_replace($match[0], $match[0] . $insertThis, $buffer);
				}
				break;
			case 'before/body':
				$buffer = str_replace('</body>', $insertThis . '</body>', $buffer);
				break;
			case 'after/body':
				$buffer = str_replace('</body>', '</body>' . $insertThis, $buffer);
				break;
			case 'after/html':
				$buffer = str_replace('</html>', '</html>' . $insertThis, $buffer);
				break;
			case 'before/html':
				$buffer = str_replace('</html>', $insertThis . '</html>', $buffer);
				break;
			default:
				return;
		}
		
		$this->app->setBody($buffer);
	}

}
