<?php
/**
 * @file Contains the code to generate the custom drush commands.
 */
/**
 * Implements hook_drush_command().
 */

use \Drupal\node\Entity\Node;
use \Drupal\file\Entity\File;

function omdb_drush_command() {
  $items = array();
  $items['file-to-node'] = [
    'description' => 'Transform item in file to node',
    'aliases' => ['ftn'],
//    'arguments' => [
//      'arg_name' => 'Transform item in file to node',
//    ]
    'options' => [
      'opt_name' => 'qwerty'
    ]
//    'drupal dependencies' => ['custom_drush_command'],
  ];
  return $items;
}
/**
 * Call back function drush_omdb_file_to_node()
 * The call back function name in the  following format
 *   drush_{module_name}_{item_id_for_command}()
 */
function drush_omdb_file_to_node() {
  // (?<=")(.*)(?=")" - title
  // (?<=\()(.*)(?=\)) - data
  $option = drush_get_option('opt_name');
  if (!empty($option)) {
    $handle = fopen($option, "r") or die("Couldn't get handle");
    if ($handle) {
      $count = 0;
      $total = explode(" ", exec('wc -l ' . $option));
      $total = $total[0];
      while (!feof($handle)) {
        $buffer = fgets($handle, 4096);
        $count++;
        $math = array();
        preg_match('/"(.*?)"/', $buffer, $math);
        if (!empty($math)) {
          $title = $math[1];
        }
//        print $buffer;
        print("$count/$total \r");
        // Process buffer here..
      }
      fclose($handle);
    }
  }
  $data = file_get_contents('https://www.drupal.org/files/druplicon.small_.png');
  $file = file_save_data($data, 'public://druplicon.png', FILE_EXISTS_REPLACE);

// Create node object with attached file.
  $node = Node::create([
    'type'        => 'node_from_file',
    'title'       => "",
    'year'        => "",
  ]);
  $node->save();

//  echo '<pre>' . print_r($option, TRUE) . '</pre>';
//  die();

//    $txt_file = file_get_contents('/home/edge/Documents/movies.list');
//    $rows = explode("\n", $txt_file);
}
