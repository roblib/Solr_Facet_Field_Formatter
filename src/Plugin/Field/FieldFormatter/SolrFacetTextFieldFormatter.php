<?php

namespace Drupal\solr_facet_field_formatter\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\search_api_solr\Utility;

/**
 * Plugin implementation of the 'Facet_Field_Formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "solr_facet_text_field_formatter",
 *   module = "solr_facet_field_formatter",
 *   label = @Translation("Solr Facet Field Formatter"),
 *   description = @Translation("Create links to a solr Facet search"),
 *   field_types = {
 *     "text",
 *     "text_long",
 *     "string_long",
 *     "string"
 *   }
 * )
 */
class SolrFacetTextFieldFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('Format string or text fields as links to a facet search.');
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    foreach ($items as $delta => $item) {
      $field = $item->getFieldDefinition();
      // TODO: more robust fieldname parsing
      $fieldLabel = str_replace(' ', '_', $field->getLabel());
      $link = Link::fromTextAndUrl($item->value, Url::fromroute('view.herbarium_search.page_1',
        [], ['query' => ['search_api_fulltext' => '','herbarium-search[0]' => $fieldLabel . ':' . $item->value]]));
      $element[$delta] = [$link->toRenderable()];
    }

    return $element;
  }
}
