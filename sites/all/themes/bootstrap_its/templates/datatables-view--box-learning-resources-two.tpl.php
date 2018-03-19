<?php
/**
 * @file
 * Template to display a datatable.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $header: An array of header labels keyed by field id.
 * - $fields: An array of CSS IDs to use for each field id.
 * - $classes: A class or classes to apply to the table, based on settings.
 * - $row_classes: An array of classes to apply to each row, indexed by row
 *   number. This matches the index in $rows.
 * - $rows: An array of row items. Each row is an array of content.
 *   $rows are keyed by row number, fields within rows are keyed by field ID.
 */
?>

<?php
if (isset($_GET['field_lr_tags_tid_1'])) {
	if (in_array("7",$_GET['field_lr_tags_tid_1'])) {
		drupal_set_message("<strong>Important:</strong> Google Sites has limited support for <a href='https://www.w3.org/standards/webdesign/accessibility'>accessibility</a>. To build a site that is accessible, consider using <a href='http://www.itcs.umich.edu/web/'>a different web publishing system</a>.", "warning");}
	//var_dump($_GET);
}
?>

<table id="<?php print $id ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <?php if (!empty($title)) : ?>
    <caption><?php print $title; ?></caption>
  <?php endif; ?>
  <thead>
    <tr>
      <?php foreach ($header as $field => $label): ?>
        <th class="views-field views-field-<?php print $fields[$field]; ?>">
          <?php 
		  if ($label == "Resource") {echo $label."s: <span id='dtcount'>".count($rows)."</span>";}
		  else {print $label;} 
		  ?>
        </th>
      <?php endforeach; ?>
    </tr>
  </thead>
  <tbody>
  
  	<?php if (count($rows) > 1) { ?>
    <?php foreach ($rows as $count => $row): ?>
      <tr class="<?php print implode(' ', $row_classes[$count]); ?>">
        <?php foreach ($row as $field => $content): ?>
          <td class="views-field views-field-<?php print $fields[$field]; ?>">
            <?php print $content; ?>
          </td>
        <?php endforeach; ?>
      </tr>
    <?php endforeach; ?>
    <?php } ?>
  </tbody>
</table>
