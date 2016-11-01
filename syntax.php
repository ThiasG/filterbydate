<?php
/**
 * DokuWiki Plugin filterbydate (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Matthias Grutzeck <mailtoall@acc.grutzeck.net>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

class syntax_plugin_filterbydate extends DokuWiki_Syntax_Plugin {
    /**
     * @return string Syntax mode type
     */
    public function getType() {
        return 'substition';
    }
    /**
     * @return string Paragraph type
     */
    public function getPType() {
        return 'block';
    }
    /**
     * @return int Sort order - Low numbers go before high numbers
     */
    public function getSort() {
        return 300;
    }

    /**
     * Connect lookup pattern to lexer.
     *
     * @param string $mode Parser mode
     */
    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('<filterbydate\b.*?>',$mode,'plugin_filterbydate');
        $this->Lexer->addSpecialPattern('</filterbydate>',$mode,'plugin_filterbydate');
    }

    /**
     * Handle matches of the filterbydate syntax
     *
     * @param string $match The match of the syntax
     * @param int    $state The state of the handler
     * @param int    $pos The position in the document
     * @param Doku_Handler    $handler The handler
     * @return array Data for the renderer
     */
    public function handle($match, $state, $pos, Doku_Handler $handler){

        switch ($state) {
          case DOKU_LEXER_SPECIAL:
                //TODO: Add parameters
                $paras = array();
                if ($match == '</filterbydate>') {
                    $paras['starttag'] = false;
                } else {
					$element = new SimpleXMLElement($match . '</filterbydate>');
                    $paras['base'] = (string)$element["base"];
                    $paras['repeat'] = (string)$element["repeat"];
                    $paras['offset'] = (string)$element["offset"];
                    $paras['starttag'] = true;
                }
                return $paras;
        }
        return false;
    }
    /**
     * Render xhtml output or metadata
     *
     * @param string         $mode      Renderer mode (supported modes: xhtml)
     * @param Doku_Renderer  $renderer  The renderer
     * @param array          $data      The data from the handler() function
     * @return bool If rendering was successful.
     */
    public function render($mode, Doku_Renderer &$renderer, $data) {
		if($mode == 'xhtml'){
			if ($data['starttag']) {
				$renderer->doc .= '<span class=\'filterbydate_start\'' .
				     ' data-base=\'' . $data['base'] . '\'' .
				     ' data-offset=\'' . $data['offset'] . '\'' .
				     ' data-repeat=\'' . $data['repeat']  .'\'></span>';  
			} else {
				$renderer->doc .= '<span class=\'filterbydate_end\'></span>';
			}
			return true;
		}
        return false;
    }
}

// vim:ts=4:sw=4:et:
