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




	public function onBeforeCompileHead()
	{
		$doc = $this->app->getDocument();

		if (
			!$this->app->isClient('administrator')
			|| $doc->getType() !== 'html'
		){
			return;
		}

		if (
			$this->params->get('replace_title', 0) === 0
			&& isset($this->app->JComponentTitle)
		)
		{
			$title = trim(strip_tags($this->app->JComponentTitle));
		}
		else
		{
			$title = $this->app->input->get('option');
			
			if ($this->params->get('replace_title', 2) === 2)
			{
				$title = Text::_($title);
			}
		}
		
		$client = Text::_('JADMINISTRATION');
		$sitename = $this->app->get('sitename');
		$combined = array();

		if (($displaySitenameAndOrClient = (int) $this->params->get('sitename_backend', 2))
			!== 0
		){
			$sitenameAndOrClient = (int) $this->params->get('sitename_client_backend', 0);

			switch ($sitenameAndOrClient)
			{
				case 0:
				$combined = array($client, $sitename);
				break;
				case 1:
				$combined = array($sitename, $client);
				break;
				case 2:
				$combined[] = $client;
				break;
				case 3:
				$combined[] = $sitename;
				break;
			}
		}

		switch ($displaySitenameAndOrClient)
		{
			case 0:
			case 1:
			$combined[] = $title;
			break;
			case 2:
			array_unshift($combined, $title);
			break;
		}
		$title = implode($this->params->get('separator', ' / '), $combined);
		$doc->setTitle($title);
	}
}
