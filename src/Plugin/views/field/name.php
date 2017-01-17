<?php

/**
 * @file
 * Definition of Drupal\omdb\Plugin\views\field\title
 */
namespace Drupal\omdb\Plugin\views\field;

//use Drupal\Core\Form\FormStateInterface;
//use Drupal\node\Entity\NodeType;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * Class Name
 *
 * @ViewsField("api_name")
 */
class Name extends FieldPluginBase {
  /**
   * {@inheritdoc}
   */
  public function query() {
    // Leave empty to avoid a query on this field.
  }

  public function render(ResultRow $values) {
    return array(
      '#markup' => $values->name// $value['title'],
    );
  }
}

