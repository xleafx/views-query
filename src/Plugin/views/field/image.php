<?php

/**
 * @file
 * Definition of Drupal\omdb\Plugin\views\field\image
 */
namespace Drupal\omdb\Plugin\views\field;

//use Drupal\Core\Form\FormStateInterface;
//use Drupal\node\Entity\NodeType;
//use Drupal\image\Entity\ImageStyle;

use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * Class Image
 *
 * @ViewsField("api_image")
 */
class Image extends FieldPluginBase {
  /**
   * {@inheritdoc}
   */
  public function query() {
    // Leave empty to avoid a query on this field.
  }

  public function render(ResultRow $values) {
//    $build = array(
//      '#theme' => 'image_style',
//      '#path' => $values->poster_path,
//      '#style_name' => 'thumbnail',
//      '#alt' => '',
//      '#title' => ''
//    );

//    $url = ImageStyle::load('thumbnail')->buildUrl($values->poster_path);

//    $style = ImageStyle::load('thumbnail'); // Стиль изображения.
//    $url = $style->buildUrl($values->poster_path); // Путь до изображения с примененным стилем.
//    $variables['picture'] = $url; // Создаем переменную для вывода в шаблоне.

    return [
      '#markup' => '<img src="' . $values->poster_path . '">'
//      'picture' => $url
    ];
  }
}
