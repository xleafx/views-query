<?php

namespace Drupal\omdb\Form;


use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use SplFileObject;

class OmdbMonitoring extends ConfigFormBase {

  /**
   * Gets the configuration names that will be editable.
   *
   * @return array
   *   An array of configuration object names that are editable if called in
   *   conjunction with the trait's config() method.
   */
  protected function getEditableConfigNames() {
    // TODO: Implement getEditableConfigNames() method.
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $position = \Drupal::config('omdb.settings')->get('line');

    $file_path = "/home/edge/Documents/movies.list";
    $count = explode(" ", exec('wc -l ' . $file_path));
    $count = $count[0];

    $form['info'] = array(
      '#markup' => "$position/$count"
    );

    $form['count'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Line'),
      '#default_value' => $position,
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => TRUE,
    );
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Start'),
      '#button_type' => 'primary',
    );
    return $form;
  }


  public function submitForm(array &$form, FormStateInterface $form_state) {
    $count = $form_state->getValue('count');
    \Drupal::configFactory()->getEditable('omdb.settings')->set('line', $count)->save();
  }

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'omdb_monitoring';
    // TODO: Implement getFormId() method.
  }

}