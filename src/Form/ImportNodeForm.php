<?php

namespace Drupal\omdb\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormState;
use Drupal\Core\Form\FormStateInterface;
/**
 * Class ImportNodeForm.
 *
 * @package Drupal\omdb\Form
 */
class ImportNodeForm extends FormBase {
    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'import_node_form';
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['file_path'] = array(
            '#type'  => 'textfield',
            '#title' => $this->t('File path'),
            '#required' => TRUE
        );
        $form['import_node'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Import Node')
        );
        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        parent::validateForm($form, $form_state);
          $file_path = $form_state->getValue('file_path');
          if (!file_exists($file_path)) {
            $form_state->setError($form['file_path'], 'Please enter the correct path');
          }
    }
    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
       $file_path = $form_state->getValue('file_path');
       $count = explode(" ", exec('wc -l ' . $file_path));
       $count = $count[0];
        $batch = array(
            'title' =>  t('Importing Node...'),
            'operations' => array(
                array(
                    '\Drupal\omdb\ImportNode::progressFile',
                    array($count, $file_path)
                ),
            ),
            'init_message'      => t('Batch is starting.'),
            'progress_message'  => t('Processed @current out of @total.'),
            'error_message'     => t('Batch has encountered an error.'),
            'finished'          => '\Drupal\omdb\ImportNode::importNodeFinishedCallback',
        );
        batch_set($batch);
    }
}
