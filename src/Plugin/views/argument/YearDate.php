<?php

namespace Drupal\views\Plugin\views\argument;

/**
 * Argument handler for a year (CCYY)
 *
 * @ViewsArgument("api_release_date_arg")
 */
class YearDate extends Date {

  /**
   * {@inheritdoc}
   */
  protected $argFormat = 'Y';

}
