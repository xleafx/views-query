<?php
/**
 * @file
 * Definition of Drupal\omdb\Plugin\views\filter\ReleaseDate.
 */
namespace Drupal\omdb\Plugin\views\filter;

use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\Plugin\views\filter\Date;
use Drupal\views\ViewExecutable;
/**
 * Filters by given list of node title options.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("api_release_date_filter")
 */
class ReleaseDate extends Date {
  /**
   * {@inheritdoc}
   */
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);
    $this->valueTitle = t('Allowed node titles');
//    $this->definition['options callback'] = array($this, 'generateOptions');
  }
  /**
   * Override the query so that no filtering takes place if the user doesn't
   * select any options.
   */
  public function query() {
    if (!empty($this->value)) {
      parent::query();
    }
  }
  /**
   * Skip validation if no options have been chosen so we can use it as a
   * non-filter.
   */
  public function validate() {
    if (!empty($this->value)) {
      parent::validate();
    }
  }
  /**
   * Helper function that generates the options.
   * @return array
   */
//  public function generateOptions() {
//    // Array keys are used to compare with the table field values.
//    return array(
//      'bubu' => '2131'
//
////      'my title' => 'my title',
////      'another title' => 'another title',
//    );
//  }
}