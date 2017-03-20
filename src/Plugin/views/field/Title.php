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
 * Class Title
 *
 * @ViewsField("api_title")
 */
class Title extends FieldPluginBase {
  /**
   * {@inheritdoc}
   */
  public function query() {
    // Leave empty to avoid a query on this field.
  }

  public function render(ResultRow $values) {
    return array(
      '#markup' => $values->title // $value['title'],
    );
  }
}
