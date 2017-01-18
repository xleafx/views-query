<?php

/**
 * @file
 * Definition of Drupal\omdb\Plugin\views\field\release_date
 */
namespace Drupal\omdb\Plugin\views\field;

//use Drupal\Core\Form\FormStateInterface;
//use Drupal\node\Entity\NodeType;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * Class ReleaseDate
 *
 * @ViewsField("api_release_date")
 */
class ReleaseDate extends FieldPluginBase {
  /**
   * {@inheritdoc}
   */
  public function query() {
    // Leave empty to avoid a query on this field.
  }

  public function render(ResultRow $values) {
    return array(
      '#markup' => $values->release_date
    );
  }
}
