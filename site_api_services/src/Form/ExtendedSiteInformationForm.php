<?php
namespace Drupal\site_api_services\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\SiteInformationForm;


class ExtendedSiteInformationForm extends SiteInformationForm {
 
   /**
   * {@inheritdoc}
   */
	  public function buildForm(array $form, FormStateInterface $form_state) {
		$site_config = $this->config('system.site');
		$form =  parent::buildForm($form, $form_state);

		// Site API Key field
		$form['site_information']['siteapikey'] = [
			'#type' => 'textfield',
			'#title' => t('Site API Key'),
			'#default_value' => $site_config->get('siteapikey') ?: 'No API Key yet',
			'#description' => t("Custom field to set the API Key"),
		];

		// Update submit button label
		if($site_config->get('siteapikey')) {
			$form['actions']['submit']['#value'] = t('Update Configuration');
		}
		
		return $form;
	}
	
	  public function submitForm(array &$form, FormStateInterface $form_state) {
		//Save the site API key value in siteapikey system variable

		$old_api_key = $this->config('system.site')->get('siteapikey');
		$new_api_key = $form_state->getValue('siteapikey');
		$this->config('system.site')
		  ->set('siteapikey', $new_api_key)
		  ->save();
		
		//Submit the parent submit form
		parent::submitForm($form, $form_state);

		//Drupal message to inform the user
		if(!empty($new_api_key) && $old_api_key != $new_api_key) {
			\Drupal::messenger()->addStatus(t('Site API Key has been saved with @siteapivalue value.', ['@siteapivalue' => $new_api_key]));
		}
	  }
}