<?php
/**
 * Event Activation
 *
 * Activation class for Event plugin.
 *
 * @package  Croogo
 * @author   Thomas Rader <thomas.rader@tigerclawtech.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.tigerclawtech.com/portfolio/croogo-event-plugin
 */
class EventActivation{

	public $version = '1.0';

/**
 * onActivate will be called if this returns true
 *
 * @param  object $controller Controller
 * @return boolean
 */
    public function beforeActivation(&$controller) {
        return true;
    }/**
 * Called after activating the hook in ExtensionsHooksController::admin_toggle()
 *
 * @param object $controller Controller
 * @return void
 */
    public function onActivation(&$controller) {
        // ACL: set ACOs with permissions
        $controller->Croogo->addAco('Social/Event');
        $controller->Croogo->addAco('Social/Event/admin_index');
        $controller->Croogo->addAco('Social/Event/index', array('registered', 'public', 'verified', 'community-admin'));
        $controller->Croogo->addAco('Social/Event/calendar', array('registered', 'public', 'verified', 'community-admin'));
        
	        $mainMenu = $controller->Link->Menu->findByAlias('main');
	        $controller->Link->Behaviors->attach('Tree', array(
		            'scope' => array(
		                'Link.menu_id' => $mainMenu['Menu']['id'],
	            ),
	        ));
/*
	        $controller->Link->save(array(
	            'menu_id' => $mainMenu['Menu']['id'],
	            'title' => 'Events',
	            'link' => 'plugin:event/controller:event/action:index',
	            'status' => 1,
		        ));
*/
     }
/**
 * onDeactivate will be called if this returns true
 *
 * @param  object $controller Controller
 * @return boolean
 */
    public function beforeDeactivation(&$controller) {
        return true;
    }
/**
 * Called after deactivating the plugin in ExtensionsPluginsController::admin_toggle()
 *
 * @param object $controller Controller
 * @return void
 */
    public function onDeactivation(&$controller) {
        // ACL: remove ACOs with permissions
        $controller->Croogo->removeAco('Social/Event'); // ExampleController ACO and it's actions will be removed

        // Main menu: delete Event link
        $link = $controller->Link->find('first', array(
            'conditions' => array(
                'Menu.alias' => 'main',
                'Link.link' => 'plugin:event/controller:event/action:index',
            ),
        ));
        $controller->Link->Behaviors->attach('Tree', array(
            'scope' => array(
                'Link.menu_id' => $link['Link']['menu_id'],
            ),
        ));
        if (isset($link['Link']['id'])) {
            $controller->Link->delete($link['Link']['id']);
        }

    }

}
?>