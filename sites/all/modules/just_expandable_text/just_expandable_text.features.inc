<?php
/**
 * @file
 * just_expandable_text.features.inc
 */

/**
 * Implements hook_node_info().
 */
function just_expandable_text_node_info() {
  $items = array(
    'expandable_text_faq' => array(
      'name' => t('Expandable Text'),
      'base' => 'node_content',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  drupal_alter('node_info', $items);
  return $items;
}
